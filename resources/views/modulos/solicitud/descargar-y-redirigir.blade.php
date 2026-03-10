<body>
    <p>Haz clic en el botón para ver tu cita. Serás redirigido al inicio en unos segundos...</p>
    <button onclick="abrirPDF()">Ver PDF</button>
    <script>
        function abrirPDF() {
            window.open("{{ $urlPdf }}", "_blank");
            setTimeout(function() {
                window.location.href = "{{ $rutaInicio }}";
            }, 3000);
        }
    </script>
</body>