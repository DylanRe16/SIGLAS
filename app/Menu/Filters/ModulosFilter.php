<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Minpptrassi\Public\Rol;
use App\Models\Minpptrassi\Public\Modulo;

class ModulosFilter implements FilterInterface
{
    public function roles()
    {
        $id_modulo = Modulo::where('sdescripcion', 'Cuerpo Combatiente')->first()->id;
        $roles = Rol::where('nenabled', true)->where('modulo_id', $id_modulo)->get();

        return $roles;
    }
    public function transform($item)
    {
        $roles = $this->roles()->pluck('id')->toArray();
        $rol_usuario = Auth::user()->roles()->whereIn('rol_id', $roles)->pluck('rol_id')->first();

        $data['rol_usuario'] = $rol_usuario;

        if (isset($item['url']) && $item['url'] === '/ccombatiente/registrar') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*')) {
                return false;
            }
        }

        if (isset($item['url']) && $item['url'] === '/ccombatiente/reporte') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*') || $data['rol_usuario'] != 99) {
                return false;
            }
        }

        if (isset($item['url']) && $item['url'] === '#ccombatiente-mantenimiento') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*') || $data['rol_usuario'] != 99) {
                return false;
            }
        }

        // if (isset($item['url']) && $item['url'] === '/ccombatiente/ayuda' && $data['rol_usuario'] == 99) {
        //     // Depuración: muestra el path actual
        //     //dd(request()->path());
        //     // El código siguiente no se ejecutará por el dd()
        //     if (!request()->is('ccombatiente/*')) {
        //         return false;
        //     }
        // }

        return $item;
    }
}
