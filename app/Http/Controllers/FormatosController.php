<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personales;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FormatosController extends Controller
{
   public function notificacion()
   {

      return view('modulos.formatos.notificacion-ausencia');
   }

   public function select(){
     return DB::connection('bd4')->table('public.personales')
            ->leftJoin('public.entidad', function ($join) {
                $join->on('entidad.nentidad', '=', 'personales.nentidad_entidad')
                    ->orOn('entidad.nentidad', '=', 'personales.nentidad_trab');
            })
            ->leftJoin('public.municipio', 'municipio.nmunicipio', '=', 'personales.nmunicipio_municipio')
            ->leftJoin('public.parroquia', 'parroquia.nparroquia', '=', 'personales.nparroquia_parroquia')
            ->leftJoin('public.ciudad', 'ciudad.id', '=', 'personales.id_ciudad')
            ->leftJoin('public.grupo_sanguineo', 'grupo_sanguineo.id', '=', 'personales.id_grupo_sanguineo')
            ->leftJoin('public.tipo_discapacidad', 'tipo_discapacidad.id', '=', 'personales.id_tipo_discapacidad')
            ->leftJoin('public.grado_discapacidad', 'grado_discapacidad.id', '=', 'personales.id_grado_discapacidad')
            ->leftJoin('recibos_pagos_constancias.recibo_pago', 'recibo_pago.personales_cedula', '=', 'personales.cedula')
            ->leftJoin('public.cargos', 'recibo_pago.cargos_id', '=', 'cargos.id')
            ->leftJoin('public.tipo_trabajador', 'recibo_pago.tipo_trabajador_ncodigo', '=', 'tipo_trabajador.ncodigo')
            ->leftJoin('public.ubicacion_administrativa', 'recibo_pago.ubicacion_administrativa_scodigo', '=', 'ubicacion_administrativa.scodigo')
            ->leftJoin('public.ubicacion_fisica', 'recibo_pago.ubicacion_fisica_scodigo', '=', 'ubicacion_fisica.scodigo')
            ->where('personales.cedula', Auth::user()->cedula)
            ->where('recibo_pago.nestatus', 1)
            ->orderByDesc('recibo_pago.dfecha_creacion')
            ->select([
                'personales.cedula',
                'personales.nacionalidad',
                'personales.ncont_estudios',
                'personales.id_opc_educativas',
                'personales.nparticipar_facilitador',
                'personales.primer_apellido',
                'personales.segundo_apellido',
                'personales.primer_nombre',
                'personales.segundo_nombre',
                'personales.id_ciudad',
                'personales.fecha_nacimiento',
                'personales.sexo',
                'personales.estado_civil',

                'personales.ncodigo_telfmovil',
                'personales.nnumero_telfmovil',
                'personales.ncodigo_telflocal',
                'personales.nnumero_telflocal',

                'personales.semail',
                'personales.srif',
                'personales.nentidad_entidad',
                'personales.nmunicipio_municipio',
                'personales.nparroquia_parroquia',
                'personales.nentidad_trab',
                'personales.ndireccion1',
                'personales.sdireccion1_2',
                'personales.ndireccion2',
                'personales.sdireccion2_2',
                'personales.ndireccion3',
                'personales.sdireccion3_2',
                'personales.ndireccion4',
                'personales.sdireccion4_2',
                'personales.spunto_referencia',
                'personales.snombre_emerg_familiar',
                'personales.sapellido_emerg_familiar',

                'personales.ncodigo_telfmovil_emerg1',
                'personales.nnumero_telfmovil_emerg1',
                'personales.ncodigo_telfmovil_emerg2',
                'personales.nnumero_telfmovil_emerg2',

                'personales.sparentesco_emerg_familiar',
                'personales.snombre_emerg_contacto',
                'personales.sapellido_emerg_contacto',
                'personales.ntelefono_emerg_contacto',
                'personales.sparentesco_emerg_contacto',
                'personales.sdiscapacidad',
                'personales.id_tipo_discapacidad',
                'personales.id_grado_discapacidad',
                'personales.scodigo_conapdis',
                'personales.slateralidad',
                'personales.id_grupo_sanguineo',
                'personales.sinscripcion_militar',
                'personales.ncodigo_inscripcion_militar',
                'personales.ncant_hijos',
                'personales.sconyuge_trabajo',
                'personales.stalla_camisa',
                'personales.stalla_pantalon',
                'personales.ntalla_zapato',
                'personales.stalla_chaqueta',
                'personales.subicacion_fisica',
                'personales.ntelefono_oficina',
                'personales.scargo_actual_ejerce',
                'personales.fecha_ingreso',
                'personales.fecha_ingreso_adm',
                'personales.sobservacion',
                'personales.ncodigo_telfoficina',
                'personales.nnumero_telfoficina',

                'ciudad.sdescripcion as ciudad',
                'municipio.sdescripcion as municipio',
                'parroquia.sdescripcion as parroquia',
                'grupo_sanguineo.sdescripcion as grupo_sanguineo',
                'tipo_discapacidad.sdescripcion as tipo_discapacidad',
                'grado_discapacidad.sdescripcion as grado_discapacidad',
                'recibo_pago.tipo_trabajador_ncodigo',
                'recibo_pago.ncodigo_nomina',
                'tipo_trabajador.ncodigo',
                'tipo_trabajador.sdescripcion_anterior_al10102013',
                'cargos.scodigo',
                'cargos.sdescripcion as cargo',
                'ubicacion_administrativa.sdescripcion as ubicacion',

            ])
            ->first();

   }

   public function generarPDFnotificacion(Request $request){
      // $request->validate([
      //    'motivo' => 'required|string|max:44|alpha_num:ascii',
      //    'fecha_inicio' => 'required',
      //    'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
      //    'soporte_legal' => 'required|string|max:200|alpha_num:ascii',
      //    'nombre' => 'required|string|max:45|regex:/^[a-zA-Z0-9\s]+$/',
      //    'director' => 'required|string|max:45|regex:/^[a-zA-Z0-9\s]+$/',
      // ], [], [
      //    'motivo' => 'Motivo',
      //    'fecha_inicio' => 'Fecha de inicio',
      //    'fecha_final' => 'Fecha de final'
      //    ,'fecha_final.after_or_equal' => 'Fecha de fin',
      //    'soporte_legal' => 'Soporte legal',
      //    'nombre' => 'Nombre',
      //    'director' => 'Director'
      // ]);

      $validator = Validator::make($request->all(), [
        'motivo' => 'required|string|max:100||regex:/^[a-zA-Z0-9\s]+$/i',
        'fecha_inicio' => 'required',
        'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        'soporte_legal' => 'required|string|max:200||regex:/^[a-zA-Z0-9\s]+$/',
        'nombre' => 'required|string|max:45|regex:/^[a-zA-Z0-9\s]+$/',
        'director' => 'required|string|max:45|regex:/^[a-zA-Z0-9\s]+$/',
    ], [], [
        'motivo' => 'Motivo',
        'fecha_inicio' => 'Fecha de Solicitud Inicio',
        'fecha_final' => 'Fecha de Solicitud Fin',
        'soporte_legal' => 'Soporte legal',
        'nombre' => 'Nombre y Apellido del Jefe(a)/Supervisor(a) Inmediato',
        'director' => 'Nombre y Apellido del Director(a)'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

      // Datos que quieres pasar al PDF (como si fuera una vista normal)
      $user = $this->select();

      $motivo= wordwrap ($request->input('motivo'), 17, "\n", true);
      $fecha_inicio = Carbon::parse($request->input('fecha_inicio'))->format('d-m-Y');
      $fecha_final = Carbon::parse($request->input('fecha_final'))->format('d-m-Y');
      $duracion= $request->input('duracion');
      // Esto inserta un <br> cada 50 caracteres sin romper palabras,
      // o rompiéndolas si es estrictamente necesario.
      $soporte_legal = wordwrap($request->input('soporte_legal'), 55, "\n", true);
      $nombre= wordwrap ($request->input('nombre'), 17, "\n", true);
      $director= wordwrap ($request->input('director'), 17, "\n", true);
      $fecha_actual = now()->format('d-m-Y');
           //dd($user);
        // 2. Usas la fachada 'Pdf' para cargar una vista de Blade.
        // 'pdf.mi_vista' es la ruta al archivo blade (resources/views/pdf/mi_vista.blade.php)
      return Pdf::loadView('modulos.formatos.pdf.pdf_notificacion', compact('user','motivo','fecha_inicio','fecha_final','duracion','soporte_legal','nombre','director','fecha_actual'))->stream('notificacion_ausencia.pdf', ['Attachment' => false]);

        // 3. Eliges qué hacer con el PDF:

        // Opción A: Verlo en el navegador (Stream)
       // return $pdf->stream('documento.pdf');

        // Opción B: Forzar la descarga (Download)
        // return $pdf->download('documento.pdf');

      //return back()->with('success', 'PDF generado correctamente.');
   }

   public function permiso()
   {
      return view('modulos.formatos.solicitud-permiso');
   }

   public function generarPDFpermiso(Request $request){
      $validator = Validator::make($request->all(), [
         'motivo' => 'required|string|max:100||regex:/^[a-zA-Z0-9\s]+$/',
         'fecha_inicio' => 'required',
        'fecha_final' => 'required|after_or_equal:fecha_inicio',
         'soporte_legal' => 'required|string|max:200||regex:/^[a-zA-Z0-9\s]+$/',
         'nombre' => 'required|string|max:45|regex:/^[a-zA-Z0-9\s]+$/',
         'director' => 'required|string|max:45|regex:/^[a-zA-Z0-9\s]+$/',

         //'duracion' => 'required'
      ],[

      ], [
         'motivo' => ' Motivo',
        'fecha_inicio' => 'Fecha de Solicitud Inicio',
         'fecha_final' => 'Fecha de Solicitud Fin',
         'soporte_legal' => ' Soporte  Legal ',
         'nombre' => 'Nombre y Apellido del Jefe(a)/Supervisor(a) Inmediato',
         'director' => 'Nombre y Apellido del Director(a)',
       //  'duracion' => 'de la sección de fecha solicitada'
      ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $this->select();

        $motivo= wordwrap ($request->input('motivo'), 17, "\n", true);
        $fecha_inicio = Carbon::parse($request->input('fecha_inicio'))->format('d-m-Y');
        $fecha_final = Carbon::parse($request->input('fecha_final'))->format('d-m-Y');
        $duracion= $request->input('duracion');
        $soporte_legal = wordwrap($request->input('soporte_legal'), 55, "\n", true);
        $nombre= wordwrap ($request->input('nombre'), 17, "\n", true);
        $director= wordwrap ($request->input('director'), 17, "\n", true);
        $fecha_actual = now()->format('d-m-Y');
           //dd($user);
        // 2. Usas la fachada 'Pdf' para cargar una vista de Blade.
        // 'pdf.mi_vista' es la ruta al archivo blade (resources/views/pdf/mi_vista.blade.php)
       return Pdf::loadView('modulos.formatos.pdf.pdf_permiso', compact('user','motivo','fecha_inicio','fecha_final','duracion','soporte_legal','nombre','director','fecha_actual'))->stream('solicitud_permiso.pdf', ['Attachment' => false]);
   }


   public function vacaciones(){

     $años_servicio = $this->calcularAños(Auth::user()->fecha_ingreso);

      return view('modulos.formatos.solicitud-vacaciones', compact('años_servicio'));
   }

   public function generarPDFvacaciones(Request $request){

      try {
       $validator = Validator::make($request->all(), [
            'años_servicio_apn' => 'required|numeric',
            //  'correo_electronico' => 'required|email',
            'lapso_vacacional_solicitado' => 'required|regex:/^\d{4}\/\d{4}(,\s?\d{4}\/\d{4})*$/',
            'fecha_deseada' => 'required|date',
            // 'jefe_supervisor_inmediato' => 'required',
            // 'director1' => 'required',
         ], [], [

            'años_servicio_apn' => 'Años de Servicio en la APN',
         //    'correo_electronico' => 'Correo electronico',
            'lapso_vacacional_solicitado' => 'Lapso Vacacional Solicitado',
            'fecha_deseada' => 'la Fecha Deseada',
            // 'jefe_supervisor_inmediato' => 'Supervisor inmediato',
            // 'director1' => 'Director',
         ]);

          if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

                 $user = $this->select();
               $user->fecha_ingreso;

               $años_servicio = $this->calcularAños($user->fecha_ingreso);

            //    return $user;

         $años_servicio_apn= $request->input('años_servicio_apn');
         $lapso_vacacional_solicitado= $request->input('lapso_vacacional_solicitado');
         $fecha_deseada= $request->input('fecha_deseada');
         $jefe_supervisor_inmediato= $request->input('jefe_supervisor_inmediato');
         $director1= $request->input('director1');
         $fecha_actual = now()->format('d-m-Y');
         $totalservicios = $años_servicio + $años_servicio_apn;


            return Pdf::loadView('modulos.formatos.pdf.pdf_vacaciones', compact('user',
                                                                                             'fecha_actual',
                                                                                             'años_servicio_apn',
                                                                                             'lapso_vacacional_solicitado',
                                                                                             'jefe_supervisor_inmediato',
                                                                                             'director1',
                                                                                             'años_servicio',
                                                                                             'totalservicios','fecha_deseada'))->stream('solicitud_vacaciones.pdf', ['Attachment' => false]);

      } catch (\Illuminate\Validation\ValidationException $e) {
         return redirect()->back()->withErrors($e->errors())->withInput();

      } catch (\Throwable $th) {
         return redirect()->back()->with('error', 'Error: '. $th->getMessage())->withInput();
      }


   }


   private function calcularAños($fecha_ingreso){
    $fecha_ingreso= new \DateTime($fecha_ingreso);
    $hoy = new \DateTime();
    return $hoy->diff($fecha_ingreso) ->y;
   }
}
