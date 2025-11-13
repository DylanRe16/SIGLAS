import "./bootstrap";
import Alpine from "alpinejs";

import $ from "jquery";
window.$ = $;
window.jQuery = $;

// 🟩 DataTables base
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.css";

// 🟩 Extensiones de DataTables
import "datatables.net-buttons/js/dataTables.buttons";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-buttons/js/buttons.colVis";
import "datatables.net-buttons-dt/css/buttons.dataTables.css";

// Dependencias para exportar
import jszip from "jszip";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = jszip;
window.pdfMake = pdfMake;

window.Alpine = Alpine;
Alpine.start();
