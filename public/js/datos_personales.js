document.addEventListener("DOMContentLoaded", function () {
    // Validación de números de teléfono
    document.querySelectorAll('.num_tlf').forEach((inputField) => {
        inputField.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '').slice(0, 7);
            this.value = value;

        });
    });

    // Validación de números de certificado
    document.querySelectorAll('.num_certif').forEach((inputField) => {
        inputField.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            this.value = value;
            this.setCustomValidity(value.length > 10 ? 'Debe ingresar un máximo de 10 dígitos.' : '');
        });
    });

    // Validación de número de RIF
    document.querySelectorAll('.num_rif').forEach((inputField) => {
        inputField.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
            this.value = value;
            this.setCustomValidity(value.length > 9 ? 'Debe ingresar un máximo de 10 dígitos.' : '');
        });
    });

    // Validación de número de RIF
    document.querySelectorAll('.num_rif2').forEach((inputField) => {
        inputField.addEventListener('input', function () {
            // Permitir solo J, G o C como primera letra y los siguientes como números
            let value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); // Permite solo letras y números
            const isValidFormat = /^[JGC][0-9]{0,9}$/.test(value); // Verifica si cumple el formato (J, G o C y hasta 9 números)

            // Ajustar el valor permitido según el formato
            if (!isValidFormat) {
                value = value.slice(0, 1).replace(/[^JGC]/g, '') + value.slice(1).replace(/[^0-9]/g, '').slice(0, 9);
            }

            this.value = value; // Actualiza el campo de entrada
            this.setCustomValidity(value.length > 10 ? 'Debe ingresar un máximo de 10 caracteres (1 letra J, G o C y 9 números).' : '');
        });
    });

    // Manejo de discapacidad
    const bDiscapacidad = document.getElementById('bdiscapacidad');
    if (bDiscapacidad) {
        bDiscapacidad.addEventListener('change', function () {
            const containers = [
                document.getElementById('tipo_discapacidad_container'),
                document.getElementById('especifique_discapacidad_container'),
                document.getElementById('grado_discapacidad_container'),
                document.getElementById('tiene_conapdis_container'),
                document.getElementById('num_conapdis_container'),
            ];

            if (this.value == '1') {
                containers.slice(0, 4).forEach(container => {
                    if (container) {
                        container.style.display = 'block';
                        container.style.opacity = '1';
                    }
                });

                
            } else {
                containers.forEach(container => {
                    if (container) {
                        container.style.opacity = '0';
                        setTimeout(() => { container.style.display = 'none'; }, 10);
                    }
                });

                ['id_tdiscapacidad', 'sdicapacidad_especifica', 'grado_discapacidad', 'bcertificado_conapdis', 'nnum_certificado']
                .forEach(id => {
                    const element = document.getElementById(id);
                    if (element) element.value = '';
                });
            }

            
        });
    }

    const certificadoConapdis = document.getElementById('bcertificado_conapdis');
    if (certificadoConapdis) {
        certificadoConapdis.addEventListener('change', function () {
            const codigoContainer = document.getElementById('num_conapdis_container');
            if (this.value == '1') {
                codigoContainer.style.display = 'block';
                codigoContainer.style.opacity = '1';
            } else {
                codigoContainer.style.opacity = '0';
                setTimeout(() => { codigoContainer.style.display = 'none'; }, 10);
                document.getElementById('nnum_certificado').value = ''; // Resetear
            }
        });
    }
});
