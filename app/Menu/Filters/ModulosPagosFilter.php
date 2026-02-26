<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Request;

class ModulosPagosFilter implements FilterInterface
{
    public function transform($item)
    {
        // 1. Si no tiene tu clase, no lo tocamos
        if (!isset($item['classes']) || !str_contains($item['classes'], 'opciones-recibos')) {
            return $item;
        }

        // 2. Definimos las rutas exactas de inicio de tu módulo
        // Eliminamos 'mantenimiento' de aquí para evitar colisiones
        $prefijosPagos = ['recibosconstancias', 'recibos-pagos', 'procesos', 'recibos'];

        // 3. Verificamos si estamos en el módulo de forma estricta
        $estoyEnPagos = false;

        foreach ($prefijosPagos as $prefijo) {
            // Verifica que la URL empiece por el prefijo (evita que 'mantenimiento' atrape todo)
            if (Request::is($prefijo . '*')) {
                $estoyEnPagos = true;
                break;
            }
        }

        // 3.1 Validación especial para mantenimiento de pagos (ruta específica)
        // Esto asegura que solo entre si la ruta es de mantenimiento PERO de pagos/usuarios
        if (Request::is('mantenimiento/tickets-alimentacion*') || Request::is('mantenimiento/usuarios*')) {
            $estoyEnPagos = true;
        }

        // 4. Lógica de EXCLUSIÓN para el Index
        if (Request::is('recibosconstancias')) {
            return false;
        }

        // 5. Si no estoy en el módulo, ocultamos
        if (!$estoyEnPagos) {
            return false;
        }

        return $item;
    }
}