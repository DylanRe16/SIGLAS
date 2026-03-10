<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sigefirrhh;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Discapacidad;
use App\Models\Tipo_Discapacidad;
use App\Models\Grado_Discapacidad;
use App\Models\Estado_Civil;
use App\Models\Grupo_sanguineo;
use App\Models\Nivel_Academico;
use App\Models\Patologias;
use App\Models\Personales;
use App\Models\Personales_Patologias;
use App\Models\Personales_Nivel_Academico;
use App\Models\Productos_Medico;
use App\Models\Tb_Codigo_Telefonico;
use App\Models\Tratamiento_Medico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ActualizacionDatoController extends Controller
{
    //
    public function getMunicipios($estadoId)
    {
        $municipios = DB::connection('bd4')
            ->table('public.municipio')
            ->select('nmunicipio', 'sdescripcion') // Selecciona loss necesarios
            ->where('nentidad', $estadoId) // Filtra por el estado
            ->where('nenabled', 1) // Solo municipios habilitados
            ->get();

        return response()->json($municipios);
    }


    public function getParroquias($municipioId)
    {
        $parroquias = DB::connection('bd4')
            ->table('public.parroquia')
            ->select('nparroquia', 'sdescripcion') // Selecciona loss necesarios
            ->where('nmunicipio', $municipioId) // Filtra por el municipio
            ->where('nenabled', 1) // Solo parroquias habilitadas
            ->get();

        return response()->json($parroquias);
    }
    public function discapacidad()
    {
        $discapacidades = Discapacidad::where('nenabled', 1)->get();
        return $discapacidades;
    }
    public function tipo_discapacidad()
    {
        $tipo_discapacidades = Tipo_Discapacidad::where('nenabled', 1)->get();
        return $tipo_discapacidades;
    }
    public function grado_discapacidad()
    {
        $grado_discapacidades = Grado_Discapacidad::where('nenabled', 1)->get();
        return $grado_discapacidades;
    }
    public function grupo_sanguineo()
    {
        $grupo_sanguineos = Grupo_sanguineo::where('nenabled', 1)->get();
        return $grupo_sanguineos;
    }
    public function nivel_academico()
    {
        $nivel_academicos = Nivel_Academico::where('nenabled', 1)->get();
        return $nivel_academicos;
    }
    public function patologias()
    {
        $patologias = Patologias::where('nenabled', 1)->get();
        return $patologias;
    }
    public function tratamiento_medico()
    {
        $tratamiento_medicos = Productos_Medico::where('nenabled', 1)->get();
        return $tratamiento_medicos;
    }
    public function estado_civil()
    {
        $estado_civiles = Estado_Civil::where('nenabled', 1)->get();
        return $estado_civiles;
    }
    public function codigos_telefonicos_local()
    {
        $codigos_telefonicos = Tb_Codigo_Telefonico::where('benabled', 1)->where('btipo', true)->get();
        return $codigos_telefonicos;
    }
    public function codigos_telefonicos_personal()
    {
        $codigos_telefonicos = Tb_Codigo_Telefonico::where('benabled', 1)->where('btipo', false)->get();
        return $codigos_telefonicos;
    }
    public function show()
    {
        // 1. Obtenemos el registro principal del trabajador y su recibo activo
        // Eliminamos los 12 joins pesados y los cambiamos por una consulta base limpia.
        $user = DB::connection('bd4')->table('public.personales')
            ->leftJoin('recibos_pagos_constancias.recibo_pago', function ($join) {
                $join->on('recibo_pago.personales_cedula', '=', 'personales.cedula')
                    ->where('recibo_pago.nestatus', '=', 1);
            })
            ->where('personales.cedula', Auth::user()->cedula)
            ->orderByDesc('recibo_pago.dfecha_creacion')
            ->select('personales.*', 'recibo_pago.*') // Traemos todos los datos base primero
            ->first();

        // 2. Si el usuario existe, inyectamos las descripciones de los catálogos
        // Esto es mucho más rápido que hacer 12 Joins en una sola sentencia SQL.
        if ($user) {
            // Geografía
            $user->ciudad = DB::connection('bd4')->table('public.ciudad')->where('id', $user->id_ciudad)->value('sdescripcion');
            $user->municipio = DB::connection('bd4')->table('public.municipio')->where('nmunicipio', $user->nmunicipio_municipio)->value('sdescripcion');
            $user->parroquia = DB::connection('bd4')->table('public.parroquia')->where('nparroquia', $user->nparroquia_parroquia)->value('sdescripcion');

            // Salud y Discapacidad
            $user->grupo_sanguineo = DB::connection('bd4')->table('public.grupo_sanguineo')->where('id', $user->id_grupo_sanguineo)->value('sdescripcion');
            $user->tipo_discapacidad = DB::connection('bd4')->table('public.tipo_discapacidad')->where('id', $user->id_tipo_discapacidad)->value('sdescripcion');
            $user->grado_discapacidad = DB::connection('bd4')->table('public.grado_discapacidad')->where('id', $user->id_grado_discapacidad)->value('sdescripcion');

            // Datos Laborales (Cargos y Nómina)
            $user->cargo = DB::connection('bd4')->table('public.cargos')->where('id', $user->cargos_id)->value('sdescripcion');
            $user->ubicacion = DB::connection('bd4')->table('public.ubicacion_administrativa')->where('scodigo', $user->ubicacion_administrativa_scodigo)->value('sdescripcion');

            // Tipo de Trabajador
            $user->sdescripcion_anterior_al10102013 = DB::connection('bd4')->table('public.tipo_trabajador')
                ->where('ncodigo', $user->tipo_trabajador_ncodigo)
                ->value('sdescripcion_anterior_al10102013');

            // Entidad (Manejando el OR que causaba lentitud)
            $entidadId = $user->nentidad_entidad ?? $user->nentidad_trab;
            if ($entidadId) {
                $user->entidad_descripcion = DB::connection('bd4')->table('public.entidad')->where('nentidad', $entidadId)->value('sdescripcion');
            }
        }

        // Ahora tienes el objeto $user con todos los campos originales disponibles para tu vista.
        //dd($user);
        $discapacidades = $this->discapacidad();
        $tipo_discapacidades = $this->tipo_discapacidad();
        $grado_discapacidades = $this->grado_discapacidad();
        $grupo_sanguineos = $this->grupo_sanguineo();
        $nivel_academicos = $this->nivel_academico();
        $patologias = $this->patologias();
        $tratamiento_medicos = $this->tratamiento_medico();
        $estado_civiles = $this->estado_civil();
        $codigos_telefonicos_local = $this->codigos_telefonicos_local();
        $codigos_telefonicos_personal = $this->codigos_telefonicos_personal();
        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias = Parroquia::all();
        $cargos = DB::connection('bd4')->table('cargos')->where('nenabled', 1)->get();


        // 1. Obtener los IDs de las patologías del usuario
        $datosCompletos = DB::connection('bd4')->table('public.personales_patologias')
            // 1. Unimos con la descripción de la Patología
            ->leftJoin('public.patologias', 'personales_patologias.patologias_id', '=', 'patologias.id')

            // 2. Unimos con los Tratamientos Médicos (usando el ID de la relación personal)
            ->leftJoin('public.tratamiento_medico', 'tratamiento_medico.personales_patologias_id', '=', 'personales_patologias.id')

            // 3. Unimos con los Productos de esos tratamientos
            ->leftJoin('public.productos', 'tratamiento_medico.productos_id', '=', 'productos.id')

            // Filtros
            ->where('personales_patologias.personales_cedula', Auth::user()->cedula)
            ->where('personales_patologias.nenabled', true)

            // Selección de campos
            ->select(
                'patologias.sdescripcion as nombre_patologia',
                'personales_patologias.id as patologia_usuario_id',
                'productos.sdescripcion as producto',
                'tratamiento_medico.sobservacion',
                'tratamiento_medico.id as tratamiento_id'
            )
            ->get();

        $formacionAcademica = DB::connection('bd4')->table('public.personales_nivel_academico')
            ->leftJoin('public.nivel_academico', 'personales_nivel_academico.id_nivel_academico', '=', 'nivel_academico.id')
            ->select(
                'personales_nivel_academico.id_nivel_academico as nivel_academico_id',
                'personales_nivel_academico.id_personales',
                'nivel_academico.sdescripcion as nivel',
                'personales_nivel_academico.sespecialidad as especialidad',
                // Usamos DB::raw para manejar el booleano de PostgreSQL
                DB::raw("(CASE WHEN personales_nivel_academico.sgraduado = true THEN 'Sí' ELSE 'No' END) as graduado"),
                'personales_nivel_academico.nenabled'
            )
            ->where('id_personales', Auth::user()->cedula)
            ->where('personales_nivel_academico.nenabled', 1)
            ->get();
        // return $formacionAcademica;

        if ($formacionAcademica->isEmpty()) {
            $formacionAcademica = null;
        }



        return view('modulos.act_datos.actualizar_datos', [
            'user' => $user,
            'discapacidades' => $discapacidades,
            'tipo_discapacidades' => $tipo_discapacidades,
            'grado_discapacidades' => $grado_discapacidades,
            'grupo_sanguineos' => $grupo_sanguineos,
            'nivel_academicos' => $nivel_academicos,
            'patologias' => $patologias,
            'tratamiento_medicos' => $tratamiento_medicos,
            'estado_civiles' => $estado_civiles,
            'codigos_telefonicos_local' => $codigos_telefonicos_local,
            'codigos_telefonicos_personal' => $codigos_telefonicos_personal,
            'estados' => $estados,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'datosCompletos' => $datosCompletos,
            'formacionAcademica' => $formacionAcademica,
            'cargos' => $cargos

        ]);
    }
    public function store(Request $request)
    {
        //
        //return $request; 

        $request->validate([
            'estado_civil' => 'required',
            'ncodigo_telfmovil' => 'required',
            'nnumero_telfmovil' => 'required|numeric|digits_between:7,7',
            'nnumero_telflocal' => 'nullable|numeric|digits_between:7,7',
            'correo_electronico' => 'required|email',
            'id_estado' => 'required',
            'id_municipio' => 'required',
            'id_parroquia' => 'required',
            'tipo_direccion' => 'required',
            'tipo_vivienda' => 'required',
            'punto_referencia' => 'required',
            'nombre_emergencia' => 'required|regex:/^[\pL\s]+$/u',
            'parentesco_emergencia' => 'required',
            'codigo_emergencia' => 'required',
            'numero_emergencia' => 'required|numeric|digits_between:7,7',
            'nombre_emergencia2' => 'required|regex:/^[\pL\s]+$/u',
            'parentesco_emergencia2' => 'required',
            'codigo_emergencia2' => 'required',
            'numero_emergencia2' => 'required|numeric|digits_between:7,7',
            'discapacidad' => 'required',
            'codigo_conapdis' => 'nullable|numeric|digits_between:7,7',
            'lateralidad' => 'required',
            'inscripcion_militar' => 'required',
            'numero_inscripcion_militar' => 'nullable|numeric',
            'cantidad_hijos' => 'required',
            'dependencia_conyuge' => 'nullable|regex:/^[\pL\s]+$/u',
            'formacion_academica' => 'required',
            'continuar_estudios' => 'required',
            'continuar_estudios' => 'required',
            'participar_facilitador' => 'required',
            'estado_laboral' => 'required',
            'ubicacion_fisica' => 'required|regex:/^[\pL\s]+$/u',
            'codigo_oficina' => 'required',
            'numero_oficina' => 'required|numeric|digits_between:7,7',
            'cargo_ejerce' => 'required',
            'nivel_academico' => 'required',


        ], [
            'estado_civil.required' => 'El estado civil es obligatorio.',
            'ncodigo_telfmovil.required' => 'El código de teléfono móvil es obligatorio.',
            'nnumero_telfmovil.required' => 'El número de teléfono móvil es obligatorio.',
            'nnumero_telfmovil.numeric' => 'El número de teléfono móvil debe ser un número.',
            'nnumero_telfmovil.digits_between' => 'El número de teléfono móvil debe tener entre 7 y 7 dígitos.',
            'nnumero_telflocal.numeric' => 'El número de teléfono local debe ser un número.',
            'nnumero_telflocal.digits_between' => 'El número de teléfono local debe tener entre 7 y 7 dígitos.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'id_estado.required' => 'El estado es obligatorio.',
            'id_municipio.required' => 'El municipio es obligatorio.',
            'id_parroquia.required' => 'La parroquia es obligatorio.',
            'tipo_direccion.required' => 'El tipo de dirección es obligatorio.',
            'tipo_vivienda.required' => 'El tipo de vivienda es obligatorio.',
            'punto_referencia.required' => 'El punto de referencia es obligatorio.',
            'nombre_emergencia.required' => 'El nombre es obligatorio.',
            'nombre_emergencia.regex' => 'El nombre solo puede contener letras y espacios.',
            'parentesco_emergencia.required' => 'El parentesco es obligatorio.',
            'codigo_emergencia.required' => 'El código de telefóno es obligatorio.',
            'numero_emergencia.required' => 'El número de telefóno es obligatorio.',
            'numero_emergencia.numeric' => 'El número de telefóno debe ser un número.',
            'numero_emergencia.digits_between' => 'El número de telefóno debe tener entre 7 y 7 dígitos.',
            'nombre_emergencia2.required' => 'El nombre es obligatorio.',
            'nombre_emergencia2.regex' => 'El nombre solo puede contener letras y espacios.',
            'parentesco_emergencia2.required' => 'El parentesco es obligatorio.',
            'codigo_emergencia2.required' => 'El código de telefóno es obligatorio.',
            'numero_emergencia2.required' => 'El número de telefóno es obligatorio.',
            'numero_emergencia2.numeric' => 'El número de telefóno debe ser un número.',
            'numero_emergencia2.digits_between' => 'El número de telefóno debe tener entre 7 y 7 dígitos.',
            'discapacidad.required' => 'La discapacidad es obligatorio.',
            'codigo_conapdis.numeric' => 'El código de CONAPDIS debe ser un número.',
            'lateralidad.required' => 'La lateralidad es obligatorio.',
            'inscripcion_militar.required' => 'La inscripción militar es obligatorio.',
            'numero_inscripcion_militar.numeric' => 'El número de inscripción militar debe ser un número.',
            'cantidad_hijos.required' => 'La cantidad de hijos es obligatorio.',
            'formacion_academica.required' => 'La sección de formación académica es obligatoria. Por favor, completa la sección de formación académica.',
            'continuar_estudios.required' => 'El continuar estudios es obligatorio.',
            'participar_facilitador.required' => 'El participar facilitador es obligatorio.',
            'estado_laboral.required' => 'El estado laboral es obligatorio.',
            'ubicacion_fisica.required' => 'La ubicación física es obligatorio.',
            'codigo_oficina.required' => 'El código de telefóno es obligatorio.',
            'numero_oficina.required' => 'El número de telefóno es obligatorio.',
            'numero_oficina.numeric' => 'El número de telefóno debe ser un número.',
            'numero_oficina.digits_between' => 'El número de telefóno debe tener entre 7 y 7 dígitos.',
            'cargo_ejerce.required' => 'El cargo ejerce es obligatorio.',
            // Agrega mensajes personalizados para otross según sea necesario
        ]);
        try {
            $academico = $request->input('formacion_academica');
            if ($academico == null) {
                return redirect()->back()->with('error', 'La sección de formación académica es obligatoria. Por favor, completa la sección de formación académica.');
            }
            //return $request->input('id_estado');
            $actualizarDatos = Personales::findOrFail(Auth::user()->cedula);
            $actualizarDatos->estado_civil = $request->input('estado_civil'); //
            $actualizarDatos->ncodigo_telfmovil = $request->input('ncodigo_telfmovil'); //
            $actualizarDatos->nnumero_telfmovil = $request->input('nnumero_telfmovil'); //
            $actualizarDatos->ncodigo_telflocal = $request->input('ncodigo_telflocal'); //
            $actualizarDatos->nnumero_telflocal = $request->input('nnumero_telflocal'); //

            $actualizarDatos->semail = $request->input('correo_electronico'); //
            $actualizarDatos->srif = $request->input('rif'); //
            $actualizarDatos->nentidad_entidad = $request->input('id_estado'); //
            $actualizarDatos->nmunicipio_municipio = $request->input('id_municipio'); //
            $actualizarDatos->nparroquia_parroquia = $request->input('id_parroquia'); //
            $actualizarDatos->ndireccion1 = $request->input('tipo_direccion'); //
            $actualizarDatos->sdireccion1_2 = $request->input('detalles_direccion'); //
            $actualizarDatos->ndireccion2 = $request->input('tipo_vivienda');
            $actualizarDatos->sdireccion2_2 = $request->input('detalles_vivienda'); //
            $actualizarDatos->ndireccion3 = $request->input('vivienda'); //
            $actualizarDatos->sdireccion3_2 = $request->input('nro_vivienda'); //
            $actualizarDatos->ndireccion4 = $request->input('zona_vivienda');
            $actualizarDatos->sdireccion4_2 = $request->input('detalles_zona');
            $actualizarDatos->spunto_referencia = $request->input('punto_referencia'); //

            $actualizarDatos->snombre_emerg_familiar = $request->input('nombre_emergencia'); //
            $actualizarDatos->sparentesco_emerg_familiar = $request->input('parentesco_emergencia'); //
            $actualizarDatos->ncodigo_telfmovil_emerg1 = $request->input('codigo_emergencia'); //
            $actualizarDatos->nnumero_telfmovil_emerg1 = $request->input('numero_emergencia'); //

            $actualizarDatos->snombre_emerg_contacto = $request->input('nombre_emergencia2'); //
            $actualizarDatos->sparentesco_emerg_contacto = $request->input('parentesco_emergencia2'); //
            $actualizarDatos->ncodigo_telfmovil_emerg2 = $request->input('codigo_emergencia2'); //
            $actualizarDatos->nnumero_telfmovil_emerg2 = $request->input('numero_emergencia2'); //

            $actualizarDatos->sdiscapacidad = $request->input('discapacidad'); //
            $actualizarDatos->id_tipo_discapacidad = $request->input('tipo_discapacidad'); //
            $actualizarDatos->id_grado_discapacidad = $request->input('grado_discapacidad'); //
            $actualizarDatos->scodigo_conapdis = $request->input('codigo_conapdis'); //
            $actualizarDatos->slateralidad = $request->input('lateralidad'); //
            $actualizarDatos->id_grupo_sanguineo = $request->input('tipo_sangre'); //
            $actualizarDatos->sinscripcion_militar = $request->input('inscripcion_militar'); //
            $actualizarDatos->ncodigo_inscripcion_militar = $request->input('numero_inscripcion_militar'); //
            $actualizarDatos->ncant_hijos = $request->input('cantidad_hijos'); //
            $actualizarDatos->sconyuge_trabajo = $request->input('dependencia_conyuge'); //
            $actualizarDatos->stalla_camisa = $request->input('talla_blusa_camisa'); //
            $actualizarDatos->stalla_pantalon = $request->input('talla_pantalon'); //
            $actualizarDatos->ntalla_zapato = $request->input('talla_zapato'); //
            $actualizarDatos->stalla_chaqueta = $request->input('talla_chaqueta');

            $actualizarDatos->nentidad_trab = $request->input('estado_laboral');

            $actualizarDatos->subicacion_fisica = $request->input('ubicacion_fisica');

            $actualizarDatos->ncodigo_telfoficina = $request->input('codigo_oficina');
            $actualizarDatos->nnumero_telfoficina = $request->input('numero_oficina');

            $actualizarDatos->scargo_actual_ejerce = $request->input('cargo_ejerce');
            $actualizarDatos->sobservacion = $request->input('observaciones_laborales');

            $actualizarDatos->ncont_estudios = $request->input('continuar_estudios');
            $actualizarDatos->id_opc_educativas = $request->input('opciones_estudio');
            $actualizarDatos->nparticipar_facilitador = $request->input('participar_facilitador');

            $actualizarDatos->save();



            //  $tablaPatologias = json_decode($request->items_detalles, true);
            // 1. Buscamos las relaciones actuales para saber qué apagar (SIEMPRE se ejecuta)
            $idsRelacion = Personales_Patologias::where('personales_cedula', Auth::user()->cedula)->pluck('id');

            // 2. APAGAMOS TODO (Si el usuario vació la tabla, esto dejará al usuario sin patologías activas)
            if (empty($idsRelacion)) {

                Tratamiento_Medico::whereIn('personaformacion_academicales_patologias_id', $idsRelacion)->update(['nenabled' => false]);
                Personales_Patologias::where('personales_cedula', Auth::user()->cedula)->update(['nenabled' => false]);
            }

            // 3. RECUPERAMOS LOS DATOS DEL FORMULARIO
            $nombresPatologias = $request->input('patologias_id');
            //  dd($nombresPatologias);
            $productosIds      = $request->input('productos_id');
            $observaciones     = $request->input('observaciones');

            // 4. SOLO SI HAY DATOS NUEVOS, INSERTAMOS/REACTIVAMOS
            if (!empty($nombresPatologias)) {

                // Buscamos los IDs maestros para los nombres recibidos
                $mapaPatologias = Patologias::whereIn('sdescripcion', $nombresPatologias)
                    ->pluck('id', 'sdescripcion');

                foreach ($nombresPatologias as $index => $nombre) {
                    $idReal = $mapaPatologias[$nombre] ?? null;

                    if ($idReal) {
                        $personalesPatologia = Personales_Patologias::create([
                            'personales_cedula'      => Auth::user()->cedula,
                            'patologias_id'          => $idReal,
                            'nenabled'               => true,
                            'dfecha_actualizacion'   => now(),
                            'nusuario_actualizacion' => Auth::user()->id
                        ]);

                        // Guardar tratamiento
                        if (!empty($productosIds[$index])) {
                            Tratamiento_Medico::create([
                                'personales_patologias_id' => $personalesPatologia->id,
                                'productos_id'             => $productosIds[$index],
                                'sobservacion'             => $observaciones[$index] ?? '',
                                'nenabled'                 => true,
                                'dfecha_actualizacion'     => now(),
                                'nusuario_actualizacion'   => Auth::user()->id
                            ]);
                        }
                    }
                }
            }
            $nivel_academico = $request->input('nivel_academico');
            $especialidad = $request->input('especialidad');
            $graduado = $request->input('graduado');
            //  return $nivel_academico;

            // 1. Apagado inicial (Correcto)
            if (!isset($nivel_academico) || empty($nivel_academico) || $nivel_academico == 'null' || $nivel_academico == 'undefined') {
                Personales_Nivel_Academico::where('id_personales', Auth::user()->cedula)->update(['nenabled' => 0]);
            }
            if (!empty($nivel_academico) && $nivel_academico != 'null' && $nivel_academico != 'undefined') {
                // 2. Mapeo correcto: [ 'Bachiller' => 1, 'Universitario' => 5 ]
                $niveles_array = is_array($nivel_academico) ? $nivel_academico : explode(',', $nivel_academico);

                $personal_academico_existente = Personales_Nivel_Academico::where('id_personales', Auth::user()->cedula)->where('nenabled', 1)->get();
                if (!$personal_academico_existente->isEmpty()) {
                    Personales_Nivel_Academico::where('id_personales', Auth::user()->cedula)->update(['nenabled' => 0]);
                }
                if (!empty($niveles_array)) {

                    foreach ($niveles_array as $index => $nombreNivel) {


                        // Determinar booleano de graduado
                        if (isset($graduado[$index]) && $graduado[$index] === 'Sí') {
                            $esGraduado = $graduado[$index] = true;
                        } else {
                            $esGraduado = $graduado[$index] = false;
                        }

                        //return $esGraduado;

                        Personales_Nivel_Academico::create([
                            'id_personales'          => Auth::user()->cedula,
                            'id_nivel_academico'     => $nombreNivel,
                            'sespecialidad'          => $especialidad[$index] ?? null,
                            'sgraduado'              => $esGraduado,
                            'nenabled'               => 1,
                            'dfecha_actualizacion'   => now(),
                            'nusuario_actualizacion' => Auth::user()->id
                        ]);
                    }
                }
            }

            if ($actualizarDatos) {
                return redirect()->route('actualizar-datos')->with('success', '¡Se han actualizado sus datos exitosamente!');
            }
        } catch (\Exception $e) {
            return redirect()->route('actualizar-datos')->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }


        // Aquí puedes procesar y guardar los datos recibidos del formulario
        // Por ejemplo, puedes actualizar la información del usuario en la base de datos
    }
}
