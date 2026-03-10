<?php 
use Illuminate\Support\Facades\Route;

//Ruta de Pruebas 

Route::get('/prototipo', function () {
    return view('modulos.prototipo.index');
})->name('prototipo.index');


Route::post('/inicio', function () {
    return view('modulos.prototipo.inicio-prototipo');
})->name('inicio-prototipo');

Route::get('/contraseña', function () {
    return view('modulos.prototipo.inicio-prototipo');
})->name('clave-index2');

Route::get('/registro-prototipo', function () {
    return view('modulos.prototipo.registro-prototipo');
})->name('registro-prototipo');

Route::get('/registro-proto-prueba', function () {
    return view('modulos.prototipo.registro2-prototipo');
})->name('registro-proto-prueba');

Route::get('/registro-proto-culminar', function () {
    return view('modulos.prototipo.registro3-prototipo');
})->name('registro-proto-culminar');

Route::get('/contraseña-prototipo', function () {
    return view('modulos.prototipo.contraseña1-prototipo');
})->name('contraseña-prototipo');

Route::get('/contraseña-prototipo2', function () {
    return view('modulos.prototipo.contraseña2-prototipo');
})->name('contraseña2-prototipo');

Route::get('/contraseña3-prototipo', function () {
    return view('modulos.prototipo.contraseña3-prototipo');
})->name('contraseña3-prototipo');

Route::get('/contraseña4-prototipo', function () {
    return view('modulos.prototipo.contraseña4-prototipo');
})->name('contraseña4-prototipo');

Route::get('/preguntas-seguridad-prototipo', function () {
    return view('modulos.prototipo.preguntas-prototipo');
})->name('preguntas-seguridad-prototipo');


Route::get('/contraseña-prototipo3', function () {
    return view('modulos.prototipo.datos-prototipo');
})->name('datoPersonal-prototipo');

Route::get('/productiva', function () {
    return view('modulos.prototipo.productiva');
})->name('productiva');


Route::get('/informe', function () {
    return view('modulos.prototipo.informe');
})->name('informe');

Route::get('/exp_productiva', function () {
    return view('modulos.prototipo.exp_productiva');
})->name('exp_productiva');




