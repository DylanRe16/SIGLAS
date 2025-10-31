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
            'nacionalidad' => 'required|in:V,E,P',
            'password' => 'required'
        ], [
            'ced_afiliado.required' => 'El :attribute es requerido',
            'ced_afiliado.numeric' => 'El :attribute debe ser numérico',
            'nacionalidad.required' => 'El :attribute es requerido',
            'password.required' => 'La :attribute es requerida',
        ], [
            'ced_afiliado' => 'Nro. de Documento',
            'nacionalidad' => 'Tipo de Documento',
            'password' => 'Contraseña',
        ]);

        $nacionalidad = $request->input('nacionalidad');
        $cedula = $request->input('ced_afiliado');
        $password = $request->input('password');

        // Log::info("Intentando autenticar usuario con nacionalidad: $nacionalidad y cédula: $cedula");

        $user = Siglas::where('personales_cedula', $cedula)
            //->where('snacionalidad', 'LIKE', "%$nacionalidad%")
            ->first();
        // return $user;

        // Verificar si el usuario existe
        if (!$user) {
            // Log::warning("Usuario no encontrado con cédula: $cedula y nacionalidad: $nacionalidad");
            return redirect()->back()->with('error', 'Usuario no encontrado, por favor verifique su cédula y nacionalidad')->withInput();
        }

        Log::info('Resultado de consulta:', ['user' => $user]);

        // Verificar la contraseña
        $storedPassword = $user->clave;
        $inputPassword  = $password;

        if ($storedPassword) {
            // 🧩 Si parece MD5 (32 caracteres hexadecimales)
            if (strlen($storedPassword) === 32 && ctype_xdigit($storedPassword)) {

                // Comparar manualmente con md5()
                if (md5($inputPassword) !== $storedPassword) {
                    return redirect()->back()
                        ->with('error', 'Contraseña incorrecta, por favor intente nuevamente')
                        ->withInput();
                }
            } else {
                // 🧩 Si es bcrypt (formato normal de Laravel)
                if (!Hash::check($inputPassword, $storedPassword)) {
                    return redirect()->back()
                        ->with('error', 'Contraseña incorrecta, por favor intente nuevamente')
                        ->withInput();
                }
            }
        } else {
            return redirect()->back()
                ->with('error', 'El usuario no tiene una contraseña registrada')
                ->withInput();
        }

        // ✅ Si llega aquí, la contraseña es correcta (MD5 o Bcrypt)
        //  Log::info("Inicio de sesión exitoso para usuario con cédula: {$cedula}");

        // Log::info("Usuario autenticado correctamente, ID: {$user->id_persona}");

        // Intentar loguear al usuario
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
