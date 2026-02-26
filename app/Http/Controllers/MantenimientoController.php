<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MantenimientoController extends Controller
{
    public function indexTickets()
    {
        $anio_actual = date('Y');
        // Obtenemos el histórico de la tabla
        $historico = DB::connection('bd4')
            ->table('recibos_pagos_constancias.tickets_alimentacion')
            ->orderBy('nanio_vigencia', 'desc')
            ->orderBy('smes', 'desc')
            ->get();

        // Meses para el select
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        return view('modulos.recibos_constancias.mantenimiento.tickets_alimentacion', compact('historico', 'anio_actual', 'meses'));
    }

   public function guardarTicket(Request $request)
{
    $request->validate([
        'mes_vigencia' => 'required',
        'txt_monto_unidad' => 'required|numeric',
        'txt_porcentaje' => 'required|numeric',
        'txt_monto_cancelar' => 'required|numeric',
    ]);

    $usuario_id = Auth::id();
    if (!$usuario_id) {
        return redirect()->back()->with('error', 'Error: Sesión de usuario no encontrada.');
    }

    try {
        DB::connection('bd4')->transaction(function () use ($request, $usuario_id) {
            $esquemaTabla = 'recibos_pagos_constancias.tickets_alimentacion';
            
            // --- PASO 1: REPARAR LA SECUENCIA (SOLUCIÓN AL ERROR 23505) ---
            // Esto sincroniza el contador interno con el valor máximo real de ncodigo
            DB::connection('bd4')->statement("
                SELECT setval(
                    pg_get_serial_sequence('$esquemaTabla', 'ncodigo'), 
                    (SELECT MAX(ncodigo) FROM $esquemaTabla)
                )
            ");

            // --- PASO 2: INHABILITAR REGISTROS ACTIVOS ---
            DB::connection('bd4')
                ->table($esquemaTabla)
                ->where('nenabled', 1)
                ->update([
                    'nenabled' => 0,
                    'nusuario_actualizacion' => $usuario_id,
                    'dfecha_actualizacion' => now()
                ]);

            // --- PASO 3: INSERTAR NUEVO TICKET ---
            DB::connection('bd4')
                ->table($esquemaTabla)
                ->insert([
                    'nunidad_tributaria' => $request->txt_monto_unidad,
                    'nmonto'             => $request->txt_monto_cancelar,
                    'dfecha_creacion'    => now(),
                    'nusuario_creacion'  => $usuario_id,
                    'nenabled'           => 1,
                    'nanio_vigencia'     => date('Y'),
                    'nporcentaje'        => $request->txt_porcentaje,
                    'smes'               => $request->mes_vigencia
                ]);
        });

        return redirect()->back()->with('success', 'Datos ingresados y secuencia sincronizada correctamente.');

    } catch (\Exception $e) {
        \Log::error("Error en guardarTicket: " . $e->getMessage());
        return redirect()->back()->with('error', 'Error al procesar: ' . $e->getMessage());
    }
}

public function indexUsuarios()
{
    $rolesPermitidos = [38, 29];

    $query = "
        SELECT DISTINCT ON (p.cedula)
            p.cedula, 
            p.primer_nombre, 
            p.primer_apellido, 
            r.sdescripcion AS rol_nombre, 
            pr.nenabled AS estatus_rol  -- Le ponemos este alias
        FROM public.personales AS p
        INNER JOIN public.personales_rol AS pr ON p.cedula = pr.personales_cedula
        INNER JOIN public.rol AS r ON pr.rol_id = r.id
        WHERE p.nenabled = '1' 
          AND pr.nenabled = '1'
          AND r.id IN (" . implode(',', $rolesPermitidos) . ")
        ORDER BY p.cedula ASC
    ";

    $usuarios = collect(DB::connection('bd4')->select($query));

    return view('modulos.recibos_constancias.mantenimiento.usuarios', compact('usuarios'));
}

public function gestionarUsuario(Request $request)
{
    $accion = $request->accion;
    $cedula = $request->cedula;
    $db = DB::connection('bd4');

    // ACCIÓN 1: BUSCAR TRABAJADOR
    if ($accion == 1) {
        // Buscamos solo por cédula, sin nacionalidad
        $personal = $db->table('public.personales')
            ->where('nenabled', '1')
            ->where('cedula', $cedula)
            ->first();

        if ($personal) {
            $nombre = "{$personal->primer_nombre} {$personal->segundo_nombre}, {$personal->primer_apellido} {$personal->segundo_apellido}";
            
            $rol = $db->table('public.personales_rol')
                ->where('personales_cedula', $cedula)
                ->where('nenabled', '1')
                ->value('rol_id');

            return response()->json([
                'status' => 1,
                'nombre' => $nombre,
                'rol' => $rol ?? '-1'
            ]);
        }
        return response()->json(['status' => 0, 'mensaje' => 'Usuario no registrado en la base de datos central.']);
    }

    // ACCIÓN 2: ASIGNAR / ACTUALIZAR ROL
    if ($accion == 2) {
        $rol = $request->rol;
        if($rol == "-1") return response()->json(['status' => 0, 'mensaje' => 'Debe seleccionar un rol']);

        try {
            $db->transaction(function () use ($db, $cedula, $rol) {
                // Inhabilitar roles anteriores
                $db->table('public.personales_rol')
                    ->where('personales_cedula', $cedula)
                    ->update(['nenabled' => '0']);

                $exists = $db->table('public.personales_rol')
                    ->where('personales_cedula', $cedula)
                    ->where('rol_id', $rol)
                    ->exists();

                if ($exists) {
                    $db->table('public.personales_rol')
                        ->where('personales_cedula', $cedula)
                        ->where('rol_id', $rol)
                        ->update([
                            'nenabled' => '1',
                            'dfecha_caducidad' => '2026-12-31'
                        ]);
                } else {
                    $db->table('public.personales_rol')->insert([
                        'personales_cedula' => $cedula,
                        'rol_id' => $rol,
                        'dfecha_caducidad' => '2026-12-31',
                        'nenabled' => '1'
                    ]);
                }
            });
            return response()->json(['status' => 1, 'mensaje' => '¡Rol asignado con éxito!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'mensaje' => 'Error: ' . $e->getMessage()]);
        }
    }

    // ACCIÓN 3: INHABILITAR
    if ($accion == 3) {
        $update = $db->table('public.personales_rol')
            ->where('personales_cedula', $cedula)
            ->where('nenabled', '1') 
            ->update(['nenabled' => '0']);

        if ($update) {
            return redirect()->back()->with('success', 'Rol inhabilitado con éxito.');
        }
        return redirect()->back()->with('error', 'El usuario no tiene un rol activo.');
    }
}
}
