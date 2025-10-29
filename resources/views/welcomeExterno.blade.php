<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MPPPSTs</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Bootstrap 5.3.3 ACTIVO -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
  <link rel="stylesheet" href="{{ asset('css/estilos2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
  <link rel="stylesheet" href="{{ asset('css/alerta.css') }}">
  <link rel="stylesheet" href="{{ asset('iconos/bootstrap-icons.min.css')}}">
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

  <style>
    .container-body {
      min-height: 100dvh;
      display: grid;
      grid-template-rows: auto 1fr auto;
    }

    .requerido {
      color: #BF1F13;
    }

    .img-primaria {
      border-radius: 30px;
      box-shadow: 0 0 15px 5px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>

<body>
  <div id="observacion" class="fondo_alerta" style="display: none;">
    <div class="alerta">
      <h4 id="titulo" style="text-align: center;">¡Atención!</h4>
      <p id="texto"> Para cualquier información puede comunicarse con nosotros a través de: <br>
        micorreo@midominio.com <br>
        Teléfonos: (0212) 000.00.00 / 000.00.00</p>
      <div class="sep"></div>
      <center>
        <button type="button" onclick="cerrar_alert()" style="background-color: #163A7F; color: #fff; border: 1px Solid #163A7F; padding: 7px 22px; border-radius: 30px; width: auto;" onmouseout='this.style.color="#fff"; this.style.backgroundColor="#163A7F"; this.style.border="1px Solid #163A7F"' onmouseover='this.style.color="#163A7F"; this.style.backgroundColor="#fff";' data-bs-toggle="tooltip">Cerrar</button>
      </center>
      <div class="sep"></div>
    </div>
  </div>

  @include('layouts.header2')
  <div class="container-body">
    <!--  <div>Ruta actual: {{ request()->path() }}</div> -->
    @if(request()->path() === 'registro')
    @yield('registro')
    @elseif(request()->path() === 'registro/buscar')
    @yield('registro')
    @elseif(request()->path() === 'ingresar')
    @yield('ingresar')
    @elseif(request()->path() === 'registro/buscar/culminar-registro')
    @yield('culminar-registro')
    @elseif(request()->path() === 'registro/buscar/culminar-registro/registro-completado')
    @yield('culminar-registro')
    @elseif(request()->path() === 'contrasena')
    @yield('contrasena')
    @elseif(request()->path() === 'contrasena/preguntas')
    @yield('contrasena')
    @elseif(request()->path() === 'contrasena/preguntas/restablecer')
    @yield('contrasena')
    @endif
  </div>

  <footer class="text-white py-1 fs-6" style="background-color: #163A7F;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            Ministerio del Poder Popular para el Trabajo
            Oficina de Tecnología de la Información y la Comunicación - División Análisis y Desarrollo de Sistemas
            <br>
            &copy; <?php echo date('Y'); ?> Todos los Derechos Reservados
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- JS -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="{{ asset('js/submenus.js') }}"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/plantilla.js') }}"></script>
  <script src="{{ asset('js/login.js') }}"></script>
  <script src="{{ asset ('js/mayusculas.js')}}"></script>
  <script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>

  {{-- @if(session('success'))
  <script type="text/javascript">
    Swal.fire({
      title: '{{ session('
      success ') }}',
  icon: 'success',
  confirmButtonText: 'Aceptar'
  });
  </script>
  @endif --}}

</body>

</html>