<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistroRequest;
use App\Models\Persona;
use App\Models\PreguntaSeg;
use App\Models\Saime;
use App\Models\Siglas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BusquedaController extends Controller
{
    public function index()
    {
        return view('modulos.register.registro');
    }


    // muestra la persona si se encuentra en saime
    public function show(Request $request)
    {

        $cedula = session('ced_afiliado');

        // Busca la persona en la base de datos

        $usuario = Siglas::where('cedula', $cedula)
            ->first();

        if (is_null($usuario->sclave)) {
            // Validar la fecha de nacimiento


            $clave = $request->password;

            // Si se encuentra la persona, redirige a la vista registro2
            return view('modulos.register.registro2', ['cedula' => $cedula, 'clave' => $clave]);
        } else {
            return redirect()->route('registro-index')->with('error', 'La persona ya se encuentra registrada.');
        }
    }



    public function create(Request $request)
    {

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


        $persona = Siglas::find($request->ndocumento);
        $cod_moviles = DB::connection('bd4')->table('tb_codigos_telefonicos')->where('btipo', true)->get();
        $cod_locales = DB::connection('bd4')->table('tb_codigos_telefonicos')->where('btipo', false)->get();

        $preguntas_seg = DB::connection('bd4')->table('tb_preguntas_seg')->get();

        $clave = $request->password;
        //$edad = $this->calcularEdad($request->dfecha_nacimiento);


        // return $request->all();  // para ver que datos lleva

        // si persona esta en data Saime
        if ($persona) {
            $persona->cedula = trim($request->ced_afiliado);


            // $fecha = $this->validarFecha($persona->fechanac);

            /* if ($fecha) {
                $persona->fechanac = $fecha->format('Y-m-d');
            } else {
                echo 'Formato de fecha inválido.';
            }
 */

            return view('modulos.register.registro3', [
                'persona' => $request->ndocumento,
                'clave' => $clave,
                'preguntas_seg' => $preguntas_seg,
            ]);
        } else {
            $persona = $request->all();
            // return $persona;
            return view('modulos.register.registro3', [
                'persona' => $request->ndocumento,
                'clave' => $clave,
                'preguntas_seg' => $preguntas_seg,

            ]);
        }
    }


    public function store(Request $request)
    {

        $sclave = trim($request->sclave);
        // //return $data;
        // $persona = Siglas::where('cedula', $request->ndocumento)->update([
        //     'sclave' => Hash::make($sclave),
        // ]);
        // return $request->sclave;

        $user = Siglas::where('cedula', $request->ndocumento)->first();

        $user->sclave = Hash::make($sclave);

        $user->save();


        $preguntas = [
            ['pregunta' => $request->pregunta_1, 'respuesta' => $request->respuesta_1],
            ['pregunta' => $request->pregunta_2, 'respuesta' => $request->respuesta_2],
            ['pregunta' => $request->pregunta_3, 'respuesta' => $request->respuesta_3],
        ];
        $persona2 = Siglas::where('cedula', $request->ndocumento)->first();
        //return $persona2;

        foreach ($preguntas as $pregunta) {
            PreguntaSeg::create([
                'id_personales' => $request->ndocumento,
                'id_preguntaseg' => $pregunta['pregunta'],
                'srespuesta' => $pregunta['respuesta'],
                'nusuario_creacion' => $request->ndocumento,
            ]);
        }

        Auth::login($persona2);
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


    private function validarFecha($fecha)
    {
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
