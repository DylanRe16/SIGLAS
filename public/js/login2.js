function login(cedula, clave) {
    const nacionalidadSelect = document.getElementById("nacionalidad");
    const cedAfiliadoInput = document.getElementById("num_cedula");
    const passwordInput = document.getElementById("password");
    const contenedorErrores = document.getElementById("contenedor-errores-js");

    let errores = [];

    const nacionalidad = nacionalidadSelect?.value || '';
    const cedAfiliado = cedAfiliadoInput?.value.trim() || '';
    const password = passwordInput?.value.trim() || '';

    // Validaciones de campos
    if (!nacionalidad) {
        errores.push("Debe seleccionar una nacionalidad.");
        nacionalidadSelect.style.borderBottom = "1px solid red";
    } else {
        nacionalidadSelect.style.borderBottom = "";
    }

    if (!cedAfiliado) {
        errores.push("Debe ingresar su número de documento.");
        cedAfiliadoInput.style.borderBottom = "1px solid red";
    } else {
        cedAfiliadoInput.style.borderBottom = "";
    }

    if (!password) {
        errores.push("Debe ingresar su contraseña.");
        passwordInput.style.borderBottom = "1px solid red";
    } else {
        passwordInput.style.borderBottom = "";
    }

    // Si hay errores, mostrar en el contenedor
    if (errores.length > 0) {
        mostrarErrores(errores);
        return false;
    }

    // Enviar datos al servidor mediante POST
    fetch(rutaIngresar, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nacionalidad, ced_afiliado: cedAfiliado, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = rutaInicio; // Redirigir al inicio si es exitoso
        } else {
            mostrarErrores([data.message || "Error al iniciar sesión."]);
        }
    })
    .catch(error => {
        console.error("Error de red:", error);
        mostrarErrores(["Error de red al intentar iniciar sesión."]);
    });

    return false;
}

// Función para mostrar errores en el contenedor de alertas
function mostrarErrores(mensajes) {
    const contenedorErrores = document.getElementById("contenedor-errores-js");
    if (contenedorErrores) {
        contenedorErrores.innerHTML = '<ul>' + mensajes.map(msg => `<li>${msg}</li>`).join('') + '</ul>';
        contenedorErrores.style.display = "block";
    }
}
