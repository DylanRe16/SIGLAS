<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RecibosPagosController extends Controller
{
    public function indexOrdinarios()
    {
        // Intentamos obtener la cédula directamente del usuario autenticado
        // Si tu campo en la tabla 'users' se llama distinto (ej. 'name' o 'username'), cámbialo aquí
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
                    'recibo_pago.nestatus as estatus',
                    'tipo_trabajador.sdescripcion_anterior_al10102013 as tipo_trabajador',
                    'recibo_pago.ncodigo_nomina as cod_nomina',
                    'recibo_pago.scuenta_nomina as cuenta_nomina',
                    'cargos.sdescripcion as cargo',
                    'ubicacion_administrativa.sdescripcion as ubicacion_admin',
                    'ubicacion_fisica.sdescripcion as ubicacion_fisica'
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
            'asignaciones', 'deducciones', 'noSalariales', 
            'totalAsignas', 'totalDeduce', 'totalNoSalarial', 'neto', 'mes', 'quincena'
        ));
    }

    public function imprimirPDF($mes, $quincena)
    {
        $cedula = Auth::user()->cedula ?? Auth::user()->name;

        // 1. Buscamos los datos (mismo query que usamos en buscarRecibo)
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
            ->where('recibo_pago.nsemana_quincena', $quincena)
            ->get();

        if ($conceptos->isEmpty()) {
            return back()->with('error', 'No se encontró el recibo para imprimir.');
        }

        // 2. Preparamos la data
        $data = [
            'user' => Auth::user(),
            'conceptos' => $conceptos,
            'mes' => $mes,
            'quincena' => $quincena,
            'totalAsignas' => $conceptos->where('categoria', 1)->sum('monto'),
            'totalDeduce' => $conceptos->where('categoria', 2)->sum('monto'),
            'totalNoSalarial' => $conceptos->where('categoria', 3)->sum('monto'),
        ];

        // 3. Generamos el PDF usando una vista especial para impresión
        $pdf = Pdf::loadView('modulos.recibos_constancias.pdf.pdf_recibo', $data);
        
        // Devolvemos el PDF para descargar o ver en navegador
        return $pdf->stream("recibo_{$mes}_{$quincena}.pdf");
    }







   public function indexEspeciales()
    {
        $cedula = Auth::user()->cedula ?? Auth::user()->name;

        // Obtenemos el perfil laboral desde el último recibo (tal como hacía el LoadData antiguo)
        $perfil = DB::connection('bd4')
            ->table('recibos_pagos_constancias.recibo_pago')
            ->join('public.personales', 'personales.cedula', '=', 'recibo_pago.personales_cedula')
            ->join('public.cargos', 'recibo_pago.cargos_id', '=', 'cargos.id')
            ->join('public.tipo_trabajador', 'recibo_pago.tipo_trabajador_ncodigo', '=', 'tipo_trabajador.ncodigo')
            ->join('public.ubicacion_administrativa', 'recibo_pago.ubicacion_administrativa_scodigo', '=', 'ubicacion_administrativa.scodigo')
            ->join('public.ubicacion_fisica', 'recibo_pago.ubicacion_fisica_scodigo', '=', 'ubicacion_fisica.scodigo')
            ->select(
                'personales.fecha_ingreso',
                'recibo_pago.nestatus',
                'tipo_trabajador.sdescripcion_anterior_al10102013 as tipo_trabajador',
                'recibo_pago.ncodigo_nomina',
                'ubicacion_administrativa.sdescripcion as ubicacion_adm',
                'ubicacion_fisica.sdescripcion as ubicacion_fisica'
            )
            ->where('personales.cedula', $cedula)
            ->where('recibo_pago.nestatus', '1')
            ->orderBy('recibo_pago.dfecha_creacion', 'DESC')
            ->first();

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
            'asignaciones', 'deducciones', 'noSalariales', 
            'totalAsigna', 'totalDeduce', 'totalNoSalarial', 'mes'
        ))->render();

        return response()->json(['html' => $html]);
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
                    'personal.id_personal', 'personal.primer_apellido', 'personal.primer_nombre',
                    'personal.nacionalidad', 'personal.sexo', 'personal.cedula',
                    'trabajador.fecha_ingreso', 'trabajador.fecha_egreso',
                    'trabajador.estatus', 'cargo.descripcion_cargo', 'dependencia.nombre as nombre_dep',
                    DB::raw("trim(both ' ' from tipopersonal.nombre) as tipo_trabajador")
                ])
                ->orderBy('trabajador.id_trabajador', 'desc')
                ->first();

            // Validación: Debe existir y ser Jubilado (usualmente estatus 'J' o según tu BD)
            // Si en tu BD los jubilados también son estatus 'E', puedes ajustar la lógica
            if (!$persona || !str_contains(strtoupper($persona->tipo_trabajador), 'JUBILADO')) {
                return response()->json([
                    'message' => 'El número de Documento consultado no corresponde a un personal Jubilado.'
                ], 404);
            }

            $genero = ($persona->sexo == 'M') ? 'el ciudadano' : 'la ciudadana';

            return view('modulos.recibos_constancias.recibospagos.resultado_jubilado', compact('persona', 'genero'))->render();

        } catch (\Exception $e) {
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
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        return view('modulos.recibos_constancias.recibospagos.mensual_trabajador', compact('anios', 'meses', 'mes_actual', 'anio_actual'));
    }

    public function buscarHistoricoMensual(Request $request)
    {
        $request->validate([
            'ndocumento' => 'required',
            'anio' => 'required',
            'mes' => 'required'
        ]);

        $db = DB::connection('sigefirrhh');

        // Esta consulta replica el SQL del código viejo pero adaptado a Query Builder
        $historial = $db->table('recibos_pagos_constancias.recibo_pago as rp')
            ->join('public.personales as p', 'p.cedula', '=', 'rp.personales_cedula')
            ->join('public.cargos as c', 'rp.cargos_id', '=', 'c.id')
            ->where('p.cedula', $request->ndocumento)
            ->whereYear('rp.dfecha_creacion', $request->anio)
            ->whereMonth('rp.dfecha_creacion', $request->mes)
            ->where('rp.nestatus', '1')
            ->select('rp.*', 'p.primer_nombre', 'p.primer_apellido', 'c.sdescripcion as cargo')
            ->get();

        if ($historial->isEmpty()) {
            return response()->json(['message' => 'No se encontraron recibos para el periodo seleccionado.'], 404);
        }

        return view('modulos.recibos_constancias.recibospagos.resultado_historico', compact('historial'))->render();
    }
}
