<?php
namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $sessionKey = 'usuario_autenticado_id';

    public function create(): View
    {
        return view('modulos.users.ingresar');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $nacionalidad = $request->input('nacionalidad');
        $cedula = $request->input('ced_afiliado');
        $password = $request->input('password');

        $user = DB::connection('bd2')
            ->table('public.tb_persona')
            ->where('snacionalidad', $nacionalidad)
            ->where('ndocumento', $cedula)
            ->first();

        if ($user && Hash::check($password, $user->sclave)) {
            // Autenticación exitosa
            Session::put($this->sessionKey, $user->id_persona);

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'redirect' => route('inicio') // Redirige a la ruta nombrada 'inicio'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Session::forget($this->sessionKey);
        $request->session()->regenerateToken();
        return redirect('/ingresar');
    }

    /**
     * Muestra la vista de inicio.
     *
     * @return View
     */
    public function inicio(): View
    {
        $usuario = null;
        if (session()->has($this->sessionKey)) {
            $userId = session($this->sessionKey);
            $usuario = DB::connection('bd2')->table('public.tb_persona')->where('id_persona', $userId)->first();
        }

        return view('modulos.users.inicio', ['usuario' => $usuario]);
    }
}