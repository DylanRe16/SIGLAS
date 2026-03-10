document.addEventListener("DOMContentLoaded", function () {
    const estadoSelect = document.getElementById("estado");
    const municipioSelect = document.getElementById("municipio");
    const parroquiaSelect = document.getElementById("parroquia");

    // Verificar si los elementos existen antes de continuar
    if (!estadoSelect || !municipioSelect || !parroquiaSelect) {
        console.error(
            "No se encontraron todos los elementos SELECT necesarios."
        );
        return;
    }

    const municipiosUrl = estadoSelect.dataset.municipiosUrl;
    const parroquiasUrl = municipioSelect.dataset.parroquiasUrl;

    /**
     * Resetea el selector de municipio y parroquia.
     */
    function resetMunicipiosYParroquias() {
        municipioSelect.innerHTML =
            '<option value="-1" disabled selected>Seleccione el municipio</option>';
        municipioSelect.disabled = true;
        parroquiaSelect.innerHTML =
            '<option value="-1" disabled selected>Seleccione la parroquia</option>';
        parroquiaSelect.disabled = true;
    }

    // Evento para cargar municipios al seleccionar un estado
    estadoSelect.addEventListener("change", function () {
        const estadoId = this.value;
        resetMunicipiosYParroquias(); // Limpiar siempre al cambiar de estado

        if (estadoId !== "-1") {
            fetch(`${municipiosUrl}/${estadoId}`)
                .then((response) => {
                    if (!response.ok)
                        throw new Error("Error en la respuesta del servidor");
                    return response.json();
                })
                .then((data) => {
                    data.forEach((municipio) => {
                        const option = document.createElement("option");
                        option.value = municipio.nmunicipio;
                        option.textContent = municipio.sdescripcion;
                        municipioSelect.appendChild(option);
                    });

                    municipioSelect.disabled = false;

                    // Lógica de PRECARGA:
                    const selectedMunicipio = municipioSelect.dataset.selected;
                    if (selectedMunicipio) {
                        municipioSelect.value = selectedMunicipio;
                        // Disparar el evento para cargar parroquias inmediatamente DESPUÉS de cargar los municipios
                        municipioSelect.dispatchEvent(new Event("change"));
                        // Después de usarse, limpia el dataset para evitar precargas futuras no deseadas.
                        delete municipioSelect.dataset.selected;
                    }
                })
                .catch((error) =>
                    console.error("Error al cargar municipios:", error)
                );
        }
    });

    // Evento para cargar parroquias al seleccionar un municipio
    municipioSelect.addEventListener("change", function () {
        const municipioId = this.value;
        parroquiaSelect.innerHTML =
            '<option value="-1" disabled selected>Seleccione la parroquia</option>';
        parroquiaSelect.disabled = true;

        if (municipioId !== "-1") {
            fetch(`${parroquiasUrl}/${municipioId}`)
                .then((response) => {
                    if (!response.ok)
                        throw new Error("Error en la respuesta del servidor");
                    return response.json();
                })
                .then((data) => {
                    data.forEach((parroquia) => {
                        const option = document.createElement("option");
                        option.value = parroquia.nparroquia;
                        option.textContent = parroquia.sdescripcion;
                        parroquiaSelect.appendChild(option);
                    });

                    parroquiaSelect.disabled = false;

                    // Lógica de PRECARGA:
                    const selectedParroquia = parroquiaSelect.dataset.selected;
                    if (selectedParroquia) {
                        parroquiaSelect.value = selectedParroquia;
                        // Limpia el dataset después de usarse.
                        delete parroquiaSelect.dataset.selected;
                    }
                })
                .catch((error) =>
                    console.error("Error al cargar parroquias:", error)
                );
        }
    });

    // 🚀 INICIO: Disparar el evento de cambio en el estado para cargar municipios y parroquias al cargar la página
    if (estadoSelect.value && estadoSelect.value !== "-1") {
        estadoSelect.dispatchEvent(new Event("change"));
    }
});
