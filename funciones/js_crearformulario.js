// var formEmpleado = document.querySelector("#formEmpleado");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function () {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: "dd/MM/yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $('#fecha_evento').multiDatesPicker();
    // obtener_formulario();
    /*---------------------------------------------------
      AL DAR CLIC EN EL BOTON DE NUEVO SE ABRE EL MODAL
    ----------------------------------------------------*/
    function obtener_formulario() {
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/crearformularios/listarparticipacion"
        }).done(function (json) {
            if (json.estado) {
                $("#cargo").empty().html(json.cargos);
            } else {
                alerta_error('Expediente', json.msg);
            }
        }).fail(function () {

        }).always(function () {
            //Swal.close();
        });
    }

    /*---------------------------------------------------
    METODOS PERSONALIZADOS DE VALIDACION DE FORMULARIOS
    ----------------------------------------------------*/

    //SOLO ALFANUMERICO
    // $.validator.addMethod("formAlphanumeric", function (value, element) {
    //     var pattern = /^[\w]+$/i;
    //     return this.optional(element) || pattern.test(value);
    // }, "El campo debe tener un valor alfanumérico (azAZ09)");

    // //SOLO LETRAS
    // $.validator.addMethod("formLetras", function (value, element) {
    //     var pattern = /^[a-z\-\s-áéíóú_.,ñ0-9()]+$/i;
    //     return this.optional(element) || pattern.test(value);
    // }, "Este campo solo acepta letras");

    // //EMAIL CORRECTO
    // $.validator.addMethod("formEmail", function (value, element) {
    //     var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    //     return this.optional(element) || pattern.test(value);
    // }, "Formato del email incorrecto");

    /*---------------------------------------------------
            VALIDANDO EL FORMULARIO
    ----------------------------------------------------*/
    // $("#formEmpleado").validate({
    //     rules: {
    //         nombre: {
    //             required: true,
    //             formLetras: true
    //         },
    //         estado: {
    //             required: true
    //         }
    //     },
    //     messages: {
    //         nombre: {
    //             required: "Este campo es requerido"
    //         },
    //         estado: {
    //             required: "Este campo es requerido"
    //         }
    //     },
    //     errorElement: 'span'
    // });

    /*---------------------------------------------------
            EVENTO CLIC EN EL FORMULARIO
    ----------------------------------------------------*/

    $(document).on("submit", "#formEmpleado", function (e) {
        e.preventDefault();
        var datos = new FormData(formEmpleado);
        div_cargando.style.display = "flex";
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/empleados/insertar?token=" + token,
            data: datos,
            processData: false,
            contentType: false
        }).done(function (json) {
            $('#modal_empleados').modal("hide");
            formEmpleado.reset();
            if (json.estado === true) {
                alerta_recargartabla('Empleado', json.msg);
            } else {
                if (json.msg === "Token expirado") { alerta_token_exp("Empleado", "El token está expirado. Inicie sesión nuevamente.") }
                else if (json.msg === "Token no existe") { alerta_token_exp("Empleado", "El token no existe. Inicie sesión nuevamente.") }
                else { alerta_error('Empleado', json.msg); }
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



/*---------------------------------------------------
                EDITAR
----------------------------------------------------*/





function reset_form(form) {
    form.reset();
}





