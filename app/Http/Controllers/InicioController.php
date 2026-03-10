<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Siglas;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{
    protected $sessionKey = 'usuario_autenticado_id';

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function create(): View
    {
        return view('modulos.users.ingresar');
    }

    /**
     * Intenta autenticar al usuario CON CONEXIÓN DIRECTA A BD2 Y EXTRAE LOS NOMBRES.
     */
    public function store(Request $request)
    {

        // Validar los datos de entrada
        $request->validate([
            'ced_afiliado' => 'required|numeric|digits_between:6,9',

            'password' => 'required'
        ], [
            'ced_afiliado.required' => 'El :attribute es requerido',
            'ced_afiliado.numeric' => 'El :attribute debe ser numérico',

            'password.required' => 'La :attribute es requerida',
        ], [
            'ced_afiliado' => 'Nro. de Documento',

            'password' => 'Contraseña',
        ]);

        $nacionalidad = $request->input('nacionalidad');
        $cedula = $request->input('ced_afiliado');
        $password = $request->password;

        // Log::info("Intentando autenticar usuario con nacionalidad: $nacionalidad y cédula: $cedula");

        $user = Siglas::where('cedula', $cedula)
            //->where('snacionalidad', 'LIKE', "%$nacionalidad%")
            ->first();

        // Verificar si el usuario existe
        if (!$user) {
            // Log::warning("Usuario no encontrado con cédula: $cedula y nacionalidad: $nacionalidad");
            return redirect()->back()->with('error', 'Usuario no encontrado, por favor verifique su cédula y nacionalidad')->withInput();
        }

        Log::info('Resultado de consulta:', ['user' => $user]);
        //return $user;

        // Verificar la contraseña
        if (is_null($user->sclave)) {
             return redirect()
                ->route('registro-index', ['cedula' => $user->cedula])
                ->with([
                    'error'        => 'Por favor cree una nueva contraseña',
                ])
            ;
        }
        // return $password."<br>". Hash::make($password)."<br>". Hash::make($user->sclave);
        if (!Hash::check($password, $user->sclave)) {
            // Log::warning("Contraseña incorrecta para usuario con cédula: $cedula");
            return redirect()->back()->with('error', 'Contraseña incorrecta, por favor intente nuevamente')->withInput();
        }
        Auth::login($user);

        // Regenerar sesión
        $request->session()->regenerate();

        // Respuesta de éxito
        return redirect()->route('inicio')->with('success', 'Bienvenido, ' . $user->sprimer_nombre . ' ' . $user->sprimer_apellido . '!');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Log::info("Cerrando sesión para usuario ID: " . Auth::id());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info("Sesión invalidada correctamente");

        return redirect('/ingresar');
    }


    public function help()
    {

        return view('modulos.manual.index');
    }
}
