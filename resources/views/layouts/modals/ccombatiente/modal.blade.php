<!-- MODAL DE AYUDA -->
<!-- BUSCAR USUARIO -->
<div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="height: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ayuda</h1> <!--TITULO DE LA PANTALLA EMERGENTE-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--CONTENIDO DE LA PANTALLA EMERGENTE-->
            <div class="modal-body">

                <p>
                    Permite registrar los Datos Básicos del trabajador(a) que desee ser parte
                    del equipo Cuerpo Combatiente “Argimiro Gabaldón”. Además de su Dirección de habitación,
                    Datos de la Comuna al cual pertenece, Datos Adicionales, y los Datos Laborales.
                    Recuerde completar todos los campos obligatorios, identificados con un asterisco (*).
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
<!-- DATOS BASICOS -->
<div class="modal fade" id="modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ayuda</h1> <!--TITULO DE LA PANTALLA EMERGENTE-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--CONTENIDO DE LA PANTALLA EMERGENTE-->
            <div class="modal-body" style="text-align: justify;">
                <h5 class="card-title" id="titulo1"> Datos Básicos </h5> <br>

                <p>
                    Visualizara <b>Primer nombre</b>, <b>Segundo nombre</b>, <b>Primer apellido</b>, <b>Segundo apellido</b>, <b>Fecha de nacimiento</b>,<b> Edad</b>,<b> Sexo</b>, <b>Correo electrónico</b>
                    y debe seleccionar de la lista desplegable <b>Estado Civil</b>, código de área e ingresar el número de <b>Teléfono personal</b> y de <b>habitación</b>. <br>
                </p>

                <div class="text-center">
                    <img src="{{ asset('img/ccombatiente/imagenes/CCDatosBasicos.png') }}" class="img-fluid" alt="Descripción de la imagen">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- DATOS HABITACION -->
<div class="modal fade" id="modal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ayuda</h1> <!--TITULO DE LA PANTALLA EMERGENTE-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--CONTENIDO DE LA PANTALLA EMERGENTE-->
            <div class="modal-body" style="text-align: justify;">

                <h5 class="card-title" id="titulo1"> Datos de la Dirección de Habitación </h5> <br>

                <p>
                    Debe seleccionar de la lista desplegable <b>Estado</b>,<b> Municipio</b>, <b>Parroquia</b>,
                    e ingresar <b>Dirección y Punto de referencia</b>. Seguidamente, seleccione de la lista desplegable la
                    <b>Comuna o Circuito Comunal.</b>
                </p>

                <div class="text-center">
                    <img src="{{ asset('img/ccombatiente/imagenes/CCDatosdelaDirecciondeHabitacion.png') }}" class="img-fluid" alt="Descripción de la imagen">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- DATOS ADICIONALES -->
<div class="modal fade" id="modal5" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ayuda</h1> <!--TITULO DE LA PANTALLA EMERGENTE-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--CONTENIDO DE LA PANTALLA EMERGENTE-->
            <div class="modal-body" style="text-align: justify;">
                <h5 class="card-title" id="titulo1"> Datos Adicionales </h5> <br>

                <p>
                    Seleccione de las listas desplegables <b>¿Tiene discapacidad?</b>, <b>Lateralidad</b>, <b>Tipo de Sangre</b>,
                    <b>Talla de Camisa</b>, <b>Talla de Zapato</b>, <b>Talla de Pantalón</b>, <b>Inscripción militar</b>,
                    <b> Se registró como miliciano</b>,<b> ¿Prestaste servicio militar?</b>, <b>¿Tiene hijos?</b>,
                    e ingresar <b>Nro. Inscripcion Militar</b>, <b>Rango</b> y <b>¿Cuánto menores de 18 años?</b>.
                    <br>
                </p>

                <div class="text-center">
                    <img src="{{ asset('img/ccombatiente/imagenes/CCDatosAdicionales.png') }}" class="img-fluid" alt="Descripción de la imagen">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
<!-- DATOS LABORALES -->
<div class="modal fade" id="modal6" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ayuda</h1> <!--TITULO DE LA PANTALLA EMERGENTE-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!--CONTENIDO DE LA PANTALLA EMERGENTE-->
            <div class="modal-body" style="text-align: justify;">
                <h5 class="card-title" id="titulo1"> Datos Laborales</h5> <br>

                <p>
                    En esta sección podrá visualizar la <b>Ubicación administrativa de adscripción</b>,
                    <b>Ubicación física</b>, <b>Cargo o puesto de trabajo titular</b>, <b>Ente de Procedencia</b>
                    debe ingresar <b>Estado</b>, <b>Cargo o puesto de trabajo que ejerce</b> y <b>Tipo de trabajador</b>,
                    luego haga clic en el botón <b>Guardar</b>.<br>
                </p>

                <div class="text-center">
                    <img src="{{ asset('img/ccombatiente/imagenes/CCDatosLaborales.png') }}" class="img-fluid" alt="Descripción de la imagen">
                </div>
                <br>
                <p>
                    Luego el módulo mostrará la siguiente alerta "¡Se ha registrado exitosamente!", haga clic en el botón <b>Cerrar</b>.
                </p>

                <div class="text-center">
                    <img src="{{ asset('img/ccombatiente/imagenes/CCDatosLaboralesAlerta.png') }}" class="img-fluid" alt="Descripción de la imagen">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>