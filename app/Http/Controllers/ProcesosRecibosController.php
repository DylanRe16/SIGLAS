<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProcesosRecibosController extends Controller
{
    public function indexActualizar()
    {
        return view('modulos.recibos_constancias.procesos.actualizar_personal_procesos');
    }

    public function procesarCargaDatos()
    {
        // Aumentar el tiempo de ejecución para procesos masivos
        set_time_limit(600);

        try {
            // 1. Obtener datos de la BD externa (SIGEFIRRHH)
            $personalExterno = DB::connection('sigefirrhh')
                ->table('personal as p')
                ->join('trabajador as t', 't.id_personal', '=', 'p.id_personal')
                ->leftJoin('ciudad as c', 'c.id_ciudad', '=', 'p.id_ciudad_nacimiento')
                ->select(
                    'p.*', 't.fecha_ingreso', 't.fecha_ingreso_apn', 't.cod_tipo_personal', 'c.nombre as ciudad_nombre'
                )
                ->whereIn('t.estatus', ['A', 'E'])
                ->get();

            $idUsuarioActual = Auth::id() ?? 1; // ID del usuario logueado
            $fechaHoy = now();

            DB::connection('bd4')->transaction(function () use ($personalExterno, $idUsuarioActual, $fechaHoy) {
                foreach ($personalExterno as $p) {
                    
                    // Lógica de Rol
                    $tiposTrabajadores = [20, 25, 28, 29, 32, 33];
                    $rolAcceso = in_array($p->cod_tipo_personal, $tiposTrabajadores) ? 28 : 11;

                    // 2. Insertar o Ignorar en personales
                    // Usamos updateOrInsert para evitar duplicados y mantener datos frescos
                    DB::connection('bd4')->table('public.personales')->updateOrInsert(
                        ['cedula' => $p->cedula],
                        [
                            'nacionalidad'      => ($p->nacionalidad == 'V') ? '1' : '2',
                            'primer_apellido'   => $p->primer_apellido,
                            'segundo_apellido'  => $p->segundo_apellido,
                            'primer_nombre'     => $p->primer_nombre,
                            'segundo_nombre'    => $p->segundo_nombre,
                            'fecha_nacimiento'  => $p->fecha_nacimiento,
                            'fecha_ingreso'     => $p->fecha_ingreso,
                            'sexo'              => ($p->sexo == 'F') ? '1' : '2',
                            'fecha_ingreso_adm' => $p->fecha_ingreso_apn,
                            'srif2'             => $p->numero_rif,
                            'usuario_idcreacion'=> $idUsuarioActual,
                            'dfecha_creacion'   => $fechaHoy,
                            'nenabled'          => '1'
                        ]
                    );

                    // 3. Gestionar personales_rol
                    DB::connection('bd4')->table('public.personales_rol')->updateOrInsert(
                        ['personales_cedula' => $p->cedula, 'rol_id' => $rolAcceso],
                        [
                            'dfecha_caducidad' => '2026-12-31',
                            'nenabled' => '1',
                            'nusuario_creacion' => $idUsuarioActual,
                            'dfecha_creacion' => $fechaHoy
                        ]
                    );

                    // 4. Crear Sesión si no existe
                    $existeSesion = DB::connection('bd4')->table('public.sesion')
                        ->where('personales_cedula', $p->cedula)->exists();

                    if (!$existeSesion) {
                        DB::connection('bd4')->table('public.sesion')->insert([
                            'personales_cedula' => $p->cedula,
                            'clave' => md5($p->cedula),
                            'dfecha_creacion' => $fechaHoy,
                            'nusuario_creacion' => $idUsuarioActual,
                            'nenabled' => '1',
                            'nestatus' => '1'
                        ]);
                    }
                }
            });

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error("Error en carga de personal: " . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

   public function buscarTrabajador(Request $request)
    {
        try {
            $request->validate([
                'snacionalidad' => 'required',
                'ndocumento' => 'required|numeric|digits_between:1,11', // Validamos longitud razonable
            ]);

            $trabajador = DB::connection('bd4')
                ->table('public.personales as p')
                ->leftJoin('public.entidad as e', 'e.nentidad', '=', 'p.nentidad_entidad')
                ->leftJoin('public.municipio as m', 'm.nmunicipio', '=', 'p.nmunicipio_municipio')
                ->leftJoin('public.parroquia as pa', 'pa.nparroquia', '=', 'p.nparroquia_parroquia')
                ->select(
                    'p.cedula', 'p.nacionalidad', 'p.primer_apellido', 'p.segundo_apellido',
                    'p.primer_nombre', 'p.segundo_nombre', 'p.fecha_nacimiento', 'p.sexo',
                    'p.semail as correoelectronico', 'p.srif',
                    'e.scapital as ciudad_descripcion',
                    'm.sdescripcion as municipio_descripcion',
                    'pa.sdescripcion as parroquia_descripcion'
                )
                // IMPORTANTE: Cast a string para evitar el límite de integer en el binding de SQL
                ->where('p.cedula', '=', (string)$request->ndocumento) 
                ->first();

            if (!$trabajador) {
                return response()->json(['error' => 'No se encontró ningún trabajador con esa cédula.'], 404);
            }

            $html = view('modulos.recibos_constancias.procesos.partials.resultado_busqueda', compact('trabajador'))->render();
            return response()->json(['html' => $html]);

        } catch (\Exception $e) {
            // Si el error es específicamente de rango numérico, damos un mensaje limpio
            if (str_contains($e->getMessage(), '22003')) {
                return response()->json(['error' => 'El número de documento ingresado es demasiado largo para el sistema.'], 422);
            }
            return response()->json(['error' => 'Error de sistema: ' . $e->getMessage()], 500);
        }
    }

    public function viewProcesarFuncionarios()
    {
        // Especificamos la conexión 'bd4' para buscar el ticket
        $ticket = DB::connection('bd4')
                    ->table('recibos_pagos_constancias.tickets_alimentacion')
                    ->where('nenabled', 1)
                    ->first();

        if (!$ticket) {
            // Manejo de error si no hay ticket activo en bd4
            return redirect()->back()->with('error', 'No se encontró un ticket de alimentación activo en el esquema.');
        }

        return view('modulos.recibos_constancias.procesos.procesar_funcionarios', compact('ticket'));
    }

    public function storeProcesarFuncionarios(Request $request)
{
    // Aumentar tiempo de ejecución para procesos largos
    set_time_limit(3000);

    $request->validate([
        'anio'   => 'required',
        'mes'    => 'required',
        'semana' => 'required', // En la vista se llama semana, pero es la quincena
        'ticket' => 'required'
    ]);

    // --- NUEVO: Validación de Duplicados (Igual al código original) ---
    $existe = DB::connection('bd4')
        ->table('recibos_pagos_constancias.recibo_pago')
        ->where('nanio', $request->anio)
        ->where('nmes', $request->mes)
        ->where('nsemana_quincena', $request->semana)
        ->where('tipo_trabajador_ncodigo', '<>', '5')
        ->count();

    if ($existe > 0) {
        return redirect()->back()->with('error', 'La Nómina ya se encuentra registrada en el sistema.');
    }

    // --- 1. Obtener datos de SIGEFIRRHH (Usando historicoquincena para Funcionarios) ---
    $datosNomina = DB::connection('sigefirrhh')->select("
        SELECT 
            trabajador.cedula, 
            historicoquincena.mes, 
            historicoquincena.semana_quincena,
            trabajador.estatus, 
            trabajador.id_cargo, 
            dependencia.cod_dependencia as cod_ubicacion_adm,
            trabajador.codigo_nomina, 
            trabajador.cuenta_nomina, 
            concepto.cod_concepto,
            (CASE WHEN historicoquincena.monto_asigna = 0 THEN historicoquincena.monto_deduce ELSE historicoquincena.monto_asigna END) AS monto,
            historicoquincena.numero_nomina, 
            dependencia.cod_dependencia as cod_ubicacion_fisica,
            trabajador.cod_tipo_personal, 
            trabajador.forma_pago 
        FROM historicoquincena
        INNER JOIN trabajador ON historicoquincena.id_trabajador = trabajador.id_trabajador
        INNER JOIN personal ON trabajador.id_personal = personal.id_personal
        INNER JOIN dependencia ON trabajador.id_dependencia = dependencia.id_dependencia
        INNER JOIN cargo ON trabajador.id_cargo = cargo.id_cargo
        INNER JOIN conceptotipopersonal ON trabajador.id_tipo_personal = conceptotipopersonal.id_tipo_personal
        INNER JOIN tipopersonal ON trabajador.id_tipo_personal = tipopersonal.id_tipo_personal
        INNER JOIN concepto ON conceptotipopersonal.id_concepto = concepto.id_concepto
        WHERE historicoquincena.anio = ? 
          AND historicoquincena.mes = ? 
          AND historicoquincena.semana_quincena = ?
          AND historicoquincena.id_concepto_tipo_personal = conceptotipopersonal.id_concepto_tipo_personal
        ORDER BY concepto.cod_concepto
    ", [$request->anio, $request->mes, $request->semana]);

    if (empty($datosNomina)) {
        return redirect()->back()->with('info', 'No se encontraron registros en SIGEFIRRHH para los parámetros seleccionados.');
    }

    $fecha_carga = now();
    $id_usuario = auth()->id();

    // --- 2. Insertar en BD4 ---
    // Usamos una transacción para asegurarnos de que se guarde todo o nada
    DB::connection('bd4')->transaction(function () use ($datosNomina, $request, $fecha_carga, $id_usuario) {
        foreach ($datosNomina as $row) {
            $estatusMap = ['A' => 1, 'E' => 2, 'C' => 3, 'S' => 4];
            $estatusFinal = $estatusMap[$row->estatus] ?? 1;

            DB::connection('bd4')->table('recibos_pagos_constancias.recibo_pago')->insert([
                'personales_cedula'               => $row->cedula,
                'nmes'                            => $row->mes,
                'nsemana_quincena'                => $row->semana_quincena,
                'nestatus'                        => $estatusFinal,
                'cargos_id'                       => $row->id_cargo,
                'ubicacion_administrativa_scodigo'=> $row->cod_ubicacion_adm,
                'ncodigo_nomina'                  => $row->codigo_nomina,
                'scuenta_nomina'                  => $row->cuenta_nomina,
                'conceptos_scodigo'               => $row->cod_concepto,
                'nmonto'                          => $row->monto,
                'tickets_alimentacion_ncodigo'    => $request->ticket,
                'nnro_nomina'                     => $row->numero_nomina,
                'filtro'                          => 0,
                'nenabled'                        => 1,
                'dfecha_creacion'                 => $fecha_carga,
                'nusuario_creacion'               => $id_usuario,
                'ubicacion_fisica_scodigo'        => $row->cod_ubicacion_fisica,
                'tipo_trabajador_ncodigo'         => $row->cod_tipo_personal,
                'nforma_pago'                     => $row->forma_pago,
                'nanio'                           => $request->anio
            ]);
        }
    });

    return redirect()->back()->with('success', 'La carga de la Nómina se ha completado exitosamente. Total: ' . count($datosNomina));
}

    public function viewProcesarObreros()
{
    $ticket = DB::connection('bd4')
                ->table('recibos_pagos_constancias.tickets_alimentacion')
                ->where('nenabled', 1)
                ->first();

    // El nombre aquí debe coincidir con el archivo (sin el .blade.php)
    return view('modulos.recibos_constancias.procesos.procesar_obreros', compact('ticket'));
}

    public function storeProcesarObreros(Request $request)
    {
        set_time_limit(3000);

        $request->validate([
            'anio' => 'required',
            'mes' => 'required',
            'semana' => 'required',
            'ticket' => 'required'
        ]);

        // 1. Obtener datos de la base de datos externa (SIGEFIRRHH)
        $datosNomina = DB::connection('sigefirrhh')->select("
            SELECT trabajador.cedula, historicosemana.mes, historicosemana.semana_quincena,
                trabajador.estatus, trabajador.id_cargo, dependencia.cod_dependencia as cod_ubicacion_adm,
                trabajador.codigo_nomina, trabajador.cuenta_nomina, concepto.cod_concepto,
                (CASE WHEN historicosemana.monto_asigna = 0 THEN historicosemana.monto_deduce ELSE historicosemana.monto_asigna END) AS monto,
                historicosemana.numero_nomina, dependencia.cod_dependencia as cod_ubicacion_fisica1,
                trabajador.cod_tipo_personal, trabajador.forma_pago 
            FROM historicosemana
            INNER JOIN trabajador ON historicosemana.id_trabajador = trabajador.id_trabajador
            INNER JOIN personal ON trabajador.id_personal = personal.id_personal
            INNER JOIN dependencia ON trabajador.id_dependencia = dependencia.id_dependencia
            INNER JOIN cargo ON trabajador.id_cargo = cargo.id_cargo
            INNER JOIN conceptotipopersonal ON trabajador.id_tipo_personal = conceptotipopersonal.id_tipo_personal
            INNER JOIN tipopersonal ON trabajador.id_tipo_personal = tipopersonal.id_tipo_personal
            INNER JOIN concepto ON conceptotipopersonal.id_concepto = concepto.id_concepto
            WHERE historicosemana.anio = ? AND historicosemana.mes = ? AND historicosemana.semana_quincena = ?
            AND historicosemana.id_concepto_tipo_personal = conceptotipopersonal.id_concepto_tipo_personal
            ORDER BY concepto.cod_concepto
        ", [$request->anio, $request->mes, $request->semana]);

        $fecha_carga = now();
        $id_usuario = auth()->id();

        // 2. Insertar en la conexión 'bd4'
        foreach ($datosNomina as $row) {
            $estatusMap = ['A' => 1, 'E' => 2, 'C' => 3, 'S' => 4];
            $estatusFinal = $estatusMap[$row->estatus] ?? 1;

            DB::connection('bd4')->table('recibos_pagos_constancias.recibo_pago')->insert([
                'personales_cedula' => $row->cedula,
                'nmes' => $row->mes,
                'nsemana_quincena' => $row->semana_quincena,
                'nestatus' => $estatusFinal,
                'cargos_id' => $row->id_cargo,
                'ubicacion_administrativa_scodigo' => $row->cod_ubicacion_adm,
                'ncodigo_nomina' => $row->codigo_nomina,
                'scuenta_nomina' => $row->cuenta_nomina,
                'conceptos_scodigo' => $row->cod_concepto,
                'nmonto' => $row->monto,
                'tickets_alimentacion_ncodigo' => $request->ticket,
                'nnro_nomina' => $row->numero_nomina,
                'filtro' => 0,
                'nenabled' => 1,
                'dfecha_creacion' => $fecha_carga,
                'nusuario_creacion' => $id_usuario,
                'ubicacion_fisica_scodigo' => $row->cod_ubicacion_fisica1,
                'tipo_trabajador_ncodigo' => $row->cod_tipo_personal,
                'nforma_pago' => $row->forma_pago,
                'nanio' => $request->anio
            ]);
        }

        return redirect()->back()->with('success', 'Nómina cargada en BD4 exitosamente. Total: ' . count($datosNomina));
    }
}
