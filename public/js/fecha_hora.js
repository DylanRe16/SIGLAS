function mostrarHoraFecha() {
  const fecha = new Date();
  const hora = fecha.getHours();
  const minutos = fecha.getMinutes();
  const segundos = fecha.getSeconds();
  const dia = fecha.getDate();
  const mes = fecha.getMonth() + 1;
  const año = fecha.getFullYear();

  let horaFormato12 = hora;
  let ampm = "AM";

  if (hora > 12) {
    horaFormato12 = hora - 12;
    ampm = "PM";
  } else if (hora === 0) {
    horaFormato12 = 12;
  }else if (hora === 12) {
    ampm = "PM";
  }

  const horaFecha = `${dia}/${mes}/${año} ${horaFormato12}:${minutos.toString().padStart(2, "0")}${ampm}`;

  document.getElementById("horaFecha").innerHTML = horaFecha;

  setTimeout(mostrarHoraFecha, 1000);
}

mostrarHoraFecha();