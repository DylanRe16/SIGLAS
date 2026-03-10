<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class RecibosPagosController extends Controller
{
    public function indexOrdinarios()
    {
        // Intentamos obtener la cédula directamente del usuario autenticado
        $cedula = Auth::user()->cedula ?? Auth::user()->name ?? session('id_usuario');

        if (!$cedula) {
            return "Error: No se pudo recuperar la cédula del usuario autenticado ni de la sesión.";
        }

        try {
            $perfil = DB::connection('bd4')
                ->table('recibos_pagos_constancias.recibo_pago')
                ->join('public.personales', 'personales.cedula', '=', 'recibo_pago.personales_cedula')
                ->join('public.cargos', 'recibo_pago.cargos_id', '=', 'cargos.id')
                ->join('public.tipo_trabajador', 'recibo_pago.tipo_trabajador_ncodigo', '=', 'tipo_trabajador.ncodigo')
                ->join('public.ubicacion_administrativa', 'recibo_pago.ubicacion_administrativa_scodigo', '=', 'ubicacion_administrativa.scodigo')
                ->join('public.ubicacion_fisica', 'recibo_pago.ubicacion_fisica_scodigo', '=', 'ubicacion_fisica.scodigo')
                ->select(
                    'personales.cedula',
                    'personales.fecha_ingreso',
                    // CAMBIO CLAVE: Traemos la ubicación física desde 'personales' que es la que se actualiza en el store
                    'personales.subicacion_fisica as ubicacion_fisica',
                    'recibo_pago.nestatus as estatus',
                    'tipo_trabajador.sdescripcion_anterior_al10102013 as tipo_trabajador',
                    'recibo_pago.ncodigo_nomina as cod_nomina',
                    'recibo_pago.scuenta_nomina as cuenta_nomina',
                    'cargos.sdescripcion as cargo',
                    'ubicacion_administrativa.sdescripcion as ubicacion_admin'
                    // Si necesitas la descripción original de la nómina para comparar, usa:
                    // 'ubicacion_fisica.sdescripcion as ubicacion_fisica_nomina' 
                )
                ->where('personales.cedula', (string)$cedula)
                ->where('recibo_pago.nestatus', '1')
                ->orderBy('recibo_pago.dfecha_creacion', 'DESC')
                ->first();

            // Si la base de datos no tiene registros para esa cédula
            if (!$perfil) {
                $perfil = (object)[
                    'estatus' => '0',
                    'fecha_ingreso' => now(),
                    'tipo_trabajador' => 'NO ENCONTRADO',
                    'cod_nomina' => 'N/A',
                    'cuenta_nomina' => 'N/A',
                    'cargo' => 'N/A',
                    'ubicacion_admin' => 'N/A',
                    'ubicacion_fisica' => 'N/A'
                ];
            }

            return view('modulos.recibos_constancias.recibospagos.ordinarios', compact('perfil'));
        } catch (\Exception $e) {
            return "Error de Base de Datos: " . $e->getMessage();
        }
    }

    public function buscarRecibo(Request $request)
    {
        $cedula = Auth::user()->cedula ?? Auth::user()->name;
        $mes = $request->input('mes');
        $quincena = $request->input('tipo_nomina'); // 1 o 2

        // Consulta de conceptos
        $conceptos = DB::connection('bd4')
            ->table('recibos_pagos_constancias.recibo_pago')
            ->join('recibos_pagos_constancias.conceptos', 'recibo_pago.conceptos_scodigo', '=', 'conceptos.scodigo')
            ->select(
                'conceptos.scodigo as cod_concepto',
                'conceptos.ncategoria as categoria',
                'recibo_pago.nmonto as monto',
                'conceptos.sdescripcion as descripcion_concepto'
            )
            ->where('recibo_pago.personales_cedula', $cedula)
            ->where('recibo_pago.nenabled', '1')
            ->where('recibo_pago.nanio', date('Y'))
            ->where('recibo_pago.nmes', $mes)
            ->where('recibo_pago.nsemana_quincena', $quincena)
            ->where('conceptos.nenabled', '1')
            ->orderBy('conceptos.scodigo')
            ->get();

        if ($conceptos->isEmpty()) {
            return response('<div class="alert alert-warning text-center">No posee recibo de pago para el periodo seleccionado.</div>', 404);
        }

        // Clasificar montos para la vista
        $asignaciones = $conceptos->where('categoria', 1);
        $deducciones = $conceptos->where('categoria', 2);
        $noSalariales = $conceptos->where('categoria', 3);

        $totalAsignas = $asignaciones->sum('monto');
        $totalDeduce = $deducciones->sum('monto');
        $totalNoSalarial = $noSalariales->sum('monto');
        $neto = $totalAsignas - $totalDeduce;

        // Retornamos una vista parcial (solo el pedazo del recibo)
        return view('modulos.recibos_constancias.recibospagos.parcial_recibo', compact(
            'asignaciones',
            'deducciones',
            'noSalariales',
            'totalAsignas',
            'totalDeduce',
            'totalNoSalarial',
            'neto',
            'mes',
            'quincena'
        ));
    }

    public function imprimirPDF($mes, $quincena)
{
    $cedula = Auth::user()->cedula;
    $anioActual = date('Y'); // Filtro de año importante

    $meses = [
        '01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL',
        '05' => 'MAYO', '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO',
        '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE',
        1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
        5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
        9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'
    ];

    $nombreMes = $meses[$mes] ?? 'DESCONOCIDO';

    $conceptos = DB::connection('bd4')
        ->table('recibos_pagos_constancias.recibo_pago as rp')
        ->join('recibos_pagos_constancias.conceptos as c', 'rp.conceptos_scodigo', '=', 'c.scodigo')
        ->leftJoin('public.personales as p', 'p.cedula', '=', 'rp.personales_cedula')
        ->leftJoin('public.cargos as car', 'rp.cargos_id', '=', 'car.id')
        ->leftJoin('public.ubicacion_administrativa as ua', 'rp.ubicacion_administrativa_scodigo', '=', 'ua.scodigo')
        ->select(
            'c.ncategoria as categoria',
            'rp.nmonto as monto',
            'c.sdescripcion as descripcion_concepto',
            'p.primer_nombre', 'p.segundo_nombre',
            'p.primer_apellido', 'p.segundo_apellido',
            'p.cedula as personales_cedula',
            'car.sdescripcion as nombre_cargo',
            'ua.sdescripcion as nombre_ubicacion',
            'rp.ncodigo_nomina', 'rp.scuenta_nomina', 'rp.nestatus'
        )
        ->where('rp.personales_cedula', $cedula)
        ->where('rp.nmes', $mes)
        ->where('rp.nsemana_quincena', $quincena)
        ->where('rp.nanio', $anioActual) // IGUAL QUE EN LA BUSQUEDA
        ->where('rp.nenabled', '1')     // IGUAL QUE EN LA BUSQUEDA
        ->where('c.nenabled', '1')      // IGUAL QUE EN LA BUSQUEDA
        ->orderBy('c.scodigo')
        ->get();

    if ($conceptos->isEmpty()) {
        return back()->with('error', 'No se encontró el recibo.');
    }

    $info = $conceptos->first();

    $path = public_path('imagenes/cintillo.png');
    $base64 = file_exists($path) ? 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path)) : '';

    $data = [
        'info' => $info,
        'cintillo' => $base64,
        'nombreMes' => $nombreMes,
        'quincena' => $quincena,
        'conceptos' => $conceptos,
        'totalAsignas' => $conceptos->where('categoria', 1)->sum('monto'),
        'totalDeduce' => $conceptos->where('categoria', 2)->sum('monto'),
        'totalNoSalarial' => $conceptos->where('categoria', 3)->sum('monto'),
    ];

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_recibo', $data);
    return $pdf->stream("Recibo_Pago_{$cedula}.pdf", ["Attachment" => false]);
}




    public function indexEspeciales()
    {
        $cedula = Auth::user()->cedula ?? Auth::user()->name;

        // Obtenemos el perfil laboral priorizando la ubicación física actualizada en personales
        $perfil = DB::connection('bd4')
            ->table('recibos_pagos_constancias.recibo_pago')
            ->join('public.personales', 'personales.cedula', '=', 'recibo_pago.personales_cedula')
            ->join('public.cargos', 'recibo_pago.cargos_id', '=', 'cargos.id')
            ->join('public.tipo_trabajador', 'recibo_pago.tipo_trabajador_ncodigo', '=', 'tipo_trabajador.ncodigo')
            ->join('public.ubicacion_administrativa', 'recibo_pago.ubicacion_administrativa_scodigo', '=', 'ubicacion_administrativa.scodigo')
            // Mantenemos el join por si necesitas otros datos, pero no lo usaremos para la descripción de la ubicación
            ->join('public.ubicacion_fisica', 'recibo_pago.ubicacion_fisica_scodigo', '=', 'ubicacion_fisica.scodigo')
            ->select(
                'personales.fecha_ingreso',
                // CAMBIO AQUÍ: Traemos el campo que el usuario edita en su perfil
                'personales.subicacion_fisica as ubicacion_fisica',
                'recibo_pago.nestatus',
                'tipo_trabajador.sdescripcion_anterior_al10102013 as tipo_trabajador',
                'recibo_pago.ncodigo_nomina',
                'ubicacion_administrativa.sdescripcion as ubicacion_adm'
            )
            ->where('personales.cedula', (string)$cedula)
            ->where('recibo_pago.nestatus', '1')
            ->orderBy('recibo_pago.dfecha_creacion', 'DESC')
            ->first();

        // Manejo de caso si no existe el perfil (opcional pero recomendado)
        if (!$perfil) {
            $perfil = (object)[
                'fecha_ingreso' => null,
                'ubicacion_fisica' => 'NO ENCONTRADO',
                'nestatus' => '0',
                'tipo_trabajador' => 'N/A',
                'ncodigo_nomina' => 'N/A',
                'ubicacion_adm' => 'N/A'
            ];
        }

        return view('modulos.recibos_constancias.recibospagos.especiales', compact('perfil'));
    }

    public function buscarEspecial(Request $request)
    {
        $cedula = Auth::user()->cedula ?? Auth::user()->name;
        $mes = $request->mes;
        $anio = date('Y');

        // Buscamos los conceptos (Lógica similar a tu SQL antiguo)
        $conceptos = DB::connection('bd4')
            ->table('recibos_pagos_constancias.recibo_pago')
            ->join('recibos_pagos_constancias.conceptos', 'recibo_pago.conceptos_scodigo', '=', 'conceptos.scodigo')
            ->select(
                'conceptos.scodigo as cod_concepto',
                'conceptos.ncategoria as categoria',
                'recibo_pago.nmonto as monto',
                'conceptos.sdescripcion as descripcion_concepto'
            )
            ->where('recibo_pago.personales_cedula', $cedula)
            ->where('recibo_pago.nmes', $mes)
            ->where('recibo_pago.nanio', $anio)
            ->where('recibo_pago.nenabled', '1')
            ->where('conceptos.nenabled', '1')
            ->orderBy('conceptos.scodigo')
            ->get();

        if ($conceptos->isEmpty()) {
            return response()->json(['html' => '<div class="alert alert-warning text-center">No posee recibos de pagos especiales para el mes seleccionado.</div>']);
        }

        // Calculamos totales por categoría (1: Asignación, 2: Deducción, 3: No Salarial)
        $asignaciones = $conceptos->where('categoria', 1);
        $deducciones = $conceptos->where('categoria', 2);
        $noSalariales = $conceptos->where('categoria', 3);

        $totalAsigna = $asignaciones->sum('monto');
        $totalDeduce = $deducciones->sum('monto');
        $totalNoSalarial = $noSalariales->sum('monto');

        // Retornamos una vista parcial con los datos
        $html = view('modulos.recibos_constancias.recibospagos.parcial_especial', compact(
            'asignaciones',
            'deducciones',
            'noSalariales',
            'totalAsigna',
            'totalDeduce',
            'totalNoSalarial',
            'mes'
        ))->render();

        return response()->json(['html' => $html]);
    }

    // ... otros métodos ...
	
	public function imprimirEspecialPDF($mes)
{
    $cedula = Auth::user()->cedula ?? Auth::user()->name;
    $anio = date('Y');

    // Mapeo de meses
    $meses = [
        '01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL',
        '05' => 'MAYO', '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO',
        '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE',
        1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL',
        5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO',
        9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'
    ];

    $nombreMes = $meses[$mes] ?? 'DESCONOCIDO';

    $conceptos = DB::connection('bd4')
        ->table('recibos_pagos_constancias.recibo_pago as rp')
        ->join('recibos_pagos_constancias.conceptos as c', 'rp.conceptos_scodigo', '=', 'c.scodigo')
        ->leftJoin('public.personales as p', 'p.cedula', '=', 'rp.personales_cedula')
        ->leftJoin('public.cargos as car', 'rp.cargos_id', '=', 'car.id')
        ->leftJoin('public.ubicacion_administrativa as ua', 'rp.ubicacion_administrativa_scodigo', '=', 'ua.scodigo')
        ->select(
            'c.ncategoria as categoria',
            'rp.nmonto as monto',
            'c.sdescripcion as descripcion_concepto',
            'p.primer_nombre',
            'p.segundo_nombre',
            'p.primer_apellido',
            'p.segundo_apellido',
            'p.cedula as personales_cedula',
            'car.sdescripcion as nombre_cargo',
            'ua.sdescripcion as nombre_ubicacion',
            'rp.ncodigo_nomina',
            'rp.scuenta_nomina',
            'rp.nestatus'
        )
        ->where('rp.personales_cedula', $cedula)
        ->where('rp.nmes', $mes)
        ->where('rp.nanio', $anio)
        ->where('rp.nenabled', '1')
        ->where('c.nenabled', '1')
        ->orderBy('c.scodigo')
        ->get();

    if ($conceptos->isEmpty()) {
        return back()->with('error', 'No posee recibos para el mes seleccionado.');
    }

    $info = $conceptos->first();

    $asignaciones = $conceptos->where('categoria', 1);
    $deducciones = $conceptos->where('categoria', 2);
    $noSalariales = $conceptos->where('categoria', 3);

    $totalAsigna = $asignaciones->sum('monto');
    $totalDeduce = $deducciones->sum('monto');
    $totalNoSalarial = $noSalariales->sum('monto');

    $path = public_path('imagenes/cintillo.png');
    $cintillo = file_exists($path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)) : '';

    $data = compact(
        'info',
        'cintillo',
        'nombreMes', // Enviamos el nombre del mes
        'asignaciones',
        'deducciones',
        'noSalariales',
        'totalAsigna',
        'totalDeduce',
        'totalNoSalarial'
    );

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modulos.recibos_constancias.pdf.pdf_recibo_especial', $data);
    return $pdf->stream("Recibo_Especial_{$cedula}.pdf");
}

   

    public function indexJubilados()
    {
        $cedula = Auth::user()->cedula ?? Auth::user()->name;

        // Obtenemos el perfil laboral (enfocado a jubilados si es necesario)
        /* $perfil = DB::connection('bd4')
            ->table('recibos_pagos_constancias.recibo_pago')
            ->join('public.personales', 'personales.cedula', '=', 'recibo_pago.personales_cedula')
            ->join('public.tipo_trabajador', 'recibo_pago.tipo_trabajador_ncodigo', '=', 'tipo_trabajador.ncodigo')
            ->select(
                'personales.fecha_ingreso',
                'recibo_pago.nestatus',
                'tipo_trabajador.sdescripcion_anterior_al10102013 as tipo_trabajador',
                'recibo_pago.ncodigo_nomina'
            )
            ->where('personales.cedula', $cedula)
            ->orderBy('recibo_pago.dfecha_creacion', 'desc')
            ->first(); */

        return view('modulos.recibos_constancias.recibospagos.jubilados');
    }

    public function buscarJubilado(Request $request)
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
                    'personal.id_personal',
                    'personal.primer_apellido',
                    'personal.segundo_apellido', // Agregado segundo_apellido
                    'personal.primer_nombre',
                    'personal.segundo_nombre',    // Agregado segundo_nombre
                    'personal.nacionalidad',
                    'personal.sexo',
                    'personal.cedula',
                    'trabajador.fecha_ingreso',
                    'trabajador.fecha_egreso',
                    'trabajador.id_trabajador',
                    'trabajador.estatus',
                    'cargo.descripcion_cargo',
                    'dependencia.nombre as nombre_dep',
                    DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
                ])
                ->orderBy('trabajador.id_trabajador', 'desc')
                ->first();

            // Validación: Ajustada para ser más flexible si el tipo_trabajador no dice explícitamente JUBILADO
            if (!$persona || !str_contains(strtoupper($persona->tipo_trabajador), 'JUBILADO')) {
                return response()->json([
                    'message' => 'El número de Documento consultado no corresponde a un personal Jubilado.'
                ], 404);
            }

            // Lógica de Género y Figura (Variables que el Blade suele pedir)
            $genero = ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana';

            $esFemenino = ($persona->sexo == 'F');
            $figura = str_contains(strtoupper($persona->tipo_trabajador), 'PENSIONADO')
                ? ($esFemenino ? 'PENSIONADA' : 'PENSIONADO')
                : ($esFemenino ? 'JUBILADA' : 'JUBILADO');

            // IMPORTANTE: Verifica que los nombres de las variables en compact coincidan con las del Blade
            return view(
                'modulos.recibos_constancias.recibospagos.resultado_jubilado',
                compact('persona', 'genero', 'figura')
            )->render();
        } catch (\Exception $e) {
            // Esto te ayudará a ver el error real en la consola del navegador (Network -> Response)
            return response()->json(['message' => 'Error de sistema: ' . $e->getMessage()], 500);
        }
    }

    public function vistaMensualTrabajador()
    {
        // Reemplaza LoadListyear y LoadListMonth
        $anio_actual = date('Y');
        $mes_actual = date('n');

        // Generamos los años (desde 2020 hasta el actual)
        $anios = range($anio_actual, 2020);

        // Nombres de meses para el combo
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        return view('modulos.recibos_constancias.recibospagos.mensual_trabajador', compact('anios', 'meses', 'mes_actual', 'anio_actual'));
    }

  public function buscarHistoricoMensual(Request $request)
{
    try {
        $cedula = trim($request->ndocumento);
        $anio   = (int)$request->anio;
        $mes    = (int)$request->mes;

        $db = DB::connection('bd4');

        $historial = $db->table('recibos_pagos_constancias.recibo_pago as rp')
            ->join('recibos_pagos_constancias.conceptos as c', 'rp.conceptos_scodigo', '=', 'c.scodigo')
            ->where('rp.personales_cedula', $cedula)
            ->where('rp.nanio', $anio)
            ->where('rp.nmes', $mes)
            ->where('rp.nenabled', '1')
            ->where('c.nenabled', '1')
            ->select(
                'c.ncategoria as categoria',
                'c.sdescripcion as descripcion_concepto',
                'rp.nanio',
                'rp.nmes',
                'rp.personales_cedula',
                DB::raw('SUM(rp.nmonto) as monto')
            )
            ->groupBy('c.ncategoria', 'c.sdescripcion', 'c.scodigo', 'rp.nanio', 'rp.nmes', 'rp.personales_cedula')
            ->orderBy('c.scodigo')
            ->get();

        // Si no hay datos, respondemos 200 (OK) pero con un mensaje de éxito falso o 404 controlado
        if ($historial->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => "No se encontraron registros de nómina para la CI $cedula en el periodo $mes-$anio."
            ], 404);
        }

        // Si hay datos, renderizamos la vista a una cadena de texto (HTML)
        $html = view('modulos.recibos_constancias.recibospagos.resultado_historico', compact('historial'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error de sistema: ' . $e->getMessage()
        ], 500);
    }
}

  public function imprimirHistoricoPDF(Request $request)
{
    $cedula = $request->ndocumento;
    $anio   = $request->anio;
    $mes    = (int)$request->mes;

    $db = DB::connection('bd4');

    $historial = $db->table('recibos_pagos_constancias.recibo_pago as rp')
        ->join('recibos_pagos_constancias.conceptos as c', 'rp.conceptos_scodigo', '=', 'c.scodigo')
        ->leftJoin('public.personales as p', 'p.cedula', '=', 'rp.personales_cedula')
        ->leftJoin('public.cargos as car', 'rp.cargos_id', '=', 'car.id')
        ->leftJoin('public.ubicacion_administrativa as ua', 'rp.ubicacion_administrativa_scodigo', '=', 'ua.scodigo')
        ->select(
            'c.ncategoria as categoria',
            'c.sdescripcion as descripcion_concepto',
            DB::raw('SUM(rp.nmonto) as monto'),
            'p.primer_nombre', 'p.segundo_nombre', 'p.primer_apellido', 'p.segundo_apellido',
            'car.sdescripcion as nombre_cargo',
            'ua.sdescripcion as nombre_ubicacion',
            'rp.ncodigo_nomina', 'rp.scuenta_nomina', 'rp.nestatus', 'rp.nmes', 'rp.nanio', 'rp.personales_cedula'
        )
        ->where('rp.personales_cedula', $cedula)
        ->where('rp.nanio', $anio)
        ->where('rp.nmes', $mes)
        ->where('rp.nenabled', '1')
        ->where('c.nenabled', '1')
        ->groupBy(
            'c.ncategoria', 'c.sdescripcion', 'c.scodigo',
            'p.primer_nombre', 'p.segundo_nombre', 'p.primer_apellido', 'p.segundo_apellido',
            'car.sdescripcion', 'ua.sdescripcion',
            'rp.ncodigo_nomina', 'rp.scuenta_nomina', 'rp.nestatus', 'rp.nmes', 'rp.nanio', 'rp.personales_cedula'
        )
        ->orderBy('c.scodigo')
        ->get();

    if ($historial->isEmpty()) return "Error: Sin datos.";

    $info = $historial->first();
    $meses = [1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];

    $path = public_path('imagenes/cintillo.png');
    $cintillo = file_exists($path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)) : null;

    // Calculamos totales antes de enviar
    $asignaciones = $historial->where('categoria', 1);
    $deducciones  = $historial->where('categoria', 2);
    $noSalariales = $historial->where('categoria', 3);

    return \Pdf::loadView('modulos.recibos_constancias.pdf.pdf_recibo_final', [
        'info'         => $info,
        'asignaciones' => $asignaciones,
        'deducciones'  => $deducciones,
        'noSalariales' => $noSalariales,
        'totalAsignaciones' => $asignaciones->sum('monto'),
        'totalDeducciones'  => $deducciones->sum('monto'),
        'totalNoSalarial'   => $noSalariales->sum('monto'),
        'mes_letras'   => $meses[$mes],
        'anio'         => $anio,
        'cintillo'     => $cintillo
    ])->setPaper('letter', 'portrait')->stream("recibo_{$cedula}.pdf");
}
}
