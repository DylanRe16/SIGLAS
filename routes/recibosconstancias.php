<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReciboConstanciaController;
use App\Http\Controllers\RecibosPagosController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ProcesosRecibosController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Accesibles desde el QR sin Login)
|--------------------------------------------------------------------------
*/
// Cambiamos 'token' por 'data' para recibir el payload del PDF
Route::get('/validar/constancia/{data}', [ReciboConstanciaController::class, 'validarPublico'])
    ->name('validar.publico');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- Módulo Recibos y Constancias ---
    Route::get('/recibosconstancias', [ReciboConstanciaController::class, 'index'])->name('recibos.index');
    Route::get('/recibosconstancias/simple-sueldo', [ReciboConstanciaController::class, 'simpleSueldo'])->name('recibos.simple-sueldo');
    Route::get('/recibosconstancias/egresado', [ReciboConstanciaController::class, 'egresado'])->name('recibos.egresado');
    Route::post('/recibosconstancias/buscar', [ReciboConstanciaController::class, 'buscarEgresado'])->name('recibos.buscar');
    Route::post('/recibosconstancias/generar-pdf-egreso', [ReciboConstanciaController::class, 'generarPdfEgreso'])->name('recibos.generar-pdf-egreso');
    Route::get('/recibosconstancias/faov', [ReciboConstanciaController::class, 'faov'])->name('recibos.faov');
    Route::post('/recibosconstancias/buscarfaov', [ReciboConstanciaController::class, 'buscarfaov'])->name('recibos.buscarfaov');
    Route::post('/recibosconstancias/pdf-faov', [ReciboConstanciaController::class, 'generarPdfFaov'])->name('recibos.generarpdf.faov');

    // Búsqueda de Sueldo
    Route::get('/recibosconstancias/buscar-sueldo', [ReciboConstanciaController::class, 'vistaBuscarSueldo'])->name('recibos.buscarsueldo.index');
    Route::post('/recibosconstancias/buscarsueldo', [ReciboConstanciaController::class, 'BuscarSueldo'])->name('recibos.buscarsueldo.post');
    Route::post('/recibosconstancias/pdf-sueldo', [ReciboConstanciaController::class, 'generarPdfSueldo'])->name('recibos.generarpdf.sueldo');

    // Jubilados
    Route::get('/recibos/jubilados', [ReciboConstanciaController::class, 'jubilados'])->name('recibos.jubilados');
    Route::post('/recibos/buscar-jubilado', [ReciboConstanciaController::class, 'BuscarJubilado'])->name('recibos.buscarjubilado');
    Route::post('/recibos/generar-pdf-jubilado', [ReciboConstanciaController::class, 'generarPdfJubilado'])->name('recibos.pdf.jubilado');

    // --- Módulo Recibos de Pagos ---
    Route::group(['prefix' => 'recibos-pagos', 'as' => 'recibos.pago.'], function () {
		Route::get('/ordinarios', [RecibosPagosController::class, 'indexOrdinarios'])->name('ordinarios');
		Route::post('/buscar-recibo', [RecibosPagosController::class, 'buscarRecibo'])->name('buscar');
		Route::get('/imprimir-recibo/{mes}/{quincena}', [RecibosPagosController::class, 'imprimirPDF'])->name('imprimir');
		
		// PAGOS ESPECIALES
		Route::get('/especiales', [RecibosPagosController::class, 'indexEspeciales'])->name('especiales');
		// Esta debe ser POST para el AJAX
		Route::post('/especiales-buscar', [RecibosPagosController::class, 'buscarEspecial'])->name('buscarEspecial');
		// Esta debe ser GET para el botón de imprimir que abre en pestaña nueva
		Route::get('/imprimir-especial/{mes}', [RecibosPagosController::class, 'imprimirEspecialPDF'])->name('imprimirEspecial');
	});

    Route::get('/recibos-jubilados', [RecibosPagosController::class, 'indexJubilados'])->name('recibos.jubilados.index');
    Route::post('/recibos-jubilados/buscar', [RecibosPagosController::class, 'buscarJubilado'])->name('recibos.jubilados.buscar');

    // Reportes e Históricos

    Route::get('/recibos/mensual-trabajador', [RecibosPagosController::class, 'vistaMensualTrabajador'])->name('recibos.mensual.trabajador');
Route::post('/recibos/historico-buscar', [RecibosPagosController::class, 'buscarHistoricoMensual'])->name('recibos.historico.buscar');
Route::post('/recibos/historico-pdf', [RecibosPagosController::class, 'imprimirHistoricoPDF'])->name('recibos.historico.pdf');

    // --- Mantenimiento ---
    Route::get('/mantenimiento/tickets-alimentacion', [MantenimientoController::class, 'indexTickets'])->name('mantenimiento.tickets.index');
    Route::post('/mantenimiento/tickets-guardar', [MantenimientoController::class, 'guardarTicket'])->name('mantenimiento.tickets.guardar');
    Route::get('/recibos-constancias/mantenimiento/usuarios', [MantenimientoController::class, 'indexUsuarios'])->name('recibos_constancias.mantenimiento.usuarios.index');
    Route::post('/recibos-constancias/mantenimiento/usuarios/gestionar', [MantenimientoController::class, 'gestionarUsuario'])->name('recibos_constancias.mantenimiento.usuarios.gestionar');

    // --- Procesos ---
    Route::controller(ProcesosRecibosController::class)->group(function () {
        Route::get('/procesos/actualizar-personal', 'indexActualizar')->name('procesos.actualizar');
        Route::post('/procesos/actualizar-personal/ejecutar', 'procesarCargaDatos')->name('procesos.actualizar.ejecutar');
    });

    Route::get('/procesos/consultar-datos', function () {
        return view('modulos.recibos_constancias.procesos.consultar_datos_procesos');
    })->name('procesos.consultar');

    Route::post('/procesos/consultar-datos/buscar', [ProcesosRecibosController::class, 'buscarTrabajador'])->name('procesos.consultar.buscar');
    
    // Funcionarios y Obreros
    Route::get('/procesos/funcionarios', [ProcesosRecibosController::class, 'viewProcesarFuncionarios'])->name('procesos.funcionarios.index');
    Route::post('/procesos/funcionarios/cargar', [ProcesosRecibosController::class, 'storeProcesarFuncionarios'])->name('procesos.funcionarios.store');
    Route::get('/procesos/obreros', [ProcesosRecibosController::class, 'viewProcesarObreros'])->name('procesos.obreros.index');
    Route::post('/procesos/obreros/cargar', [ProcesosRecibosController::class, 'storeProcesarObreros'])->name('procesos.obreros.store');

});