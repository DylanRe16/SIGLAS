<?php
namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\PreguntaSeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // ¡Asegúrate de que esta línea esté aquí!

class ContraseñaController extends Controller
{

    public function index() {
        return view('modulos.restablecer_clave.contrasena');
    }


    // Mostrar preguntas de seguridad si el usuario existe en la base de datos
    public function show(Request $request){
    
        $request->validate([
            'nacionalidad' => 'required|in:V,E,P',
            'ced_afiliado' => 'required|regex:/^[0-9]{5,9}$/'
        ],[],[
            'nacionalidad' => 'Tipo de Documento',
            'ced_afiliado' => 'Nro. de Documento',
        ]);	

        $cedula = $request->ced_afiliado;
        $nacionalidad = $request->nacionalidad;

        $persona = Persona::where('ndocumento', $cedula)
                            ->where('snacionalidad', 'LIKE', "%$nacionalidad%")
                            ->first();

        if (!$persona) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        // Verifica si la persona tiene preguntas de seguridad
        $preguntaSeg = PreguntaSeg::where('id_persona',$persona->id_persona)->get();
        if ($preguntaSeg->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron preguntas de seguridad para este usuario.');
        }
        
        // Selecciona aleatoriamente 2 preguntas de seguridad
        $preguntasAleatorias = $preguntaSeg->shuffle()->take(2);

        return view('modulos.restablecer_clave.contrasena2',['persona' => $persona, 'preguntas' => $preguntasAleatorias]);
    }
    
    
    public function create(Request $request){
        $id_persona = $request->id_persona;
        $request->validate([
            'respuesta_1' => 'required|string|max:255',
            'respuesta_2' => 'required|string|max:255',
        ]);

        // Obtén las preguntas y respuestas correctas
        $preguntas = PreguntaSeg::where('id_persona', $id_persona)
            ->whereIn('id_preguntaseg', [$request->pregunta_id_1, $request->pregunta_id_2])
            ->get()
            ->keyBy('id_preguntaseg');

        // return $preguntas;

        // Validar respuesta 1
        $respuesta1 = trim(strtolower($request->respuesta_1));
        $correcta1 = trim(strtolower($preguntas[$request->pregunta_id_1]->srespuesta ?? ''));

        // Validar respuesta 2
        $respuesta2 = trim(strtolower($request->respuesta_2));
        $correcta2 = trim(strtolower($preguntas[$request->pregunta_id_2]->srespuesta ?? ''));

        if (($respuesta1 !== $correcta1) || ($respuesta2 !== $correcta2)) {
            return redirect()->back()->with(['error' => 'Respuesta(s) incorrecta(s).']);
        }

        return view('modulos.restablecer_clave.contrasena3', ['id_persona' => $id_persona]);
    }




    public function store(Request $request){
        $id_persona = $request->id_persona;
        if (!$id_persona) {
            return redirect()->back()->with(['error' => 'No se encontró el ID del usuario. Intente nuevamente el proceso de recuperación.']);
        }

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

        try {
            $nuevaClave = Hash::make($request->password);

            $persona = Persona::find($id_persona);

            $persona->update([
                'sclave' => $nuevaClave,
                'nusuario_actualizacion' => $persona->id_persona,
                'dfecha_actualizacion' => now()
            ]);

            return redirect()->route('ingresar')->with('success', 'Contraseña restablecida exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Error al restablecer la contraseña.']);
        }
    }

    // para actualizar la contraseña desde el perfil
    public function clave_edit(){
        return view('modulos.users.contrasena-3');
    }

    // para actualizar la contraseña desde el perfil
    public function clave_update(Request $request){
        
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

        try {
            $nuevaClave = Hash::make($request->password);
            $user = Persona::find(Auth::id());
            $user->update([
                'sclave' => $nuevaClave,
                'nusuario_creacion' => Auth::user()->ndocumento,
                'dfecha_actualizacion' => now(),
            ]);

            return redirect()->route('inicio')->with('success', 'Contraseña actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Error al actualizar la contraseña.']);
        }
    }

}