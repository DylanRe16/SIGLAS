<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiration
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si la sesión sigue activa
        if (!Session::has('last_activity')) {
            Session::put('last_activity', time());
        }

        $maxLifetime = config('session.lifetime') * 60; // Convertir minutos a segundos
        $elapsed = time() - Session::get('last_activity');

        if ($elapsed >= $maxLifetime) {
            // NO uses flush aquí, usa invalidate:
            Session::invalidate();
            // El mensaje flash se mantiene
            return redirect()->route('ingresar')->with('error', 'Tu sesión ha expirado.');
        }

        // Actualizar la actividad de la sesión
        Session::put('last_activity', time());

        return $next($request);
    }
}

