document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('alert') === null) {
        return;
    }
    // Si el elemento con id 'alert' no existe, no hacemos nada
    // Si existe, lo mostramos
    let mensaje = document.getElementById('alert');
    mensaje.style.display = 'block';

    setTimeout(() => {
        mensaje.style.opacity = '0';

        mensaje.addEventListener('transitionend', function() {
            mensaje.style.display = 'none';
        }, { once: true }); // El { once: true } asegura que el listener se ejecute solo una vez
    }, 3000); // Mantiene el mensaje visible durante 3 segundos
});