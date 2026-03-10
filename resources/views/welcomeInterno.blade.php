<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MPPPST</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="csrf-token" content="{{ csrf_token() }}">


  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">


  <link rel="stylesheet" href="{{ asset('css/estilos.css')}}">
  <link rel="stylesheet" href="{{ asset('css/estilos2.css')}}">
  <link rel="stylesheet" href="{{ asset('css/menus.css')}}">
  <link rel="stylesheet" href="{{ asset('css/alerta.css')}}">
  <link rel="stylesheet" href="{{ asset('iconos/bootstrap-icons.min.css')}}">

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

  @yield('css') {{-- **AÑADIDO: Para estilos específicos de la vista** --}}

</head>

<body>

  @include('layouts.header')

  <div class="container-body">

    <!--  <div>Ruta actual: {{ request()->path() }}</div> -->
    {{-- @if(request()->path() === 'registro') --}}

    @yield('contenido')

    {{-- @else

      @yield('ingresar')

    @endif


@endif --}}

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

  </div>

  <script src="{{ asset('js/submenus.js')}}"></script>
  <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
  <script src="{{ asset('js/mayusculas.js')}}"></script>



  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

  {{-- <script src="{{ asset('bower_components/iCheck/icheck.min.js') }}"></script> --}}


  <script src="{{ asset('js/plantilla.js') }}"></script>
  <script src="{{ asset('js/login.js') }}"></script>
  @if(request()->path() === 'inicio')
  <script src="{{ asset('js/fecha_hora.js') }}"></script>
  @endif
  <script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>


  {{-- @if(session('success'))
  <script type="text/javascript">
    Swal.fire({
      //title: 'Correcto',
      title: '{{ session('
      success ') }}',
  icon: 'success',
  confirmButtonText: 'Aceptar'
  });
  </script>
  @endif --}}


  <!-- Modal de advertencia de sesión -->
  <div class="modal fade" id="sessionWarningModal" tabindex="-1" aria-labelledby="sessionWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content fs-6">
        <div class="modal-header d-flex justify-content-center" style="background-color: rgb(70, 162, 253)">
          <h5 class="modal-title text-white" id="sessionWarningModalLabel">¡Tu sesión está por expirar!</h5>
        </div>
        <div class="modal-body text-center">
          ¿Deseas extenderla?
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button id="extendSessionBtn" type="button" class="btn btn-guardar rounded-pill">Extender sesión</button>
          <button type="button" id="closeSessionBtn" class="btn btn-limpiar rounded-pill" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const sessionLifetimeMs = 20 * 60 * 1000; // Cambia a 20 * 60 * 1000 para producción
    const warningTimeMs = 2 * 60 * 1000; // Cambia a 2 * 60 * 1000 para producción

    let warningTimeout, expireTimeout;
    let sessionModal = null;

    // Inicializa el modal de Bootstrap cuando se necesite
    function showSessionWarning() {
      if (!sessionModal) {
        sessionModal = new bootstrap.Modal(document.getElementById('sessionWarningModal'));
      }
      sessionModal.show();
    }

    // Botón para extender la sesión
    document.getElementById('extendSessionBtn').onclick = function() {
      fetch('{{ url("/keepalive") }}').then(() => {
        if (sessionModal) sessionModal.hide();
        resetSessionTimers();
      });
    };

    function resetSessionTimers() {
      clearTimeout(warningTimeout);
      clearTimeout(expireTimeout);
      warningTimeout = setTimeout(showSessionWarning, sessionLifetimeMs - warningTimeMs);
      expireTimeout = setTimeout(() => {
        window.location.href = '{{ route("ingresar") }}';
      }, sessionLifetimeMs);
    }

    // Reiniciar los timers con cualquier interacción del usuario
    ['click', 'keypress', 'mousemove', 'scroll'].forEach(evt => {
      document.addEventListener(evt, resetSessionTimers, false);
    });

    resetSessionTimers();

    document.getElementById('closeSessionBtn').onclick = function() {
      window.location.href = '{{ route("ingresar") }}';
    };
  </script>




</body>

</html>