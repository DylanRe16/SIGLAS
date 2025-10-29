
<header style="header" style="margin-bottom:-15px">
    <nav class="navbar" style="background-color:rgb(255, 255, 255);">
        <div class="container-fluid ">
            <div class="logo">
                <img src="{{ url('img/cintillo_institucional.jpg')}}">
            </div>
           <!--  <h2 tabindex="16" class="type-titulo" style="margin-top:10px"></h2> -->
        </div>
    </nav>
</header>
@if(session('session_warning'))
    <script>
        let extendSession = confirm("Tu sesión está a punto de expirar. ¿Deseas extenderla?");
        if (extendSession) {
            fetch('{{ route("extend-session") }}'); 
        } else {
            alert("Sesión expirada. Serás redirigido a ingresar.");
            window.location.href = "{{ route('ingresar') }}";
        }
    </script>
@endif