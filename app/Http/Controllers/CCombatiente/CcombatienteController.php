<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRegistroRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Sigefirrhh;
use App\Models\Ccombatiente;
use App\Models\Personales;
use App\Models\RegistroMiliciano;
use App\Models\Comunas;

use Carbon\Carbon;

use Illuminate\Http\Request;

class CcombatienteController extends Controller
{
    public function getMunicipios($estadoId)
    {
        $municipios = DB::connection('bd4')
            ->table('public.municipio')
            ->select('nmunicipio', 'sdescripcion') // Selecciona los campos necesarios
            ->where('nentidad', $estadoId) // Filtra por el estado
            ->where('nenabled', 1) // Solo municipios habilitados
            ->get();

        return response()->json($municipios);
    }


    public function getParroquias($municipioId)
    {
        $parroquias = DB::connection('bd4')
            ->table('public.parroquia')
            ->select('nparroquia', 'sdescripcion') // Selecciona los campos necesarios
            ->where('nmunicipio', $municipioId) // Filtra por el municipio
            ->where('nenabled', 1) // Solo parroquias habilitadas
            ->get();

        return response()->json($parroquias);
    }

    public function cosas()
    {
        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias = Parroquia::all();
        $comunas = Comunas::where('benabled', true)->get();
        $registro_miliciano = RegistroMiliciano::where('benabled', true)->get();
        $id_grupo_sanguineo = DB::connection('bd4')->table('grupo_sanguineo')->where('nenabled', 1)->get();
        $tipo_trabajo = DB::connection('bd4')->table('tipo_trabajador')->where('nenabled', 1)->get();
        $cargos = DB::connection('bd4')->table('cargos')->where('nenabled', 1)->get();


        $cod_moviles = DB::connection('bd2')->table('tb_codigos_telefonicos')->where('btipo', true)->get();
        $cod_locales = DB::connection('bd2')->table('tb_codigos_telefonicos')->where('btipo', false)->get();
        $t_discapacidad = DB::connection('bd2')->table('tb_tipo_discapacidad')->get();

        return compact('estados', 'municipios', 'parroquias',  'registro_miliciano', 'cod_moviles', 'cod_locales', 't_discapacidad', 'id_grupo_sanguineo', 'tipo_trabajo', 'cargos', 'comunas');
    }

    //
    public function show()
    {
        $data = $this->cosas();
        return view('modulos.ccombatiente.registrar', $data);
    }
    public function busqueda(Request $request)
    {
        $request->validate([
            'ndocumento' => 'required|numeric|digits_between:6,9',
            'snacionalidad' => 'required|in:V,E,P'
        ], [
            'ndocumento.required' => 'El número de documento es obligatorio y debe tener entre 6 y 9 dígitos.',
            'ndocumento.numeric' => 'El número de documento debe ser un valor numerico.',
            'ndocumento.digits_between' => 'El número de documento debe tener entre 6 y 9 digitos.',
            'snacionalidad.required' => 'El tipo de documento es obligatorio y debe ser V, E o P.',
            'snacionalidad.in' => 'El tipo de documento debe ser V, E o P.',
        ]);
        $cedula = $request->ndocumento;
        $nacionalidad = $request->snacionalidad;

        $buscar_persona_ccombatiente = Ccombatiente::where('ndocumento', $cedula)
            ->where('snacionalidad', $nacionalidad)
            ->first();

        if ($buscar_persona_ccombatiente) {
            return back()->withInput()->with('error', 'Persona ya registrada como combatiente.');
        }

        $persona = DB::connection('sigefirrhh')->table('personal')
            ->join('trabajador', 'trabajador.id_personal', '=', 'personal.id_personal')
            ->where('personal.nacionalidad', $nacionalidad)
            ->where('personal.cedula', $cedula)
            ->where('trabajador.estatus', 'A')
            ->select('personal.*')
            ->first();
        if ($persona) {
            if ($nacionalidad == 'V') {
                $nacionalidad = 1;
            } elseif ($nacionalidad == 'E') {
                $nacionalidad = 2;
            } elseif ($nacionalidad == 'P') {
                $nacionalidad = 3;
            }

            $personales = DB::connection('bd4')->table('public.personales')
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
                ->where('personales.nacionalidad', $nacionalidad)
                ->where('personales.cedula', $cedula)
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
                    'personales.ntelefono_personal',
                    'personales.ntelefono_hab',
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
                    'personales.ntelefono_emerg_familiar',
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


            if ($personales) {
                $data = $this->cosas();
                //return $personales;
                return view('modulos.ccombatiente.registrar', array_merge(['persona' => $personales], $data, ['personaSigefirrhh' => $persona]));
            } else {
                $data = $this->cosas();
                /* return $persona;
            die(); */
                return view('modulos.ccombatiente.registrar', array_merge(['persona' => $persona], $data));
            }
        } else {

            return back()->withInput()->with('error', 'Persona no encontrada en SIGEFIRHH.')->with('nacionalidad', $nacionalidad)->with('cedula', $cedula);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'ndocumento2' => 'required|numeric|digits_between:6,9',
            'snacionalidad2' => 'required|in:V,E,P',
            'sprimer_nombre' => 'required|string|max:50',
            'ssegundo_nombre' => 'nullable|string|max:50',
            'sprimer_apellido' => 'required|string|max:50',
            'ssegundo_apellido' => 'nullable|string|max:50',
            'dfecha_nacimiento' => 'required|date|before:today',
            'ssexo' => 'required|in:1,2',
            'bembarazada' => 'nullable|in:0,1',
            'semail' => 'required|email',
            'ecivil' => 'required|in:1,2,3,4',
            'ncodigo_telfmovil' => 'required',
            'nnumero_telfmovil' => 'required|numeric|digits_between:7,7',
            'ncodigo_telflocal' => 'nullable',
            'nnumero_telflocal' => 'nullable|numeric|digits_between:7,7',
            'id_estado' => 'required',
            'id_municipio' => 'required',
            'id_parroquia' => 'required',
            'ndireccion' => 'required|string|max:255',
            'comuna' => 'required',
            'bdiscapacidad' => 'required|in:0,1',
            'lateralidad' => 'required',
            'tsangre' => 'required',
            'talla_camisa' => 'required',
            'talla_pantalon' => 'required',
            'talla_zapato' => 'required',
            'imilitar' => 'required',
            'registro_mimilitar' => 'required',
            'prestaste_servicio_militar' => 'required',
            'hijos' => 'required|in:0,1',
            'ubicacion_estado' => 'required',
            'ubicacion_fisica' => 'required',
            'cargo_ejerce' => 'required',
            'tipo_trabajador' => 'required',
            'ente_trabajador' => 'required',
        ], [
            'ndocumento2.required' => 'El número de documento es obligatorio y debe tener entre 6 y 9 dígitos.',
            'ndocumento2.numeric' => 'El número de documento debe ser un valor numerico.',
            'ndocumento2.digits_between' => 'El número de documento debe tener entre 6 y 9 digitos.',
            'snacionalidad2.required' => 'El tipo de documento es obligatorio y debe ser V, E o P.',
            'snacionalidad2.in' => 'El tipo de documento debe ser V, E o P.',
            'sprimer_nombre.required' => 'El primer nombre es obligatorio.',
            'sprimer_nombre.string' => 'El primer nombre debe ser una cadena de texto.',
            'sprimer_nombre.max' => 'El primer nombre no debe exceder los 50 caracteres.',
            'ssegundo_nombre.string' => 'El segundo nombre debe ser una cadena de texto.',
            'ssegundo_nombre.max' => 'El segundo nombre no debe exceder los 50 caracteres.',
            'sprimer_apellido.required' => 'El primer apellido es obligatorio.',
            'sprimer_apellido.string' => 'El primer apellido debe ser una cadena de texto.',
            'sprimer_apellido.max' => 'El primer apellido no debe exceder los 50 caracteres.',
            'ssegundo_apellido.string' => 'El segundo apellido debe ser una cadena de texto.',
            'ssegundo_apellido.max' => 'El segundo apellido no debe exceder los 50 caracteres.',
            'dfecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'dfecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'dfecha_nacimiento.before' => 'La fecha de nacimiento debe ser una fecha pasada.',
            'ssexo.required' => 'El sexo es obligatorio.',
            'ssexo.in' => 'El sexo debe ser 1 (Masculino) o 2 (Femenino).',
            'bembarazada.in' => 'El embarazada debe ser 0 (No) o 1 (Si).',
            'semail.required' => 'El correo electrónico es obligatorio.',
            'semail.email' => 'El correo electrónico debe ser una dirección válida.',
            'ecivil.required' => 'El estado civil es obligatorio.',
            'ncodigo_telfmovil.required' => 'El código de teléfono móvil es obligatorio.',
            'nnumero_telfmovil.required' => 'El número de teléfono móvil es obligatorio.',
            'nnumero_telfmovil.numeric' => 'El número de teléfono móvil debe ser un valor numérico.',
            'nnumero_telfmovil.digits_between' => 'El número de teléfono móvil debe tener exactamente 7 dígitos.',
            'nnumero_telflocal.numeric' => 'El número de teléfono local debe ser un valor numérico.',
            'nnumero_telflocal.digits_between' => 'El número de teléfono local debe tener exactamente 7 dígitos.',
            'id_estado.required' => 'El estado es obligatorio.',
            'id_municipio.required' => 'El municipio es obligatorio.',
            'id_parroquia.required' => 'La parroquia es obligatoria.',
            'ndireccion.required' => 'La dirección de habitación es obligatoria.',
            'ndireccion.string' => 'La direccion de habitación debe ser una cadena de texto.',
            'ndireccion.max' => 'La direccion de habitación no debe exceder los 255 caracteres.',
            'comuna.required' => 'La comuna o Circuito Comunal es obligatoria.',
            'bdiscapacidad.required' => 'La discapacidad es obligatoria.',
            'bdiscapacidad.in' => 'La discapacidad debe ser 0 (No) o 1 (Si).',
            'lateralidad.required' => 'La lateralidad es obligatoria.',
            'lateralidad.in' => 'La lateralidad debe ser D (Diestro) o Z (Zurdo).',
            'tsangre.required' => 'El tipo de sangre es obligatorio.',
            'talla_camisa.required' => 'La talla de la camisa es obligatoria.',
            'talla_pantalon.required' => 'La talla del pantalón es obligatoria.',
            'talla_zapato.required' => 'La talla del zapato es obligatoria.',
            'imilitar.required' => 'La inscripción militar es obligatoria.',
            'registro_mimilitar.required' => 'El registro como miliciano es obligatorio.',
            'prestaste_servicio_militar.required' => 'El prestaste servicio militar es obligatorio.',
            'hijos.required' => 'La cantidad de hijos es obligatoria.',
            'hijos.in' => 'La cantidad de hijos debe ser 0 (No) o 1 (Si).',
            'ubicacion_estado.required' => 'El estado de Datos laborales es obligatorio.',
            'ubicacion_fisica.required' => 'La ubicación física es obligatoria.',

            'cargo_titular.max' => 'El cargo titular no debe exceder los 255 caracteres.',
            'cargo_ejerce.required' => 'El Cargo o puesto de trabajo que ejerce es obligatorio.',
            'cargo_ejerce.string' => 'El Cargo o puesto de trabajo que ejerce debe ser una cadena de texto.',
            'cargo_ejerce.max' => 'El Cargo o puesto de trabajo que ejerce no debe exceder los 255 caracteres.',
            'id_estado_civil.required' => 'El estado civil es obligatorio.',
            'tipo_trabajador.required' => 'El tipo de trabajador es obligatorio.',
            'ente_trabajador.required' => 'El Ente de Procedencia es obligatorio.',
            'ente_trabajador.string' => 'El Ente de Procedencia debe ser una cadena de texto.',
            'ente_trabajador.max' => 'El Ente de Procedencia no debe exceder los 255 caracteres.',
        ]);

        $snacionalidad = $request->snacionalidad2;
        $ndocumento = $request->ndocumento2;
        $sprimer_nombre = $request->sprimer_nombre;
        $ssegundo_nombre = $request->ssegundo_nombre;
        $sprimer_apellido = $request->sprimer_apellido;
        $ssegundo_apellido = $request->ssegundo_apellido;
        $dfecha_nacimiento = $request->dfecha_nacimiento;
        $ssexo = $request->ssexo;
        $bembarazada = $request->bembarazada ?? 0;
        $semail = $request->semail;
        $id_estado_civil = $request->ecivil; // viene como 'ecivil' en el request
        $ncodigo_telfmovil = $request->ncodigo_telfmovil;
        $nnumero_telfmovil = $request->nnumero_telfmovil;
        $ncodigo_telflocal = $request->ncodigo_telflocal;
        $nnumero_telflocal = $request->nnumero_telflocal;
        $id_entidad = $request->id_estado;
        $id_municipio = $request->id_municipio;
        $id_parroquia = $request->id_parroquia;
        $sdireccion = $request->ndireccion;
        $spunto_referencia = $request->punto_referencia;
        $id_comuna_circuito = $request->comuna;
        $btiene_discapacidad = $request->bdiscapacidad;
        $id_tipo_discapacidad = $request->id_tdiscapacidad ?? null;
        $id_grado_discapacidad = $request->grado_discapacidad ?? null;
        $sdicapacidad_especifique = $request->sdicapacidad_especifica ?? null;
        $bcertificado_conapdis = $request->bcertificado_conapdis ?? 0;
        $ncodigo_conapdis = $request->nnum_certificado ?? null;
        $slateralidad = $request->lateralidad;
        $id_grupo_sanguineo = $request->tsangre;
        $stalla_camisa = $request->talla_camisa;
        $stalla_pantalon = $request->talla_pantalon;
        $ntalla_zapato = $request->talla_zapato;
        $binscripcion_militar = $request->imilitar;
        $nnumero_inscripcion_militar = $request->registro_mimilitar ?? null;
        $id_registro_miliciano = $request->id_registro_miliciano ?? null;
        $bservicio_militar = $request->prestaste_servicio_militar;
        $srango_militancia = $request->srango_militancia ?? null;
        $btiene_hijos = $request->hijos;
        $ncant_hijos_menores = $request->nhijos ?? null;
        $subicacion_administrativa = $request->ubicacion;
        $id_ciudad = $request->ubicacion_estado;
        $subicacion_fisica = $request->ubicacion_fisica;
        $scargo_actual_ejerce = $request->cargo_ejerce;
        $id_tipo_trabajador = $request->tipo_trabajador;
        $id_ente = $request->ente_trabajador;
        $benabled = 1;
        $nusuario_creacion = Auth::user()->id_persona ?? 1; // o el ID de usuario actual
        $dfecha_creacion = now();
        $ncod_cargo_titular = $request->cargo_titular;

        $persona = new Ccombatiente([
            'snacionalidad' => $snacionalidad,
            'ndocumento' => $ndocumento,
            'sprimer_nombre' => $sprimer_nombre,
            'ssegundo_nombre' => $ssegundo_nombre,
            'sprimer_apellido' => $sprimer_apellido,
            'ssegundo_apellido' => $ssegundo_apellido,
            'dfecha_nacimiento' => $dfecha_nacimiento,
            'ssexo' => $ssexo,
            'bembarazada' => $bembarazada,
            'semail' => $semail,
            'id_estado_civil' => $id_estado_civil,
            'ncodigo_telfmovil' => $ncodigo_telfmovil,
            'nnumero_telfmovil' => $nnumero_telfmovil,
            'ncodigo_telflocal' => $ncodigo_telflocal,
            'nnumero_telflocal' => $nnumero_telflocal,
            'id_entidad' => $id_entidad,
            'id_municipio' => $id_municipio,
            'id_parroquia' => $id_parroquia,
            'sdireccion' => $sdireccion,
            'spunto_referencia' => $spunto_referencia,
            'id_comuna_circuito' => $id_comuna_circuito,
            'btiene_discapacidad' => $btiene_discapacidad,
            'id_tipo_discapacidad' => $id_tipo_discapacidad,
            'id_grado_discapacidad' => $id_grado_discapacidad,
            'sdicapacidad_especifique' => $sdicapacidad_especifique,
            'bcertificado_conapdis' => $bcertificado_conapdis,
            'ncodigo_conapdis' => $ncodigo_conapdis,
            'slateralidad' => $slateralidad,
            'id_grupo_sanguineo' => $id_grupo_sanguineo,
            'stalla_camisa' => $stalla_camisa,
            'stalla_pantalon' => $stalla_pantalon,
            'ntalla_zapato' => $ntalla_zapato,
            'binscripcion_militar' => $binscripcion_militar,
            'nnumero_inscripcion_militar' => $nnumero_inscripcion_militar,
            'id_registro_miliciano' => $id_registro_miliciano,
            'bservicio_militar' => $bservicio_militar,
            'srango_militancia' => $srango_militancia,
            'btiene_hijos' => $btiene_hijos,
            'ncant_hijos_menores' => $ncant_hijos_menores,
            'subicacion_administrativa' => $subicacion_administrativa,
            'id_ciudad' => $id_ciudad,
            'subicacion_fisica' => $subicacion_fisica,
            'scargo_actual_ejerce' => $scargo_actual_ejerce,
            'id_tipo_trabajador' => $id_tipo_trabajador,
            'id_ente' => $id_ente,
            'benabled' => $benabled,
            'nusuario_creacion' => $nusuario_creacion,
            'dfecha_creacion' => $dfecha_creacion,
            'ncod_cargo_titular' => $ncod_cargo_titular,
        ]);

        $persona->save();
        $data = $this->cosas();


        session()->flash('success', '¡Se ha registrado exitosamente!');
        return view('modulos.ccombatiente.registrar', $data);
    }
}
