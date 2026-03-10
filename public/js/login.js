function registrar(rif, razon_social, sector, cargo_direccion, cargo, direccion, estado, municipio, parroquia, solicitud, tipo_solicitud) {
  var campos = [
    { id: "rif", valor: rif },
    { id: "razon_social", valor: razon_social },
    { id: "sector", valor: sector },
    { id: "cargo_direccion", valor: cargo_direccion },
    { id: "cargo", valor: cargo },
    { id: "direccion", valor: direccion },
    { id: "estado", valor: estado },
    { id: "municipio", valor: municipio },
    { id: "parroquia", valor: parroquia },
    { id: "solicitud", valor: solicitud },
    { id: "tipo_solicitud", valor: tipo_solicitud }
  ];
  var errores = false;
  for (var i = 0; i < campos.length; i++) {
    if (campos[i].valor === ""||campos[i].valor == -1) {
      errores = true;
      document.getElementById(campos[i].id).style.borderBottom = "1px solid red";
    } else {
      document.getElementById(campos[i].id).style.border = "";
    }
  }
  if (errores) {
    alert("Por favor, complete todos los campos");
  } else {
    // Ejecuta el botón para mandar el formulario
    document.getElementById("boton-enviar").click();
  }
}

/*function buscar(nacionalidad, ced_afiliado) {
    let valor = 0;

    if (nacionalidad === "") {
        document.getElementById("nacionalidad").style.borderBottom = "1px solid red";
        valor++;
    } else {
        document.getElementById("nacionalidad").style.border = "";
    }

    if (ced_afiliado === "") {
        document.getElementById("ced_afiliado").style.borderBottom = "1px solid red";
        valor++;
    } else {
        document.getElementById("ced_afiliado").style.border = "";
    }

    if (valor > 0) {
        document.getElementById("texto").innerText = "Debe completar todos los campos obligatorios.";
        document.getElementById("titulo").style.backgroundColor = "#DC3831"; // Rojo
        document.getElementById("titulo").style.color = "white";
        document.getElementById("titulo").innerText = "¡Atención!";
        document.getElementById("observacion").style.display = "block";
        return false;
    } else {
        // Mostrar y ocultar elementos según tu lógica
        document.getElementById("grup2").style.display = 'block';
        document.getElementById("busca").style.display = 'none';
        document.querySelector('.content-todo').style.paddingBottom = "180px";
        document.querySelector('.content-login').style.marginTop = "235px";
        document.getElementById("ced_afiliado").disabled = true;
        document.getElementById("nacionalidad").disabled = true;

        // Redirigir a la ruta de búsqueda con parámetros en la URL
        const url = `/sistemas/public/registro?nacionalidad=${encodeURIComponent(nacionalidad)}&ced_afiliado=${encodeURIComponent(ced_afiliado)}`;
        window.location.href = url;
    }
}*/

/*$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content');
    }
});*/
  
$(".btnBuscar").on('click', function(){
    var nacionalidad = $("#nacionalidad").val();
    var ced_afiliado = $("#ced_afiliado").val();

    //alert("cedula: "+nacionalidad+ced_afiliado);
    var url = 'consulta-registro/'+nacionalidad+'/'+ced_afiliado;
    $.ajax({
        url:url,
        type:'GET',
        success:function(response){
            console.log(response);
            // $("#idEditar").val(response.id);
            // $("#selectCategoriaEditar").val(response.id_categoria);
            // $("#codigoProductoEditar").val(response.codigo);
            // $("#nombreProductoEditar").val(response.nombre);
            // $("#descripcionEditar").val(response.descripcion);
            // $("#stockEditar").val(response.stock);
            // $("#precioCompraEditar").val(response.precio_compra);
            // $("#precioVentaEditar").val(response.precio_venta);


        }
    }) 
});

$(".btn-registrarse").on('click', function(){

    var formData = $("#registro2").serializeArray();

    console.log(formData);
    //var nacionalidad = $("#nacionalidad").val();
    //var ced_afiliado = $("#ced_afiliado").val();

    //alert("cedula: "+nacionalidad+ced_afiliado);
    var url = 'consulta-registro/';
    $.ajax({
        url:url,
        type:'POST',
        data: formData,
        
        success:function(response){
            console.log(response);
            // $("#idEditar").val(response.id);
            // $("#selectCategoriaEditar").val(response.id_categoria);
            // $("#codigoProductoEditar").val(response.codigo);
            // $("#nombreProductoEditar").val(response.nombre);
            // $("#descripcionEditar").val(response.descripcion);
            // $("#stockEditar").val(response.stock);
            // $("#precioCompraEditar").val(response.precio_compra);
            // $("#precioVentaEditar").val(response.precio_venta);


        }
    }) 
});

function buscar2(nacionalidad,ced_afiliado){
    /* alert(nacionalidad+" "+ced_afiliado); */
    let valor = 0;

    if(nacionalidad == ""){
        document.getElementById("nacionalidad").style.borderBottom = "1px solid red";
        valor++;
    }else{
        document.getElementById("nacionalidad").style.border = "";
    }
    if(ced_afiliado == ""){
        document.getElementById("ced_afiliado").style.borderBottom = "1px solid red";
        valor++;
    }else{
        document.getElementById("ced_afiliado").style.border = "";
    }
    if(valor > 0){
        document.getElementById("texto").innerText = "Debe completar todos los campos obligatorios.";
        document.getElementById("titulo").style.backgroundColor = "#DC3831"; //Rojo
        document.getElementById("titulo").style.color = "white";
        document.getElementById("titulo").innerText = ("¡Atención!");
        document.getElementById("observacion").style.display = "Block";
        return false;
    }else{
        document.getElementById("grup2").style.display = 'Block';
        document.getElementById("grup1").style.display = 'none';
        document.getElementById("tit").style.display = 'none';

        document.querySelector('.content-todo').style.paddingBottom="180px";
        document.querySelector('.content-login').style.marginTop="235px";
    }


}



