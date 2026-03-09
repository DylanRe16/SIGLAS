<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon; // Importante añadir esto

class ReciboConstanciaController extends Controller
{
    public function index()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.recibos_constancias.index', $data);
    }

    public function simpleSueldo()
{
    $user = Auth::user();
    $db = DB::connection('sigefirrhh');

    $datos = $db->table('trabajador')
        ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
        ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
        ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
        ->leftJoin('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
        ->where([['personal.cedula', '=', $user->cedula], ['trabajador.estatus', '=', 'A']])
        ->select([
            'personal.*', 
            'trabajador.fecha_ingreso', 
            'trabajador.id_trabajador', 
            'cargo.descripcion_cargo', 
            'dependencia.nombre as nombre_dep', 
            DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
        ])
        ->first();

    if (!$datos) return 'No se encontraron datos o usted no es un trabajador activo.';

    // --- CÁLCULOS UNIFICADOS (Igual a BuscarSueldo) ---
    $conceptos = $db->table('conceptofijo')
        ->join('conceptotipopersonal', 'conceptotipopersonal.id_concepto_tipo_personal', '=', 'conceptofijo.id_concepto_tipo_personal')
        ->join('frecuenciapago', 'frecuenciapago.cod_frecuencia_pago', '=', 'conceptotipopersonal.cod_frecuencia_pago')
        ->join('concepto', 'concepto.id_concepto', '=', 'conceptotipopersonal.id_concepto')
        ->where('conceptofijo.id_trabajador', $datos->id_trabajador)
        ->where('concepto.cod_concepto', '<', '5000') // Filtro de asignaciones
        ->where('frecuenciapago.cod_frecuencia_pago', '<=', '4')
        ->whereNotIn('concepto.cod_concepto', ['0318', '0312', '4006', '4009', '4010', '4300', '4301', '1500'])
        ->select('conceptofijo.monto', 'frecuenciapago.cod_frecuencia_pago')
        ->get();

    $sueldoMensual = 0;
    foreach ($conceptos as $c) {
        $monto = $c->monto;
        if ($c->cod_frecuencia_pago == 3) {
            $monto *= 2; // Quincenal a Mensual
        } elseif ($c->cod_frecuencia_pago == 4) {
            $monto = round(($monto / 7) * 30, 2); // Semanal a Mensual (Correcto)
        }
        $sueldoMensual += $monto;
    }

    $montoCestaticket = DB::connection('bd4')
        ->table('recibos_pagos_constancias.tickets_alimentacion')
        ->where('nenabled', 1)
        ->value('nmonto') ?? 0;

    // --- PROCESAR FIGURA LABORAL PARA EL PDF ---
    $figura = 'TRABAJADOR(A)'; 
    $t = $datos->tipo_trabajador;
    if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'FUNCIONARIO';
    elseif (str_contains($t, 'OBREROS')) $figura = 'OBRERO';
    elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
    elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
    elseif (str_contains($t, 'PENSIONADO')) $figura = 'PENSIONADO';
    else $figura = 'EMPLEADO';

    // --- PAYLOAD PARA EL QR ---
    $payload = [
        't'  => 's',
        'c'  => $datos->cedula,
        'n'  => $datos->nacionalidad,
        'tp' => $datos->tipo_trabajador,
        'fg' => $figura, // Agregamos la figura para evitar el error de "JUBILADO"
        'sx' => $datos->sexo,
        'nom'=> trim($datos->primer_apellido.' '.$datos->segundo_apellido.', '.$datos->primer_nombre.' '.$datos->segundo_nombre),
        'fi' => $datos->fecha_ingreso,
        'cr' => $datos->descripcion_cargo,
        'dp' => $datos->nombre_dep,
        'sm' => $sueldoMensual,
        'ct' => $montoCestaticket
    ];

    $encodedData = urlencode(base64_encode(json_encode($payload)));
    $url_validacion = route('validar.publico', ['data' => $encodedData]);
    
    $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(150)->margin(1)->errorCorrection('M')
                ->generate($url_validacion);
    $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);

    $data = $this->prepararDataPdf($payload, $qrCode);

    return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.simple-sueldo', $data)
        ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true])
        ->setPaper('letter', 'portrait')
        ->stream('Constancia_Sueldo_'.$datos->cedula.'.pdf');
}

/**
 * Función que recibe el escaneo en el teléfono
 */
public function validarPublico($data)
{
    try {
        $decoded = json_decode(base64_decode(urldecode($data)), true);
        if (!$decoded) return "Error: Datos de validación inválidos.";

        // Generar QR para el PDF de validación (SVG)
        $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(150)->margin(0)
            ->generate(route('validar.publico', ['data' => $data]));
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);

        $tipo = $decoded['t'] ?? 's';

        // --- CASO FAOV ---
        if ($tipo === 'f') {
            $pdfData = $this->prepararDataFaovParaValidacion($decoded, $qrCode);
            return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_faov', $pdfData)
                ->setPaper('letter', 'portrait')
                ->stream('Validacion_FAOV.pdf');
        } 

        // Los demás casos usan prepararDataPdf
        $pdfData = $this->prepararDataPdf($decoded, $qrCode);
        
        // Selección de vista por tipo
        if ($tipo === 'e') {
            return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_egreso', $pdfData)
                ->setPaper('letter', 'portrait')
                ->stream('Validacion_Egreso.pdf');
        }

                if ($tipo === 'j') {
    $pdfData = $this->prepararDataPdf($decoded, $qrCode); 
    return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_jubilado_documento', $pdfData)
        ->setPaper('letter', 'portrait')
        ->stream('Validacion_Jubilado.pdf');
}

        // --- CASO POR DEFECTO: SUELDO SIMPLE ---
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.simple-sueldo', $pdfData)
            ->setPaper('letter', 'portrait')
            ->stream('Validacion_Constancia_Sueldo.pdf');

    } catch (\Exception $e) {
        return "Error al validar el documento: " . $e->getMessage();
    }
}

/**
 * Organización de variables para la vista Blade
 */
private function prepararDataPdf($p, $qrCode)
{
    $hoy = \Carbon\Carbon::now()->locale('es');
    
    // Detectar Sexo
    $sexo = $p['s'] ?? $p['sx'] ?? 'M';
    
    // Detectar Montos
    $monto = (float)($p['sm'] ?? $p['monto'] ?? 0);
    // Agregamos la detección del monto del ticket del payload (ct)
    $montoTicket = (float)($p['ct'] ?? $p['tickets'] ?? 0); 

    return [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        
        'ciudadano'       => ($sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
        'adscrito'        => ($sexo == 'M') ? 'adscrito a' : 'adscrita a',
        
        'nombre_completo' => strtoupper($p['m'] ?? $p['nom'] ?? ''),
        'cedula'          => number_format($p['c'] ?? 0, 0, '', '.'),
        'nacionalidad'    => $p['n'] ?? '',
        
        'fecha_ingreso'   => isset($p['i']) ? date('d/m/Y', strtotime($p['i'])) : (isset($p['fi']) ? date('d/m/Y', strtotime($p['fi'])) : ''),
        'fecha_egreso'    => isset($p['o']) ? date('d/m/Y', strtotime($p['o'])) : (isset($p['fe']) ? date('d/m/Y', strtotime($p['fe'])) : 'N/A'),
        
        'cargo'           => strtoupper($p['a'] ?? $p['cr'] ?? ''),
        'dependencia'     => strtoupper($p['d'] ?? $p['dp'] ?? ''),
        
        'figura'          => strtoupper($p['fg'] ?? $p['p'] ?? 'JUBILADO'), 
        'tipo_asignacion' => $p['ta'] ?? 'Jubilación',
        
        'monto_num'       => number_format($monto, 2, ',', '.'),
        'monto_letras'    => strtoupper($this->montoEnLetras($monto)),

        // --- LAS DOS VARIABLES QUE FALTABAN ---
        'tickets'         => number_format($montoTicket, 2, ',', '.'),
        'tickets_letras'  => strtoupper($this->montoEnLetras($montoTicket)),
        
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
        'fec_caducidad'   => $hoy->copy()->addDays(30)->format('d/m/Y'),
        'horario'         => '8:00 a.m. a 12:30 p.m. y de 1:30 p.m. a 4:30 p.m.',
    ];
}

    private function montoEnLetras($numero){
        $entero = floor($numero);
        $decimales = round(($numero - $entero) * 100);
        
        $letrasEntero = $this->convertirSueldoALetras($entero);
        $letrasDecimal = $this->convertirSueldoALetras($decimales);

        // Si el decimal es 1, a veces la función devuelve "UN", lo ideal es "01" o "UN"
        $txtDecimal = ($decimales < 10 && $decimales > 0) ? "CERO " . $letrasDecimal : $letrasDecimal;
        if ($decimales == 0) $txtDecimal = "CERO";

        return strtoupper($letrasEntero) . " BOLIVARES CON " . strtoupper($txtDecimal) . " CENTIMOS";
    }

    private function convertirSueldoALetras($num){
        if ($num == 0) return "cero";
        if ($num == 100) return "cien";
        
        $unidades = ["", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
        $decenas = ["", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
        $especiales = [11 => "once", 12 => "doce", 13 => "trece", 14 => "catorce", 15 => "quince"];
        $centenas = ["", "ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];

        if ($num < 10) return $unidades[$num];
        if ($num >= 11 && $num <= 15) return $especiales[$num];
        
        if ($num < 100) {
            $u = $num % 10; $d = floor($num / 10);
            if ($u == 0) return $decenas[$d];
            if ($d == 1) return "dieci" . $unidades[$u];
            if ($d == 2) return "veinti" . $unidades[$u];
            return $decenas[$d] . " y " . $unidades[$u];
        }
        
        if ($num < 1000) {
            $ce = floor($num / 100); $resto = $num % 100;
            if ($resto == 0) return $centenas[$ce];
            return $centenas[$ce] . " " . $this->convertirSueldoALetras($resto);
        }

        if ($num < 1000000) {
            $mille = floor($num / 1000); $resto = $num % 1000;
            $txt_mille = ($mille == 1) ? "mil" : $this->convertirSueldoALetras($mille) . " mil";
            if ($resto == 0) return $txt_mille;
            return $txt_mille . " " . $this->convertirSueldoALetras($resto);
        }

        return (string)$num; 
    }




    public function egresado()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.recibos_constancias.egresado', $data);
    }

    public function buscarEgresado(Request $request)
{
    $request->validate([
        'snacionalidad' => 'required',
        'ndocumento' => 'required|numeric|digits_between:4,11',
    ]);

    try {
        $db = DB::connection('sigefirrhh');

        $persona = $db->table('trabajador')
            ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
            ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
            ->join('cargo', 'trabajador.id_cargo', '=', 'cargo.id_cargo')
            ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
            ->where('personal.cedula', $request->ndocumento)
            ->where('personal.nacionalidad', $request->snacionalidad)
            ->select([
                'personal.id_personal', 'personal.primer_apellido', 'personal.segundo_apellido',
                'personal.primer_nombre', 'personal.segundo_nombre',
                'personal.nacionalidad', 'personal.sexo', 'personal.cedula',
                'trabajador.fecha_ingreso', 'trabajador.fecha_egreso',
                'trabajador.estatus', 'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep',
                DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
            ])
            ->orderBy('trabajador.fecha_egreso', 'desc') // Ordenar por la salida más reciente
            ->orderBy('trabajador.id_trabajador', 'desc')
            ->first();

        // VALIDACIÓN FLEXIBLE:
        // Si no existe OR (el estatus no es 'E' Y tampoco tiene fecha de egreso)
        if (!$persona || ($persona->estatus !== 'E' && empty($persona->fecha_egreso))) {
            return response()->json([
                'message' => 'El número de Documento consultado no posee registros de egreso en el sistema.'
            ], 404);
        }

        // Lógica de Género
        $genero = [
            'ciudadano' => ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
            'adscrito'  => ($persona->sexo == 'M') ? 'adscrito a' : 'adscrita a'
        ];

        // Determinar Figura
        $t = strtoupper($persona->tipo_trabajador);
        $figura = 'EGRESADO';
        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'EMPLEADOS FIJOS';
        elseif (str_contains($t, 'OBREROS FIJOS')) $figura = 'OBREROS FIJOS';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
        elseif (str_contains($t, 'HONORARIOS')) $figura = 'HONORARIOS PROFESIONALES';
        elseif (str_contains($t, 'ALTO NIVEL')) $figura = 'ALTO NIVEL';

        return view('modulos.recibos_constancias.resultado_busqueda', compact('persona', 'genero', 'figura'))->render();

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function generarPdfEgreso(Request $request)
{
    $db = DB::connection('sigefirrhh');
    $datos = $db->table('trabajador')
        ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
        ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
        ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
        ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
        ->where('trabajador.id_personal', $request->id_personal)
        ->select([
            'personal.*', 
            'trabajador.fecha_ingreso', 
            'trabajador.fecha_egreso',
            'cargo.descripcion_cargo', 
            'dependencia.nombre as nombre_dep', 
            'tipopersonal.nombre as tipo_trabajador'
        ])
        ->orderBy('trabajador.id_trabajador', 'desc')
        ->first();

    if (!$datos) return 'No se encontraron datos para generar el PDF.';

    /**
     * PAYLOAD ULTRA-COMPACTO
     * Usamos claves de una letra para que el QR no sea denso y escanee rápido.
     */
    $payload = [
        't' => 'e', // Tipo: Egreso
        'c' => $datos->cedula,
        'n' => $datos->nacionalidad,
        's' => $datos->sexo,
        'm' => trim($datos->primer_apellido.' '.$datos->primer_nombre), // Reducido para el QR
        'i' => $datos->fecha_ingreso,
        'o' => $datos->fecha_egreso,
        'a' => $datos->descripcion_cargo,
        'd' => $datos->nombre_dep,
        'p' => $datos->tipo_trabajador
    ];

    // Codificación para la URL
    $encodedData = urlencode(base64_encode(json_encode($payload)));
    $url_validacion = route('validar.publico', ['data' => $encodedData]);
    
    try {
        // Generamos en PNG con corrección 'L' (La más ligera y escaneable)
        $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(250)
            ->margin(0)
            ->errorCorrection('L') 
            ->generate($url_validacion);
        
        $qrCode = 'data:image/png;base64,' . base64_encode($qrRaw);
    } catch (\Exception $e) {
        // Si falla PNG por falta de GD, intentamos SVG como respaldo
        $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(250)->margin(0)->generate($url_validacion);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);
    }

    // Preparamos los datos completos para la vista (Aquí sí van nombres completos)
    $data = $this->prepararDataEgreso($payload, $qrCode);
    
    // Sobrescribimos el nombre completo para la vista con todos los apellidos/nombres
    $data['nombre_completo'] = strtoupper(trim($datos->primer_apellido.' '.$datos->segundo_apellido.', '.$datos->primer_nombre.' '.$datos->segundo_nombre));

    return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_egreso', $data)
        ->setPaper('letter', 'portrait')
        ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true])
        ->stream('Constancia_Egreso_'.$datos->cedula.'.pdf');
}

/**
 * Procesa el payload para la vista del PDF
 */
private function prepararDataEgreso($p, $qrCode) 
{
    $hoy = \Carbon\Carbon::now()->locale('es');
    
    // 1. Identificar el tipo de personal (Clave 'p' o 'tp')
    $tipoStr = '';
    if (isset($p['p'])) $tipoStr = strtoupper($p['p']);
    elseif (isset($p['tp'])) $tipoStr = strtoupper($p['tp']);

    $figura = 'EGRESADO';
    if (str_contains($tipoStr, 'EMPLEADOS FIJOS')) $figura = 'EMPLEADOS FIJOS';
    elseif (str_contains($tipoStr, 'OBREROS FIJOS')) $figura = 'OBREROS FIJOS';
    elseif (str_contains($tipoStr, 'CONTRATADO')) $figura = 'CONTRATADO';
    elseif (str_contains($tipoStr, 'JUBILADO')) $figura = 'JUBILADO';
    elseif (str_contains($tipoStr, 'HONORARIOS')) $figura = 'HONORARIOS PROFESIONALES';
    elseif (str_contains($tipoStr, 'ALTO NIVEL')) $figura = 'ALTO NIVEL';

    // 2. Identificar el sexo (Clave 's' o 'sx')
    $sexo = '';
    if (isset($p['s'])) $sexo = $p['s'];
    elseif (isset($p['sx'])) $sexo = $p['sx'];

    return [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        'ciudadano'       => ($sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
        'adscrito'        => ($sexo == 'M') ? 'adscrito a' : 'adscrita a',
        // 'm' es nombre en egresado, 'nom' en sueldo simple
        'nombre_completo' => strtoupper($p['m'] ?? $p['nom'] ?? ''),
        'cedula'          => number_format($p['c'] ?? 0, 0, '', '.'),
        'nacionalidad'    => $p['n'] ?? '',
        // 'i' es fecha ingreso en egresado, 'fi' en sueldo simple
        'fecha_ingreso'   => isset($p['i']) ? date('d/m/Y', strtotime($p['i'])) : (isset($p['fi']) ? date('d/m/Y', strtotime($p['fi'])) : ''),
        // 'o' es fecha egreso
        'fecha_egreso'    => isset($p['o']) ? date('d/m/Y', strtotime($p['o'])) : 'N/A',
        // 'a' es cargo en egresado, 'cr' en sueldo simple
        'cargo'           => strtoupper($p['a'] ?? $p['cr'] ?? ''),
        // 'd' es dependencia en egresado, 'dp' en sueldo simple
        'dependencia'     => strtoupper($p['d'] ?? $p['dp'] ?? ''),
        'figura'          => $figura,
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
        'horario'         => '8:00 a.m. a 12:30 p.m. y de 1:30 p.m. a 4:30 p.m.',

        'fec_caducidad'   => $hoy->copy()->addDays(30)->format('d/m/Y'),
    ];
}



    // En App\Http\Controllers\ReciboConstanciaController.php

    public function faov()
    {
        $user = Auth::user();
        // Ajuste preventivo por si roles() no existe como relación directa
        $rol_usuario = method_exists($user, 'roles') ? $user->roles()->first() : null;

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.recibos_constancias.faov', $data);
    }

    public function buscarfaov(Request $request)
{
    $request->validate([
        'snacionalidad' => 'required',
        'ndocumento' => 'required|numeric|digits_between:4,8',
    ], [
        'ndocumento.digits_between' => 'Por favor, reintente llenar el Nro. de Documento o contacte a soporte.',
    ]);

    try {
        $db = DB::connection('sigefirrhh');

        $persona = $db->table('trabajador')
            ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
            ->join('tipopersonal', 'tipopersonal.cod_tipo_personal', '=', 'trabajador.cod_tipo_personal')
            ->join('cargo', 'trabajador.id_cargo', '=', 'cargo.id_cargo')
            ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
            ->where('personal.cedula', $request->ndocumento)
            ->where('personal.nacionalidad', $request->snacionalidad)
            ->where('trabajador.estatus', 'A')
            ->select([
                'personal.id_personal',
                'personal.primer_apellido', 'personal.segundo_apellido',
                'personal.primer_nombre', 'personal.segundo_nombre',
                'personal.nacionalidad', 'personal.sexo', 'personal.cedula',
                'trabajador.fecha_ingreso',
                'cargo.descripcion_cargo', 
                'dependencia.nombre as nombre_dep',
                DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
            ])
            ->first();

        if (!$persona) {
            return response()->json(['message' => 'Usted no se encuentra registrado como trabajador activo del MPPPST.'], 404);
        }

        $genero = [
            'ciudadano' => ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
            'adscrito'  => ($persona->sexo == 'M') ? 'adscrito a' : 'adscrita a'
        ];

        // --- LÓGICA DE FIGURA LABORAL CORREGIDA ---
        $t = strtoupper($persona->tipo_trabajador);
        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'FUNCIONARIO';
        elseif (str_contains($t, 'OBREROS')) $figura = 'OBRERO';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
        elseif (str_contains($t, 'PENSIONADO')) $figura = 'PENSIONADO';
        else $figura = 'EMPLEADO';

        return view('modulos.recibos_constancias.resultado_busqueda_faov', compact('persona', 'genero', 'figura'))->render();

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error de base de datos: ' . $e->getMessage()], 500);
    }
}



    public function generarPdfFaov(Request $request)
{
    $db = DB::connection('sigefirrhh');
    
    $datos = $db->table('trabajador')
        ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
        ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
        ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
        ->join('tipopersonal', 'tipopersonal.cod_tipo_personal', '=', 'trabajador.cod_tipo_personal')
        ->where('personal.id_personal', $request->id_personal)
        ->select([
            'personal.*', 
            'trabajador.fecha_ingreso', 
            'trabajador.fecha_egreso',
            'cargo.descripcion_cargo', 
            'dependencia.nombre as nombre_dep', 
            'tipopersonal.nombre as tipo_trabajador'
        ])
        ->orderBy('trabajador.id_trabajador', 'desc')
        ->first();

    if (!$datos) return 'No se encontraron datos para generar el PDF.';

    // 1. Crear Payload comprimido para que el QR sea fácil de leer
    $payload = [
        't' => 'f', // Identificador para FAOV
        'c' => $datos->cedula,
        'n' => $datos->nacionalidad,
        's' => $datos->sexo,
        'm' => trim($datos->primer_apellido.' '.$datos->primer_nombre),
        'i' => $datos->fecha_ingreso,
        'o' => $datos->fecha_egreso ?? '', 
        'p' => $datos->tipo_trabajador
    ];

    // 2. Generar URL de validación y QR
    $encodedData = urlencode(base64_encode(json_encode($payload)));
    $url_validacion = route('validar.publico', ['data' => $encodedData]);
    
    try {
    // Cambiamos format('png') por format('svg') y quitamos la dependencia de Imagick
    $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
        ->size(150)
        ->margin(0)
        ->generate($url_validacion);
    
    // Cambiamos el base64 a tipo svg+xml
    $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);
} catch (\Exception $e) {
    $qrCode = null; 
}

    // 3. Llamar a la función de preparación (Aquí evitamos el error de variables faltantes)
    $data = $this->prepararDataFaov($datos, $payload, $qrCode);

    return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_faov', $data)
        ->setPaper('letter', 'portrait')
        ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true])
        ->stream('Referencia_FAOV_'.$datos->cedula.'.pdf');
}

/**
 * Función auxiliar para blindar las variables de la vista FAOV
 */
private function prepararDataFaov($datos, $payload, $qrCode) 
{
    $hoy = \Carbon\Carbon::now()->locale('es');
    
    // Determinación de la figura laboral
    $figura = 'TRABAJADOR(A)'; 
    $t = strtoupper($datos->tipo_trabajador);
    if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'FUNCIONARIO';
    elseif (str_contains($t, 'OBREROS FIJOS')) $figura = 'OBRERO';
    elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
    elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';

    return [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        'ciudadano'       => ($datos->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
        'nombre_completo' => strtoupper(trim($datos->primer_apellido.' '.$datos->segundo_apellido.', '.$datos->primer_nombre.' '.$datos->segundo_nombre)),
        'cedula'          => number_format($datos->cedula, 0, '', '.'),
        'nacionalidad'    => $datos->nacionalidad,
        'fecha_ingreso'   => date('d/m/Y', strtotime($datos->fecha_ingreso)),
        'fecha_egreso_raw'=> $datos->fecha_egreso, 
        'fecha_egreso_fmt'=> $datos->fecha_egreso ? date('d/m/Y', strtotime($datos->fecha_egreso)) : 'la ACTUALIDAD',
        'cargo'           => strtoupper($datos->descripcion_cargo),
        'dependencia'     => strtoupper($datos->nombre_dep),
        'figura'          => $figura,
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
        // Aquí aseguramos que la variable que dio error antes, ahora sí exista
        'fec_caducidad'   => $hoy->copy()->addDays(30)->format('d/m/Y'),
    ];
}

private function prepararDataFaovParaValidacion($decoded, $qrCode)
{
    $hoy = \Carbon\Carbon::now()->locale('es');
    
    // Mapeo de campos comprimidos a campos de vista
    return [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        'ciudadano'       => ($decoded['s'] == 'M') ? 'el ciudadano' : 'la ciudadana',
        'nombre_completo' => strtoupper($decoded['m']),
        'cedula'          => number_format($decoded['c'], 0, '', '.'),
        'nacionalidad'    => $decoded['n'],
        'fecha_ingreso'   => date('d/m/Y', strtotime($decoded['i'])),
        'fecha_egreso_raw'=> $decoded['o'] ?: null,
        'fecha_egreso_fmt'=> $decoded['o'] ? date('d/m/Y', strtotime($decoded['o'])) : 'la ACTUALIDAD',
        'cargo'           => strtoupper($decoded['a'] ?? 'TRABAJADOR'), 
        'dependencia'     => strtoupper($decoded['d'] ?? 'MINISTERIO'),
        'figura'          => strtoupper($decoded['p'] ?? 'CONTRATADO'),
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
        'fec_caducidad'   => $hoy->copy()->addDays(30)->format('d/m/Y'),
        'horario'         => '8:00 a.m. a 12:30 p.m. y de 1:30 p.m. a 4:30 p.m.',
    ];
}




    

    public function vistaBuscarSueldo()
    {
        $user = Auth::user();
        // Ajuste preventivo por si roles() no existe como relación directa
        $rol_usuario = method_exists($user, 'roles') ? $user->roles()->first() : null;

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.recibos_constancias.buscarsueldo', $data);
    }

    public function BuscarSueldo(Request $request)
{
    $request->validate([
        'snacionalidad' => 'required',
        'ndocumento' => 'required|numeric',
    ]);

    try {
        $db = DB::connection('sigefirrhh');

        $persona = $db->table('personal')
            ->join('trabajador', 'trabajador.id_personal', '=', 'personal.id_personal')
            ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
            ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
            ->leftJoin('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
            ->where('personal.cedula', $request->ndocumento)
            ->where('personal.nacionalidad', $request->snacionalidad)
            ->where('trabajador.estatus', 'A')
            ->select([
                'trabajador.id_trabajador',
                'personal.id_personal',
                'personal.primer_apellido', 'personal.segundo_apellido', 
                'personal.primer_nombre', 'personal.segundo_nombre',
                'personal.cedula', 'personal.nacionalidad', 'personal.sexo',
                'cargo.descripcion_cargo',
                'dependencia.nombre as nombre_dep',
                DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador"),
                'trabajador.fecha_ingreso'
            ])
            ->first();

        if (!$persona) {
            return response()->json(['message' => 'Trabajador no encontrado o no está activo.'], 404);
        }

        // Cálculo de sueldo (Lógica de 30 días para semanales)
        $conceptos = $db->table('conceptofijo')
            ->join('conceptotipopersonal', 'conceptotipopersonal.id_concepto_tipo_personal', '=', 'conceptofijo.id_concepto_tipo_personal')
            ->join('frecuenciapago', 'frecuenciapago.cod_frecuencia_pago', '=', 'conceptotipopersonal.cod_frecuencia_pago')
            ->join('concepto', 'concepto.id_concepto', '=', 'conceptotipopersonal.id_concepto')
            ->where('conceptofijo.id_trabajador', $persona->id_trabajador)
            ->where('concepto.cod_concepto', '<', '5000')
            ->where('frecuenciapago.cod_frecuencia_pago', '<=', '4')
            ->whereNotIn('concepto.cod_concepto', ['0318', '0312', '4006', '4009', '4010', '4300', '4301', '1500'])
            ->select('conceptofijo.monto', 'frecuenciapago.cod_frecuencia_pago')
            ->get();

        $sueldoMensual = 0;
        foreach ($conceptos as $c) {
            $monto = $c->monto;
            if ($c->cod_frecuencia_pago == 3) $monto *= 2; 
            elseif ($c->cod_frecuencia_pago == 4) $monto = round(($monto / 7) * 30, 2); 
            $sueldoMensual += $monto;
        }

        $montoCestaticket = DB::connection('bd4')
            ->table('recibos_pagos_constancias.tickets_alimentacion')
            ->where('nenabled', 1)
            ->value('nmonto') ?? 0;

        // --- LÓGICA DE FIGURA LABORAL CORREGIDA ---
        $t = strtoupper($persona->tipo_trabajador);
        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'FUNCIONARIO';
        elseif (str_contains($t, 'OBREROS')) $figura = 'OBRERO';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
        elseif (str_contains($t, 'PENSIONADO')) $figura = 'PENSIONADO';
        else $figura = 'EMPLEADO';

        return view('modulos.recibos_constancias.resultado_busqueda_sueldo', [
            'persona'          => $persona,
            'monto_sueldo'     => $sueldoMensual,
            'monto_tickets'    => $montoCestaticket,
            'figura'           => $figura,
            'tipo_asignacion'  => 'ASIGNACIÓN MENSUAL'
        ])->render();

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error en el cálculo: ' . $e->getMessage()], 500);
    }
}

    public function generarPdfSueldo(Request $request)
{
    $db = DB::connection('sigefirrhh');
    $persona = $db->table('personal')
        ->join('trabajador', 'trabajador.id_personal', '=', 'personal.id_personal')
        ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
        ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
        // Cambié join por leftJoin y corregí la relación para asegurar que traiga el tipo
        ->leftJoin('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
        ->where('personal.id_personal', $request->id_personal)
        ->select([
            'personal.*', 
            'trabajador.fecha_ingreso', 
            'cargo.descripcion_cargo', 
            'dependencia.nombre as nombre_dep', 
            DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
        ])
        ->first();

    if (!$persona) return 'No se encontraron datos.';

    // --- LÓGICA DE FIGURA LABORAL (Crucial para que no salga JUBILADO por defecto) ---
    $figura = 'TRABAJADOR(A)'; 
    $t = $persona->tipo_trabajador;

    if (str_contains($t, 'EMPLEADOS FIJOS')) {
        $figura = 'FUNCIONARIO';
    } elseif (str_contains($t, 'OBREROS')) {
        $figura = 'OBRERO';
    } elseif (str_contains($t, 'CONTRATADO')) {
        $figura = 'CONTRATADO';
    } elseif (str_contains($t, 'JUBILADO')) {
        $figura = 'JUBILADO';
    } elseif (str_contains($t, 'PENSIONADO')) {
        $figura = 'PENSIONADO';
    } else {
        $figura = 'EMPLEADO'; 
    }

    $sueldoMensual = $request->monto_sueldo;
    $montoCestaticket = $request->monto_tickets;

    // --- PAYLOAD COMPRIMIDO PARA EL QR ---
    $payload = [
        't'  => 's', 
        'c'  => $persona->cedula,
        'n'  => $persona->nacionalidad,
        'sx' => $persona->sexo,
        'nom'=> trim($persona->primer_apellido.' '.$persona->segundo_apellido.', '.$persona->primer_nombre.' '.$persona->segundo_nombre),
        'fi' => $persona->fecha_ingreso,
        'cr' => $persona->descripcion_cargo,
        'dp' => $persona->nombre_dep,
        'tp' => $persona->tipo_trabajador,
        'fg' => $figura, // <--- ESTO FALTABA: Se envía la figura procesada
        'sm' => $sueldoMensual,
        'ct' => $montoCestaticket
    ];

    $encodedData = urlencode(base64_encode(json_encode($payload)));
    $url_validacion = route('validar.publico', ['data' => $encodedData]);

    $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
        ->size(150)->margin(0)
        ->generate($url_validacion);
    $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);

    // --- PREPARACIÓN DE DATA ---
    $data = $this->prepararDataPdf($payload, $qrCode);

    return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.simple-sueldo', $data)
        ->setPaper('letter', 'portrait')
        ->stream('Constancia_Sueldo_'.$persona->cedula.'.pdf');
}








    public function jubilados()
{
    $user = Auth::user();
    $rol_usuario = method_exists($user, 'roles') ? $user->roles()->first() : null;

    return view('modulos.recibos_constancias.jubilado', [
        'rol_usuario' => $rol_usuario,
        'persona'     => null // Se define nula para evitar el error de "variable indefinida"
    ]);
}

    public function BuscarJubilado(Request $request)
{
    $request->validate([
        'snacionalidad' => 'required',
        'ndocumento' => 'required|numeric',
    ]);

    try {
        $db = DB::connection('sigefirrhh');

        $persona = $db->table('trabajador')
            ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
            ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
            ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
            ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
            ->where('personal.cedula', $request->ndocumento)
            ->where('personal.nacionalidad', $request->snacionalidad)
            ->where('trabajador.estatus', 'A')
            ->whereIn('tipopersonal.cod_tipo_personal', ['20', '28', '29'])
            ->select([
                'trabajador.id_trabajador', 'personal.id_personal', 'personal.sexo',
                // Traemos los 4 campos de nombre para cumplir con tu requerimiento
                'personal.primer_apellido', 'personal.segundo_apellido', 
                'personal.primer_nombre', 'personal.segundo_nombre',
                'personal.cedula', 'personal.nacionalidad',
                'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep',
                'tipopersonal.nombre as tipo_trabajador', 'tipopersonal.cod_tipo_personal',
                'trabajador.fecha_ingreso',
                'trabajador.fecha_egreso' // <--- USAR ESTA COMO FECHA DE JUBILACIÓN
            ])
            ->orderBy('trabajador.fecha_ingreso', 'DESC')
            ->first();

        if (!$persona) {
            return response()->json(['message' => 'No se encontró registro activo como Jubilado o Pensionado.'], 404);
        }

        // Lógica de Género y Figura (Funcionario/Jubilado)
        $esFemenino = ($persona->sexo == 'F');
        $figura = ($persona->cod_tipo_personal == '20') 
                    ? ($esFemenino ? 'JUBILADA' : 'JUBILADO') 
                    : ($esFemenino ? 'PENSIONADA' : 'PENSIONADO');
        
        $tipo_asignacion = ($persona->cod_tipo_personal == '20') ? 'Jubilación' : 'Pensión';

        // Cálculo de Sueldo (Conceptos específicos de jubilados)
        $conceptos = $db->table('conceptofijo')
            ->join('conceptotipopersonal', 'conceptotipopersonal.id_concepto_tipo_personal', '=', 'conceptofijo.id_concepto_tipo_personal')
            ->join('concepto', 'concepto.id_concepto', '=', 'conceptotipopersonal.id_concepto')
            ->where('conceptofijo.id_trabajador', $persona->id_trabajador)
            ->whereIn('concepto.cod_concepto', ['0010', '0026', '0011', '3415'])
            ->select('conceptofijo.monto', 'conceptotipopersonal.cod_frecuencia_pago')
            ->get();

        $sueldoMensual = 0;
        foreach ($conceptos as $c) {
            $monto = $c->monto;
            if ($c->cod_frecuencia_pago == 3) $monto *= 2;
            elseif ($c->cod_frecuencia_pago == 4) $monto = round(($monto / 7) * 30, 2);
            $sueldoMensual += $monto;
        }

        return view('modulos.recibos_constancias.resultado_busqueda_jubilado', [
            'persona' => $persona,
            'monto_sueldo' => $sueldoMensual,
            'figura' => $figura,
            'tipo_asignacion' => $tipo_asignacion,
            // Si fecha_egreso es nula, usamos fecha_ingreso como respaldo
            'fecha_jubilacion' => $persona->fecha_egreso ?? $persona->fecha_ingreso 
        ])->render();

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

 public function generarPdfJubilado(Request $request)
    {
        $db = DB::connection('sigefirrhh');
        
        $datos = $db->table('trabajador')
            ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
            ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
            ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
            ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
            ->where('personal.id_personal', $request->id_personal)
            ->select([
                'personal.*', 
                'trabajador.fecha_ingreso', 
                'trabajador.fecha_egreso',
                'cargo.descripcion_cargo', 
                'dependencia.nombre as nombre_dep', 
                'tipopersonal.nombre as tipo_trabajador'
            ])
            ->orderBy('trabajador.id_trabajador', 'desc')
            ->first();

        if (!$datos) return 'No se encontraron datos.';

        // REDUCCIÓN CRÍTICA DE DATOS PARA EL QR (Para que no salga saturado)
        $payload = [
            't'  => 'j', 
            'c'  => $datos->cedula,
            'n'  => $datos->nacionalidad,
            's'  => $datos->sexo,
            'm'  => trim($datos->primer_apellido.' '.$datos->primer_nombre),
            'o'  => $datos->fecha_egreso,
            'sm' => $request->monto_sueldo,
            'fg' => $request->figura,
            'ta' => $request->tipo_asignacion
        ];

        $encodedData = urlencode(base64_encode(json_encode($payload)));
        $url_validacion = route('validar.publico', ['data' => $encodedData]);
        
        try {
            // Tamaño 100 y margen 0 para máxima claridad del punto
            $qrRaw = QrCode::format('svg')
                ->size(100)->margin(0)->errorCorrection('L') 
                ->generate($url_validacion);
            $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);
        } catch (\Exception $e) { $qrCode = null; }

        $data = $this->prepararDataJubilado($datos, $payload, $qrCode);

        return Pdf::loadView('modulos.recibos_constancias.pdf.pdf_jubilado_documento', $data)
            ->setPaper('letter', 'portrait')
            ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true])
            ->stream('Constancia_Jubilado_'.$datos->cedula.'.pdf');
    }

    /**
     * PREPARAR DATA PARA VISTA (Llenado de variables)
     */
    private function prepararDataJubilado($datos, $payload, $qrCode) 
{
    $hoy = Carbon::now()->locale('es');
    $monto = (float)($payload['sm'] ?? 0);

    // DEFINIR LA VARIABLE ANTES DE USARLA
    $fecha_jub_raw = $datos->fecha_egreso ?? $datos->fecha_ingreso;

    return [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        'ciudadano'       => ($datos->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
        // Nombre con los 4 campos
        'nombre_completo' => strtoupper(trim($datos->primer_nombre.' '.$datos->segundo_nombre.' '.$datos->primer_apellido.' '.$datos->segundo_apellido)),
        'cedula'          => number_format($datos->cedula, 0, '', '.'),
        'nacionalidad'    => $datos->nacionalidad,
        'fecha_jubilacion'=> $fecha_jub_raw, // Enviamos la fecha cruda para procesar en Blade o aquí
        'fecha_egreso'    => $fecha_jub_raw ? date('d/m/Y', strtotime($fecha_jub_raw)) : 'N/A',
        'figura'          => strtoupper($payload['fg'] ?? 'JUBILADO'),
        'tipo_asignacion' => $payload['ta'] ?? 'Jubilación',
        'monto_num'       => number_format($monto, 2, ',', '.'),
        'monto_letras'    => strtoupper($this->montoEnLetras($monto)),
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
        'fec_caducidad'   => $hoy->copy()->addDays(30)->format('d/m/Y'),
    ];
}

    /**
     * VALIDACIÓN PÚBLICA (QR)
     */




}
