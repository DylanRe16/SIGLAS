@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Formatos')
@section('body_class', 'page-Formatos')

@section('content')
<main class="p-4">
    @include('layouts.modals.formatos.modal_vacaciones')
    <form action="{{ route('formatos-solicitud-vacaciones-generarpdf') }}" method="post" id="form-pdf" >
    <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <div class="link-secondary">
                    <h4 class="font-weight-bold">
                        <a href="{{ route('formatos') }}" class="link-secondary text-decoration-none">
                        Formato
                        </a>
                        > Solicitud de Vacaciones</h4>
                </div>
                <div class="text-danger fs-6 fw-normal">Campos obligatorios (*)</div>
            </div>
    </div>

      <div id="alert-container"></div>

    <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos del Funcionario</h3>
                <div class="card-tools">
                   <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
            </button><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                </div>
            </div>


            <div class="card-body">

                {{-- @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif --}}
                @csrf

                {{-- <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="link-secondary ">Nombre(s) y Apellido(s)</label>
                            <input type="text" name="nombres_apellidos" id="nombres_apellidos" class="form-control form-control-ovalado" disabled>
                            </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="link-secondary ">Nro.Documento</label>
                            <input type="text" name="documento" id="documento" class="form-control form-control-ovalado" disabled>
                            </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="link-secondary ">Código de Nómina</label>
                            <input type="text" name="codigo_nomina" id="codigo_nomina" class="form-control form-control-ovalado" disabled>
                            </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="link-secondary ">Correo Electrónico<span class="text-danger">*</span></label>
                            <input type="text" name="correo_electronico" id="correo_electronico" class="form-control form-control-ovalado" placeholder="Ingrese...">
                            </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="link-secondary ">Cargo o Puesto de Trabajo Titular <span class="text-danger">*</span></label>
                                <input type="text" name="cargo_puesto_trabajo" id="cargo_puesto_trabajo" class="form-control form-control-ovalado" placeholder="Ingrese...">
                                </div>
                        </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="link-secondary ">Ubicación Administrativa</label>
                                    <input type="text" name="ubicacion_administrativa" id="ubicacion_administrativa" class="form-control form-control-ovalado" disabled>
                                    </div>
                            </div>


                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="link-secondary ">Fecha de Ingreso al Ministerio</label>
                                    <input type="text" name="fecha_ingreso_ministerio" id="fecha_ingreso_ministerio" class="form-control form-control-ovalado" disabled>
                                    </div>
                            </div>


                        </div> --}}




                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label class="link-secondary ">Correo Electrónico<span class="text-danger">*</span></label>
                                <input type="text" name="correo_electronico" id="correo_electronico" class="form-control form-control-ovalado" placeholder="Ingrese...">
                                @error('correo_electronico')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div> --}}
                        {{--
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="link-secondary ">Total de Años en la APN</label>
                                    <input type="text" name="total_años_apn" id="total_años_apn" class="form-control form-control-ovalado" disabled>
                                </div>
                            </div>  --}}


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="link-secondary ">Años de Servicio en la APN<span class="text-danger">*</span></label>
                                            <input type="text" name="años_servicio_apn" id="años_servicio_apn" class="form-control form-control-ovalado" value="{{ old('años_servicio_apn') }}" placeholder="Ingrese...">
                                            @error('años_servicio_apn')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="link-secondary ">Años en la Institución</label>
                                                <input type="text" name="años" id="años" class="form-control form-control-ovalado" value="{{ $años_servicio }}" disabled>
                                                </div>
                                        </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="link-secondary ">Lapso Vacacional Solicitado<span class="text-danger">*</span></label>
                                                            <input type="text" name="lapso_vacacional_solicitado"
                                                            id="lapso_vacacional_solicitado"
                                                            class="form-control form-control-ovalado"
                                                            value="{{ old('lapso_vacacional_solicitado') }}" placeholder="Ej: 2026/2027, 2027/2028">
                                                        @error('lapso_vacacional_solicitado')
                                                            <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="link-secondary ">Fecha Deseada<span class="text-danger">*</span></label>
                                                            <input type="date" name="fecha_deseada" id="fecha_deseada"
                                                            class="form-control form-control-ovalado"
                                                            onkeypress="return false;"
                                                            onkeydown="return false;"
                                                            onclick="this.showPicker();"
                                                            {{-- Genera 2024-01-01 (dependiendo del año actual) --}}
                                                            min="{{ date('Y') }}-01-01"
                                                            value="{{ old('fecha_deseada') }}" placeholder="Ingrese...">
                                                            @error('fecha_deseada')
                                                            <small class="text-danger">{{$message}}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="link-secondary ">Jefe(a)/Supervisor(a) Inmediato (Nombre y Apellido)<span class="text-danger">*</span></label>
                                            <input type="text"
                                             name="jefe_supervisor_inmediato"
                                              id="jefe_supervisor_inmediato"
                                               maxlength="45"
                                               class="form-control form-control-ovalado"
                                               value="{{ old('jefe_supervisor_inmediato') }}"
                                                placeholder="Ingrese...">
                                            @error('jefe_supervisor_inmediato')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="link-secondary ">Director(a) (Nombre y Apellido)<span class="text-danger">*</span></label>
                                            <input type="text"
                                             name="director1"
                                              id="director1"
                                               maxlength="45"
                                               class="form-control form-control-ovalado"
                                               value="{{ old('director1') }}"
                                                placeholder="Ingrese...">
                                            @error('director1')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div> --}}


                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary mt-3" type="submit">Imprimir</button>
                                    </div>

                        </div>

            {{-- </div> --}}
    </div>
</div>
</form>
<script>
     function MayusculasAutomatico() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="search"], textarea');

    inputs.forEach(input => {
      input.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
      });
    });
  }
  // Llama a la función cuando el DOM esté completamente cargado
  document.addEventListener('DOMContentLoaded', MayusculasAutomatico);

document.getElementById('lapso_input').addEventListener('input', function (e) {
    let cursorPosition = this.selectionStart;
    let value = this.value;

    // 1. Solo permite números, barra, coma y espacio
    let cleanedValue = value.replace(/[^0-9/ ,]/g, '');

    // 2. Evita caracteres repetidos seguidos (ej: // o ,,)
    cleanedValue = cleanedValue.replace(/[/]{2,}/g, '/');
    cleanedValue = cleanedValue.replace(/[,]{2,}/g, ',');

    this.value = cleanedValue;
});
</script>

{{-- SCRIPT DE ENVÍO Y VALIDACIÓN --}}
<script>
document.getElementById('form-pdf').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const alertContainer = document.getElementById('alert-container');

    // 1. LIMPIEZA PREVIA:
    // Remover mensajes de error anteriores (JS y Blade)
    document.querySelectorAll('.error-msg').forEach(el => el.remove());
    // Remover clase de error en los inputs
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    // Limpiar alerta superior
    if(alertContainer) alertContainer.innerHTML = '';

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(async response => {

        // ❌ ERROR DE VALIDACIÓN (422)
        if (response.status === 422) {
            const data = await response.json();
            let errorsHtml = '';

            Object.keys(data.errors).forEach(field => {
                const messages = data.errors[field];
                const input = form.querySelector(`[name="${field}"]`);

                if (input) {
                    // A) Marcar el input en rojo
                    //input.classList.add('is-invalid');

                    // B) Crear mensaje debajo del input
                    const errorElement = document.createElement('small');
                    errorElement.classList.add('text-danger', 'error-msg', 'd-block', 'mt-1');
                    errorElement.innerHTML = `${messages[0]}`;

                    // C) Insertar justo después del input (funciona mejor que appendChild para fechas)
                    input.insertAdjacentElement('afterend', errorElement);
                }

                // Acumular para alerta superior (opcional)
                messages.forEach(msg => {
                    errorsHtml += `<li>${msg}</li>`;
                });
            });

            // Si quieres mantener la alerta superior también:
            if(alertContainer) {
                 alertContainer.innerHTML = `
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0 pl-3">${errorsHtml}</ul>
                    </div>
                `;
                // Scroll suave hacia el primer error
                const firstError = document.querySelector('.is-invalid');
                if(firstError) firstError.scrollIntoView({behavior: 'smooth', block: 'center'});
            }

            return;
        }

        // ✅ ÉXITO
        if (response.ok) {
            const blob = await response.blob();
            const url = URL.createObjectURL(blob);
            window.open(url, '_blank');
        } else {
             alert('Ocurrió un error inesperado en el servidor.');
        }
    })
    .catch((error) => {
        console.error(error);
        alert('Error de conexión.');
    });
});
</script>
</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection


