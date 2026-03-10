function buscar3(nacionalidad, ced_afiliado) {
    const requeridoCampos = document.getElementById("requerido-campos");
    const errorContainer = document.querySelector(".alert.alert-danger.fs-6");
    let errorListHTML = '<ul>';
    let hayError = false;

    // Limpiar errores previos
    errorContainer.innerHTML = '';
    errorContainer.style.display = 'none';

    // Validación mínima en el frontend: solo campos vacíos
    if (!nacionalidad) {
        document.getElementById("nacionalidad").style.borderBottom = "1px solid red";
        errorListHTML += '<li>Debe seleccionar un tipo de documento.</li>';
        hayError = true;
    } else {
        document.getElementById("nacionalidad").style.border = "";
    }

    if (!ced_afiliado) {
        document.getElementById("ced_afiliado").style.borderBottom = "1px solid red";
        errorListHTML += '<li>Debe ingresar el número de documento.</li>';
        hayError = true;
    } else {
        document.getElementById("ced_afiliado").style.border = "";
    }

    errorListHTML += '</ul>';

    if (hayError) {
        if (requeridoCampos) requeridoCampos.style.color = "red";
        errorContainer.innerHTML = errorListHTML;
        errorContainer.style.display = "block";
        return false;
    } else {
        if (requeridoCampos) requeridoCampos.style.color = "";

        const form = document.createElement("form");
        form.method = "POST";
        form.action = rutaContrasenaPost;

        const csrfTokenInput = document.createElement("input");
        csrfTokenInput.type = "hidden";
        csrfTokenInput.name = "_token";
        csrfTokenInput.value = document.querySelector('meta[name="csrf-token"]').content;

        const nacionalidadInput = document.createElement("input");
        nacionalidadInput.type = "hidden";
        nacionalidadInput.name = "nacionalidad";
        nacionalidadInput.value = nacionalidad;

        const cedAfiliadoInput = document.createElement("input");
        cedAfiliadoInput.type = "hidden";
        cedAfiliadoInput.name = "ced_afiliado";
        cedAfiliadoInput.value = ced_afiliado;

        form.appendChild(csrfTokenInput);
        form.appendChild(nacionalidadInput);
        form.appendChild(cedAfiliadoInput);

        document.body.appendChild(form);
        form.submit();
    }
}



function verificarRespuestasLlenas(event) {
    event.preventDefault();

    const respuestaInputs = document.querySelectorAll('.respuesta-pregunta');
    let algunCampoVacio = false;
    const errorContainer = document.querySelector(".alert.alert-danger.fs-6");
    let errorListHTML = '<ul>';

    // Limpiar errores previos
    errorContainer.innerHTML = '';
    errorContainer.style.display = 'none';

    respuestaInputs.forEach(input => {
        if (input.value.trim() === '') {
            algunCampoVacio = true;
            input.style.borderBottom = '1px solid red';
        } else {
            input.style.borderBottom = '';
        }
    });

    if (algunCampoVacio) {
        errorListHTML += `<li>Debe responder todas las preguntas de seguridad.</li></ul>`;
        errorContainer.innerHTML = errorListHTML;
        errorContainer.style.display = "block";
        return;
    }

    // Crear formulario y enviarlo sin usar fetch
    const form = document.createElement("form");
    form.method = "POST";
    form.action = rutaContrasena2;

    const csrfTokenInput = document.createElement("input");
    csrfTokenInput.type = "hidden";
    csrfTokenInput.name = "_token";
    csrfTokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    respuestaInputs.forEach(input => {
        const inputHidden = document.createElement("input");
        inputHidden.type = "hidden";
        inputHidden.name = `respuesta_${input.dataset.preguntaId}`;
        inputHidden.value = input.value.trim();
        form.appendChild(inputHidden);
    });

    form.appendChild(csrfTokenInput);
    document.body.appendChild(form);
    form.submit();
}


document.addEventListener('DOMContentLoaded', function() {
    const btnSiguiente = document.getElementById('btnSiguientePreguntas');
    if (btnSiguiente) {
        btnSiguiente.addEventListener('click', verificarRespuestasLlenas);
    }
});

