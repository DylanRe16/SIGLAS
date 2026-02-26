<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CcombatienteController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\ReporteCCombatienteController;

Route::middleware('auth')->group(function () {
    route::get('/ccombatiente', [CcombatienteController::class, 'index'])->name('ccombatiente-index');

    Route::get('/ccombatiente/reporte', [ReporteCCombatienteController::class, 'index'])->name('ccombatiente-reportes');

    #CATALOGO COMUNAS
    Route::get('/ccombatiente/mantenimiento/catalogos/comunas', [ComunaController::class, 'index'])->name('ccombatiente-mantenimiento-catalogos-comunas');

    Route::post('/ccombatiente/mantenimiento/catalogos/comunas/crear', [ComunaController::class, 'store'])->name('comuna-crear');
    Route::get('/ccombatiente/mantenimiento/catalogos/comunas/actualizar/{id}', [ComunaController::class, 'edit'])->name('comuna-editar');
    Route::put('/ccombatiente/mantenimiento/catalogos/comunas/actualizar/{id}', [ComunaController::class, 'update'])->name('comuna-actualizar');
    Route::get('/ccombatiente/mantenimiento/catalogos/comunas/eliminar/{id}', [ComunaController::class, 'destroy'])->name('comuna-eliminar');
    #CATALOGO REGISTRO rango
    Route::get('/ccombatiente/mantenimiento/catalogos/registro-rango', [RangoController::class, 'index'])->name('ccombatiente-mantenimiento-catalogos-registro-rango');

    Route::post('/ccombatiente/mantenimiento/catalogos/registro-rango/crear', [RangoController::class, 'store'])->name('registro-rango-crear');
    Route::get('/ccombatiente/mantenimiento/catalogos/registro-rango/actualizar/{id}', [RangoController::class, 'edit'])->name('registro-rango-editar');
    Route::put('/ccombatiente/mantenimiento/catalogos/registro-rango/actualizar/{id}', [RangoController::class, 'update'])->name('registro-rango-actualizar');
    Route::get('/ccombatiente/mantenimiento/catalogos/registro-rango/eliminar/{id}', [RangoController::class, 'destroy'])->name('registro-rango-eliminar');

    #REGISTRAR COMBATIENTE
    Route::get('/ccombatiente/registrar', [CcombatienteController::class, 'show'])->name('ccombatiente-registrar');
    Route::post('/ccombatiente/registrar', [CcombatienteController::class, 'busqueda'])->name('busqueda-siggefirh');
    Route::post('/ccombatiente/registrar/crear', [CcombatienteController::class, 'store'])->name('dato-personal-crear');
    Route::get('municipios/{estadoId}', [CcombatienteController::class, 'getMunicipios'])->name('getMunicipios');
    Route::get('parroquias/{municipioId}', [CcombatienteController::class, 'getParroquias'])->name('getParroquias');
    #MANTENIMIENTO USUARIOS
    Route::get('/ccombatiente/mantenimiento/usuarios', [CcombatienteController::class, 'usuarios'])->name('ccombatiente-mantenimiento-usuarios');
    Route::post('/ccombatiente/mantenimiento/usuarios/asignar', [CcombatienteController::class, 'asignarRoles'])->name('ccombatiente.usuarios.asignar');
    Route::get('/ccombatiente/mantenimiento/usuarios/desasignar/{cedula}', [CcombatienteController::class, 'desasignarRoles'])->name('ccombatiente.usuarios.desasignar');
});
