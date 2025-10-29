document.addEventListener("DOMContentLoaded", function () {
    const submenuLinks = document.querySelectorAll("#side-menu .has-submenu > a");

    submenuLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const submenu = this.nextElementSibling;

            // Cierra otros submenús si quieres solo uno abierto a la vez:
            // document.querySelectorAll("#side-menu .submenu").forEach(ul => {
            //     if (ul !== submenu) ul.classList.remove("active");
            // });

            if (submenu) {
                submenu.classList.toggle("active");
            }
        });
    });
});

function ajustarMarginArticle() {
    // Solo aplica en pantallas pequeñas
    if (window.innerWidth <= 768) {
        const header = document.querySelector('header, #main-header');
        const nav = document.querySelector('nav');
        const article = document.querySelector('article');
        const titulos = document.querySelectorAll('.titulo')
        if (header && nav && article) {
            const headerHeight = header.offsetHeight;
            const navHeight = nav.offsetHeight;
            article.style.marginTop = ((headerHeight + navHeight) - 148) + 'px';
            titulos.forEach(titulo => {
                titulo.style.scrollMarginTop = ((headerHeight + navHeight) + 10) + 'px';
            });
            // console.log("Header: "+headerHeight+"\n\nNav: "+ navHeight)
        }
    } else {
        // Restablece el margin-top en pantallas grandes
        const article = document.querySelector('article');
        if (article) article.style.marginTop = '';
        titulos.forEach(titulo => {
            titulo.style.scrollMarginTop = '';
        });
    }
}

// Ejecuta al cargar y al cambiar tamaño de ventana
window.addEventListener('DOMContentLoaded', ajustarMarginArticle);
window.addEventListener('resize', ajustarMarginArticle);