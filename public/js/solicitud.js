document.addEventListener('DOMContentLoaded', function () {
    const solicitudSelect = document.getElementById('solicitud');
    const tipoSolicitudSelect = document.getElementById('tipo_solicitud');

    // URL para cargar los tipos de solicitud
    const tiposolicitudUrl = solicitudSelect.dataset.tiposolicitudUrl;

    // Evento para cargar tipo de solicitud al seleccionar una solicitud
    solicitudSelect.addEventListener('change', function () {
        const solicitudId = this.value;

        if (solicitudId !== '-1') {
            fetch(`${tiposolicitudUrl}/${solicitudId}`)
                .then(response => response.json())
                .then(data => {
                    tipoSolicitudSelect.innerHTML = '<option value="-1" disabled selected>Seleccione el tipo de solicitud</option>';

                    data.forEach(tipoSolicitud => {
                        const option = document.createElement('option');
                        option.value = tipoSolicitud.id_tsolicitud;
                        option.textContent = tipoSolicitud.sdescripcion;
                        tipoSolicitudSelect.appendChild(option);
                    });

                    tipoSolicitudSelect.disabled = false;

                    // Seleccionar el valor previamente seleccionado
                    const selectedTipoSolicitud = tipoSolicitudSelect.dataset.selected;
                    if (selectedTipoSolicitud) {
                        tipoSolicitudSelect.value = selectedTipoSolicitud;
                    }
                })
                .catch(error => console.error('Error al cargar tipos de solicitud:', error));
        }
    });

    // Disparar el evento de cambio en la solicitud para cargar el tipo de solicitud al cargar la página
    const selectedSolicitud = solicitudSelect.dataset.selected;
    if (selectedSolicitud && selectedSolicitud !== '-1') {
        solicitudSelect.value = selectedSolicitud;
        solicitudSelect.dispatchEvent(new Event('change'));
    }
    console.log('Valor seleccionado para tipo de solicitud:', tipoSolicitudSelect.dataset.selected);
});