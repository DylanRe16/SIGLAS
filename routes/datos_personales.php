<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatoPersonalController;

Route::middleware('auth')->group(function () {
    Route::get('/perfil/mis-datos', [DatoPersonalController::class, 'edit'])->name('datoPersonal-edit');
    Route::put('/perfil/mis-datos/{user}', [DatoPersonalController::class, 'update'])->name('datoPersonal-update');
});
