document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');

    const validations = {
        t1: /[a-z]/, // Al menos una letra minúscula
        t2: /[A-Z]/, // Al menos una letra mayúscula
        t3: /\d/,    // Al menos un número
        t4: /.{8,}/, // Más de 7 caracteres
        t5: /[@#$%^&*(),.?":{}|<>]/, // Al menos un carácter especial
    };

    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;

        for (const [id, regex] of Object.entries(validations)) {
            const element = document.getElementById(id);
            if (regex.test(password)) {
                element.classList.remove('text-danger');
                element.classList.add('text-success');
            } else {
                element.classList.remove('text-success');
                element.classList.add('text-danger');
            }
        }

        // Validar si las contraseñas coinciden
        const matchElement = document.getElementById('t6');
        if (password === confirmPasswordInput.value && password !== '') {
            matchElement.classList.remove('text-danger');
            matchElement.classList.add('text-success');
        } else {
            matchElement.classList.remove('text-success');
            matchElement.classList.add('text-danger');
        }
    });

    confirmPasswordInput.addEventListener('input', function () {
        const matchElement = document.getElementById('t6');
        if (passwordInput.value === confirmPasswordInput.value && passwordInput.value !== '') {
            matchElement.classList.remove('text-danger');
            matchElement.classList.add('text-success');
        } else {
            matchElement.classList.remove('text-success');
            matchElement.classList.add('text-danger');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordIcons = document.querySelectorAll('.bi-eye-slash, .bi-eye');

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const input = this.parentElement.previousElementSibling; // Obtiene el input asociado
            const isPasswordVisible = input.type === 'text';

            // Alternar el tipo de input entre 'password' y 'text'
            input.type = isPasswordVisible ? 'password' : 'text';

            // Alternar la clase del ícono
            this.classList.toggle('bi-eye-slash');
            this.classList.toggle('bi-eye');
        });
    });
});