@extends('prototipoInterno')

@section('contenido')

<main>
    @include('modulos.prototipo.menu-prototipo')

    <div class="content-todo2 row my-3" style="width: 70%; max-height: 34rem;">
        <div class="content-login-2">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Preguntas de seguridad</b></h4>
                    </div>
                    <div class="requerido h6 mt-3">Campos obligatorios (*)</div>
                </div>
            </div>
            <hr class="mt-0">

            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="font-weight-bold text-primary">
                        <h4 style="font-size: calc(1.500rem + 0.3vw);">Tus Preguntas y Respuestas</h4>
                    </div>

                    @for ($i = 1; $i <= 3; $i++)
                        <div class="row mb-4 fs-6" style="font-weight: 450;">
                            <div class="col-sm-6">
                                <div class="form-label" style="color: #004B9D;">Pregunta {{ $i }} <span class="requerido">*</span></div>
                                <select name="pregunta_{{ $i }}" class="form-control select-preg">
                                    <option value="">Seleccione</option>
                                    {{-- Aquí podrías agregar las opciones dinámicamente --}}
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-label" style="color: #004B9D;">Respuesta <span class="requerido">*</span></div>
                                <input type="text" name="respuesta_{{ $i }}" class="form-control" value="">
                            </div>
                        </div>
                    @endfor

                    <div class="col-sm-4"></div>
                    <div class="col-sm-4 text-center mt-3">
                        <button type="submit" class="btn btn-guardar rounded-pill">Guardar</button>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="sep"></div>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection
