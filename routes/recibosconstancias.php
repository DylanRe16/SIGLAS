<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReciboConstanciaController;
use App\Http\Controllers\RecibosPagosController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ProcesosRecibosController;


Route::get('/validar/constancia/{token}', [ReciboConstanciaController::class, 'validarPublico'])
    ->name('validar.publico');



Route::middleware('auth')->group(function () {
    // 1. Ruta principal del panel (INDEX)
    Route::get('/recibosconstancias', [ReciboConstanciaController::class, 'index'])->name('recibos.index');
    
    // 2. Ruta para generar el PDF de sueldo
    Route::get('/recibosconstancias/simple-sueldo', [ReciboConstanciaController::class, 'simpleSueldo'])->name('recibos.simple-sueldo');

    // 3. Ruta para la vista de Egresado
    Route::get('/recibosconstancias/egresado', [ReciboConstanciaController::class, 'egresado'])->name('recibos.egresado');

    // 4. NUEVA RUTA: Procesa la búsqueda (POST)
    Route::post('/recibosconstancias/buscar', [ReciboConstanciaController::class, 'buscarEgresado'])->name('recibos.buscar');

    Route::post('/recibosconstancias/generar-pdf-egreso', [ReciboConstanciaController::class, 'generarPdfEgreso'])->name('recibos.generar-pdf-egreso');

    Route::get('/recibosconstancias/faov', [ReciboConstanciaController::class, 'faov'])->name('recibos.faov');

    Route::post('/recibosconstancias/buscarfaov', [ReciboConstanciaController::class, 'buscarfaov'])->name('recibos.buscarfaov');

    Route::post('/recibosconstancias/pdf-faov', [ReciboConstanciaController::class, 'generarPdfFaov'])->name('recibos.generarpdf.faov');


    // 1. Ruta para MOSTRAR la vista (GET)
    Route::get('/recibosconstancias/buscar-sueldo', [ReciboConstanciaController::class, 'vistaBuscarSueldo'])->name('recibos.buscarsueldo.index');

    // 2. Ruta para PROCESAR la búsqueda (POST) - CAMBIAMOS EL NOMBRE AQUÍ
    Route::post('/recibosconstancias/buscarsueldo', [ReciboConstanciaController::class, 'BuscarSueldo'])->name('recibos.buscarsueldo.post');

    Route::post('/recibosconstancias/pdf-sueldo', [ReciboConstanciaController::class, 'generarPdfSueldo'])->name('recibos.generarpdf.sueldo');

        // Vista principal
    Route::get('/recibos/jubilados', [ReciboConstanciaController::class, 'jubilados'])->name('recibos.jubilados');

    // Procesamiento de búsqueda (AJAX)
    Route::post('/recibos/buscar-jubilado', [ReciboConstanciaController::class, 'BuscarJubilado'])->name('recibos.buscarjubilado');

    Route::post('/recibos/generar-pdf-jubilado', [ReciboConstanciaController::class, 'generarPdfJubilado'])->name('recibos.pdf.jubilado');

    // Recibos de Pagos

    Route::group(['prefix' => 'recibos-pagos', 'as' => 'recibos.pago.'], function () {

        Route::get('/ordinarios', [RecibosPagosController::class, 'indexOrdinarios'])->name('ordinarios');

        Route::post('/buscar-recibo', [RecibosPagosController::class, 'buscarRecibo'])->name('buscar');

        Route::get('/imprimir-recibo/{mes}/{quincena}', [RecibosPagosController::class, 'imprimirPDF'])->name('recibos.pago.imprimir');

        Route::get('/especiales', [RecibosPagosController::class, 'indexEspeciales'])->name('especiales');


       // Esta es la nueva, simplificada al máximo
        Route::post('/especiales-buscar', [RecibosPagosController::class, 'buscarEspecial'])->name('buscarEspecial');
    
    });

        Route::get('/recibos-jubilados', [RecibosPagosController::class, 'indexJubilados'])
            ->name('recibos.jubilados.index');

        Route::post('/recibos-jubilados/buscar', [RecibosPagosController::class, 'buscarJubilado'])
            ->name('recibos.jubilados.buscar');

        // Reporte mensual histórico por trabajador
        Route::get('/recibos/mensual-trabajador', [RecibosPagosController::class, 'vistaMensualTrabajador'])->name('recibos.mensual.trabajador');
        
        Route::post('/recibos/historico-buscar', [RecibosPagosController::class, 'buscarHistoricoMensual'])->name('recibos.historico.buscar');

        // Ruta para el módulo de Tickets Alimentación
       Route::get('/mantenimiento/tickets-alimentacion', [MantenimientoController::class, 'indexTickets'])->name('mantenimiento.tickets.index');
       Route::post('/mantenimiento/tickets-guardar', [MantenimientoController::class, 'guardarTicket'])->name('mantenimiento.tickets.guardar');

        // Rutas de Usuarios dentro de Mantenimiento
        // Ruta para cargar la página
        Route::get('/recibos-constancias/mantenimiento/usuarios', [MantenimientoController::class, 'indexUsuarios'])
    ->name('recibos_constancias.mantenimiento.usuarios.index');

// Ruta para las acciones AJAX
Route::post('/recibos-constancias/mantenimiento/usuarios/gestionar', [MantenimientoController::class, 'gestionarUsuario'])
    ->name('recibos_constancias.mantenimiento.usuarios.gestionar');

        Route::controller(ProcesosRecibosController::class)->group(function () {
            // Vista
            Route::get('/procesos/actualizar-personal', 'indexActualizar')->name('procesos.actualizar');
            // Ejecución AJAX
            Route::post('/procesos/actualizar-personal/ejecutar', 'procesarCargaDatos')->name('procesos.actualizar.ejecutar');
        });

        Route::get('/procesos/consultar-datos', function () {
            return view('modulos.recibos_constancias.procesos.consultar_datos_procesos');
        })->name('procesos.consultar');

        Route::post('/procesos/consultar-datos/buscar', [ProcesosRecibosController::class, 'buscarTrabajador'])->name('procesos.consultar.buscar');

        Route::get('/procesos/funcionarios', [ProcesosRecibosController::class, 'viewProcesarFuncionarios'])->name('procesos.funcionarios.index');
Route::post('/procesos/funcionarios/cargar', [ProcesosRecibosController::class, 'storeProcesarFuncionarios'])->name('procesos.funcionarios.store');

Route::get('/procesos/obreros', [ProcesosRecibosController::class, 'viewProcesarObreros'])->name('procesos.obreros.index');
Route::post('/procesos/obreros/cargar', [ProcesosRecibosController::class, 'storeProcesarObreros'])->name('procesos.obreros.store');

});
?>