<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusquedaController;


//REGISTRO DE USUARIOS
Route::get('/registro', [BusquedaController::class, 'index'])->name('registro-index');
Route::get('/registro/buscar', [BusquedaController::class, 'show'])->name('registro-show');
Route::get('/registro/buscar/culminar-registro', [BusquedaController::class, 'create'])->name('registro-create');
Route::post('/culminar-registro', [BusquedaController::class, 'store'])->name('registro-store');

// para pruebas
Route::get('/registro/buscar/culminar-registro/registro-completado', [BusquedaController::class, 'complete'])->name('registro-complete');


