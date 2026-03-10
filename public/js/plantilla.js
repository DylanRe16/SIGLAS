// $(document).ready(function() {
// if (!$.fn.DataTable.isDataTable('.table')) {
//   //$('#table').DataTable()
//   $(".table").DataTable({
    
//     "ordering": false,

//     "language": {
      
//       "sSearch": "Buscar:",
//       "sEmptyTable": "No hay datos en la Tabla",
//       "sZeroRecords": "No se encontraron resultados",
//       "sInfo": "Mostrando registros del _START_ al _END_ de un total _TOTAL_",
//       "SInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
//       "sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
//       "oPaginate": {

//         "sFirst": "Primero",
//         "sLast": "Último",
//         "sNext": "Siguiente",
//         "sPrevious": "Anterior"

//       },

//       "sLoadingRecords": "Cargando...",
//       "sLengthMenu": "Mostrar _MENU_ registros"
    

//     }

//   });
// }
// });

//   //Editar Sucursales ======================= esto es Ajax y traernos el ID DE LA SUCURSAL====================
//   //cuando hagamos en la clase Table table y On cuando hagamos un clic, En la clase que le agregamos aquí btn Editar sucursal.
//   $(".table").on("click", ".btnEditarSucursal", function(){
    
//     var idSucursal = $(this).attr("idSucursal");

//     $.ajax({
//       //Esta Url debe estar creada en Web.php
//       url: "editar-sucursal/"+idSucursal,
//       //method: "GET",
//       //data: datos,
//       //cache: false,
//       //contentType: false,
//       //processData: false,
//       dataType: "json",
//       type:'GET',
//       success: function(respuesta){
//         //alert(respuesta.nombre);
//         console.log("respuesta", respuesta);

//         $('#nombreEditar').val(respuesta.nombre);
//         $('#idEditar').val(respuesta.id);

//       }
//     });
//   });
