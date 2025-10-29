<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class ModulosFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['url']) && $item['url'] === '/ccombatiente/registrar') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*')) {
                return false;
            }
        }
        if (isset($item['url']) && $item['url'] === '/ccombatiente/reportes') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*')) {
                return false;
            }
        }
        if (isset($item['url']) && $item['url'] === '#ccombatiente-mantenimiento') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*')) {
                return false;
            }
        }
        if (isset($item['url']) && $item['url'] === '/ccombatiente/ayuda') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente/*')) {
                return false;
            }
        }

        return $item;
    }
}
