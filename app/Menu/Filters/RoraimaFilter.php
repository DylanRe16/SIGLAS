<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Request;

class RoraimaFilter implements FilterInterface
{
    public function transform($item)
    {
        // 1. Si el elemento del menú no tiene la clase 'opciones-roraima', no lo procesamos
        if (!isset($item['classes']) || !str_contains($item['classes'], 'opciones-roraima')) {
            return $item;
        }

        // 2. Definimos los prefijos de las URLs de Roraima
        // Usamos 'roraima*' para atrapar todas las subrutas (proyectos, asignar, etc.)
        $prefijosRoraima = [
            'roraima*'
        ];

        // 3. Verificamos si la ruta actual pertenece al módulo Roraima
        $estoyEnRoraima = false;

        foreach ($prefijosRoraima as $prefijo) {
            if (Request::is($prefijo)) {
                $estoyEnRoraima = true;
                break;
            }
        }

        // 4. Lógica de EXCLUSIÓN para el Index 
        // Si el usuario está en la raíz del módulo, ocultamos el menú del topnav
        if (Request::is('roraima')) {
            return false;
        }

        // 5. Si no estamos dentro de una ruta de Roraima, ocultamos los elementos
        if (!$estoyEnRoraima) {
            return false;
        }

        return $item;
    }
}