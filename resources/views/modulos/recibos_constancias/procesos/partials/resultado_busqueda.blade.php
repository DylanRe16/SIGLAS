<div class="card card-outline  shadow-sm">
    <div class="card-header bg-success">
        <h3 class="card-title text-bold"><i class="fas fa-user mr-2 text-light"></i> Información del Trabajador</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center border-right">
                <i class="fas fa-user-circle fa-6x text-secondary mb-3"></i>
                <h5 class="text-bold mb-0">{{ $trabajador->primer_nombre }} {{ $trabajador->primer_apellido }}</h5>
                <p class="text-muted">{{ $trabajador->nacionalidad }}-{{ $trabajador->cedula }}</p>
            </div>
            <div class="col-md-9">
                <div class="row mt-2">
                    <div class="col-md-4"><strong>Nombres:</strong><br> {{ $trabajador->primer_nombre }} {{ $trabajador->segundo_nombre }}</div>
                    <div class="col-md-4"><strong>Apellidos:</strong><br> {{ $trabajador->primer_apellido }} {{ $trabajador->segundo_apellido }}</div>
                    <div class="col-md-4"><strong>RIF:</strong><br> {{ $trabajador->numero_rif ? $trabajador->numero_rif : 'N/A' }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><strong>Género:</strong><br> {{ $trabajador->sexo == '1' ? 'Femenino' : 'Masculino' }}</div>
                    <div class="col-md-4"><strong>F. Nacimiento:</strong><br> {{ date('d/m/Y', strtotime($trabajador->fecha_nacimiento)) }}</div>
                    <div class="col-md-4"><strong>Correo:</strong><br> {{ $trabajador->email ?? 'N/A' }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Ubicación:</strong><br>
                        {{ $trabajador->direccion_residencia }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>