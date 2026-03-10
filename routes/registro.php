<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusquedaController;


//REGISTRO DE USUARIOS
Route::get('/registro/{cedula}', [BusquedaController::class, 'index'])->name('registro-index');
//Route::get('/registro/buscar', [BusquedaController::class, 'show'])->name('registro-show');

Route::post('/registro/buscar/culminar-registro', [BusquedaController::class, 'create'])->name('registro-create');
Route::get('/registro/personas/preguntas/', [BusquedaController::class, 'preguntas'])->name('registro-preguntas');
// Route::middleware('auth')->group(function () {

//     });
Route::get('/culminar-registro', [BusquedaController::class, 'store'])->name('registro-store');
// para pruebas
Route::post('/registro/buscar/culminar-registro/registro-completado', [BusquedaController::class, 'complete'])->name('registro-complete');
