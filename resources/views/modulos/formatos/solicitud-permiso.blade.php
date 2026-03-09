@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Formatos')
@section('body_class', 'page-Formatos')

@section('content')
<main class="p-4">
     @include('layouts.modals.formatos.modal_permiso')
    <form action="{{ route('formatos-solicitud-permiso-generarpdf') }}" method="post" id="form-pdf">
    <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <div class="link-secondary">
                    <h4 class="font-weight-bold">
                        <a href="{{ route('formatos') }}" class="link-secondary text-decoration-none">
                        Formato
                        </a>
                        > Solicitud de Permiso</h4>
                </div>
                <div class="text-danger fs-6 fw-normal">Campos obligatorios (*)</div>
            </div>
    </div>

    {{-- Contenedor para Alerta General (opcional, si quieres resumen arriba) --}}
    <div id="alert-container"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Especificaciones del Permiso</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
            </button> <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
        </div>

        <div class="card-body">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="link-secondary ">Motivo<span class="text-danger">*</span></label>
                        <textarea name="motivo" id="motivo" maxlength="100" class="form-control " placeholder="Ingrese...">{{ old('motivo') }}</textarea>
                        {{-- Placeholder para error de PHP --}}
                        @error('motivo')
                            <small class="text-danger error-msg">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="link-secondary">Fecha de Solicitud</label>
                        <div class="sep"></div>
                        
                        <div class="d-flex gap-3 w-100">
                            <div class="box flex-fill link-secondary">
                                <label for="fecha_inicio">Inicio<span class="text-danger">*</span></label>
                                <input type="date" class="form-control " name="fecha_inicio" id="fecha_inicio"
                                onkeypress="return false;" onkeydown="return false;" onclick="this.showPicker();"
                                min="{{ date('Y') }}-01-01" value="{{ old('fecha_inicio') }}">
                                @error('fecha_inicio')
                                    <small class="text-danger error-msg">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="box flex-fill link-secondary">
                                <label for="fecha_final">Fin<span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('fecha_final') is-invalid @enderror" id="fecha_final" name="fecha_final"
                                onkeypress="return false;" onkeydown="return false;" onclick="this.showPicker();"
                                min="{{ date('Y') }}-01-01" value="{{ old('fecha_final') }}">
                                @error('fecha_final')
                                    <small class="text-danger error-msg">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="box flex-fill link-secondary">
                                <label for="duracion">Duración</label>
                                <input type="text" class="form-control" name="duracion" id="duracion" readonly style="background-color: #e9ecef;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="link-secondary ">Soporte Legal<span class="text-danger">*</span></label>
                        <textarea name="soporte_legal" id="soporte_legal" maxlength="200" class="form-control @error('soporte_legal') is-invalid @enderror" placeholder="Ingrese...">{{ old('soporte_legal') }}</textarea>
                        @error('soporte_legal')
                            <small class="text-danger error-msg">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="link-secondary ">Jefe(a)/Supervisor(a) Inmediato (Nombre y Apellido)<span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" maxlength="40" class="form-control form-control-ovalado @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ingrese...">
                        @error('nombre')
                            <small class="text-danger error-msg">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="link-secondary ">Director(a) (Nombre y Apellido)<span class="text-danger">*</span></label>
                        <input type="text" name="director" id="director" maxlength="40" class="form-control form-control-ovalado @error('director') is-invalid @enderror" value="{{ old('director') }}" placeholder="Ingrese...">
                        @error('director')
                            <small class="text-danger error-msg">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <button class="btn btn-primary mt-3" type="submit">Imprimir</button>
                </div>

            </div>
        </div>
    </div>
    </form>

{{-- SCRIPTS DE FUNCIONALIDAD BÁSICA (Fechas, mayúsculas, filtros) --}}
<script>
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFinal = document.getElementById('fecha_final');
    const duracion = document.getElementById('duracion');

    // Bloquear teclado pero permitir selección de calendario
    [fechaInicio, fechaFinal].forEach(input => {
        if(input) input.addEventListener('keydown', e => e.preventDefault());
    });

    function calcularDiferencia() {
        if (!fechaInicio.value || !fechaFinal.value) return;
        const inicio = new Date(fechaInicio.value);
        const fin = new Date(fechaFinal.value);

        if (fin >= inicio) {
            const diferenciaMilisegundos = fin - inicio;
            const dias = (diferenciaMilisegundos / (1000 * 60 * 60 * 24)) + 1; // +1 si quieres contar el día de inicio
            duracion.value = dias + (dias === 1 ? " día" : " días");
        } else {
            duracion.value = "Error: Fin menor a inicio";
            fechaFinal.value = "";
        }
    }

    function MayusculasAutomatico() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="search"], textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        MayusculasAutomatico();
        if (fechaInicio.value && fechaFinal.value) calcularDiferencia();
    });

    if(fechaInicio) fechaInicio.addEventListener('change', calcularDiferencia);
    if(fechaFinal) fechaFinal.addEventListener('change', calcularDiferencia);

    document.querySelectorAll('#motivo, #soporte_legal, #nombre, #director').forEach(element => {
        element.addEventListener('input', function (e) {
             // Lógica combinada: Mayúsculas y solo caracteres permitidos
             let valor = this.value;
             // Permitir letras, números y espacios, eliminar símbolos raros
             this.value = valor.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]/g, '').replace(/\s{2,}/g, ' ');
             if (this.value.startsWith(' ')) this.value = this.value.trim();
        });
    });


document.addEventListener("DOMContentLoaded", () => {
  const soloLetrasEspacios = (e) => {
    e.target.value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, "");
  };

  document.getElementById("nombre").addEventListener("input", soloLetrasEspacios);
  document.getElementById("director").addEventListener("input", soloLetrasEspacios);
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
            // alert('Ocurrió un error inesperado en el servidor.');
             // 🛑 AQUÍ CAPTURAMOS EL ERROR REAL DEL SERVIDOR (CÓDIGO 500)
            const textError = await response.text();
            console.error("Error del Servidor:", textError); // Muestra el error en la consola del navegador (F12)
            alert('Error 500: Revisa la consola (F12) para ver el detalle técnico.');

        // Opcional: Escribir el error en el body para verlo rápido
        // document.body.innerHTML = textError;
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



