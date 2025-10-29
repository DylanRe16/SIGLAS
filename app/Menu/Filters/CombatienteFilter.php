<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class CombatienteFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['text']) && $item['text'] === 'Opciones de Módulo') {
            // Depuración: muestra el path actual
            //dd(request()->path());
            // El código siguiente no se ejecutará por el dd()
            if (!request()->is('ccombatiente') && !request()->is('ccombatiente/*')) {
                return false;
            }
        }
        return $item;
    }
}
