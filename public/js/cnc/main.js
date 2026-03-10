
// {{-- todo: para obtener los datos de una persona y empresa --}}
document.addEventListener('DOMContentLoaded', () => {

    // const urlBasePersona = "{{ url('cnconstituyente/getPerson') }}";
    const btnBuscarPersona = document.getElementById('btnGetPerson');
    const inputNacionalidad = document.getElementById('snacionalidad');
    const inputDocumento = document.getElementById('ndocumento');

    // const urlBaseEmpresa = "{{ url('cnconstituyente/getCompany') }}";
    const btnBuscarEmpresa = document.getElementById('btnGetCompany');
    const inputRif = document.getElementById('srif');

    const camposPersona = [
        'sprimer_nombre',
        'ssegundo_nombre',
        'sprimer_apellido',
        'ssegundo_apellido'
    ];

    const camposEmpresa = [
        'srazon_social',
        'sdenominacion_comercial',
        'entidad_nentidad',
        'municipio_nmunicipio',
        'parroquia_nparroquia',
    ];

    // 🔹 Función reutilizable para limpiar los campos
    function limpiarCampos(campos) {
        campos.forEach(id => {
            const campo = document.getElementById(id);
            if (campo) campo.value = '';
        });
    }

    // 🔹 Función principal de búsqueda
    async function buscarEmpresa() {
        const srif = inputRif.value.trim();
        const originalText = btnBuscarEmpresa.innerHTML;
        // console.log(srif);

        try {
            // Deshabilitar botón y mostrar indicador de carga
            btnBuscarEmpresa.disabled = true;
            btnBuscarEmpresa.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>';

            const queryParams = new URLSearchParams({
                srif
            });

            const response = await fetch(`${urlBaseEmpresa}?${queryParams}`);

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const json = await response.json();
            console.log(json);

            if (json.success && json.company) {
                const company = json.company;
                // console.log(company.estado);
                camposEmpresa.forEach(id => {
                    const campo = document.getElementById(id);
                    console.log(campo.id,' ', company[id]);
                    if (campo && company[id] !== undefined) {
                        if(campo.id == 'estado'){
                            // Asignar el valor al select de estado
                            console.log("estadoId: " + campo);
                            campo.value = company[id]?.toString().trim() ?? '';
                            
                        } else {
                        campo.value = company[id] ?? '';
                        // console.log('no salio');
                        // console.log(company.entidad_nentidad);
                        }
                    }
                });
                Swal.fire({
                    title: "Éxito!",
                    text: "Empresa encontrada correctamente!",
                    icon: "success"
                });

                // Swal.fire({
                //     toast: true,
                //     position: 'bottom-end',
                //     icon: 'success',
                //     title: 'Empresa encontrada correctamente.',
                //     showConfirmButton: false,
                //     timer: 4000,
                //     timerProgressBar: true
                // });
                // showToast('Empresa encontrada correctamente.', 'success');
            } else {
                limpiarCampos(camposEmpresa);
                // Swal.fire({
                //     title: "Advertencia!",
                //     text: json.message,
                //     icon: "warning"
                // });
                // alert(json.message || '');
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'warning',
                    title: json.message,
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
                // showToast(json.message || 'No se encontraron datos para el rif.', 'warning');
            }

        } catch (error) {
            console.error('Error al obtener los datos:', error);
            limpiarCampos(camposEmpresa);
            // Swal.fire({
            //         title: "Error!",
            //         text: error,
            //         icon: "error"
            //     });

            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'error',
                title: 'Ocurrió un error al intentar obtener los datos.',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
            // showToast('Ocurrió un error al intentar obtener los datos.', 'error');
        } finally {
            // Rehabilitar botón y restaurar texto original
            btnBuscarEmpresa.disabled = false;
            btnBuscarEmpresa.innerHTML = originalText;
        }
    }
    
    async function buscarPersona() {
        const snacionalidad = inputNacionalidad.value.trim();
        const ndocumento = inputDocumento.value.trim();
        const originalText = btnBuscarPersona.innerHTML;

        try {
            const queryParams = new URLSearchParams({
                snacionalidad,
                ndocumento
            });

            // Deshabilitar botón y mostrar indicador de carga
            btnBuscarPersona.disabled = true;
            btnBuscarPersona.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>';

            const response = await fetch(`${urlBasePersona}?${queryParams}`);

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const json = await response.json();
            console.log(json);

            if (json.success && json.persona) {
                const persona = json.persona;

                camposPersona.forEach(id => {
                    const campo = document.getElementById(id);
                    if (campo && persona[id] !== undefined) {
                        campo.value = persona[id] ?? '';
                    }
                });

                Swal.fire({
                    title: "Éxito!",
                    text: "Persona encontrada correctamente!",
                    icon: "success"
                });

                // showToast('Persona encontrada correctamente.', 'success');
            } else {
                limpiarCampos(camposPersona);
                // alert(json.message || '');
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'warning',
                    title: json.message || 'No se encontraron datos para el documento.',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
                // showToast(json.message || 'No se encontraron datos para el documento.', 'warning');
            }

        } catch (error) {
            console.error('Error al obtener los datos:', error);
            limpiarCampos(camposPersona);
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'error',
                title: 'Ocurrió un error al intentar obtener los datos.',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
            // showToast('Ocurrió un error al intentar obtener los datos.', 'error');
        } finally {
            // Rehabilitar botón y restaurar texto original
            btnBuscarPersona.disabled = false;
            btnBuscarPersona.innerHTML = originalText;
        }
    }


    // 🔹 Asignar evento
    btnBuscarPersona.addEventListener('click', buscarPersona);
    // btnBuscarEmpresa.addEventListener('click', buscarEmpresa);
});