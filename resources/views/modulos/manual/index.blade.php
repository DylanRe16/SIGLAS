<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Manual de Usuario Sistema Gestión de Solicitudes</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<meta name="csrf-token" content="KGRJ5g3lnDAHOoYww4wpj9PWFs2pdzFj04SEWaJS">


<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<link rel="stylesheet" href="{{asset("css/estilos.css")}}">
<link rel="stylesheet" href="{{asset("css/estilos2.css")}}">
<link rel="stylesheet" href="{{asset("css/estilos_manual.css")}}">

</head>

<body>

  
  <main class="container-body">

    <!--ENCABEZADO-->

    <header id="main-header" style="margin-bottom:5px; background-color: #fff; height: 70px;">
      <div style="display: flex; align-items: center; justify-content: space-between;">

        <!--LOGO MPPPST-->
        <div class="logo">
          <img style="vertical-align: baseline;" src="{{ asset('img/manual/encabezado.png') }}" alt="encabezado">
        </div>

        <!--TITULO MANUAL DE USUARIO-->

        <h4 style="margin-right: 70px; color: #004B9D;">Manual de Usuario</h4>
      </div>
    </header>
    

    <!--MENU VERTICAL -->
    <nav id="side-menu">
      <h4 style="color: #fff;" class="text-center">Tabla de Contenido</h4>
      <ul class="opciones">
          <li>
            <a href="#objetivo_sistema">Objetivo del Sistema</a>
          </li>

          <li>
            <a href="#inicia_sesion">Inicia tu Sesión</a>
          </li>

          <li>
            <a href="#registrate">Regístrate</a>
          </li>

          <li>
            <a href="#olvidaste_contrasena">Olvidaste tu contraseña</a>
          </li>

          <li>
            <a href="#contactanos">Contáctanos</a>
          </li>
          
          <li class="has-submenu">
              <a href="#personas" class="menu-link">MI PERFIL
                  <span class="submenu-arrow">▼</span>
              </a>
              <ul class="submenu">
                  <li><a href="#datos_personales">Datos Personales</a></li>
                  <li><a href="#cambiar_contrasena">Cambiar contraseña</a></li>
                  <li><a href="#preguntas_seguridad">Preguntas de seguridad</a></li>
              </ul>
          </li>

          <li class="has-submenu">
              <a href="#solicitudes" class="menu-link">SOLICITUDES
                  <span class="submenu-arrow">▼</span>
              </a>
              <ul class="submenu">
                  <li><a href="#cita">Cita</a></li>
                  <li><a href="#consulta">Consultas</a></li>
              </ul>
            </li>

          <li>
            <a href="{{ route('inicio') }}">Regresar al sistema</a>
          </li>          
      </ul>
    </nav>

  <!--CONTENIDO-->

  <article class="card d-flex justify-content-center">
    <!--TITULO DEL SISTEMA-->

    <h1 style="text-align: center;">Sistema Gestión de Solicitudes</h1>

    <!--OBJETIVO DEL SISTEMA-->

    <h3 class="titulo" id="objetivo_sistema" style="margin-top: 30px;">Objetivo del Sistema</h3>
    <br>

    <div>
      <p>
        El Sistema Gestión de Solicitudes, tiene como función permitirle al trabajador(a) 
        solicitar una cita programada de atención a la Inspectoría del Trabajo, más cercana a su 
        Entidad de Trabajo. 
      </p>
    </div>
    <br>

    <!--INICIA TU SESION-->

    <h3 class="titulo" id="inicia_sesion" style="margin-top: 30px;"> Inicia tu sesión </h3>
    <br>
    <div>
      <p>
        Para ingresar al Sistema de Gestión de Solicitudes, escriba en el explorador, 
        preferiblemente Google Chrome, el siguiente enlace: https://www.mpppst.gob.ve/mpppstweb/ 
        visualizará la página web del Ministerio del Poder Popular para el Proceso Social de Trabajo 
        (MPPPST). Haga clic en el menú Solicitudes en Línea, opción Ciudadanos, Sistema Gestión de 
        Solicitudes. Una vez en el sistema seleccione de la lista desplegable la nacionalidad, 
        ingrese el número del documento de identidad, contraseña y haga clic en el botón Iniciar. 
        Debe suministrar todos los datos en los campos que estén habilitados y requeridos, los cuales 
        se denotan con un asterisco (*).
        </p>
    </div>
    <br>

    <div>
      <img class="img img-fluid" src="{{asset('img/manual/pantalla_inicia_sesion.png')}}" alt="pantalla_inicia_sesion.png">
    </div>
    <br>

    <!--REGISTRATE-->

    <h3 class="titulo" id="registrate" style="margin-top: 30px;"> Regístrate </h3>
    <br>
    <div>
      <p>
        1. Haga clic en el botón Regístrate. Seleccione de la lista desplegable la nacionalidad, 
        luego ingrese el número de documento de identidad y haga clic en el botón Buscar. Debe suministrar 
        todos los datos en los campos que estén habilitados y requeridos, los cuales se denotan con un 
        asterisco (*).
      </p>
    </div>
    <br>
                
    <div>
      <img class="img" src="{{asset('img/manual/pantalla_inicio_registrate.png')}}" alt="pantalla_inicio_registrate.png">
    </div>
    <br>

    <div>
      <p>
          2. Se mostrará en pantalla Apellido(s) y Nombre(s), fecha de nacimiento, del documento de 
          identidad consultado, deberá crear una contraseña cumplimiento con los parámetros requeridos y 
          confirmar la misma. De lo contrario debe realizar el registro completo de sus datos. 
          Haga clic en el botón Registrarse. 
      </p>
    </div>
    <br>
                
    <div>
    <img class="img" src="{{asset('img/manual/pantalla_inicio_registrate_completo.png')}}" alt="pantalla_inicio_registrate_completo.png">
    </div>
    <br>

    <div>
      <p>
        3. El sistema mostrará la siguiente pantalla con dos (02) sesiones Datos Personales y Preguntas de seguridad. 
      </p>
    </div>
    <br>


    <div>
      <p>
        Datos Personales: Complete la información requerida, ingrese correo electrónico personal, 
        con ayuda de las listas de selección responda las siguientes preguntas ¿Está embarazada?, 
        ¿Tiene discapacidad? Si su respuesta es afirmativa, debe responder las preguntas ¿Tipo de 
        discapacidad? Especificar el tipo de discapacidad. ¿Tiene Certificado CONAPDIS? 
        Si su respuesta es afirmativa, indique el número de certificado, ingrese número de Teléfono 
        personal, número de Teléfono local, debe suministrar todos los datos en los campos que 
        estén habilitados y requeridos, los cuales se denotan con un asterisco (*). 
      </p>
    </div>
    <br>
                
    <div>
      <img class="img" src="{{asset('img/manual/pantalla_registrate.png')}}" alt="pantalla_registrate">
    </div>
    <br>

    <div>
      <p>
      Preguntas de seguridad: Con ayuda de las listas de selección, debe seleccionar tres (03) 
      preguntas de seguridad configuradas por defecto en el sistema, al lado derecho debe ingresar 
      sus respuestas personalizadas. Una vez finalizado el proceso, haga clic en el botón Guardar. 
      Debe suministrar todos los datos en los campos que estén habilitados y requeridos, los cuales 
      se denotan con un (*). Haga clic en el botón Guardar.
      </p>
    </div>
    <br>
                
    <div>
        <img class="img" src="{{asset('img/manual/pantalla_registrar_preguntas_seguridad.png')}}" alt="registrar_preguntas_seguridad.png">
    </div>
    <br>

    <!--OLVIDASTE TU CONTRASEÑA-->

    <h3 class="titulo" id="olvidaste_contrasena" style="margin-top: 30px;"> ¿Olvidaste tu contraseña? </h3>

    <div>
        <p>
          1. Haga clic en ¿Olvidaste tu contraseña?
        </p>
    </div>
    <br>


    <div>
      <img class="img" src="{{asset('img/manual/pantalla_inicia_sesion.png')}}" alt="pantalla_inicia_sesion.png">
    </div>
    <br>

    <div>
        <p>
            2.	Se mostrará la pantalla Verifica tu identidad, seleccione de la lista desplegable 
                la nacionalidad, luego ingrese el número de documento y haga clic en el botón Verificar. 
                Debe suministrar todos los datos en los campos que estén habilitados y requeridos, los 
                cuales se denotan con un asterisco (*).
        </p>
    </div>
    <br>
                
    <div>
        <img class="img" src="{{asset("img/manual/pantalla_verifica_identidad.png")}}" alt="pantalla_verifica_identidad.png">
    </div>
    <br>

    <div>
        <p>
            3.	Luego de verificar la identidad, en la pantalla Cambia tu contraseña, aparecerá 
                Nombre(s) y Apellido(s), ingrese la respuesta a (02) dos preguntas de seguridad, debe 
                suministrar todos los datos en los campos que estén habilitados y requeridos, los cuales 
                se denotan con un (*). Haga clic en el botón Siguiente.
        </p>
    </div>
    <br>
                
    <div>
        <img class="img" src="{{asset("img/manual/pantalla_cambia_contrasena.png")}}" alt="pantalla_cambia_contrasena.png">
    </div>
    <br>

    <br>
    <div>
        <p>
          4.	Ingrese una nueva contraseña cumpliendo con las características requeridas. 
              Haga clic en el botón Restablecer. Debe suministrar todos los datos en los campos que 
              estén habilitados y requeridos, los cuales se denotan con un asterisco (*).
        </p>
    </div>
    <br>
                
    <div>
      <img class="img" src="{{asset("img/manual/pantalla_cambia_contrasena_restablecer.png")}}" alt="pantalla_cambia_contrasena_restablecer.png">
    </div>
    <br>

    <div>
      <p>
          5.	Aparecerá una alerta con el siguiente mensaje “Contraseña restablecida exitosamente”. 
      </p>
    </div>
    <br>
                
    <div>
      <img class="img" src="{{asset("img/manual/alerta_contrasena_restablecida_exitosamente.png")}}" alt="alerta_contrasena_restablecida_exitosamente.png">
    </div>
    <br>


    <!--CONTÁCTANOS-->

    <h3 class="titulo" id="contactanos" style="margin-top: 30px;"> Contáctanos </h3>

    <div>
      <p>
        1.	En la pantalla principal, haga clic en Contáctanos.
      </p>
    </div>
    <br>
                
    <div>
      <img class="img" src="{{asset("img/manual/pantalla_inicia_sesion.png")}}" alt="pantalla_inicia_sesion.png">
    </div>
    <br>

    <div>
      <p>
        2.	Se visualizará una alerta con información de Contáctanos. Haga clic en el botón Cerrar, para salir de 
        la ventana emergente. 
      </p>
    </div>
    <br>
                
    <div>
      <img class="img" src="{{asset("img/manual/pantalla_contactanos.png")}}" alt="pantalla_contactanos.png">
    </div>
    <br>

    <!--MI PERFIL-->

    <h3 class="titulo" id="mi_perfil" style="margin-top: 30px;">MI PERFIL</h3>

    <!--MI PERFIL / OPCIÓN DATOS PERSONALES-->

    <h3 class="titulo" id="datos_personales" style="margin-top: 30px;">Datos Personales</h3>

    <div>
      <p>
        1.	Haga clic en el menú desplegable MI PERFIL, opción Datos Personales.
      </p>
    </div>
    <br>

    <div>
      <img class="img" src="{{asset("img/manual/miperfil_datos_personales.png")}}" alt="miperfil_datos_personales.png">
    </div>
    <br>

    <div>
      <p>
        2.	El sistema mostrará sus Datos Personales, si lo requiere puede actualizar la información. 
        Debe responder con ayuda de las listas de selección las siguientes preguntas ¿Está embarazada?, 
        ¿Tiene discapacidad? Si su respuesta es afirmativa, debe responder las preguntas 
        ¿Tipo de discapacidad? Especificar el tipo de discapacidad. ¿Tiene Certificado CONAPDIS? 
        Si su respuesta es afirmativa, indique el número de certificado, debe suministrar todos los 
        datos en los campos que estén habilitados y requeridos, los cuales se denotan con un (*).  
        Haga clic en el botón Guardar.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/pantalla_datos_personales.png")}}" alt="pantalla_datos_personales.png">
    </div>
    <br>

    <div>
      <p>
        3.	Aparecerá una alerta con el siguiente mensaje “Datos actualizados correctamente”. 
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/alerta_datos_personales_correctos.png")}}" alt="alerta_datos_personales_correctos.png">
    </div>

    <!--MI PERFIL / OPCIÓN CAMBIAR CONTRASEÑA-->

    <h3 class="titulo" id="cambiar_contrasena" style="margin-top: 30px;">Cambiar contraseña</h3>
    <br>

    <div>
    <p>
      Haga clic en el menú desplegable MI PERFIL, opción Cambiar contraseña
    </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/miperfil_cambiar_contrasena.png")}}" alt="miperfil_cambiar_contrasena.png">
    </div>
    <br>

    <div>
      <p>
        2.	El sistema mostrará la siguiente pantalla, si lo requiere puede actualizar la información,
        y cambiar su contraseña, asegúrese de que cumpla con las características requeridas y confirme la misma, 
        luego haga clic en el botón Guardar.
      </p>
    </div>

    <div>
    <img class="img" src="{{asset("img/manual/pantalla_perfil_cambiacontrasena.png")}}" alt="pantalla_perfil_cambiacontrasena.png">
    </div>
    <br>

    <div>
      <p>
        3.	Aparecerá una alerta con el siguiente mensaje “Contraseña actualizada exitosamente”. 
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/alerta_contrasena_actualizada.png")}}" alt="alerta_contrasena_actualizada.png">
    </div>
    <br>

    <!--MI PERFIL / OPCIÓN PREGUNTAS DE SEGURIDAD-->

    <h3 class="titulo" id="preguntas_seguridad" style="margin-top: 30px;"> Preguntas de seguridad </h3>

    <div>
    <p>
        1.	Haga clic en el menú desplegable MI PERFIL, opción Preguntas de seguridad. 
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/miperfil_preguntas_seguridad.png")}}" alt="miperfil_preguntas_seguridad.png">
    </div>
    <br>

    <div>
      <p>
        2.	El sistema mostrará la siguiente pantalla, con las preguntas y respuestas registradas 
            previamente en el sistema.  Si lo requiere actualice la información y haga clic en el botón Guardar. 
            Debe suministrar todos los datos en los campos que estén habilitados y requeridos, los cuales se denotan 
            con un (*). Haga clic en el botón Guardar.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/pantalla_actualizar_preguntas_seguridad.png")}}" alt="pantalla_actualizar_preguntas_seguridad.png">
    </div>
    <br>
                
    <div>
      <p>
        3.	Aparecerá una alerta con el siguiente mensaje “Preguntas de seguridad actualizadas exitosamente”.    
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/alerta_preguntas_respuestas_actualizadas.png")}}" alt="alerta_preguntas_respuestas_actualizadas.png">
    </div>
    <br>

    <!--SOLICITUDES-->

    <h3 class="titulo" id="solicitudes" style="margin-top: 30px;"> SOLICITUDES </h3>

    <!--SOLICITUDES / OPCION CITA-->

    <h3 class="titulo" id="cita" style="margin-top: 30px;"> Cita </h3>

    <div>
      <p>
        1.	Haga clic en el menú desplegable SOLICITUDES, opción Cita.    
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/solicitudes_cita.png")}}" alt="solicitudes_cita.png">
    </div>
    <br>

    <div>
      <p>
          2.	Para generar una cita, si conoce el Número de Registro de Información Fiscal (RIF) de la Entidad de Trabajo, 
              ingrese la información, seguidamente haga clic en el botón Buscar. De lo contrario haga clic en el 
              enlace que aparece en pantalla. 
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/pantalla_solicitudes_cita.png")}}" alt="pantalla_solicitudes_cita.png">
    </div>
    <br>

    <div>
      <p>
          3.	El sistema mostrará la siguiente pantalla con dos (02) sesiones. 
          <br>
          Datos de la Entidad de Trabajo: Ingrese la información de la Entidad de Trabajo. Debe suministrar 
          todos los datos en los campos que estén habilitados y requeridos, los cuales se denotan con un (*). 
          <br>
          Trámite: Ingrese la información del Trámite. Debe suministrar todos los datos en los campos que estén 
          habilitados y requeridos, los cuales se denotan con un (*). Haga clic en el botón Guardar.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/pantalla_guardar_cita.png")}}" alt="pantalla_guardar_cita.png">
    </div>
    <br>

    <div>
      <p>
          4.	El sistema mostrará en pantalla una ventana emergente con la cita creada exitosamente. 
              Haga clic en el botón Imprimir.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/modal_cita_generada_con_exito.png")}}" alt="modal_cita_generada_con_exito.png">
    </div>
    <br>        

    <div>
      <p>
        5.	Se descargará un archivo formato Portable Document Format (PDF), donde especifica todos los datos de la cita.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/PDF_cita.png")}}" alt="PDF_cita.png">
    </div>
    <br> 

    <!--SOLICITUDES / OPCION CONSULTAS-->

    <h3 class="titulo" id="consulta" style="margin-top: 30px;"> Consultas </h3>

    <div>
      <p>
        Haga clic en el menú desplegable SOLICITUDES, opción Consultas. 
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/solicitudes_consultas.png")}}" alt="solicitudes_consultas.png">
    </div>
    <br> 

    <div>
      <p>
        En pantalla se mostrará la consulta de las citas. Para ver el detalle haga clic en el botón Ver.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/Vista_consultas.png")}}" alt="Vista_consultas.png">
    </div>
    <br> 

    <div>
      <p>
      En pantalla se mostrará el detalle de la cita. Haga clic en el botón Ver requisitos
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/pantalla_consultas_opcion_ver.png")}}" alt="pantalla_consultas_opcion_ver.png">
    </div>
    <br> 

    <div>
      <p>
        En pantalla se mostrará el detalle de la cita. Haga clic en el botón Ver requisitos
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/modal_requisitos_consignar_cita.png")}}" alt="modal_requisitos_consignar_cita.png">
    </div>
    <br> 

    <div>
      <p>
          Haga clic en el botón de imprimir; visualizará la cita generada en formato Portable Document Format (PDF), 
          que contiene la información de la cita y los requisitos que debe presentar el día señalado para la atención en 
          la Inspectoría del Trabajo más cercana a su Entidad de Trabajo. Falta capturar imagen.
      </p>
    </div>

    <div>
      <img class="img" src="{{asset("img/manual/PDF_cita.png")}}" alt="PDF_cita.png">
    </div>
    <br> 

       
  </article>

  <footer class="text-center fs-6">
        Centro Simón Bolivar. Torre Sur. Caracas, Distrito Capital. Ministerio del Poder Popular para el Proceso Social de Trabajo<br>
        Oficina de Tecnología de la Información y la Comunicación - División Análisis y Desarrollo de Sistemas<br>
        &copy; <?php echo date('Y'); ?> Todos los Derechos Reservados
  </footer>

  <!-- Botón para ir al inicio -->
  <button id="scrollToTopBtn" style="display:none;position:fixed;bottom:20px;right:20px;">↑</button>



</main>

<script>
// Mostrar el botón cuando el usuario baja 100px o más
window.onscroll = function() {
  var btn = document.getElementById("scrollToTopBtn");
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
};

// Al hacer clic, volver arriba suavemente
document.getElementById("scrollToTopBtn").onclick = function() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<!--  <img src="img/" width="px" heigth="px"/> para la imagen de fondo-->
<script src="{{asset("js/funciones_manual.js")}}"></script>
</body>
</html>