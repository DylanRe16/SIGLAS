<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud_citaModel;
use App\Models\EmpresaModel;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Persona;
use App\Models\PersonaRol;
use App\Models\PersonaRolUnidadSust;
use App\Models\Solicitud;
use App\Models\SolicitudProcurador;
use App\Models\TipoSolicitud;
use App\Models\UnidadSust;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class Solicitud_citaController extends Controller{
    
    public function index(){
        return view('modulos.solicitud.cita');
    }
    

    public function show(){
        $citas_user = Solicitud_citaModel::with(['persona', 'empresa', 
                                                'tipoSolicitud',
                                                'empresa.estado',
                                                'empresa.municipio',
                                                'empresa.parroquia',
                                                'empresa.sector',])
                        ->where('id_persona', Auth::user()->id_persona)
                        ->orderBy('id_ptsolicitud','desc')->paginate(10);


        return view('modulos.solicitud.cita-show', ['citas_user' => $citas_user]);
    }


    public function show2($id_ptsolicitud){
        $cita = Solicitud_citaModel::with(['persona', 'empresa', 
                                                'tipoSolicitud',
                                                'empresa.estado',
                                                'empresa.municipio',
                                                'empresa.parroquia',
                                                'empresa.sector',])
                        ->where('id_ptsolicitud', $id_ptsolicitud)
                        ->first();

        if (empty($cita)){
            return redirect()->route('cita-show')->with('error', 'Solicitud no encontrada.');
        }
        $requisitos = TipoSolicitud::find($cita->id_tsolicitud)->requisitos;
        // return $requisitos;

        return view('modulos.solicitud.cita-show2-table', ['cita' => $cita]);
    }

    public function show3($id_ptsolicitud){
        $cita = Solicitud_citaModel::with([
            'persona', 'empresa', 'tipoSolicitud',
            'empresa.estado', 'empresa.municipio',
            'empresa.parroquia', 'empresa.sector'
        ])->where('id_ptsolicitud', $id_ptsolicitud)->first();

        if (!$cita) {
            return redirect()->route('cita-show')->with('error', 'No se encontró la cita.');
        }

        // Verificar si id_persona tiene un valor
        if (!$cita->id_persona) {
            return redirect()->route('cita-show')->with('error', 'No se encontró información de la persona.');
        }

        // Obtener manualmente la persona si la relación está fallando
        $persona = Persona::where('id_persona', $cita->id_persona)->first();

        if (!$persona) {
            return redirect()->route('cita-show')->with('error', 'No se encontraron datos de la persona.');
        }

        $requisitos = TipoSolicitud::find($cita->id_tsolicitud)->requisitos;

        /* dd($persona->toArray()); */

        return view('modulos.solicitud.prueba', compact('cita', 'requisitos', 'persona','procurador'));
    }
    
    // TODO: en caso de que haya digitado el rif de la entidad
    public function create(Request $request, $cita_id = null){

        request()->validate([
            'tipo_rif' => 'required|string|max:1|in:J,G,C',
            'num_rif' => 'required|string|max:10|size:9',
        ],[
            'tipo_rif.required' => 'El campo tipo de RIF es obligatorio.',
            'num_rif.required' => 'El campo número de RIF es obligatorio.',
            'tipo_rif.in' => 'El tipo de RIF debe ser J, G o C.',
            'num_rif.size' => 'El número de RIF debe ser de 9 dígitos.',
        ],[
            'tipo_rif' => 'Tipo de RIF',
            'num_rif' => 'Número de RIF',
        ]);

        $sectores = DB::connection('bd2')->table('public.tb_sector_empleo')->select('id_sectoremp', 'sdescripcion')->where('benabled', 'true')->get();
        $solicitud = DB::connection('bd2')->table('public.tb_solicitud')->select('id_solicitud', 'sdescripcion')->where('benabled', 'true')->get();
        $tipo_solicitud = DB::connection('bd2')->table('public.tb_tipo_solicitud')->select('id_tsolicitud', 'sdescripcion')->where('benabled', 'true')->get();
        $estados = DB::connection('bd2')->table('public.tb_estado')->select('id_estado', 'sdescripcion')->where('benabled', 'true')->get();
        $municipios = DB::connection('bd2')->table('public.tb_municipio')->select('id_municipio', 'sdescripcion')->where('benabled', 'true')->get();
        $parroquias = DB::connection('bd2')->table('public.tb_parroquia')->select('id_parroquia', 'sdescripcion')->where('benabled', 'true')->get();

        // $citas_user = Solicitud_citaModel::where('id_persona', Auth::user()->id_persona)
        //                                     ->where('id_empresa', Auth::user()->id_persona)                        
        //                                     ->get();
        // $empresa = EmpresaModel::where('id_persona', Auth::user()->id_persona)->get();  

        $citas_user = Solicitud_citaModel::with(['persona', 'empresa', 
                                                'tipoSolicitud',
                                                'empresa.estado',
                                                'empresa.municipio',
                                                'empresa.parroquia',
                                                'empresa.sector',])
                        ->where('id_persona', Auth::user()->id_persona)
                        ->get();


        $rif = strtoupper($request->tipo_rif). "" . $request->num_rif;

        // return $rif;
        // verifica que la empresa se encuentre en BD entes tabla Seniat
        $entidad = DB::connection('third_pgsql')
                        ->table('public.seniat')
                        ->where('srif', $rif)
                        ->first();

        $cita = null;
        if ($cita_id) {
            $cita = Solicitud_citaModel::with(['persona', 'empresa', 
                                                'tipoSolicitud',
                                                'empresa.estado',
                                                'empresa.municipio',
                                                'empresa.parroquia',
                                                'empresa.sector',])->find($cita_id);
        }
                        
        if (is_null($entidad)) {
            session()->flash('warning', 'Entidad no encontrada, puede ingresar los datos manualmente.');
            return view('modulos.solicitud.cita2', ['rif' => $rif,
                                                    'entidad' => $entidad,
                                                    'sectores' => $sectores,
                                                    'solicitud' => $solicitud,
                                                    'tipo_solicitud' => $tipo_solicitud,
                                                    'estados' => $estados,
                                                    'municipios' => $municipios,
                                                    'parroquias' => $parroquias,
                                                    'citas_user' => $citas_user,
                                                    'cita' => $cita,
                                                    'show_modal' => session('show_modal', false), // SIEMPRE enviar show_modal
                                                    ]);
        }

        

        // session()->flash('success', 'Datos de la entidad recuperados exitosamente');
        return view('modulos.solicitud.cita2', ['rif' => null,
                                                'entidad' => $entidad,
                                                'sectores' => $sectores,
                                                'solicitud' => $solicitud,
                                                'tipo_solicitud' => $tipo_solicitud,
                                                'estados' => $estados,
                                                'municipios' => $municipios,
                                                'parroquias' => $parroquias,
                                                'citas_user' => $citas_user,
                                                'cita' => $cita,
                                                'show_modal' => session('show_modal', false), // SIEMPRE enviar show_modal
                                            ]);
    }


    // TODO: en caso de que haya seleccionado el link de no saber el rif de la entidad
    public function create2(Request $request, $cita_id = null){
        

        $sectores = DB::connection('bd2')->table('public.tb_sector_empleo')->select('id_sectoremp', 'sdescripcion')->where('benabled', 'true')->get();
        $solicitud = DB::connection('bd2')->table('public.tb_solicitud')->select('id_solicitud', 'sdescripcion')->where('benabled', 'true')->get();
        $tipo_solicitud = DB::connection('bd2')->table('public.tb_tipo_solicitud')->select('id_tsolicitud', 'sdescripcion')->where('benabled', 'true')->get();
        $estados = DB::connection('bd2')->table('public.tb_estado')->select('id_estado', 'sdescripcion')->where('benabled', 'true')->get();
        $municipios = DB::connection('bd2')->table('public.tb_municipio')->select('id_municipio', 'sdescripcion')->where('benabled', 'true')->get();
        $parroquias = DB::connection('bd2')->table('public.tb_parroquia')->select('id_parroquia', 'sdescripcion')->where('benabled', 'true')->get();

        $citas_user = Solicitud_citaModel::with(['persona', 'empresa', 
                                                'tipoSolicitud',
                                                'empresa.estado',
                                                'empresa.municipio',
                                                'empresa.parroquia',
                                                'empresa.sector',])
                                            ->where('id_persona', Auth::user()->id_persona)
                                            ->get();

        $cita = null;
        if ($cita_id) {
            $cita = Solicitud_citaModel::with(['persona', 'empresa', 
                                                'tipoSolicitud',
                                                'empresa.estado',
                                                'empresa.municipio',
                                                'empresa.parroquia',
                                                'empresa.sector',])->find($cita_id);
        }

        $rif = null; // o el valor que corresponda según tu lógica

        return view('modulos.solicitud.cita2', ['rif' => null,
                                                'sectores' => $sectores,
                                                'solicitud' => $solicitud,
                                                'tipo_solicitud' => $tipo_solicitud,
                                                'estados' => $estados,
                                                'municipios' => $municipios,
                                                'parroquias' => $parroquias, 
                                                'citas_user' => $citas_user,
                                                'cita' => $cita,
                                                'show_modal' => session('show_modal', false),]);    
    }


    // TODO: para generar el listado de municipios y parroquias de manera dinámica
    public function getMunicipios($estadoId)
    {
        $municipios = DB::connection('bd2')
            ->table('public.tb_municipio')
            ->select('id_municipio', 'sdescripcion') // Selecciona los campos necesarios
            ->where('id_estado', $estadoId) // Filtra por el estado
            ->where('benabled', 'true') // Solo municipios habilitados
            ->get();

        return response()->json($municipios);
    }


    public function getParroquias($municipioId)
    {
        $parroquias = DB::connection('bd2')
            ->table('public.tb_parroquia')
            ->select('id_parroquia', 'sdescripcion') // Selecciona los campos necesarios
            ->where('id_municipio', $municipioId) // Filtra por el municipio
            ->where('benabled', 'true') // Solo parroquias habilitadas
            ->get();

        return response()->json($parroquias);
    }

    // TODO: para generar el listado de tipos de solicitud de manera dinámica
    public function getTipoSolicitud($solicitudId)
    {
        $tipo_solicitud = DB::connection('bd2')
            ->table('public.tb_tipo_solicitud')
            ->select('id_tsolicitud', 'sdescripcion') // Selecciona los campos necesarios
            ->where('id_solicitud', $solicitudId) // Filtra por el id de la solicitud
            ->where('benabled', 'true') // Solo tipos de solicitud habilitados
            ->get();

        return response()->json($tipo_solicitud);
    }

    // TODO: para guardar la solicitud
    public function store(StoreCitaRequest $request){
        // cuando se requiera, se debe colocar una validacion en caso de que el cliente tenga una cita con estatus 12 (en solicitud)
        // 1. Validar y obtener datos del request/empresa
        $data = $request->merge([
            'nusuario_creacion' => Auth::user()->ndocumento,
            'id_estatus' => 12,
        ]);

        // Todo: para validar si posee solicitud en estatus 12
       /*  $citasActivas = SolicitudProcurador::with(['personaSolicitud'])
        ->whereHas('personaSolicitud', function ($q){
            $q->where('id_persona', Auth::user()->id_persona);
        })->where('nenabled',1)->where('estatus_id',12)
        ->get(); // O la columna de tu clave primaria
    
        // return $citasActivas;
        
        if($citasActivas->count() > 0){
            return back()->with('error', 'Usted posee una solicitud activa.')->withInput();
        } */

        // Retorna los procuradores con rol_id = 91 que tienen una relación en la tabla personaRol_unidadSust,
        // validando además el estado correspondiente en esa relación.
        // 2. Buscar las Unidades Sustantivas del estado
        $unidades = UnidadSust::where('entidad_id', $request->id_estado)->first();
        

        if (!$unidades) {
            $estado = Estado::find($request->id_estado);
            return back()->with('error', 'Inspectorias no disponibles para el estado '. $estado->sdescripcion)->withInput();
        }
        // return $unidades->nnro_cupos_diarios;
        // Todo: para validar los municipios con inspectoria disponible en Miranda
        if ($request->id_estado == 15 && !in_array($request->id_municipio, [179, 183, 185, 195])) {
            $municipio = Municipio::find($request->id_municipio);
            return back()->with('error', 'Inspectoria no disponible para el municipio '. $municipio->sdescripcion .'.')->withInput();
        }
        
        // 3. Buscar procuradores (PersonalRol con rol 91) asociados a esas unidades
        // El modelo PersonalRolUnidadSust debe tener relación 'unidadSust' y 'personalRol'
        $personalRolUnidadSusts = PersonaRolUnidadSust::where('unidad_sustantiva_gs_id', $unidades->id)
            ->where('nenabled', 1)
            ->whereHas('personalRol', function($q) {
                $q->where('rol_id', 94)
                ->where('nenabled', 1);
            })
            ->get();
            
        if ($personalRolUnidadSusts->isEmpty()) {
            return back()->with('error', 'No se encontraron procuradores en las Inspectorias de este estado.')->withInput();
        }

        // DB::listen(function ($query) {
            //     Log::info($query->sql, $query->bindings, $query->time);
            // });
        // return $personalRolUnidadSusts;

        if ($request->tipo_solicitud == 0) {
            return back()->with('error', 'Debe seleccionar un tipo de solicitud.')->withInput();
        }
        
        // 4. Buscar fecha/hora disponible y procurador disponible
        $procuradorAsignado = null;
        $fechaDisponible = null;

        $maxCitasTotalesPorDia = $unidades->nnro_cupos_diarios;
        // return $maxCitasTotalesPorDia;
        $totalProcuradores = $personalRolUnidadSusts->count();
        // Citas base que recibirá cada procurador
        $maxCitasPorProcuradorPorDia = floor($maxCitasTotalesPorDia / $totalProcuradores); // máximo por día
        // return $personalRolUnidadSusts;
        $maxCitasPorProcuradorPorHora = 1; // máximo por hora (ajusta si necesitas)
        $intentos = 0;
        $fechasIntentadas = [];

        // id de los procuradores presentes en la uni dad sustantiva en particular
        $pruIds = $personalRolUnidadSusts->pluck('id')->toArray();
        // return $pruIds;
        do {
            $fechaDisponible = $this->getNextAvailableDateTime($pruIds,$fechasIntentadas, $maxCitasTotalesPorDia);

            if (!$fechaDisponible) {
                return back()->with('error', 'No hay fechas ni horarios disponibles para asignar.')->withInput();
            }

            // Marcar la fecha intentada para evitar repetirla si no hay procurador en ella
            $fechasIntentadas[] = $fechaDisponible;

            // 1. Obtén la cantidad de citas de cada procurador para la fecha/hora candidata
            $procuradoresConCitas = [];
            foreach ($personalRolUnidadSusts as $pru) {
                // Citas de este procurador en ese día
                $citasPorDia = SolicitudProcurador::where('personales_rol_unidad_sustantiva_id', $pru->id)
                    ->whereDate('dfecha_cita', Carbon::parse($fechaDisponible)->toDateString())
                    ->count();

                // Citas de este procurador en ese horario exacto
                $citasPorHora = SolicitudProcurador::where('personales_rol_unidad_sustantiva_id', $pru->id)
                    ->whereDate('dfecha_cita', Carbon::parse($fechaDisponible)->toDateString())
                    ->whereTime('dfecha_cita', Carbon::parse($fechaDisponible)->format('H:i:s'))
                    ->count();

                // Solo considerar procuradores que no han llegado al máximo por día ni por hora
                if ($citasPorDia < $maxCitasPorProcuradorPorDia && $citasPorHora < $maxCitasPorProcuradorPorHora) {
                    $procuradoresConCitas[] = [
                        'procurador' => $pru,
                        'citasPorDia' => $citasPorDia,
                    ];
                }
            }

            // Si hay al menos un procurador disponible, elige el que menos citas tenga ese día
            if (!empty($procuradoresConCitas)) {
                // Ordenar por menor cantidad de citas por día
                usort($procuradoresConCitas, function($a, $b) {
                    return $a['citasPorDia'] <=> $b['citasPorDia'];
                });
                $procuradorAsignado = $procuradoresConCitas[0]['procurador'];
                break;
            }

            $intentos++;
            if ($intentos > 100) {
                return back()->with('error', 'No se encontró combinación de fecha y procurador disponible.')->withInput();
            }
        } while(!$procuradorAsignado);

        // 6. Crear empresa si es necesario
        $empresa = EmpresaModel::create($data->all());

        $data = $request->merge([
            'id_empresa' => $empresa->id_empresa,
            'id_persona' => Auth::user()->id_persona,
            'id_tsolicitud' => $request->tipo_solicitud,
            'nusuario_creacion' => Auth::user()->ndocumento,
            'dfecha_creacion' => now(),
        ]);

        $solicitudCita = Solicitud_citaModel::create($data->all());

        // 8. Crear el registro en SolicitudProcurador
        SolicitudProcurador::create([
            'personales_rol_unidad_sustantiva_id' => $procuradorAsignado->id,
            'persona_tsolicitud_id' => $solicitudCita->id_ptsolicitud,
            'estatus_id' => 12, // puedes ajustar este valor si es necesario
            'personales_asistido' => $procuradorAsignado->personalRol->personales_cedula,
            'sobservacion' => '', // o puedes poner alguna observación relevante
            'dfecha_cita' => $fechaDisponible,
            'nenabled' => 1,
            'dfecha_creacion' => now(),
            'nusuario_creacion' => Auth::user()->ndocumento,
        ]);

        // Redirige al inicio y pasa los datos por sesión flash
        return redirect()->route('inicio')->with([
            'success' => 'Cita creada y asignada al procurador exitosamente.',
            'show_modal' => true,
            'cita' => $solicitudCita
        ]);
    }

    // * Método para obtener la próxima fecha y hora disponible para una cita.
    public function getNextAvailableDateTime($pruIds,$fechasIntentadas = [], $maxCitasTotalesPorDia){
        $horarios = [
            '08:00:00', 
            '13:30:00', 
        ];
        
        $maxCitasPorDia = floor($maxCitasTotalesPorDia);
        $maxCitasPorHora = floor($maxCitasTotalesPorDia / 2);
        $date = Carbon::now()->addDay();

        while (true) {
            if ($date->isWeekend()) {
                $date->addDay();
                continue;
            }
            
            // Filtra por unidad_sustantiva_gs_id
            $citas = SolicitudProcurador::whereIn('personales_rol_unidad_sustantiva_id', $pruIds)
                                        ->whereDate('dfecha_cita', $date->toDateString())
                                        ->get();
            $totalCitasDia = $citas->count();
            if ($totalCitasDia >= $maxCitasPorDia) {
                $date->addDay();
                continue;
            }
            foreach ($horarios as $hora) {
                $fechaHora = $date->copy()->setTimeFromTimeString($hora);
                // Si ya probaste esta fecha/hora, saltarla
                if (in_array($fechaHora->toDateTimeString(), $fechasIntentadas)) {
                    continue;
                }
                $citasCount = SolicitudProcurador::whereIn('personales_rol_unidad_sustantiva_id', $pruIds)
                    ->whereDate('dfecha_cita', $fechaHora->toDateString())
                    ->whereTime('dfecha_cita', $fechaHora->format('H:i:s'))
                    ->count();
                if ($citasCount < $maxCitasPorHora) {
                    return $fechaHora->toDateTimeString();
                }
            }
            $date->addDay();
        }
    }

}
