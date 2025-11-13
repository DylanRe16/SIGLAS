<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CcombatienteController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\RegistroMilicianoController;
use App\Http\Controllers\ReporteCCombatienteController;

Route::middleware('auth')->group(function () {
    Route::get('/ccombatiente', function () {
        return view('modulos.ccombatiente.index');
    })->name('ccombatiente-index');

    Route::get('/ccombatiente/reporte', [ReporteCCombatienteController::class, 'index'])->name('ccombatiente-reportes');

    #CATALOGO COMUNAS
    Route::get('/ccombatiente/mantenimiento/catalogos/comunas', [ComunaController::class, 'index'])->name('ccombatiente-mantenimiento-catalogos-comunas');

    Route::post('/ccombatiente/mantenimiento/catalogos/comunas/crear', [ComunaController::class, 'store'])->name('comuna-crear');
    Route::get('/ccombatiente/mantenimiento/catalogos/comunas/actualizar/{id}', [ComunaController::class, 'edit'])->name('comuna-editar');
    Route::put('/ccombatiente/mantenimiento/catalogos/comunas/actualizar/{id}', [ComunaController::class, 'update'])->name('comuna-actualizar');
    Route::get('/ccombatiente/mantenimiento/catalogos/comunas/eliminar/{id}', [ComunaController::class, 'destroy'])->name('comuna-eliminar');
    #CATALOGO REGISTRO MILICIANO
    Route::get('/ccombatiente/mantenimiento/catalogos/registro-miliciano', [RegistroMilicianoController::class, 'index'])->name('ccombatiente-mantenimiento-catalogos-registro-miliciano');

    Route::post('/ccombatiente/mantenimiento/catalogos/registro-miliciano/crear', [RegistroMilicianoController::class, 'store'])->name('registro-miliciano-crear');
    Route::get('/ccombatiente/mantenimiento/catalogos/registro-miliciano/actualizar/{id}', [RegistroMilicianoController::class, 'edit'])->name('registro-miliciano-editar');
    Route::put('/ccombatiente/mantenimiento/catalogos/registro-miliciano/actualizar/{id}', [RegistroMilicianoController::class, 'update'])->name('registro-miliciano-actualizar');
    Route::get('/ccombatiente/mantenimiento/catalogos/registro-miliciano/eliminar/{id}', [RegistroMilicianoController::class, 'destroy'])->name('registro-miliciano-eliminar');

    #REGISTRAR COMBATIENTE
    Route::get('/ccombatiente/registrar', [CcombatienteController::class, 'show'])->name('ccombatiente-registrar');
    Route::post('/ccombatiente/registrar', [CcombatienteController::class, 'busqueda'])->name('busqueda-siggefirh');
    Route::post('/ccombatiente/registrar/crear', [CcombatienteController::class, 'store'])->name('dato-personal-crear');
    Route::get('municipios/{estadoId}', [CcombatienteController::class, 'getMunicipios'])->name('getMunicipios');
    Route::get('parroquias/{municipioId}', [CcombatienteController::class, 'getParroquias'])->name('getParroquias');
});
