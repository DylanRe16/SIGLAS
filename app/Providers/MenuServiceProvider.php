<?php

namespace App\Providers;

use App\Models\Minpptrassi\Public\Modulo as PublicModulo;
use App\Models\Minpptrassi\Public\Opcion as PublicOpcion;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Modulo;
use App\Models\Opcion;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $user = Auth::user();
            if (!$user) return;

            // Obtener roles del usuario
            $roles = $user->roles->pluck('id');

            // Obtener módulos habilitados (senabled = 1)
            $modulos = PublicModulo::where('senabled', 1)->get();

            foreach ($modulos as $modulo) {

                // Obtener la opción principal del módulo (nnivel = 0)
                $opcion = PublicOpcion::select('opcion.*')
                    ->join('rolopcion', 'rolopcion.opcion_id', '=', 'opcion.id')
                    ->where('opcion.id', $modulo->opcion_id)
                    ->where('opcion.nnivel', 0)
                    ->where('opcion.nenabled', 1)
                    ->whereIn('rolopcion.rol_id', $roles)
                    ->first();

                if (!$opcion) continue;

                // Agregar al menú (sin submenú)
                $event->menu->add([
                    'text' => $modulo->sdescripcion,
                    'url'  => $modulo->surl ?: '#',
                    'icon' => $modulo->slogo3 ?? $modulo->slogo ?? 'fas fa-folder',
                ]);
            }
        });
    }
}
