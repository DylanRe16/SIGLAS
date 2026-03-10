<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ContraseñaController;


//recuperar contraseña
Route::get('/contrasena', [ContraseñaController::class, 'index'])->name('clave-index');
Route::get('/contrasena/preguntas', [ContraseñaController::class, 'show'])->name('clave-show');
Route::get('/contrasena/preguntas/restablecer', [ContraseñaController::class, 'create'])->name('clave-create');
Route::post('/contrasena/preguntas/restablecer', [ContraseñaController::class, 'store'])->name('clave-store');



