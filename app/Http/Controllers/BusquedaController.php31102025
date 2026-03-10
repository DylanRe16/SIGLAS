<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistroRequest;
use App\Models\Persona;
use App\Models\PreguntaSeg;
use App\Models\Saime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BusquedaController extends Controller
{
    public function index(){
        return view('modulos.register.registro');
    }


    // muestra la persona si se encuentra en saime
    public function show(Request $request) {
        $request->validate([
            'ced_afiliado' => 'required|numeric|digits_between:6,9',
            'nacionalidad' => 'required|in:V,E,P'
        ],[
            // mensajes de error
        ],[
            'ced_afiliado' => 'Nro. de Documento',
            'nacionalidad' => 'Tipo de Documento',
        ]);
    
        $cedula = $request->ced_afiliado;
        $nacionalidad = $request->nacionalidad;

        // Busca la persona en la base de datos
        $persona = Saime::where('numcedula', $cedula)
                        ->where('letra', 'LIKE', "%$nacionalidad%")
                        ->first();

        $usuario = Persona::where('ndocumento', $cedula)
                            ->where('snacionalidad', 'LIKE', "%$nacionalidad%")
                            ->first();
        
        // // Si no se encuentra la persona, redirige con un mensaje de error
        // if (!$persona) {
        //     return redirect()->route('registro-index')->with('error', 'Persona no encontrada en el sistema.');
        // // Si se encuentra la persona y esta registrada, redirige con un mensaje de error
        // } else if ($usuario) {
        //     return redirect()->route('registro-index')->with('error', 'La persona ya se encuentra registrada.');
        // }


        if(!$persona){
            if (!$usuario) {
                session()->flash('warning', 'Persona no encontrada en Saime. Ingrese sus datos de forma manual.');
            }
            return view('modulos.register.registro2', ['cedula' => $cedula, 'nacionalidad' => $nacionalidad]);
        } else if ($usuario) {
            return redirect()->route('registro-index')->with('error', 'La persona ya se encuentra registrada.');
        } else {
            // Validar la fecha de nacimiento
            $fecha = $this->validarFecha($persona->fechanac);

            if ($fecha) {
                $persona->fechanac = $fecha->format('Y-m-d');
            } else {
                echo 'Formato de fecha inválido.';
            }

            $clave = $request->password;
        
            // Si se encuentra la persona, redirige a la vista registro2
            return view('modulos.register.registro2', ['persona' => $persona, 'clave' => $clave]);
        }
    }



    public function create(Request $request){

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/\d/',    // Al menos un número
                'regex:/[@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial
                'min:8', // Más de 10 caracteres
            ],
        ], [
            'password.*' => 'La contraseña debe cumplir con todos los requisitos especificados.',
            
        ]);
        
        
        $persona = Saime::find($request->ndocumento);
        $cod_moviles = DB::connection('bd2')->table('tb_codigos_telefonicos')->where('btipo', true)->get();
        $cod_locales = DB::connection('bd2')->table('tb_codigos_telefonicos')->where('btipo', false)->get();

        $t_discapacidad = DB::connection('bd2')->table('tb_tipo_discapacidad')->get();
        $preguntas_seg = DB::connection('bd2')->table('tb_preguntas_seg')->get();

        $clave = $request->password;
        $edad = $this->calcularEdad($request->dfecha_nacimiento);
        
        
        // return $request->all();  // para ver que datos lleva

        // si persona esta en data Saime
        if ($persona){
            $persona->ndocumento = trim($request->ced_afiliado);

            
            $fecha = $this->validarFecha($persona->fechanac);
    
            if ($fecha) {
                $persona->fechanac = $fecha->format('Y-m-d');
            } else {
                echo 'Formato de fecha inválido.';
            }
            
    
            return view('modulos.register.registro3', ['persona' => $persona, 
                                                    'clave' => $clave, 
                                                    't_discapacidad' => $t_discapacidad, 
                                                    'preguntas_seg' => $preguntas_seg, 
                                                    'edad' => $edad,
                                                    'cod_moviles' => $cod_moviles,
                                                    'cod_locales' => $cod_locales]);
        } else { 
            $persona = $request->all();
            // return $persona;
            return view('modulos.register.registro3', ['persona' => $persona, 
                                                    'clave' => $clave, 
                                                    't_discapacidad' => $t_discapacidad, 
                                                    'preguntas_seg' => $preguntas_seg, 
                                                    'edad' => $edad,
                                                    'cod_moviles' => $cod_moviles,
                                                    'cod_locales' => $cod_locales]);
        }

        
    }


    public function store(StoreRegistroRequest $request){

        $data = $request->merge([
            'sclave' => Hash::make($request->sclave),
            'nusuario_actualizacion' => $request->ndocumento,
        ]);

        $persona = Persona::create($data->all());

        $preguntas = [
            ['pregunta' => $request->pregunta_1, 'respuesta' => $request->respuesta_1],
            ['pregunta' => $request->pregunta_2, 'respuesta' => $request->respuesta_2],
            ['pregunta' => $request->pregunta_3, 'respuesta' => $request->respuesta_3],
        ];
        
        foreach ($preguntas as $pregunta) {
            PreguntaSeg::create([
                'id_persona' => $persona->id_persona,
                'id_preguntaseg' => $pregunta['pregunta'],
                'srespuesta' => $pregunta['respuesta'],
                'nusuario_creacion' => $persona->ndocumento,
            ]);
        }
        
        Auth::login($persona);
        return redirect()->route('inicio')->with('success', '¡Se ha registrado exitosamente!');
    }


    // public function complete(){
    //     $persona = Persona::find(27302402); // Recuperar los datos desde la sesión
    //     return view('modulos.users.prueba', ['persona' => $persona]);
    // }


    private function calcularEdad($fechaNacimiento)
    {
        $fechaNacimiento = new \DateTime($fechaNacimiento);
        $hoy = new \DateTime();
        return $hoy->diff($fechaNacimiento)->y; // Retorna la edad en años
    }
    

    private function validarFecha($fecha) {
        $formatos = ['Y-m-d', 'd-m-Y'];
    
        foreach ($formatos as $formato) {
            try {
                $fechaFormateada = Carbon::createFromFormat($formato, trim($fecha));
                return $fechaFormateada; // Retorna la fecha si se parsea correctamente
            } catch (\Exception $e) {
                continue; // Intentar con el siguiente formato
            }
        }
    
        return null; // Retorna null si no se pudo validar
    }

}

    
