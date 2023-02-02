document.addEventListener('DOMContentLoaded', function () {




}, false);


function alerta_error(titulo, mensaje) {
  Swal.fire({
    title: '<strong>' + titulo + '</strong>',
    imageUrl: imagenes_alertas + "/usuario_error.png",
    imageWidth: 100,
    imageHeight: 100,
    html: mensaje,
    showCloseButton: true,
    focusConfirm: true,
    confirmButtonText:
      '<i class="ti-check"></i> Aceptar!',
    confirmButtonColor: "#AA0000"
  });
}


function alerta_exito(titulo, mensaje) {
  Swal.fire({
    title: '<strong>' + titulo + '</strong>',
    imageUrl: imagenes_alertas + "/usuario_exito.png",
    imageWidth: 100,
    imageHeight: 100,
    html: mensaje,
    showCloseButton: true,
    focusConfirm: true,
    confirmButtonText:
      '<i class="ti-check"></i> Aceptar!',
    confirmButtonColor: "#AA0000"
  });
}


function inicializar_tabla(tabla) {
  $('#' + tabla).dataTable({
    "responsive": true,
    "aServerSide": true,
    "autoWidth": false,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "paging": true,
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    columnDefs: [{
      targets: "_all"
    }],

    "bDestroy": true,
    "iDisplayLength": 5,
    "order": [[0, "asc"]]
  });
}


function inicializar_tabla_con_cinco(tabla) {
  $('#' + tabla).dataTable({
    "responsive": true,
    "aServerSide": true,
    "autoWidth": false,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "paging": true,
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    columnDefs: [{
      targets: "_all"
    }],
    "bDestroy": true,
    "iDisplayLength": 5,
    "order": [[1, "desc"]]
  });
}

function inicializar_tabla_con_dos(tabla) {
  $('#' + tabla).dataTable({
    "responsive": true,
    "aServerSide": true,
    "autoWidth": false,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "paging": true,
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    columnDefs: [{
      targets: "_all"
    }],
    "bDestroy": true,
    "iDisplayLength": 2,
    "order": [[1, "asc"]]
  });
}

function inicializar_tabla_cinco(tabla) {
  $('#' + tabla).dataTable({
    "responsive": true,
    "aServerSide": true,
    "autoWidth": false,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "paging": true,
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    columnDefs: [{
      targets: "_all"
    }],
    "bDestroy": true,
    "iDisplayLength": 5,
    "order": [[0, "asc"]]
  });
}

function inicializar_tabla_sin_paginacion(tabla) {
  $('#' + tabla).dataTable({
    "responsive": true,
    "aServerSide": true,
    "autoWidth": false,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    scrollY: '200px',
    scrollCollapse: true,
    paging: false,
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    columnDefs: [{
      targets: "_all"
    }],

    "bDestroy": true,
    "iDisplayLength": 5,
    "order": [[0, "asc"]]
  });
}



function mostrar_mensaje(titulo, mensaje = "") {
  Swal.fire({
    title: titulo,
    html: mensaje,
    allowOutsideClick: false,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading()

    },
    willClose: () => {

    }
  }).then((result) => {


  })
}



