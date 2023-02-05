let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function () {
  cargar_datos();


}, false);


function alerta_token_exp(titulo, mensaje) {
  Swal.fire({
    title: "<strong>" + titulo + "</strong>",
    imageUrl: imagenes_alertas + "/usuario_error.png",
    imageWidth: 100,
    imageHeight: 100,
    html: mensaje,
    showCloseButton: true,
    focusConfirm: true,
    confirmButtonText: '<i class="ti-check"></i> Aceptar!',
    confirmButtonColor: "#AA0000",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = url_base + "/logout";
    } //result confirm
  });
}

function alerta_recargartabla(titulo, mensaje) {
  Swal.fire({
    title: "<strong>" + titulo + "</strong>",
    imageUrl: imagenes_alertas + "/usuario_exito.png",
    imageWidth: 100,
    imageHeight: 100,
    html: mensaje,
    showCloseButton: true,
    focusConfirm: true,
    confirmButtonText: '<i class="ti-check"></i> Aceptar!',
    confirmButtonColor: "#AA0000",
  }).then((result) => {
    if (result.isConfirmed) {
      cargar_datos();
    } //result confirm
  });
}

/*---------------------------------------------------
            CARGA LOS DATOS A LA TABLA
----------------------------------------------------*/
function cargar_datos() {
  div_cargando.style.display = "flex";
  $.ajax({
    dataType: "json",
    method: "POST",
    url: url_base + "/formulario/listar?token=" + token,
  })
    .done(function (json) {
      if (json.estado === true) {
        $("#tabla_formulario").DataTable().destroy();
        $("#datos_tabla").empty().html(json.tabla);
        inicializar_tabla("tabla_formulario");
      } else {
        if (json.msg === "Token expirado") {
          alerta_token_exp(
            "Empleado",
            "El token está expirado. Inicie sesión nuevamente."
          );
        } else if (json.msg === "Token no existe") {
          alerta_token_exp(
            "Empleado",
            "El token no existe. Inicie sesión nuevamente."
          );
        } else {
          if (json.msg === "Token expirado") { alerta_token_exp("Formulario", "El token está expirado. Inicie sesión nuevamente.") }
          else if (json.msg === "Token no existe") { alerta_token_exp("Formulario", "El token no existe. Inicie sesión nuevamente.") }
          else { alerta_error('Formulario', json.msg); }
        }
      }
    })
    .fail(function () { })
    .always(function () {
      div_cargando.style.display = "none";
    });
}

/*---------------------------------------------------
                EDITAR
----------------------------------------------------*/

function editarFormulario(id) {
  if (id !== null) {
    window.open(
      url_base + "/crearformulario/obtener?id=" + id,
      "_blank"
    );
  }

}


function verFormulario(id_reconocimiento) {
  $("#modal_detalle_formulario").modal("show");
}



// function fnt_eliminar_empleado(idempleado) {
//     let datos = { "id": idempleado };
//     Swal.fire({
//         title: '<strong>Eliminar Empleado</strong>',
//         imageUrl: imagenes_alertas + "/usuario_advertencia.png",
//         imageWidth: 100,
//         imageHeight: 100,
//         html: "Realmente desea eliminar el empleado?",
//         showCloseButton: true,
//         showCancelButton: true,
//         focusConfirm: true,
//         confirmButtonText: 'Si',
//         cancelButtonText: 'No',
//     }).then((result) => {
//         if (result.isConfirmed) {
//             div_cargando.style.display = "flex";
//             $.ajax({
//                 dataType: "json",
//                 method: "POST",
//                 url: url_base + "/empleados/eliminar?token=" + token,
//                 data: datos,
//             }).done(function (json) {

//                 if (json.estado === true) {
//                     alerta_recargartabla('Empleado', json.msg);
//                 } else {
//                     if (json.msg === "Token expirado") { alerta_token_exp("Empleado", "El token está expirado. Inicie sesión nuevamente.") }
//                     else if (json.msg === "Token no existe") { alerta_token_exp("Empleado", "El token no existe. Inicie sesión nuevamente.") }
//                     else { alerta_error('Empleado', json.msg); }
//                 }

//             }).fail(function () {

//             }).always(function () {
//                 div_cargando.style.display = "none";
//             });


//         } //result confirm
//     });

// }


