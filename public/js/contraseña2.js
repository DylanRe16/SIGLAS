// Función para actualizar la validación visual en la interfaz
function actualizarRequisitosContraseña(password, confirmPassword) {
    const requisitos = [
        { id: 't1', regex: /[a-z]/, mensaje: 'Al menos una letra minúscula' },
        { id: 't2', regex: /[A-Z]/, mensaje: 'Al menos una letra mayúscula' },
        { id: 't3', regex: /[0-9]/, mensaje: 'Al menos un número' },
        { id: 't4', cond: password.length > 10, mensaje: 'Debe contener más de 10 caracteres' },
        { id: 't5', regex: /[\W_]/, mensaje: 'Debe tener un carácter especial Ej:(@, #, $, etc.)' },
        { id: 't6', cond: password === confirmPassword, mensaje: 'La contraseña debe coincidir' }
    ];

    requisitos.forEach(req => {
        const elemento = document.getElementById(req.id);
        if (req.regex) {
            elemento.className = req.regex.test(password) ? 'text-success' : 'text-danger';
        } else if ('cond' in req) {
            elemento.className = req.cond ? 'text-success' : 'text-danger';
        }
    });
}

// Validación de la contraseña al escribir en los campos
document.getElementById('password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('password2').value;
    actualizarRequisitosContraseña(this.value, confirmPassword);
});

document.getElementById('password2').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    actualizarRequisitosContraseña(password, this.value);
});

// Función para validar y enviar la nueva contraseña al servidor
function validarCambioContraseña(event) {
    event.preventDefault();

    const passwordInput = document.getElementById('password');
    const passwordInput2 = document.getElementById('password2');
    const errorContainer = document.querySelector(".alert.alert-danger.fs-6");
    let errorListHTML = '<ul>';
    let erroresEncontrados = false;

    // Limpiar errores previos
    errorContainer.innerHTML = '';
    errorContainer.style.display = 'none';

    const password = passwordInput.value.trim();
    const confirmPassword = passwordInput2.value.trim();

    // Validaciones
    if (!password || !confirmPassword) {
        erroresEncontrados = true;
        errorListHTML += '<li>Debe completar todos los campos.</li>';
    }

    if (password !== confirmPassword) {
        erroresEncontrados = true;
        errorListHTML += '<li>Las contraseñas deben coincidir.</li>';
    }

    if (!/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || password.length < 10 || !/[\W_]/.test(password)) {
        erroresEncontrados = true;
        errorListHTML += '<li>La contraseña no cumple con los requisitos.</li>';
    }

    errorListHTML += '</ul>';

    if (erroresEncontrados) {
        errorContainer.innerHTML = errorListHTML;
        errorContainer.style.display = "block";
        return;
    }

    // Crear formulario y enviarlo sin usar fetch
    const form = document.createElement("form");
    form.method = "POST";
    form.action = rutaGuardarContrasena;

    const csrfTokenInput = document.createElement("input");
    csrfTokenInput.type = "hidden";
    csrfTokenInput.name = "_token";
    csrfTokenInput.value = document.querySelector('meta[name="csrf-token"]').content;

    const passwordField = document.createElement("input");
    passwordField.type = "hidden";
    passwordField.name = "password";
    passwordField.value = password;

    const confirmPasswordField = document.createElement("input");
    confirmPasswordField.type = "hidden";
    confirmPasswordField.name = "password_confirmation";
    confirmPasswordField.value = confirmPassword;

    form.appendChild(csrfTokenInput);
    form.appendChild(passwordField);
    form.appendChild(confirmPasswordField);

    document.body.appendChild(form);
    form.submit();
}

// Evento para validar al hacer clic en el botón
document.addEventListener('DOMContentLoaded', function() {
    const guardarButton = document.querySelector('.buttom');
    if (guardarButton) {
        guardarButton.addEventListener('click', validarCambioContraseña);
    }
});