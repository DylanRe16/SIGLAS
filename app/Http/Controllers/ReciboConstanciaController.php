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
        ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
        ->where([['personal.cedula', '=', $user->cedula], ['trabajador.estatus', '=', 'A']])
        ->select(['personal.*', 'trabajador.fecha_ingreso', 'trabajador.id_trabajador', 'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep', 'tipopersonal.nombre as tipo_trabajador'])
        ->first();

    if (!$datos) return 'No se encontraron datos.';

    // GENERACIÓN DEL QR - FORZANDO PNG Y LIBRERÍA GD
    // 2. Generación del QR (Formato PNG base64)
$token_validacion = bin2hex(random_bytes(16)); 
    $url_validacion = route('validar.publico', ['token' => $token_validacion]);
    
    try {
        // Generamos el QR asegurándonos de que no haya basura en el buffer
        $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($url_validacion);
            
        // Convertimos a base64 asegurando que no haya saltos de línea
        $qrCode = 'data:image/png;base64,' . base64_encode($qrRaw);
        
    } catch (\Exception $e) {
        // Esto te ayudará a ver el error real si vuelve a fallar
        // Una vez que funcione, puedes volver a ponerlo como $qrCode = null;
        return "Error técnico: " . $e->getMessage(); 
    }

    // Cálculos (Sueldo y Cestaticket)
    $conceptos = $db->table('conceptofijo')
        ->join('conceptotipopersonal', 'conceptotipopersonal.id_concepto_tipo_personal', '=', 'conceptofijo.id_concepto_tipo_personal')
        ->where('conceptofijo.id_trabajador', $datos->id_trabajador)
        ->where('conceptotipopersonal.cod_frecuencia_pago', '<=', 4)
        ->get();

    $sueldoMensual = 0;
    foreach ($conceptos as $c) {
        $sueldoMensual += ($c->cod_frecuencia_pago == 3 || $c->cod_frecuencia_pago == 4) ? ($c->monto * 2) : $c->monto;
    }

    $montoCestaticket = DB::connection('bd4')
        ->table('recibos_pagos_constancias.tickets_alimentacion')
        ->where('nenabled', 1)
        ->value('nmonto') ?? 0;

    $figura = 'TRABAJADOR';
    $t = $datos->tipo_trabajador;
    if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'FUNCIONARIO';
    elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
    elseif (str_contains($t, 'OBRERO')) $figura = 'OBRERO';

    $hoy = Carbon::now()->locale('es');

    $data = [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        'ciudadano'       => ($datos->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
        'adscrito'        => ($datos->sexo == 'M') ? 'adscrito a' : 'adscrita a',
        'nombre_completo' => strtoupper(trim($datos->primer_apellido.' '.$datos->segundo_apellido.', '.$datos->primer_nombre.' '.$datos->segundo_nombre)),
        'cedula'          => number_format($datos->cedula, 0, '', '.'),
        'nacionalidad'    => $datos->nacionalidad,
        'fecha_ingreso'   => date('d/m/Y', strtotime($datos->fecha_ingreso)),
        'cargo'           => strtoupper($datos->descripcion_cargo),
        'dependencia'     => strtoupper($datos->nombre_dep),
        'figura'          => $figura,
        'monto_num'       => number_format($sueldoMensual, 2, ',', '.'),
        'monto_letras'    => $this->montoEnLetras($sueldoMensual), 
        'tickets'         => number_format($montoCestaticket, 2, ',', '.'),
        'tickets_letras'  => $this->montoEnLetras($montoCestaticket),
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
        'fec_caducidad'   => $hoy->addDays(30)->format('d/m/Y'),
    ];

    // IMPORTANTE: Asegúrate de que la vista sea la correcta
    return Pdf::loadView('modulos.recibos_constancias.simple-sueldo', $data)
              ->setPaper('letter', 'portrait')
              ->stream('constancia.pdf');
}

/**
 * Esta función debe ser PÚBLICA (Sin middleware auth)
 */
public function validarPublico($token)
{
    // Aquí puedes retornar una vista simple para el teléfono
    return "Constancia Válida. Token de seguridad: " . $token;
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
    // 1. Validaciones iniciales
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
                'personal.id_personal', 'personal.primer_apellido', 'personal.primer_nombre',
                'personal.nacionalidad', 'personal.sexo', 'personal.cedula',
                'trabajador.fecha_ingreso', 'trabajador.fecha_egreso',
                'trabajador.estatus', 'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep',
                DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
            ])
            ->orderBy('trabajador.id_trabajador', 'desc')
            ->first();

        // CAMBIO AQUÍ: Validar existencia y estatus para el mensaje solicitado
        if (!$persona || $persona->estatus !== 'E') {
            return response()->json([
                'message' => 'El número de Documento consultado no se encuentra egresado.'
            ], 404);
        }

        // Lógica de Género y Figura
        $genero = [
            'ciudadano' => ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
            'adscrito'  => ($persona->sexo == 'M') ? 'adscrito a' : 'adscrita a'
        ];

        $figura = 'EGRESADO';
        $t = strtoupper($persona->tipo_trabajador);
        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'EMPLEADOS FIJOS';
        elseif (str_contains($t, 'OBREROS FIJOS')) $figura = 'OBREROS FIJOS';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
        elseif (str_contains($t, 'HONORARIOS')) $figura = 'HONORARIOS PROFESIONALES';
        elseif (str_contains($t, 'ALTO NIVEL')) $figura = 'ALTO NIVEL';

        return view('modulos.recibos_constancias.resultado_busqueda', compact('persona', 'genero', 'figura'))->render();

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error de conexión: ' . $e->getMessage()], 500);
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

        // --- LÓGICA PARA CALCULAR LA FIGURA (Esto es lo que faltaba) ---
        $figura = 'EGRESADO'; // Valor por defecto
        $t = strtoupper($datos->tipo_trabajador);

        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'EMPLEADOS FIJOS';
        elseif (str_contains($t, 'OBREROS FIJOS')) $figura = 'OBREROS FIJOS';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
        elseif (str_contains($t, 'HONORARIOS')) $figura = 'HONORARIOS PROFESIONALES';
        elseif (str_contains($t, 'ALTO NIVEL')) $figura = 'ALTO NIVEL';
        // ---------------------------------------------------------------

        $token_validacion = bin2hex(random_bytes(16)); 
        $url_validacion = "https://www.mpppst.gob.ve/validar/egreso/" . $token_validacion;
        
        try {
            $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->margin(1)->generate($url_validacion);
            $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);
        } catch (\Exception $e) {
            $qrCode = null; 
        }

        $hoy = \Carbon\Carbon::now()->locale('es');
        
        $data = [
            'qrCode'          => $qrCode,
            'cintillo'        => public_path('imagenes/cintillo.png'),
            'firma'           => public_path('img_firmas/firmaCARLOS.png'),
            'sello'           => public_path('img_firmas/sello.png'),
            'ciudadano'       => ($datos->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
            'adscrito'        => ($datos->sexo == 'M') ? 'adscrito a' : 'adscrita a',
            'nombre_completo' => strtoupper(trim($datos->primer_apellido.' '.$datos->segundo_apellido.', '.$datos->primer_nombre.' '.$datos->segundo_nombre)),
            'cedula'          => number_format($datos->cedula, 0, '', '.'),
            'nacionalidad'    => $datos->nacionalidad,
            'fecha_ingreso'   => date('d/m/Y', strtotime($datos->fecha_ingreso)),
            'fecha_egreso'    => date('d/m/Y', strtotime($datos->fecha_egreso)),
            'cargo'           => strtoupper($datos->descripcion_cargo),
            'dependencia'     => strtoupper($datos->nombre_dep),
            'figura'          => $figura, // <--- AHORA SÍ SE ENVÍA A LA VISTA
            'dia'             => $hoy->format('d'),
            'mes'             => ucfirst($hoy->translatedFormat('F')),
            'ano'             => $hoy->year,

            'horario'         => '8:00 a.m. a 12:30 p.m. y de 1:30 p.m. a 4:30 p.m.',
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_egreso', $data)
            ->setPaper('letter', 'portrait')
            ->stream('Constancia_Egreso_'.$datos->cedula.'.pdf');
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
                ->where('trabajador.estatus', 'A') // Personal Activo para FAOV
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
                return response()->json([
                    'message' => 'Usted no se encuentra registrado como trabajador activo del MPPPST.'
                ], 404);
            }

            // --- LÓGICA DE GÉNERO (Extraída de tu código legacy) ---
            $genero = [
                'ciudadano' => ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
                'adscrito'  => ($persona->sexo == 'M') ? 'adscrito a' : 'adscrita a'
            ];

            // --- LÓGICA DE FIGURA LABORAL (Extraída de tu código legacy) ---
            $figura = 'TRABAJADOR(A)'; // Valor por defecto
            $t = $persona->tipo_trabajador;

            if ($t == 'EMPLEADOS FIJOS') $figura = 'FUNCIONARIO';
            elseif ($t == 'EMPLEADO FIJO ENCARGADURIA') $figura = 'EMPLEADO';
            elseif ($t == 'EMPLEADOS FIJOS DESIGNACION 99') $figura = 'EMPLEADO';
            elseif ($t == 'OBREROS SEMANALES') $figura = 'OBRERO';
            elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
            elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
            elseif (str_contains($t, 'PENSIONADO')) $figura = 'PENSIONADO';

            // Retornamos la vista con los datos procesados
            return view('modulos.recibos_constancias.resultado_busqueda_faov', 
                compact('persona', 'genero', 'figura'))->render();

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

        // --- LÓGICA PARA CALCULAR LA FIGURA ---
        $figura = 'TRABAJADOR(A)'; 
        $t = strtoupper($datos->tipo_trabajador);

        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'EMPLEADOS FIJOS';
        elseif (str_contains($t, 'OBREROS FIJOS')) $figura = 'OBREROS FIJOS';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'JUBILADO')) $figura = 'JUBILADO';
        elseif (str_contains($t, 'HONORARIOS')) $figura = 'HONORARIOS PROFESIONALES';
        elseif (str_contains($t, 'ALTO NIVEL')) $figura = 'ALTO NIVEL';

        // --- GENERACIÓN DE QR ---
        $token_validacion = bin2hex(random_bytes(16)); 
        $url_validacion = "https://www.mpppst.gob.ve/validar/faov/" . $token_validacion;
        
        try {
            $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->margin(1)->generate($url_validacion);
            $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);
        } catch (\Exception $e) {
            $qrCode = null; 
        }

        $hoy = \Carbon\Carbon::now()->locale('es');
        
        $data = [
            'qrCode'          => $qrCode,
            'cintillo'        => public_path('imagenes/cintillo.png'),
            'firma'           => public_path('img_firmas/firmaCARLOS.png'),
            'sello'           => public_path('img_firmas/sello.png'),
            'ciudadano'       => ($datos->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
            'nombre_completo' => strtoupper(trim($datos->primer_apellido.' '.$datos->segundo_apellido.', '.$datos->primer_nombre.' '.$datos->segundo_nombre)),
            'cedula'          => number_format($datos->cedula, 0, '', '.'),
            'nacionalidad'    => $datos->nacionalidad,
            'fecha_ingreso'   => date('d/m/Y', strtotime($datos->fecha_ingreso)),
            // Cambiamos 'ACTUALIDAD' por un valor que podamos evaluar en la vista
            'fecha_egreso_raw'=> $datos->fecha_egreso, 
            'fecha_egreso_fmt'=> $datos->fecha_egreso ? date('d/m/Y', strtotime($datos->fecha_egreso)) : 'la ACTUALIDAD',
            'cargo'           => strtoupper($datos->descripcion_cargo),
            'dependencia'     => strtoupper($datos->nombre_dep),
            'figura'          => $figura,
            'dia'             => $hoy->format('d'),
            'mes'             => ucfirst($hoy->translatedFormat('F')),
            'ano'             => $hoy->year,
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_faov', $data)
            ->setPaper('letter', 'portrait')
            ->stream('Referencia_FAOV_'.$datos->cedula.'.pdf');
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
        // 1. Validación de entrada
        $request->validate([
            'snacionalidad' => 'required',
            'ndocumento' => 'required|numeric',
        ]);

        try {
            $db = DB::connection('sigefirrhh');

            // 2. Obtener datos básicos del trabajador
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
                    'tipopersonal.nombre as tipo_trabajador',
                    'trabajador.fecha_ingreso'
                ])
                ->first();

            if (!$persona) {
                return response()->json(['message' => 'Trabajador no encontrado o no está activo.'], 404);
            }

            // 3. Cálculo de Sueldo Mensual
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
                if ($c->cod_frecuencia_pago == 3) {
                    $monto *= 2; 
                } elseif ($c->cod_frecuencia_pago == 4) {
                    $monto = round(($monto / 7) * 30, 2); 
                }
                $sueldoMensual += $monto;
            }

            // 4. Obtener Cestaticket
            $montoCestaticket = DB::connection('bd4')
                ->table('recibos_pagos_constancias.tickets_alimentacion')
                ->where('nenabled', 1)
                ->value('nmonto') ?? 0;

            // 5. Variables adicionales para la vista
            $figura = "TRABAJADOR(A) ACTIVO(A)";
            $tipo_asignacion = "ASIGNACIÓN MENSUAL";

            return view('modulos.recibos_constancias.resultado_busqueda_sueldo', [
                'persona'          => $persona,
                'monto_sueldo'     => $sueldoMensual,
                'monto_tickets'    => $montoCestaticket,
                'figura'           => $figura,
                'tipo_asignacion'  => $tipo_asignacion
            ])->render();

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error en el cálculo: ' . $e->getMessage()], 500);
        }
    }

    public function generarPdfSueldo(Request $request)
    {
        // Aquí recibimos el ID que enviamos desde el resultado de búsqueda
        $db = DB::connection('sigefirrhh');
        $persona = $db->table('personal')
            ->join('trabajador', 'trabajador.id_personal', '=', 'personal.id_personal')
            ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
            ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
            ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
            ->where('personal.id_personal', $request->id_personal)
            ->select(['personal.*', 'trabajador.fecha_ingreso', 'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep', 'tipopersonal.nombre as tipo_trabajador'])
            ->first();

        $sueldoMensual = $request->monto_sueldo;
        $montoCestaticket = $request->monto_tickets;

        // QR y Tiempos
        $token_validacion = bin2hex(random_bytes(16));
        $url_validacion = "https://www.mpppst.gob.ve/validar/constancia/" . $token_validacion;
        $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->format('svg')->generate($url_validacion);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);

        // Figura Laboral
        $figura = 'TRABAJADOR(A)';
        $t = $persona->tipo_trabajador;
        if (str_contains($t, 'EMPLEADOS FIJOS')) $figura = 'FUNCIONARIO';
        elseif (str_contains($t, 'CONTRATADO')) $figura = 'CONTRATADO';
        elseif (str_contains($t, 'OBRERO')) $figura = 'OBRERO';

        $hoy = \Carbon\Carbon::now()->locale('es');

        $data = [
            'qrCode'          => $qrCode,
            'cintillo'        => public_path('imagenes/cintillo.png'),
            'firma'           => public_path('img_firmas/firmaCARLOS.png'),
            'sello'           => public_path('img_firmas/sello.png'),
            'ciudadano'       => ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
            'adscrito'        => ($persona->sexo == 'M') ? 'adscrito a' : 'adscrita a',
            'nombre_completo' => strtoupper(trim($persona->primer_apellido.' '.$persona->segundo_apellido.', '.$persona->primer_nombre.' '.$persona->segundo_nombre)),
            'cedula'          => number_format($persona->cedula, 0, '', '.'),
            'nacionalidad'    => $persona->nacionalidad,
            'fecha_ingreso'   => date('d/m/Y', strtotime($persona->fecha_ingreso)),
            'cargo'           => strtoupper($persona->descripcion_cargo),
            'dependencia'     => strtoupper($persona->nombre_dep),
            'figura'          => $figura,
            'monto_num'       => number_format($sueldoMensual, 2, ',', '.'),
            'monto_letras'    => $this->montoEnLetras($sueldoMensual),
            'tickets'         => number_format($montoCestaticket, 2, ',', '.'),
            'tickets_letras'  => $this->montoEnLetras($montoCestaticket),
            'dia'             => $hoy->format('d'),
            'mes'             => ucfirst($hoy->translatedFormat('F')),
            'ano'             => $hoy->year,
            'fec_caducidad'   => $hoy->addDays(30)->format('d/m/Y'),
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.simple-sueldo', $data)->stream('Constancia_'.$persona->cedula.'.pdf');
    }

     public function jubilados()
    {
        $user = Auth::user();
        // Ajuste preventivo por si roles() no existe como relación directa
        $rol_usuario = method_exists($user, 'roles') ? $user->roles()->first() : null;

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.recibos_constancias.jubilado', $data);
    }

    public function BuscarJubilado(Request $request)
    {
        $request->validate([
            'snacionalidad' => 'required',
            'ndocumento' => 'required|numeric',
        ]);

        try {
            $db = DB::connection('sigefirrhh');

            // 1. Buscamos al trabajador con los códigos de jubilados (20, 28, 29)
            $persona = $db->table('trabajador')
                ->join('personal', 'personal.id_personal', '=', 'trabajador.id_personal')
                ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
                ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
                ->join('tipopersonal', 'tipopersonal.id_tipo_personal', '=', 'trabajador.id_tipo_personal')
                ->where('personal.cedula', $request->ndocumento)
                ->where('personal.nacionalidad', $request->snacionalidad)
                ->where('trabajador.estatus', 'A')
                ->whereIn('tipopersonal.cod_tipo_personal', ['20', '28', '29']) // Códigos del sistema antiguo
                ->select([
                    'trabajador.id_trabajador', 'personal.id_personal', 'personal.sexo',
                    'personal.primer_apellido', 'personal.segundo_apellido', 
                    'personal.primer_nombre', 'personal.segundo_nombre',
                    'personal.cedula', 'personal.nacionalidad',
                    'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep',
                    'tipopersonal.nombre as tipo_trabajador', 'tipopersonal.cod_tipo_personal',
                    'trabajador.fecha_ingreso'
                ])
                ->orderBy('trabajador.id_trabajador', 'DESC')
                ->first();

            if (!$persona) {
                return response()->json(['message' => 'No se encontró registro activo como Jubilado o Pensionado.'], 404);
            }

            // 2. Lógica de Género y Títulos (según el PHP viejo)
            $esFemenino = ($persona->sexo == 'F');
            $figura = '';
            $tipo_asignacion = '';

            if ($persona->cod_tipo_personal == '20') {
                $figura = $esFemenino ? 'JUBILADA' : 'JUBILADO';
                $tipo_asignacion = 'Jubilación';
            } else {
                $figura = $esFemenino ? 'PENSIONADA' : 'PENSIONADO';
                $tipo_asignacion = 'Pensión';
            }

            // 3. Cálculo de Sueldo basado en conceptos específicos (0010, 0026, 0011, 3415)
            $conceptos = $db->table('conceptofijo')
                ->join('conceptotipopersonal', 'conceptotipopersonal.id_concepto_tipo_personal', '=', 'conceptofijo.id_concepto_tipo_personal')
                ->join('concepto', 'concepto.id_concepto', '=', 'conceptotipopersonal.id_concepto')
                ->where('conceptofijo.id_trabajador', $persona->id_trabajador)
                ->whereIn('concepto.cod_concepto', ['0010', '0026', '0011', '3415'])
                ->select('conceptofijo.monto', 'conceptotipopersonal.cod_frecuencia_pago')
                ->get();

            $sueldoMensual = 0;
            foreach ($conceptos as $c) {
                // Aplicamos la misma conversión de frecuencia que en activos
                $monto = $c->monto;
                if ($c->cod_frecuencia_pago == 3) $monto *= 2;
                elseif ($c->cod_frecuencia_pago == 4) $monto = round(($monto / 7) * 30, 2);
                $sueldoMensual += $monto;
            }

            // 4. Retornar vista previa (reutilizamos la misma o creamos una similar)
            return view('modulos.recibos_constancias.resultado_busqueda_sueldo', [
                'persona' => $persona,
                'monto_sueldo' => $sueldoMensual,
                'monto_tickets' => 0, // Jubilados usualmente no cobran cestaticket según el código viejo
                'figura' => $figura,
                'tipo_asignacion' => $tipo_asignacion
            ])->render();

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

   public function generarPdfJubilado(Request $request)
{
    $db = DB::connection('sigefirrhh');
    
    $persona = $db->table('personal')
        ->join('trabajador', 'trabajador.id_personal', '=', 'personal.id_personal')
        ->join('cargo', 'cargo.id_cargo', '=', 'trabajador.id_cargo')
        ->join('dependencia', 'dependencia.id_dependencia', '=', 'trabajador.id_dependencia')
        ->where('personal.id_personal', $request->id_personal)
        ->where('trabajador.estatus', 'A')
        ->select('personal.*', 'trabajador.fecha_egreso', 'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep')
        ->first();

    if (!$persona) return abort(404);

    // Generar QR
    $token = bin2hex(random_bytes(16));
    $url_validacion = "https://www.mpppst.gob.ve/validar/" . $token;
    $qrRaw = QrCode::size(100)->format('svg')->generate($url_validacion);
    $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);

    $monto = (float)$request->monto_sueldo;
    $hoy = Carbon::now()->locale('es');

    $data = [
        'qrCode'          => $qrCode,
        'cintillo'        => public_path('imagenes/cintillo.png'),
        'firma'           => public_path('img_firmas/firmaCARLOS.png'),
        'sello'           => public_path('img_firmas/sello.png'),
        'ciudadano'       => ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana',
        'nombre_completo' => strtoupper($persona->primer_apellido . ($persona->segundo_apellido ? ' '.$persona->segundo_apellido : '') . ', ' . $persona->primer_nombre . ' ' . $persona->segundo_nombre),
        'cedula'          => number_format($persona->cedula, 0, '', '.'),
        'nacionalidad'    => $persona->nacionalidad,
        'figura'          => $request->figura,
        'tipo_asignacion' => $request->tipo_asignacion,
        'fecha_egreso'    => Carbon::parse($persona->fecha_egreso)->format('d/m/Y'),
        'monto_num'       => number_format($monto, 2, ',', '.'),
        'monto_letras'    => strtoupper($this->montoEnLetras($monto)),
        'dia'             => $hoy->format('d'),
        'mes'             => ucfirst($hoy->translatedFormat('F')),
        'ano'             => $hoy->year,
    ];

    $pdf = Pdf::loadView('modulos.recibos_constancias.pdf.pdf_jubilado_documento', $data);
    return $pdf->stream('Constancia_'.$persona->cedula.'.pdf');
}

}
