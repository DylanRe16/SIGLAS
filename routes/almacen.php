<?php

use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/almacen', function () {
        return view('modulos.almacen.index');
    })->name('almacen-inventario');

    Route::get('/almacen/nota-entrega', function () {
        return view('modulos.almacen.nota.index');
    })->name('almacen-nota-entrega');

    Route::get('/almacen/inventario/consulta', function () {
        return view('modulos.almacen.inventario.consulta');
    })->name('almacen-reporte-consulta');

    Route::get('/almacen/inventario/registro', function () {
        return view('modulos.almacen.inventario.registro');
    })->name('almacen-reporte-registro');

    Route::get('/almacen/nota-entrega/consulta', function () {
        return view('modulos.almacen.nota.consulta');
    })->name('almacen-nota-consulta');
    Route::get('/almacen/nota-entrega/registro', function () {
        return view('modulos.almacen.nota.registro');
    })->name('almacen-nota-registro');
});
