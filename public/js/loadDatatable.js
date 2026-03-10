window.addEventListener('load', function () {
    const configDataTable = {
        responsive: true,
        language: {
            decimal: ",",
            thousands: ".",
            processing: "Procesando...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ entradas",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            infoEmpty: "Mostrando 0 a 0 de 0 entradas",
            infoFiltered: "(filtrado de _MAX_ entradas totales)",
            loadingRecords: "Cargando...",
            zeroRecords: "No se encontraron registros coincidentes",
            emptyTable: "No hay datos disponibles en la tabla",
            paginate: { first: "«", previous: "‹", next: "›", last: "»" },
            aria: { sortAscending: ": activar para ordenar ascendente", sortDescending: ": activar para ordenar descendente" }
        }
    };

    const tableEl = document.querySelector('#myTable');
    if (window.DataTable && tableEl) {
        new DataTable(tableEl, configDataTable);
    } else {
        console.warn('DataTable no disponible o #myTable no encontrado.');
    }
});