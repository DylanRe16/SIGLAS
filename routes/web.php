<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ContraseñaController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\PDFController;

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('ingresar');
});

Route::get('/ingresar', [InicioController::class, 'create'])->name('ingresar');
Route::post('/ingresar', [InicioController::class, 'store'])->name('ingresar');

Route::get('/salir', [InicioController::class, 'destroy'])->name('salir');

// Rutas protegidas para usuarios autenticados
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    Route::get('/perfil', function () {
        return view('modulos.users.mis-datos');
    })->name('perfil');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Página inicio
    Route::get('/inicio', function () {
        return view('modulos.users.inicio');
    })->name('inicio');

    // Contraseña

    Route::get('perfil/contrasena-3', [ContraseñaController::class, 'clave_edit'])->name('contrasena-3');
    Route::post('perfil/contrasena-3', [ContraseñaController::class, 'clave_update'])->name('clave-update');

    // Preguntas seguridad
    Route::get('perfil/preguntas-seguridad', [PreguntasController::class, 'edit'])->name('preguntaSeg-edit');
    Route::post('perfil/preguntas-seguridad', [PreguntasController::class, 'update'])->name('preguntaSeg-update');
});


// Route::match(['get', 'post'], '/contrasena', [ContraseñaController::class, 'manejarContrasena'])->name('contrasena');
//     Route::get('/contrasena2', [ContraseñaController::class, 'mostrarContrasena2'])->name('contrasena2');
//     Route::post('/contrasena2', [ContraseñaController::class, 'procesarContrasena2'])->name('contrasena2');
//     Route::match(['get', 'post'], '/contrasena-2', [ContraseñaController::class, 'cambiarContraseña'])->name('contrasena-2');

// Rutas públicas o sin middleware auth
Route::get('/test-db', function () {
    return view('modulos.users.prueba2');
});


Route::get('/keepalive', function () {
    session(['last_activity' => time()]);
    return response()->json(['status' => 'ok']);
})->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/ayuda', [InicioController::class, 'help'])->name('help');
});



Route::get('/manual-usuario', function () {
    return view('modulos.ayuda-test.index');
})->name('manual-usuario');


// Incluye otros archivos de rutas
require __DIR__ . '/auth.php';
require __DIR__ . '/registro.php';
require __DIR__ . '/datos_personales.php';
require __DIR__ . '/clave.php';
require __DIR__ . '/solicitud.php';
require __DIR__ . '/prototipo.php';
require __DIR__ . '/almacen.php';
require __DIR__ . '/ccombatiente.php';
require __DIR__ . '/cnconstituyente/web.php';
require __DIR__ . '/recibosconstancias.php';
require __DIR__ . '/formatos.php';
require __DIR__ . '/roraima.php';
require __DIR__ . '/siris.php';
