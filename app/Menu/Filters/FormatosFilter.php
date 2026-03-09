<?php
namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Request;

class FormatosFilter implements FilterInterface 
{
    public function transform($item)
    {
        // 1. Si el ítem de menú no tiene tu clase específica, lo dejamos pasar sin cambios
        if (!isset($item['classes']) || !str_contains($item['classes'], 'opciones-formatos')) {
            return $item;
        }

        // 2. Definimos las rutas donde SÍ debe verse el menú
        $prefijosFormatos = [
            'formatos/notificacion-ausencia*', 
            'formatos/solicitud-permiso*', 
            'formatos/solicitud-vacaciones*'
        ];

        // 3. Verificamos si la URL actual coincide con alguna de las permitidas
        $estoyEnFormatos = false;

        foreach ($prefijosFormatos as $prefijo) {
            if (Request::is($prefijo)) {
                $estoyEnFormatos = true;
                break;
            }
        }

        // 4. Si NO estoy en las rutas de formatos, ocultamos el elemento devolviendo false
        if (!$estoyEnFormatos) {
            return false;
        }

        // 5. Si pasó las validaciones, se muestra el ítem
        return $item;
    }
}

?>
