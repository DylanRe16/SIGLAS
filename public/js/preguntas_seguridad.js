document.addEventListener('DOMContentLoaded', function () {
    // Seleccionamos todos los select y los campos de respuesta
    const selects = document.querySelectorAll('.select-preg');
    
    // Función para actualizar las opciones disponibles en los select
    function updateOptions() {
        const selectedValues = Array.from(selects)
            .map(select => select.value)
            .filter(value => value !== ''); // Excluir valores vacíos

        selects.forEach(select => {
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                if (selectedValues.includes(option.value) && option.value !== select.value) {
                    option.hidden = true; // Ocultar si ya está seleccionada en otro select
                } else {
                    option.hidden = false;
                }
            });
        });
    }

    // Función para limpiar la respuesta relacionada con el select que cambió
    function resetRespuesta(select) {
        const respuestaId = select.getAttribute('data-respuesta-id');
        const respuestaInput = document.getElementById(respuestaId);
        if (respuestaInput) {
            respuestaInput.value = ''; // Limpiar contenido de la respuesta
        }
    }

    // Asignamos el evento change a cada select
    selects.forEach(select => {
        select.addEventListener('change', function () {
            updateOptions();
            resetRespuesta(select);
        });
    });

    // Ejecutamos la función para inicializar los selects
    updateOptions();
});
