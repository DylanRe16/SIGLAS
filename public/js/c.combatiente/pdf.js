document.getElementById("btnImprimir").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Prioridad del Proceso";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const canvas = document.getElementById("myChart");
    const imgData = canvas.toDataURL("image/png", 1.0);

    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });
    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO CENTRADO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-distribucion-sexo.pdf");
});
document.getElementById("btnImprimir2").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Prioridad del Proceso";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    // Capturamos el gráfico con más resolución
    const canvas = document.getElementById("myChart2");
    const tempCanvas = document.createElement("canvas");
    const scale = 4; // 🔹 Escala más alta = más nitidez (recomendado 3 o 4)
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    // Ahora generamos el PNG con buena calidad
    const imgData = tempCanvas.toDataURL("image/png", 1.0);

    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });
    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-edad.pdf");
});
document.getElementById("btnImprimir3").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Prioridad del Proceso";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const canvas = document.getElementById("myChart3");
    const tempCanvas = document.createElement("canvas");
    const scale = 4; // 🔹 Escala más alta = más nitidez (recomendado 3 o 4)
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    // Ahora generamos el PNG con buena calidad
    const imgData = tempCanvas.toDataURL("image/png", 1.0);
    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-entidad.pdf");
});
document.getElementById("btnImprimir4").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Tipo de Proceso";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const canvas = document.getElementById("myChart4");
    const tempCanvas = document.createElement("canvas");
    const scale = 4; // 🔹 Escala más alta = más nitidez (recomendado 3 o 4)
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    // Ahora generamos el PNG con buena calidad
    const imgData = tempCanvas.toDataURL("image/png", 1.0);
    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-discapacidad.pdf");
});
document.getElementById("btnImprimir5").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Estado del Proceso";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const canvas = document.getElementById("myChart5");
    const tempCanvas = document.createElement("canvas");
    const scale = 4; // 🔹 Escala más alta = más nitidez (recomendado 3 o 4)
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    // Ahora generamos el PNG con buena calidad
    const imgData = tempCanvas.toDataURL("image/png", 1.0);
    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-estado-proceso.pdf");
});

document.getElementById("btnImprimir6").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Ente de Procedencia";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const canvas = document.getElementById("myChart6");
    const tempCanvas = document.createElement("canvas");
    const scale = 4; // 🔹 Escala más alta = más nitidez (recomendado 3 o 4)
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    // Ahora generamos el PNG con buena calidad
    const imgData = tempCanvas.toDataURL("image/png", 1.0);
    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-ente-procedencia.pdf");
});
document.getElementById("btnImprimir7").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png"; // Ruta del logo
    const titulo = "Reporte de Ente de Procedencia";
    const autor = "Sistema SIGLAS";
    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const canvas = document.getElementById("myChart7");
    const tempCanvas = document.createElement("canvas");
    const scale = 4; // 🔹 Escala más alta = más nitidez (recomendado 3 o 4)
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    // Ahora generamos el PNG con buena calidad
    const imgData = tempCanvas.toDataURL("image/png", 1.0);
    // === ENCABEZADO (logo fijo y fondo gris claro) ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => {
        img.onload = resolve;
    });

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Fondo gris claro del encabezado
    // pdf.setFillColor(245, 245, 245);
    // pdf.rect(0, 0, pageWidth, 25, "F");

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Título centrado
    //pdf.setFont("helvetica", "bold");
    //pdf.setFontSize(16);
    //pdf.text(titulo, pageWidth / 2, 15, { align: "center" });

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140; // puedes ajustarlo
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    // Posición centrada
    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;
    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA PROFESIONAL ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Línea superior del pie de página
    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    // Texto inferior (autor + fecha y hora)
    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);
    //pdf.text(`Generado por: ${autor}`, 15, pageHeight - 12);
    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    // Numeración de página (derecha)
    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-comunas.pdf");
});
document.getElementById("btnImprimir8").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png";
    const titulo = "Reporte de Prioridad del Proceso";
    const autor = "Sistema SIGLAS";

    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    // === CANVAS ===
    const canvas = document.getElementById("myChart8");
    const tempCanvas = document.createElement("canvas");
    const scale = 4;
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    const imgData = tempCanvas.toDataURL("image/png", 1.0);

    // === ENCABEZADO ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => (img.onload = resolve));

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140;
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;

    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);

    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-prioridad-proceso.pdf");
});

document.getElementById("btnImprimir9").addEventListener("click", async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4",
    });

    // === CONFIGURACIÓN ===
    const logoUrl = "../img/cintillo_mpppst_documentos_g3302.png";
    const titulo = "Reporte de Prioridad del Proceso";
    const autor = "Sistema SIGLAS";

    const fecha = new Date();
    const fechaFormateada = fecha.toLocaleDateString("es-VE", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
    const horaFormateada = fecha.toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    // === CANVAS ===
    const canvas = document.getElementById("myChart9");
    const tempCanvas = document.createElement("canvas");
    const scale = 4;
    tempCanvas.width = canvas.width * scale;
    tempCanvas.height = canvas.height * scale;

    const ctx = tempCanvas.getContext("2d");
    ctx.scale(scale, scale);
    ctx.drawImage(canvas, 0, 0);

    const imgData = tempCanvas.toDataURL("image/png", 1.0);

    // === ENCABEZADO ===
    const img = new Image();
    img.src = logoUrl;
    await new Promise((resolve) => (img.onload = resolve));

    const pageWidth = pdf.internal.pageSize.getWidth();

    // Logo
    pdf.addImage(img, "PNG", 10, 5, 200, 0);

    // Línea divisoria
    pdf.setDrawColor(0, 122, 204);
    pdf.setLineWidth(0.8);
    pdf.line(10, 27, pageWidth - 10, 27);

    // === GRÁFICO ===
    const imgWidth = 140;
    const imgHeight = (canvas.height / canvas.width) * imgWidth;

    const pageWidth1 = pdf.internal.pageSize.getWidth();
    const pageHeight1 = pdf.internal.pageSize.getHeight();

    const posX = (pageWidth1 - imgWidth) / 2;
    const posY = (pageHeight1 - imgHeight) / 2;

    pdf.addImage(imgData, "PNG", posX, posY, imgWidth, imgHeight);

    // === PIE DE PÁGINA ===
    const pageHeight = pdf.internal.pageSize.getHeight();

    pdf.setDrawColor(180);
    pdf.setLineWidth(0.5);
    pdf.line(10, pageHeight - 20, pageWidth - 10, pageHeight - 20);

    pdf.setFont("helvetica", "normal");
    pdf.setFontSize(10);
    pdf.setTextColor(80);

    pdf.text(
        `Fecha: ${fechaFormateada} - ${horaFormateada}`,
        15,
        pageHeight - 7
    );

    pdf.text(`Página 1 de 1`, pageWidth - 15, pageHeight - 7, {
        align: "right",
    });

    // === DESCARGA ===
    pdf.save("reporte-prioridad-proceso.pdf");
});
