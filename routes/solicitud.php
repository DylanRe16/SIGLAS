<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Solicitud_citaController;
use App\Http\Controllers\PDFController;

Route::middleware('auth')->group(function () {
    Route::get('/solicitud', [Solicitud_citaController::class, 'index'])->name('cita-index');
    Route::get('/solicitud/cita', [Solicitud_citaController::class, 'create'])->name('cita-create');
    Route::get('/solicitud/cita2/{cita_id?}', [Solicitud_citaController::class, 'create2'])->name('cita-create2');

    // Para obtener municipios y parroquias dinámicamente
    Route::get('/solicitud/municipios/{estadoId}', [Solicitud_citaController::class, 'getMunicipios'])->name('getMunicipios');
    Route::get('/solicitud/parroquias/{municipioId}', [Solicitud_citaController::class, 'getParroquias'])->name('getParroquias');

    // Para obtener la solicitud y tipo de manera dinámica
    Route::get('/solicitud/tiposolicitud/{id}', [Solicitud_citaController::class, 'getTipoSolicitud'])->name('getTipoSolicitud');

    // Para guardar la solicitud
    Route::post('/solicitud/cita', [Solicitud_citaController::class, 'store'])->name('cita-store');

    // Para ver las citas creadas por el usuario
    Route::get('/solicitud/consulta', [Solicitud_citaController::class, 'show'])->name('cita-show');
    Route::get('/solicitud/consulta/{id_ptsolicitud}', [Solicitud_citaController::class, 'show2'])->name('cita-show2');

    // Nueva ruta para acceder a la vista `prueba.blade.php`
    Route::get('/solicitud/prueba/{id_ptsolicitud}', [Solicitud_citaController::class, 'show3'])->name('prueba');

    
});

// Ruta pública para descargar el PDF
Route::get('/solicitud/cita/pdf/{codigo}', [Solicitud_citaController::class, 'descargar_pdf'])->name('descargar-pdf');

Route::get('/solicitud/cita/{codigo}', [Solicitud_citaController::class, 'show_pdf'])->name('show-pdf');

Route::get('/imprimir-pdf/{id}', [PDFController::class, 'generatePdf'])->name('pdf-print');




