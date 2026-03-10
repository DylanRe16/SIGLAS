<aside class="sidebar bd-sidebar">
    <header class="sidebar-header">
        <a href="{{route('inicio')}}" class="header-logo">
            <img src="{{ asset('img/logo2.png') }}" alt="CodingNepal">
            <div class="user-name">
                {{ Auth::user()->sprimer_nombre ?? 'Usuario' }} {{ Auth::user()->sprimer_apellido ?? '' }}
            </div>
        </a>
        <button class="toggler sidebar-toggler">
            <span class="material-symbols-rounded">chevron_left</span>
        </button>
        <button class="toggler menu-toggler">
            <span class="material-symbols-rounded">menu</span>
        </button>
    </header>

    <nav class="sidebar-nav">
        <ul class="nav-list primary-nav">
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('ccombatiente-index') }}" role="button">
                    <span class="nav-icon material-symbols-rounded">account_circle</span>
                    <span class="nav-label">C. COMBATIENTE</span>
                </a>
                <span class="nav-tooltip">CUERPO COMBATIENTE</span>
                <!-- <ul class="dropdown-menu dropdown-menu-dark" id="miCcombatienteMenu">
                    <li><a class="dropdown-item" href="{{ route('datoPersonal-edit') }}">Registrar</a></li>
                    <li><a class="dropdown-item" href="#">Reporte</a></li>
                    <li><a class="dropdown-item" href="#">Mantenimiento</a></li>
                    <li><a class="dropdown-item" href="#">Ayuda</a></li>
                </ul> -->
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route('cita-index') }}" class="nav-link" id="miSolicitudesToggle">
            <span class="nav-icon material-symbols-rounded">calendar_today</span>
            <span class="nav-label">SOLICITUDES</span>
            </a>
            <span class="nav-tooltip">SOLICITUDES</span>
            <ul class="dropdown-menu dropdown-menu-dark" id="miSolicitudesMenu">
                <li><a class="dropdown-item" href="{{ route('cita-index') }}">Solicitud</a></li>
                <li><a class="dropdown-item" href="{{ route('cita-show') }}">Consultas</a></li>
            </ul>
            </li> --}}

            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-rounded">account_circle</span>
                    <span class="nav-label">REPORTE</span>
                </a>
                <span class="nav-tooltip">REPORTE</span>
            </li> --}}


            <li class="nav-item">
                <a href="{{ route('almacen-inventario') }}" class="nav-link">
                    <span class="nav-icon material-symbols-rounded">account_circle</span>
                    <span class="nav-label">ALMACEN</span>
                </a>
                <span class="nav-tooltip">ALMACEN</span>
                <!--  <ul class="dropdown-menu dropdown-menu-dark" id="miSolicitudesMenu">
                    <li><a class="dropdown-item" href="{{ route('almacen-nota-entrega') }}">Nota de entrega</a></li>
                    <li><a class="dropdown-item" href="{{ route('almacen-inventario') }}">Inventario</a></li>
                </ul> -->
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link" id="miPerfilToggle">
                    <span class="nav-icon material-symbols-rounded">account_circle</span>
                    <span class="nav-label">PERFIL</span>
                </a>
                <span class="nav-tooltip">PERFIL</span>
                <ul class="dropdown-menu dropdown-menu-dark" id="miPerfilMenu">
                    <li><a class="dropdown-item" href="{{ url('contrasena-3') }}">Cambiar contraseña</a></li>
                    <li><a class="dropdown-item" href="{{ url('preguntas-seguridad') }}">Preguntas de seguridad</a></li>
                </ul>
            </li>

            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-rounded">account_circle</span>
                    <span class="nav-label">AYUDA</span>
                </a>
                <span class="nav-tooltip">AYUDA</span>
            </li> --}}
            <li class="nav-item">
                <form method="POST" action="{{ route('salir') }}">
                    @csrf
                    <button type="submit" class="nav-link">
                        <span class="nav-icon material-symbols-rounded">logout</span>
                        <span class="nav-label">CERRAR SESIÓN</span>
                    </button>
                </form>
                <span class="nav-tooltip">CERRAR SESIÓN</span>
            </li>
        </ul>
    </nav>
</aside>

<style>
    .sidebar-header {
        display: flex;
        align-items: center;
        padding: 10px;
    }

    .header-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-logo img {
        max-width: 120px;
        max-height: 60px;
        width: auto;
        height: auto;
        transition: max-width 0.3s, max-height 0.3s;
    }

    .sidebar.collapsed .header-logo img {
        max-width: 40px;
        max-height: 40px;
        display: block;
        margin: 0 auto;
    }

    .user-name {
        font-size: 16px;
        font-weight: normal;
        color: #F0F0F0;
        margin-right: 35px;
        /* Espacio entre el nombre y el botón de expansión */
        text-decoration: none;
        /* Evita subrayados */
        transition: text-shadow 0.3s ease;
        /* Transiciones suaves */
    }

    .user-name:hover {
        text-shadow: 0px 4px 6px rgba(255, 255, 255, 0.3);
        margin-right: 35px;
        /* Espacio entre el nombre y el botón de expansión */
        text-decoration: none;
        /* Evita subrayados */
        cursor: pointer;
        /* Asegura que no actúe como un enlace */
    }


    .sidebar {
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out, transform 0.3s ease-in-out;
        margin-right: 0;
    }

    .dropdown-item {
        color: #004B9D;
    }

    .dropdown-item:hover {
        background-color: #004B9D;
        color: rgb(255, 255, 255);
    }

    .dropdown-menu {
        background-color: rgb(255, 255, 255);
        opacity: 0;
        transform: translateY(10px);
        display: block;
        height: 0;
        overflow: hidden;
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out, height 0.2s ease-in-out;
        z-index: 10;
    }

    .dropdown-menu.show {
        opacity: 1;
        transform: translateY(0);
        height: auto;
    }

    .sidebar.collapsed .header-logo>div {
        display: none;
    }

    .sidebar.collapsed .dropdown-menu.show {
        position: fixed !important;
        top: auto !important;
        left: 5px !important;
        transform: translateY(0) !important;
        border: 1px solid #ccc !important;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1) !important;
        z-index: 9999 !important;
        overflow: visible !important;
    }

    .sidebar-toggler,
    .menu-toggler {
        margin-right: 10px;
    }

    .fixed-item {
        position: fixed !important;
        left: 5px !important;
        padding: 8px;
        border: 1px solid #ccc;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        background: #fff;
        z-index: 9999;
    }

    /* Estilos para los tooltips en el estado colapsado (modificados) */
    .sidebar.collapsed .nav-item {
        position: relative;
        /* Necesario para posicionar el tooltip */
    }

    .sidebar.collapsed .nav-item .nav-tooltip {
        display: none;
        /* Ocultar por defecto en el estado colapsado */
        position: absolute;
        top: 50%;
        left: 100%;
        /* Mostrar a la derecha del icono */
        transform: translateY(-50%);
        background-color: white;
        /* Fondo blanco */
        color: #004B9D;
        /* Texto azul */
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out;
        margin-left: 10px;
        /* Espacio entre el icono y el tooltip */
        border: 1px solid #ccc;
        /* Añadimos un borde sutil para mejor contraste */
    }

    .sidebar.collapsed .nav-item:hover .nav-tooltip {
        display: block;
        /* Mostrar al pasar el mouse */
        opacity: 1;
        visibility: visible;
    }

    .sidebar.collapsed .nav-item .nav-label {
        display: none;
        /* Ocultar el texto del label cuando está colapsado */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggler = document.querySelector('.sidebar-toggler');
        const collapsedClass = 'collapsed';
        const marginRightValue = '100px';

        // CUERPO COMBATIENTE
        const miCcombatienteToggle = document.getElementById('miCcombatienteToggle');
        const miCcombatienteMenu = document.getElementById('miCcombatienteMenu');
        const miCcombatienteDropdownItem = document.getElementById('miCcombatienteDropdown');

        // MI PERFIL
        const miPerfilToggle = document.getElementById('miPerfilToggle');
        const miPerfilMenu = document.getElementById('miPerfilMenu');
        const miPerfilDropdownItem = document.getElementById('miPerfilDropdown');

        // SOLICITUDES
        const miSolicitudesToggle = document.getElementById('miSolicitudesToggle');
        const miSolicitudesMenu = document.getElementById('miSolicitudesMenu');
        const miSolicitudesDropdownItem = document.getElementById('miSolicitudesDropdown');

        const dropdownMenus = document.querySelectorAll('.dropdown-menu');

        function closeAllDropdowns(exceptMenu) {
            dropdownMenus.forEach(menu => {
                if (menu !== exceptMenu && menu.classList.contains('show')) {
                    menu.classList.remove('show');
                    if (menu.parentElement.classList.contains('show')) {
                        menu.parentElement.classList.remove('show');
                    }
                }
            });
        }

        function toggleDropdownMenu(event, menu, dropdownItem) {
            event.preventDefault();
            if (menu) {
                const isOpen = menu.classList.toggle('show');
                dropdownItem.classList.toggle('show');
                if (sidebar.classList.contains(collapsedClass) && isOpen) {
                    sidebar.style.marginRight = marginRightValue;
                } else {
                    sidebar.style.marginRight = '0';
                }
                closeAllDropdowns(menu);
            }
        }

        if (sidebarToggler) {
            sidebarToggler.addEventListener('click', function() {
                sidebar.classList.toggle(collapsedClass);
                // Cierra todos los menús al colapsar/expandir
                dropdownMenus.forEach(menu => {
                    menu.classList.remove('show');
                    if (menu.parentElement.classList.contains('show')) {
                        menu.parentElement.classList.remove('show');
                    }
                });
                sidebar.style.marginRight = '0';
            });
        }

        if (miPerfilToggle) {
            miPerfilToggle.addEventListener('click', function(e) {
                toggleDropdownMenu(e, miPerfilMenu, miPerfilDropdownItem);
            });
        }

        if (miSolicitudesToggle) {
            miSolicitudesToggle.addEventListener('click', function(e) {
                toggleDropdownMenu(e, miSolicitudesMenu, miSolicitudesDropdownItem);
            });
        }

        if (miCcombatienteToggle) {
            miCcombatienteToggle.addEventListener('click', function(e) {
                toggleDropdownMenu(e, miCcombatienteMenu, miCcombatienteDropdownItem);
            });
        }

        document.addEventListener('click', function(event) {
            dropdownMenus.forEach(menu => {
                const isClickInside = event.target === menu || menu.contains(event.target) ||
                    event.target === menu.previousElementSibling ||
                    (menu.parentElement && menu.parentElement.contains(event.target));
                if (!isClickInside && menu.classList.contains('show')) {
                    menu.classList.remove('show');
                    if (menu.parentElement.classList.contains('show')) {
                        menu.parentElement.classList.remove('show');
                    }
                    if (sidebar.classList.contains(collapsedClass)) {
                        sidebar.style.marginRight = '0';
                    }
                }
            });
        });
    });
</script>