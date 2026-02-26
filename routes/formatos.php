<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormatosController;

Route::middleware('auth')->group(function () {

    Route::get('/formatos', function () {
        return view('modulos.formatos.index');
    })->name('formatos');

    Route::get('/formatos/notificacion-ausencia', [FormatosController::class, 'notificacion'])
    ->name('formatos-notificacion-ausencia');

    Route::post('/formatos/notificacion-ausencia/generarPDF', [FormatosController::class, 'generarPDFnotificacion'])
    ->name('formatos-notificacion-ausencia-generarpdf');


    Route::get('/formatos/solicitud-permiso', [FormatosController::class, 'permiso'])
    ->name('formatos-solicitud-permiso');

     Route::post('/formatos/solicitud-permiso/generarPDF', [FormatosController::class, 'generarPDFpermiso'])
    ->name('formatos-solicitud-permiso-generarpdf');


    Route::get('/formatos/solicitud-vacaciones', [FormatosController::class, 'vacaciones'])
        ->name('formatos-solicitud-vacaciones');

    Route::post('/formatos/solicitud-vacacionesgenerarPDF', [FormatosController::class, 'generarPDFvacaciones'])
    ->name('formatos-solicitud-vacaciones-generarpdf');
});


