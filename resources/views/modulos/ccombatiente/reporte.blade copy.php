@extends('adminlte::page')

@section('title', 'Ccombatiente')
@section('body_class', 'page-ccombatiente')

@section('content')

<main class="p-4">
    @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Cuerpo Combatiente > Reportes</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">Sexo</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" width="400" height="400" style="width: 400px; height: 400px !important;"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-olive">
                <div class="card-header">
                    <h5 class="card-title">Edad</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <canvas id="myChart2" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir2" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="card-title">Estado</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart3" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir3" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h5 class="card-title">Discapacidad</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart4" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir4" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-purple">
                <div class="card-header">
                    <h5 class="card-title">Tipo de Trabajo</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart5" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir5" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-cyan">
                <div class="card-header">
                    <h5 class="card-title">Ente de Procedencia</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <div id="contenedorReportes">
                        <canvas id="myChart6" width="400" height="400"></canvas>
                    </div>
                    <div class="text-end">
                        <button id="btnImprimir6" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="card-title">Comunas</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart7" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir7" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">Milicia</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart8" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir8" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">Rango</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart9" width="400" height="400"></canvas>
                    <div class="text-end">
                        <button id="btnImprimir9" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Descargar Reporte PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript" src="{{ asset('js/c.combatiente/pdf.js')}}"></script>
<script>
    //Definicion de varibles de los reportes
    //Reporte de tipo de trabajador
    const cant = @json($catidadPersonaTipoTrabajo->pluck('tipo_trabajo'));
    const valores = @json($catidadPersonaTipoTrabajo->pluck('cantidad'));
    const total = valores.reduce((acc, val) => acc + val, 0);
    const labels = cant.map((tipo, index) => `${tipo} (${valores[index]})`);
    const edades = @json($cantidadEdades);
    console.log(labels);
    //Reporte por edad
    const labelsEdades = [`20-24 (${edades.entre20y24})`, `25-29 (${edades.entre25y29})`, `30-34 (${edades.entre30y34})`, `35-39 (${edades.entre35y39})`, `40-45 (${edades.entre40y45})`, `46-50 (${edades.entre46y50})`, `51-55 (${edades.entre51y55})`, `56-60 (${edades.entre56y60})`, `60+ (${edades.de60ymasanios})`];
    const valoresEdades = Object.values(edades);
    const totalEdades = valoresEdades.reduce((acc, val) => acc + val, 0);
    //Reporte por sexo
    const hombres = @json($totalHombres);
    const mujeres = @json($totalMujeres);
    const totalPersona = hombres + mujeres
    const labelssexo = [`Mujeres (${mujeres})`, `Hombres (${hombres})`];
    //Reporte por Entidad
    const datosEntidad = @json($cantidadPersonaEntidad);
    const labelsEntidad = datosEntidad.map(e => `${e.entidad_federal} (${e.cantidad})`);
    const valoresEntidad = datosEntidad.map(e => e.cantidad);
    const totalEntidad = valoresEntidad.reduce((acc, val) => acc + val, 0);
    //Reporte por Persona Discapacitadas
    const personasDiscapacitadas = @json($personasDiscapacitadas);
    const personasNoDiscapacitadas = @json($personasNoDiscapacitadas);
    const labelsDiscapacidad = [
        `Con Discapacidad (${personasDiscapacitadas})`,
        `Sin Discapacidad (${personasNoDiscapacitadas})`
    ];
    const totalDiscapacidad = personasDiscapacitadas + personasNoDiscapacitadas;
    const valoresDiscapacidad = [personasDiscapacitadas, personasNoDiscapacitadas];
    //Reporte por Ente 
    const cantidadMPPPST = @json($cantidadMPPPST);
    const cantidadINPSASEL = @json($cantidadINPSASEL);
    const cantidadINCES = @json($cantidadINCES);
    const cantidadTSS = @json($cantidadTSS);
    const totalPersonasEnte = @json($totalPersonasEnte);

    const labelsEnte = [
        `MPPPST (${cantidadMPPPST})`,
        `INPSASEL (${cantidadINPSASEL})`,
        `INCES (${cantidadINCES})`,
        `TSS (${cantidadTSS})`
    ];

    const valoresEnte = [
        cantidadMPPPST,
        cantidadINPSASEL,
        cantidadINCES,
        cantidadTSS
    ];
    //Reporte por Comuna
    const datosComuna = @json($cantidadComunas);
    const labelsComuna = datosComuna.map(c => c.comuna);
    const valoresComuna = datosComuna.map(c => c.cantidad);
    const totalComuna = valoresComuna.reduce((acc, val) => acc + val, 0);

    const labelsConCantidad = datosComuna.map(c => `${c.comuna} (${c.cantidad})`);

    //Definimos las graficas    
    const ctx = document.getElementById('myChart');

    const ctx2 = document.getElementById('myChart2');
    const ctx3 = document.getElementById('myChart3');
    const ctx4 = document.getElementById('myChart4');
    const ctx5 = document.getElementById('myChart5');
    const ctx6 = document.getElementById('myChart6');
    const ctx7 = document.getElementById('myChart7');
    //Creamos las graficas
const textoAbajoPlugin = {
    id: 'textoAbajoPlugin',
    afterDraw(chart, args, options) {
        const { ctx, chartArea: { bottom, left, right } } = chart;

        ctx.save();
        ctx.font = '16px Arial';
       ctx.fillStyle = '#6c757d';
        ctx.textAlign = 'center';
        ctx.padding = '10px';
        ctx.textBaseline = 'bottom';


        // Texto centrado debajo de la gráfica
        ctx.fillText(options.texto, (left + right) / 2, bottom + 40);

        ctx.restore();
    }
};

    if (ctx && labels.length > 0) {
   // ctx.canvas.style.height = "400px";
        new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labelssexo,
        datasets: [{
            label: 'Cantidad de Personas',
            totalPersona,
            data: [mujeres, hombres],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)'
            ],
            borderColor: 'rgba(0,0,0,0.2)',
            borderWidth: 1
        }]
    },
    options: {
    responsive: true,
    aspectRatio: 1, // Más espacio vertical
    plugins: {
        legend: { position: 'bottom' },
        title: {
            display: true,
            text: 'Relación del Cuerpo Combatiente por Sexo',
            font: {
                size: 20
            }
        },
        textoAbajoPlugin: {
            texto: "Total de registros: " + totalPersona,
            marginTop: 20
        }
    },
    layout: {
        padding: {
            bottom: 50 // espacio garantizado
        }
    }
},
    plugins: [textoAbajoPlugin]
});

    }
    if (ctx2) {
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labelsEdades,
                datasets: [{
                    label: 'Cantidad de Personas por Rango de Edad',
                    data: valoresEdades,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(0,0,0,0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Relación del Cuerpo Combatiente por Grupo Etario Total de Registros: (${totalEdades})`,
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
    if (ctx3 && labelsEntidad.length > 0) {
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: labelsEntidad,
                datasets: [{
                    label: 'Cantidad de Personas por Estado',
                    data: valoresEntidad,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(0,0,0,0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Relación del Cuerpo Combatiente por Estado Total de Registros: (${totalEntidad})`,
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    } else {
        console.warn('⚠️ No hay datos o no se encontró el canvas.');
    }

    if (ctx4) { 
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: labelsDiscapacidad,
                datasets: [{
                    label: 'Personas',
                    data: valoresDiscapacidad,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)', // rojo
                        'rgba(75, 192, 192, 0.6)' // verde
                    ],
                    borderColor: 'rgba(255,255,255,1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Relación del Cuerpo Combatiente por Discapacidad Total de Registros: (' + totalDiscapacidad + ')',
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    } else {
        console.warn('⚠️ No se encontró el canvas para discapacidad.');
    }
    if (ctx5 && labels.length > 0) {
        new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: labels, 
                datasets: [{
                    data: valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: 'rgba(0,0,0,0.2)',
                    borderWidth: 1
                }]
            },
            options: {
               //indexAxis: 'y',
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Relación del Cuerpo Combatiente por Tipo de Trabajo Total de Registros: (' + total + ')',
                        font: {
                            size: 20
                        }
                    },
                  
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    } else {
        console.warn('⚠️ No hay datos o no se encontró el canvas.');
    }
    if (ctx6) {
        new Chart(ctx6, {
            type: 'pie',
            data: {
                labels: labelsEnte,
                datasets: [{
                    label: 'Distribución por Ente',
                    data: valoresEnte,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', // Azul
                        'rgba(255, 99, 132, 0.7)', // Rojo
                        'rgba(255, 206, 86, 0.7)', // Amarillo
                        'rgba(75, 192, 192, 0.7)' // Verde agua
                    ],
                    borderColor: 'rgba(255,255,255,1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Relación del Cuerpo Combatiente por Ente de Procedencia Total de Registros: (${totalPersonasEnte})`,
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                 scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        console.warn('⚠️ No se encontró el canvas para la gráfica de ente.');
    }
    if (ctx7 && labelsComuna.length > 0) {
        new Chart(ctx7, {
            type: 'bar',
            data: {
                labels: labelsConCantidad, // ⬅️ Aquí va el nuevo
                datasets: [{
                    label: 'Cantidad de Personas por Comuna',
                    data: valoresComuna,
                    backgroundColor: [
                        'rgba(98, 75, 192, 0.6)',
                        'rgba(192, 75, 75, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: 'rgba(0,0,0,0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                //indexAxis: 'y',
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Relación del Cuerpo Combatiente por Comuna Total de registros: (${totalComuna})`,
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

    } else {
        console.warn('⚠️ No hay datos o no se encontró el canvas.');
    }
</script>




//////////////////////////////////////////////



@endpush
@endsection
@include('layouts.extenciones')
@section('footer')
@include('layouts.footer')
@endsection