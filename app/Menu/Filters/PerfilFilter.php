<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Minpptrassi\Public\Rol;
use App\Models\Minpptrassi\Public\Modulo;

class PerfilFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['url']) && $item['url'] === '/perfil/contrasena-3') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('perfil/*')) {
                return false;
            }
        }
        if (isset($item['url']) && $item['url'] === '/perfil/preguntas-seguridad') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('perfil/*')) {
                return false;
            }
        }
        if (isset($item['url']) && $item['url'] === '/perfil/actualizar-datos') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('perfil/*')) {
                return false;
            }
        }
        return $item;
    }
}
