<?php

use App\Http\Controllers\CNConstituyente\CNCController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\CcombatienteController;
// use App\Http\Controllers\DatoPersonalController;


Route::middleware('auth')->group(function () {
    Route::get('/cnconstituyente', function () {
        return view('modulos.cnconstituyente.index');
    })->name('cnconstituyente-index');


    Route::get('/cnconstituyente/registrar', [CNCController::class , 'create'])->name('cnconstituyente-registrar');

    Route::get('/cnconstituyente/getPerson', [CNCController::class , 'getPerson'])->name('cnc-getPerson');

    // Route::get('/ccombatiente/registrar', [CcombatienteController::class, 'show'])->name('ccombatiente-registrar');
    // Route::post('/ccombatiente/registrar', [CcombatienteController::class, 'busqueda'])->name('busqueda-siggefirh');
    // Route::post('/ccombatiente/registrar/crear', [CcombatienteController::class, 'store'])->name('dato-personal-crear');
    // Route::get('municipios/{estadoId}', [CcombatienteController::class, 'getMunicipios'])->name('getMunicipios');
    // Route::get('parroquias/{municipioId}', [CcombatienteController::class, 'getParroquias'])->name('getParroquias');
});
