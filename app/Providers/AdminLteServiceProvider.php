namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Auth;
use App\Models\Modulo;
use App\Models\Opcion;

class AdminLteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Se dispara cuando AdminLTE está construyendo el menú
        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $user = Auth::user();

            if (!$user) return;

            // Obtener roles del usuario
            $roles = $user->roles()->pluck('id');

            // Consultar opciones habilitadas según roles
            $opciones = Opcion::select('opcion.*')
                ->join('rolopcion', 'rolopcion.opcion_id', '=', 'opcion.id')
                ->whereIn('rolopcion.rol_id', $roles)
                ->where('opcion.nenabled', 1)
                ->orderBy('opcion.nmodulo')
                ->orderBy('opcion.norden_salida')
                ->get();

            // Agrupar por módulo
            $modulos = $opciones->groupBy('nmodulo');

            foreach ($modulos as $idModulo => $opcionesModulo) {
                $modulo = Modulo::find($idModulo);

                if (!$modulo) continue;

                $submenu = [];

                foreach ($opcionesModulo as $opcion) {
                    $submenu[] = [
                        'text' => $opcion->sdescripcion,
                        'url'  => $opcion->surl ?? '#',
                        'icon' => 'fas fa-angle-right',
                    ];
                }

                $event->menu->add([
                    'text' => $modulo->sdescripcion,
                    'icon' => $modulo->slogo ?? 'fas fa-folder',
                    'submenu' => $submenu,
                ]);
            }
        });
    }
}
