<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoraimaController;


Route::middleware('auth')->group(function () {

    Route::prefix('roraima')->group(function () {
        
        // Esta es la ruta INDEX (URL: /roraima)
        // Al estar dentro del prefijo 'roraima', el '/' representa la raíz del prefijo.
        Route::get('/', [RoraimaController::class, 'index'])->name('roraima.index');

        // Proyectos (URL: /roraima/proyectos)
        Route::get('/proyectos', [RoraimaController::class, 'proyectos'])->name('roraima.proyectos');
        Route::get('/acciones-centralizadas', [RoraimaController::class, 'acciones_centralizadas'])->name('roraima.acciones_centralizadas');
        
        // Asignar Usuarios (URL: /roraima/asignar-proyectos)
        Route::get('/asignar-proyectos', [RoraimaController::class, 'asignar_proyectos'])->name('roraima.asignar_proyectos');
        Route::get('/asignar-acciones', [RoraimaController::class, 'asignar_acciones'])->name('roraima.asignar_acciones');
        
        // Solicitudes (URL: /roraima/proyectos-requerimientos)
        Route::get('/proyectos-requerimientos', [RoraimaController::class, 'proyectos_requerimientos'])->name('roraima.proyectos_requerimientos');
        Route::get('/acc-requerimientos', [RoraimaController::class, 'acc_requerimientos'])->name('roraima.acc_requerimientos');
        
        // Variables (URL: /roraima/variables/proyectos)
        Route::get('/variables/proyectos', [RoraimaController::class, 'proyectos2'])->name('roraima.proyectos2');
        Route::get('/variables/acciones', [RoraimaController::class, 'acciones_centralizadas2'])->name('roraima.acciones_centralizadas2');
        Route::get('/variables/reportes', [RoraimaController::class, 'reportes_planificacion'])->name('roraima.reportes_planificacion');
    });
    
});

?>