function validarCambioContraseña(event) {
    event.preventDefault();

    const passwordInput = document.getElementById('password');
    const passwordInput2 = document.getElementById('password2');
    const errorContainer = document.querySelector(".alert.alert-danger.fs-6");
    let errorListHTML = '<ul>';
    let erroresEncontrados = false;

    const password = passwordInput.value.trim();
    const confirmPassword = passwordInput2.value.trim();

    // Limpiar errores previos
    errorContainer.innerHTML = '';
    errorContainer.style.display = 'none';

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

    // Crear formulario y enviarlo sin `fetch`
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
document.addEventListener('DOMContentLoaded', function() {
    const guardarButton = document.querySelector('.buttom');
    if (guardarButton) {
        guardarButton.addEventListener('click', validarCambioContraseña);
    }
});


function resaltarCampoInvalido(campo, esInvalido) {
    campo.style.borderBottom = esInvalido ? "1px solid red" : "";
}

function ocultarAlerta() {
    const errorContainer = document.querySelector(".alert.alert-danger.fs-6");
    if (errorContainer) errorContainer.style.display = "none";
}

// Event listeners para la validación en tiempo real
document.getElementById('password').addEventListener('input', function() {
    actualizarRequisitosContraseña(this.value);
    ocultarAlerta();
    this.style.borderBottom = "";
});

document.getElementById('password2').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    const t6 = document.getElementById('t6');
    t6.className = password === confirmPassword ? 'text-success' : 'text-danger';
    ocultarAlerta();
    this.style.borderBottom = "";
});

function actualizarRequisitosContraseña(password) {
    const t1 = document.getElementById('t1');
    const t2 = document.getElementById('t2');
    const t3 = document.getElementById('t3');
    const t4 = document.getElementById('t4');
    const t5 = document.getElementById('t5');

    t1.className = /[a-z]/.test(password) ? 'text-success' : 'text-danger';
    t2.className = /[A-Z]/.test(password) ? 'text-success' : 'text-danger';
    t3.className = /[0-9]/.test(password) ? 'text-success' : 'text-danger';
    t4.className = password.length > 10 ? 'text-success' : 'text-danger';
    const tieneCaracterEspecial =/[^a-zA-Z0-9\s]/g.test(password);
    t5.className = tieneCaracterEspecial ? 'text-success' : 'text-danger';
}
// Reemplazar el onclick del botón con un event listener
document.addEventListener('DOMContentLoaded', function() {
    const guardarButton = document.querySelector('.buttom[onclick="validarCambioContraseña()"]');
    if (guardarButton) {
        guardarButton.removeAttribute('onclick'); // Remove inline onclick
        guardarButton.addEventListener('click', validarCambioContraseña);
    }
});