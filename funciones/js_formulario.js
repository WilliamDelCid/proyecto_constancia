let div_cargando = document.querySelector("#div_cargando");
document.addEventListener(
  "DOMContentLoaded",
  function () {
    cargar_datos();
    $(document).on("click", ".abrir", function (e) {
      let id = e.target.getAttribute("data-id");
      if (e.target.getAttribute("data-id") !== null) {
        window.open(url_base + "/crearformulario/obtener?id=" + id, "_blank");
      }
    });
  },
  false
);

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
          if (json.msg === "Token expirado") {
            alerta_token_exp(
              "Formulario",
              "El token está expirado. Inicie sesión nuevamente."
            );
          } else if (json.msg === "Token no existe") {
            alerta_token_exp(
              "Formulario",
              "El token no existe. Inicie sesión nuevamente."
            );
          } else {
            alerta_error("Formulario", json.msg);
          }
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

function verFormulario(id_reconocimiento) {
  let datos = { id: id_reconocimiento };
  div_cargando.style.display = "flex";

  $.ajax({
    dataType: "json",
    method: "POST",
    url: url_base + "/formulario/verDetalle?token=" + token,
    data: datos,
  })
    .done(function (json) {
      if (json.estado) {
        let evento = "";
        console.log(json.datos);
        // return;
        evento = json.datos[0].evento_opcional || json.datos[0].nombre_evento;
        document.querySelector("#imagen").innerHTML = `<img src="${json.datos[0].url}" alt="Codigo QR" width="250px">`;
        document.querySelector("#nombreEvento").innerHTML = evento;
        // document.querySelector("#nombreEvento").value=json.datos[0].;
        document.querySelector("#fechaEvento").innerHTML = json.datos[0].fecha_evento;
        document.querySelector("#fechaExpedicion").innerHTML = json.datos[0].fecha_expedicion;
        document.querySelector("#nombreCompleto").innerHTML = `${json.datos[0].nombre_formulario} ${json.datos[0].apellido_formulario}`;
        document.querySelector("#tipoParticipacion").innerHTML = json.datos[0].nombre_participacion;
        // document.querySelector("#tipoParticipacion").innerHTML=json.datos[0].fecha_evento;
        document.querySelector("#lugarEvento").innerHTML = json.datos[0].lugar_evento;
        document.querySelector("#codigo").innerHTML = json.datos[0].token_unico;
      } else {
        if (json.msg === "Token expirado") {
          alerta_token_exp(
            "Error",
            "El token está expirado. Inicie sesión nuevamente."
          );
        } else if (json.msg === "Token no existe") {
          alerta_token_exp(
            "Error",
            "El token no existe. Inicie sesión nuevamente."
          );
        } else {
          alerta_error("Error", json.msg);
        }
      }
    })
    .fail(function () { })
    .always(function () {
      div_cargando.style.display = "none";
    });

  $("#modal_detalle_formulario").modal("show");
}

function fnt_editar_empleado(idempleado) {
  $("#titulo_modal").empty().html("Actualizar Empleado");
  reset_form(formEmpleado);
  let datos = { id: idempleado };
  //console.log("Imprimiendo datos: ",datos);
  div_cargando.style.display = "flex";
  $.ajax({
    dataType: "json",
    method: "POST",
    url: url_base + "/empleados/obtener?token=" + token,
    data: datos,
  })
    .done(function (json) {
      if (json.estado) {
        $("#id").val(json.datos.id);
        $("#nombre").val(json.datos.nombres);
        $("#apellido").val(json.datos.apellidos);
        $("#cargo").val(json.datos.id_cargo).trigger("change");
        $("#estado").val(json.datos.estado).trigger("change");
        $("#modal_empleados").modal("show");
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
          alerta_error("Empleado", json.msg);
        }
      }
    })
    .fail(function () { })
    .always(function () {
      div_cargando.style.display = "none";
    });
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
