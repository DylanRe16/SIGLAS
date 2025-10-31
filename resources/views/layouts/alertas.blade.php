@if ($errors->any())
    <div class="alert alert-danger fs-6">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if(session('success'))
    <div class="modal" id="errorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">¡Alerta!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalEl = document.getElementById('errorModal');
            var modal = new bootstrap.Modal(modalEl);
            modal.show();

            // Opcional: cerrar el modal al hacer clic en el botón
            modalEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    modal.hide();
                });
            });
        });
    </script>
@elseif(session('error'))<div class="modal" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">¡Alerta!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEl = document.getElementById('errorModal');
        var modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Opcional: cerrar el modal al hacer clic en el botón
        modalEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                modal.hide();
            });
        });
    });
</script>
<!--   <div class="alert alert-danger fs-6" id="alert">
            </div> -->
@endif

<script>
    // Mostrar toast con AdminLTE
        function showToast(message, type = 'info') {
            const colors = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning',
                info: 'bg-info'
            };

            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white border-0 ${colors[type] || 'bg-info'}`;
            toast.role = 'alert';
            toast.ariaLive = 'assertive';
            toast.ariaAtomic = 'true';
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            document.getElementById('toast-container').appendChild(toast);
            const toastBootstrap = new bootstrap.Toast(toast, { delay: 4000 });
            toastBootstrap.show();
        }
</script>