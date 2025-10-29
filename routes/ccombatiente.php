<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CcombatienteController;
use App\Http\Controllers\DatoPersonalController;

Route::get('/ccombatiente', function () {
    return view('modulos.ccombatiente.index');
})->name('ccombatiente-index');
/* Route::get('/ccombatiente/registrar', function () {
    return view('modulos.ccombatiente.registrar');
})->name('ccombatiente-registrar'); */


Route::get('/ccombatiente/reporte', function () {
    return view('modulos.ccombatiente.reporte');
})->name('ccombatiente-reportes');

Route::get('/ccombatiente/mantenimiento/catalogos/comunas', function () {
    return view('modulos.ccombatiente.mantenimiento.catalogos.comunas');
})->name('ccombatiente-mantenimiento-catalogos-comunas');

Route::get('/ccombatiente/mantenimiento/catalogos/registro-miliciano', function () {
    return view('modulos.ccombatiente.mantenimiento.catalogos.registro-miliciano');
})->name('ccombatiente-mantenimiento-catalogos-registro-miliciano');

Route::middleware('auth')->group(function () {
    Route::get('/ccombatiente/registrar', [CcombatienteController::class, 'show'])->name('ccombatiente-registrar');
    Route::post('/ccombatiente/registrar', [CcombatienteController::class, 'busqueda'])->name('busqueda-siggefirh');
    Route::post('/ccombatiente/registrar/crear', [CcombatienteController::class, 'store'])->name('dato-personal-crear');
    Route::get('municipios/{estadoId}', [CcombatienteController::class, 'getMunicipios'])->name('getMunicipios');
    Route::get('parroquias/{municipioId}', [CcombatienteController::class, 'getParroquias'])->name('getParroquias');
});
