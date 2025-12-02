//Definicion de varibles de los reportes
//Reporte de tipo de trabajador
    const labels = @json($catidadPersonaTipoTrabajo->pluck('tipo_trabajo'));
    const valores = @json($catidadPersonaTipoTrabajo->pluck('cantidad'));
    const edades = @json($cantidadEdades);
    console.log(labels);
//Reporte por edad
    const labelsEdades = Object.keys(edades);
    const valoresEdades = Object.values(edades);
    const totalEdades = valoresEdades.reduce((acc, val) => acc + val, 0);
//Reporte por sexo
    const hombres = @json($totalHombres);
    const mujeres = @json($totalMujeres);
    const totalPersona = hombres + mujeres
    const labelssexo = [ `Mujeres (${mujeres})`,`Hombres (${hombres})`, `Total (${totalPersona})`];
//Reporte por Entidad
const datosEntidad = @json($cantidadPersonaEntidad);
    const labelsEntidad = datosEntidad.map(e => e.entidad_federal);
    const valoresEntidad = datosEntidad.map(e => e.cantidad);
    const totalEntidad = valoresEntidad.reduce((acc, val) => acc + val, 0);    
//Reporte por Persona Discapacitadas
    const personasDiscapacitadas = @json($personasDiscapacitadas);
    const personasNoDiscapacitadas = @json($personasNoDiscapacitadas);
    const labelsDiscapacidad = [
        `Con Discapacidad (${personasDiscapacitadas})`,
        `Sin Discapacidad (${personasNoDiscapacitadas})`
    ];
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
//Definimos las graficas    
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');
    const ctx3 = document.getElementById('myChart3');
    const ctx4 = document.getElementById('myChart4');
    const ctx5 = document.getElementById('myChart5');
    const ctx6 = document.getElementById('myChart6');

    if (ctx && labels.length > 0) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labelssexo,
                datasets: [{
                    label: 'Cantidad de Personas',
                    totalPersona,
                    data: [mujeres,hombres],
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribución por Sexo'
                    },
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
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
                        text: `Distribución por Edad (Total: ${totalEdades})`
                    },
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
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
                        text: `Distribución por Estado (Total: ${totalEntidad})`
                    },
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
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
                        'rgba(75, 192, 192, 0.6)'  // verde
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
                        text: 'Distribución por Discapacidad'
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
                    label: 'Cantidad de Personas',
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribución por Tipo de Trabajo'
                    },
                    legend: {
                        position: 'top'
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
     if (ctx6) {
        new Chart(ctx6, {
            type: 'pie',
            data: {
                labels: labelsEnte,
                datasets: [{
                    label: 'Distribución por Ente',
                    data: valoresEnte,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',   // Azul
                        'rgba(255, 99, 132, 0.7)',   // Rojo
                        'rgba(255, 206, 86, 0.7)',   // Amarillo
                        'rgba(75, 192, 192, 0.7)'    // Verde agua
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
                        text: `Distribución de Personas por Ente (Total: ${totalPersonasEnte})`
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    } else {
        console.warn('⚠️ No se encontró el canvas para la gráfica de ente.');
    }
