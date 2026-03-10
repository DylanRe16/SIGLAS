<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/siris', function () {
        return view('modulos.siris.index');
    })->name('siris');

    Route::get('/siris/consulta', function () {
        return view('modulos.siris.consulta');
    })->name('siris-consulta');

    // todo: Inicio primeras 5 vistas 
    Route::get('/siris/consulta-registrador', function () {
        return view('modulos.siris.consulta-registrador');
    })->name('siris.consulta-registrador');

    Route::get('/siris/insolvencias', function () {
        return view('modulos.siris.insolvencias');
    })->name('siris.insolvencias');

    Route::get('/siris/insolvencias-datos', function () {
        return view('modulos.siris.insolvencias-datos');
    })->name('siris.insolvencias-datos');

    Route::get('/siris/insolvencias-grilla', function () {
        return view('modulos.siris.insolvencias-grilla');
    })->name('siris.insolvencias-grilla');

    Route::get('/siris/insolvencias-registro', function () {
        return view('modulos.siris.insolvencias-registro');
    })->name('siris.insolvencias-registro');
    // todo: Fin primeras 5 vistas 

    Route::get('/siris/registro-novedades', function () {
        return view('modulos.siris.registro-novedades');
    })->name('siris-registro-novedades');

    Route::get('/siris/registros-consulta', function () {
        return view('modulos.siris.registros-consulta');
    })->name('siris-registros-consulta');

    Route::get('/siris/subsanaciones-registro', function () {
        return view('modulos.siris.subsanaciones-registro');
    })->name('siris-subsanaciones-registro');

    Route::get('/siris/subsanaciones', function () {
        return view('modulos.siris.subsanaciones');
    })->name('siris-subsanaciones');

    Route::get('/siris/totales-insolvencias', function () {
        return view('modulos.siris.totales-insolvencias');
    })->name('siris-totales-insolvencias');
    // todo: Fin ultimas 5 vistas 

});
