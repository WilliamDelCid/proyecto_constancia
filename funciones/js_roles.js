var formRol = document.querySelector("#formRol");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function () {
    cargar_datos();

    /*---------------------------------------------------
      AL DAR CLIC EN EL BOTON DE NUEVO SE ABRE EL MODAL
    ----------------------------------------------------*/

    $("#btn_nuevo_rol").click(function (e) {
        e.preventDefault();
        $("#titulo_modal").empty().html("Nuevo Rol");
        $("#id").val(0);
        reset_form(formRol);
        $('#modal_roles').modal('show');
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
    $("#formRol").validate({
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

    $(document).on("submit", "#formRol", function (e) {
        e.preventDefault();
        var datos = new FormData(formRol);
        div_cargando.style.display = "flex";
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/roles/insertar?token=" + token,
            data: datos,
            processData: false,
            contentType: false
        }).done(function (json) {
            $('#modal_roles').modal("hide");
            formRol.reset();
            if (json.estado === true) {
                alerta_recargartabla('Roles de usuario', json.msg);
            } else {
                if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
                else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
                else { alerta_error('Roles de usuario', json.msg); }
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
        url: url_base + "/roles/listar?token=" + token
    }).done(function (json) {
        if (json.estado === true) {

            $('#tabla_roles').DataTable().destroy();
            $("#datos_tabla").empty().html(json.tabla);
            inicializar_tabla("tabla_roles");
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Roles de usuario', json.msg); }
        }
    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });
}


/*---------------------------------------------------
                EDITAR
----------------------------------------------------*/
function fnt_editar_rol(idrol) {
    $("#titulo_modal").empty().html("Actualizar Rol");
    reset_form(formRol);
    let datos = { "id": idrol };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/roles/obtener?token=" + token,
        data: datos,
    }).done(function (json) {

        if (json.estado) {
            $("#id").val(json.datos.id);
            $("#nombre").val(json.datos.nombre);
            $("#estado").select2("val", json.datos.estado);
            $('#modal_roles').modal('show');
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Roles de usuario', json.msg); }
        }

    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });

}



function fnt_permisos_rol(idrol, nombrerol) {
    $("#titulo_modal_permisos").empty().html("Permisos del rol: " + nombrerol);
    let datos = { "idrol": idrol };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/roles/obtener_permisos_rol?token=" + token,
        data: datos,
    }).done(function (json) {

        if (json.estado) {
            $('#v-pills-tab').html(json.modulos);
            $('#v-pills-tabContent').html(json.contenidos);
            $('#modal_permisosrol').modal('show');
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Roles de usuario', json.msg); }
        }

    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });


}

function fnt_desactivar_permisorol(idpermisorol, idboton) {
    let datos = { "idpermisorol": idpermisorol };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/roles/desactivar_permiso_rol?token=" + token,
        data: datos,
    }).done(function (json) {

        if (json.estado) {
            //$('#'+idboton).replaceWith('<button type="button" id="'+idboton+'" class="btn btn-md" onClick="fnt_activar_permisorol('+idpermisorol+',\''+idboton+'\')" title="Activar permiso"><i class="fas fa-toggle-off"></i></button>');
            $('#' + idboton).replaceWith('<div id="' + idboton + '" onChange="fnt_activar_permisorol(' + idpermisorol + ',\'' + idboton + '\')" title="Activar permiso" class="custom-control custom-switch custom-switch-off-light custom-switch-on-' + sidebar_activo + '">' +
                '<input type="checkbox" class="custom-control-input" id="customSwitch' + idboton + '">' +
                '<label class="custom-control-label" for="customSwitch' + idboton + '"></label></div>');
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Roles de usuario', json.msg); }
        }

    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });


}

function fnt_activar_permisorol(idpermisorol, idboton) {
    let datos = { "idpermisorol": idpermisorol };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/roles/activar_permiso_rol?token=" + token,
        data: datos,
    }).done(function (json) {

        if (json.estado) {
            //$('#'+idboton).replaceWith('<button type="button" id="'+idboton+'" class="btn btn-md" onClick="fnt_desactivar_permisorol('+idpermisorol+',\''+idboton+'\')" title="Desactivar permiso"><i class="fas fa-toggle-on"></i></button>');
            $('#' + idboton).replaceWith('<div id="' + idboton + '" onChange="fnt_desactivar_permisorol(' + idpermisorol + ',\'' + idboton + '\')" title="Desactivar permiso" class="custom-control custom-switch custom-switch-off-light custom-switch-on-' + sidebar_activo + '">' +
                '<input type="checkbox" class="custom-control-input" id="customSwitch' + idboton + '" value="1" checked>' +
                '<label class="custom-control-label" for="customSwitch' + idboton + '"></label></div>');
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Roles de usuario', json.msg); }
        }

    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });


}

function fnt_insertar_permisorol(idrol, idpermiso, idboton) {
    let datos = { "idpermiso": idpermiso, "idrol": idrol };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/roles/insertar_permiso_rol?token=" + token,
        data: datos,
    }).done(function (json) {

        if (json.estado) {
            //$('#'+idboton).replaceWith('<button type="button" id="'+idboton+'" class="btn btn-md" onClick="fnt_desactivar_permisorol('+json.idpermisorol+',\''+idboton+'\')" title="Desactivar permiso"><i class="fas fa-toggle-on"></i></button>');
            $('#' + idboton).replaceWith('<div id="' + idboton + '" onChange="fnt_desactivar_permisorol(' + json.idpermisorol + ',\'' + idboton + '\')" title="Desactivar permiso" class="custom-control custom-switch custom-switch-off-light custom-switch-on-' + sidebar_activo + '">' +
                '<input type="checkbox" class="custom-control-input" id="customSwitch' + idboton + '" value="1" checked>' +
                '<label class="custom-control-label" for="customSwitch' + idboton + '"></label></div>');
        } else {
            if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
            else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
            else { alerta_error('Roles de usuario', json.msg); }
        }

    }).fail(function () {

    }).always(function () {
        div_cargando.style.display = "none";
    });


}

function reset_form(form) {
    form.reset();
}


function fnt_eliminar_rol(idrol) {
    let datos = { "id": idrol };
    Swal.fire({
        title: '<strong>Eliminar Rol</strong>',
        imageUrl: imagenes_alertas + "/usuario_advertencia.png",
        imageWidth: 100,
        imageHeight: 100,
        html: "Realmente desea eliminar el rol?",
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
                url: url_base + "/roles/eliminar?token=" + token,
                data: datos,
            }).done(function (json) {

                if (json.estado === true) {
                    alerta_recargartabla('Roles de usuario', json.msg);
                } else {
                    if (json.msg === "Token expirado") { alerta_token_exp("Roles de usuario", "El token está expirado. Inicie sesión nuevamente.") }
                    else if (json.msg === "Token no existe") { alerta_token_exp("Roles de usuario", "El token no existe. Inicie sesión nuevamente.") }
                    else { alerta_error('Roles de usuario', json.msg); }
                }

            }).fail(function () {

            }).always(function () {
                div_cargando.style.display = "none";
            });


        } //result confirm
    });

}


