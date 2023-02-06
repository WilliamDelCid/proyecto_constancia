var formParticipacion = document.querySelector("#formParticipacion");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function () {
    cargar_datos();

    /*---------------------------------------------------
      AL DAR CLIC EN EL BOTON DE NUEVO SE ABRE EL MODAL
    ----------------------------------------------------*/

    $("#btn_nueva_participacion").click(function (e) {
        e.preventDefault();
        $("#titulo_modal").empty().html("Nueva Participacion");
        $("#id").val(0);
        reset_form(formParticipacion);
        $('#modal_participacion').modal('show');
    });

    /*---------------------------------------------------
                INICIALIZANDO LOS SELECT2
    ----------------------------------------------------*/

    $('.select2').select2({
        "language": {
            "noResults": function () {
                return "No se encontraron resultados";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    /*---------------------------------------------------
    METODOS PERSONALIZADOS DE VALIDACION DE FORMULARIOS
    ----------------------------------------------------*/

    //SOLO ALFANUMERICO
    $.validator.addMethod("formAlphanumeric", function (value, element) {
        var pattern = /^[\w]+$/i;
        return this.optional(element) || pattern.test(value);
    }, "El campo debe tener un valor alfanumérico (azAZ09)");

    //SOLO LETRAS
    $.validator.addMethod("formLetras", function (value, element) {
        var pattern = /^[a-z\-\s-áéíóú_.,ñ0-9()]+$/i;
        return this.optional(element) || pattern.test(value);
    }, "Este campo solo acepta letras");

    //EMAIL CORRECTO
    $.validator.addMethod("formEmail", function (value, element) {
        var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
        return this.optional(element) || pattern.test(value);
    }, "Formato del email incorrecto");

    /*---------------------------------------------------
            VALIDANDO EL FORMULARIO
    ----------------------------------------------------*/
    $("#formParticipacion").validate({
        rules: {
            nombre: {
                required: true,
                formLetras: true
            },
            estado: {
                required: true
            }
        },
        messages: {
            nombre: {
                required: "Este campo es requerido"
            },
            estado: {
                required: "Este campo es requerido"
            }
        },
        errorElement: 'span'
    });

    /*---------------------------------------------------
            EVENTO CLIC EN EL FORMULARIO
    ----------------------------------------------------*/

    $(document).on("submit", "#formParticipacion", function (e) {
        e.preventDefault();
        var datos = new FormData(formParticipacion);
        div_cargando.style.display = "flex";
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/participacion/insertar?token=" + token,
            data: datos,
            processData: false,
            contentType: false
        }).done(function (json) {
            $('#modal_participacion').modal("hide");
            formParticipacion.reset();
            if (json.estado === true) {
                alerta_recargartabla('Participacion', json.msg);
            } else {
                if (json.msg === "Token expirado") { alerta_token_exp("Participacion", "El token está expirado. Inicie sesión nuevamente.") }
                else if (json.msg === "Token no existe") { alerta_token_exp("Participacion", "El token no existe. Inicie sesión nuevamente.") }
                else { alerta_error('Participacion', json.msg); }
            }
        }).fail(function () {

        }).always(function () {
            div_cargando.style.display = "none";
        });


    });

}, false);


function alerta_token_exp(titulo, mensaje) {

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
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = url_base + '/logout';
        } //result confirm
    });

}

function alerta_recargartabla(titulo, mensaje) {

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
        url: url_base + "/participacion/listar?token=" + token
    }).done(function (json) {
        if (json.estado === true) {

            $('#tabla_participacion').DataTable().destroy();
            $("#datos_tabla").empty().html(json.tabla);
            inicializar_tabla("tabla_participacion");
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Participacion", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Participacion", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Participacion', json.msg); }
        }
    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });
}


/*---------------------------------------------------
                EDITAR
----------------------------------------------------*/
function fnt_editar_participacion(idParticipacion) {
    $("#titulo_modal").empty().html("Actualizar Participación");
    reset_form(formParticipacion);
    let datos = { "id": idParticipacion };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/participacion/obtener?token=" + token,
        data: datos,
    }).done(function (json) {

        if (json.estado) {
            $("#id").val(json.datos.id);
            $("#nombre").val(json.datos.nombre);
            $("#estado").select2("val", json.datos.estado);
            $('#modal_participacion').modal('show');
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Participacion", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Participacion", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Participacion', json.msg); }
        }

    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });

}


function reset_form(form) {
    form.reset();
}


function fnt_eliminar_participacion(idParticipacion) {
    let datos = { "id": idParticipacion };
    Swal.fire({
        title: '<strong>Eliminar Participación</strong>',
        imageUrl: imagenes_alertas + "/usuario_advertencia.png",
        imageWidth: 100,
        imageHeight: 100,
        html: "Realmente desea eliminar el Participacion?",
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            div_cargando.style.display = "flex";
            $.ajax({
                dataType: "json",
                method: "POST",
                url: url_base + "/participacion/eliminar?token=" + token,
                data: datos,
            }).done(function (json) {

                if (json.estado === true) {
                    alerta_recargartabla('Participacion', json.msg);
                } else {
                    if (json.msg === "Token expirado") { alerta_token_exp("Participacion", "El token está expirado. Inicie sesión nuevamente.") }
                    else if (json.msg === "Token no existe") { alerta_token_exp("Participacion", "El token no existe. Inicie sesión nuevamente.") }
                    else { alerta_error('Participacion', json.msg); }
                }

            }).fail(function () {

            }).always(function () {
                div_cargando.style.display = "none";
            });


        } //result confirm
    });

}


