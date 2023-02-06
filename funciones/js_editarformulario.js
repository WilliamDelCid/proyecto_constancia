let formFormulario = document.querySelector("#formFormulario");
let div_cargando = document.querySelector("#div_cargando");
document.addEventListener("DOMContentLoaded", () => {
    obtener_participacion();
    obtener_evento();
    editarbotones();
    editar();
    $.datepicker.regional["es"] = {
        closeText: "Cerrar",
        prevText: "<Ant",
        nextText: "Sig>",
        currentText: "Hoy",
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ],
        monthNamesShort: [
            "Ene",
            "Feb",
            "Mar",
            "Abr",
            "May",
            "Jun",
            "Jul",
            "Ago",
            "Sep",
            "Oct",
            "Nov",
            "Dic",
        ],
        dayNames: [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
        weekHeader: "Sm",
        dateFormat: "dd/MM/yy",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: "",
    };
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $("#fecha_evento").multiDatesPicker();

    /*---------------------------------------------------
      Cargar combo tipo de participacion
    ----------------------------------------------------*/
    function obtener_participacion() {
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/crearformulario/listarparticipacion",
        })
            .done(function (json) {
                if (json.estado) {
                    $("#participacion").empty().html(json.participacion);
                } else {
                    alerta_error("Participacion", json.msg);
                }
            })
            .fail(function () { })
            .always(function () {
            });
    }

    /*---------------------------------------------------
      Cargar combo evento
    ----------------------------------------------------*/

    function obtener_evento() {
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/crearformulario/listarevento",
        })
            .done(function (json) {
                if (json.estado) {
                    $("#evento").empty().html(json.evento);
                } else {
                    alerta_error("Participacion", json.msg);
                }
            })
            .fail(function () { })
            .always(function () {
            });
    }


    function editarbotones() {
        document.querySelector('#buttonQR').setAttribute('hidden', true);
        document.querySelector('#guardar').removeAttribute('disabled');
    }

    /*---------------------------------------------------
      Formato del Combo buscador Select 2
    ----------------------------------------------------*/

    $(".select2").select2({
        language: {
            noResults: function () {
                return "No se encontraron resultados";
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });


    // SOLO ALFANUMERICO
    $.validator.addMethod(
        "formAlphanumeric",
        function (value, element) {
            var pattern = /^[\w]+$/i;
            return this.optional(element) || pattern.test(value);
        },
        "El campo debe tener un valor alfanumérico (azAZ09)"
    );

    //SOLO LETRAS
    $.validator.addMethod(
        "formLetras",
        function (value, element) {
            var pattern = /^[a-z\-\s-áéíóú_.,ñ0-9()]+$/i;
            return this.optional(element) || pattern.test(value);
        },
        "Este campo solo acepta letras"
    );

    //EMAIL CORRECTO
    $.validator.addMethod(
        "formEmail",
        function (value, element) {
            var pattern =
                /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            return this.optional(element) || pattern.test(value);
        },
        "Formato del email incorrecto"
    );

    /*---------------------------------------------------
            VALIDANDO EL FORMULARIO
    ----------------------------------------------------*/
    $("#formFormulario").validate({
        rules: {
            nombre: {
                required: true,
                formLetras: true,
            },
            apellido: {
                required: true,
                formLetras: true,
            },
            messages: {
                nombre: {
                    required: "Este campo es requerido"
                },
                apellido: {
                    required: "Este campo es requerido"
                },
                participacion: {
                    required: "Este campo es requerido"
                },
                evento: {
                    required: "Este campo es requerido"
                },
                evento_opcional: {
                    required: "Este campo es requerido"
                },
                fecha_evento: {
                    required: "Este campo es requerido"
                },
                lugar_evento: {
                    required: "Este campo es requerido"
                },
                fecha_expedicion: {
                    required: "Este campo es requerido"
                }

            },
            participacion: {
                required: true,
            },
            evento: {
                required: true,
            },
            fecha_evento: {
                required: true,
            },
            lugar_evento: {
                required: true,
            },
            fecha_expedicion: {
                required: true,
            },
        },
        messages: {
            nombre: {
                required: "Este campo es requerido",
            },
            apellido: {
                required: "Este campo es requerido",
            },
            participacion: {
                required: "Este campo es requerido",
            },
            evento: {
                required: "Este campo es requerido",
            },
            fecha_evento: {
                required: "Este campo es requerido",
            },
            evento_opcional: {
                required: "Este campo es requerido"
            },
            lugar_evento: {
                required: "Este campo es requerido",
            },
            fecha_expedicion: {
                required: "Este campo es requerido",
            },
        },
        errorElement: "span",
    });


    $(document).on("change", "#evento", function (e) {
        if (e.target.value == '-1') {
            document.querySelector('#evento_opcional').removeAttribute('disabled');
            document.querySelector('#evento_opcional').setAttribute('required', 'true');
        } else {
            document.querySelector('#evento_opcional').setAttribute('disabled', 'false')
            document.querySelector('#evento_opcional').removeAttribute('required');
        }
    });

    $(document).on("submit", "#formFormulario", function (e) {
        e.preventDefault();
        var datos = new FormData(formFormulario);
        div_cargando.style.display = "flex";
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base + "/formulario/editar?token=" + token,
            data: datos,
            processData: false,
            contentType: false
        }).done(function (json) {
            formFormulario.reset();
            // document.querySelector('#token').value = '';
            // document.getElementById("contenedorQR").innerHTML = '';
            // document.querySelector('#guardar').setAttribute('disabled', true);
            // document.querySelector('#buttonQR').removeAttribute('disabled');
            if (json.estado === true) {
                alerta_recargartabla('Formulario', json.msg);
            } else {
                if (json.msg === "Token expirado") { alerta_token_exp("Formulario", "El token está expirado. Inicie sesión nuevamente.") }
                else if (json.msg === "Token no existe") { alerta_token_exp("Formulario", "El token no existe. Inicie sesión nuevamente.") }
                else { alerta_error('Formulario', json.msg); }
            }
        }).fail(function () {

        }).always(function () {
            div_cargando.style.display = "none";
        });
    });
},
    false
);

function editar() {
    let datos = { id: document.querySelector('#id_formulario').value };
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base + "/formulario/obtener?token=" + token,
        data: datos,
    })
        .done(function (json) {
            if (json.estado) {
                $("#id").val(json.datos.id);
                $("#nombre").val(json.datos.nombres);
                $("#apellido").val(json.datos.apellidos);
                $("#participacion").val(json.datos.id_tipo_participacion).trigger("change");
                if (json.datos.id_evento == null) {
                    $("#evento").val(-1).trigger("change")
                    document.querySelector('#evento_opcional').removeAttribute('disabled');
                    document.querySelector('#evento_opcional').setAttribute('required', 'true');
                } else {
                    $("#evento").val(json.datos.id_evento).trigger("change");
                }
                $("#evento_opcional").val(json.datos.nombre_evento_opcional);
                $("#fecha_evento").val(json.datos.fecha_evento);
                $("#lugar_evento").val(json.datos.lugar_evento);
                $("#fecha_expedicion").val(json.datos.fecha_expedicion);
                document.querySelector('#label_QR').innerHTML = '';
            } else {
                if (json.msg === "Token expirado") {
                    alerta_token_exp(
                        "Formulario",
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

async function fntAñadirMarca() { //Cambiarlo

    const { value: nombre } = await Swal.fire({
        title: 'Ingrese una participación',
        input: 'text',
        inputLabel: 'Su participación',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Ingrese una participación'
            } else {
                div_cargando.style.display = "flex";
                var datos = { "txtNombre": value };
                $.ajax({
                    dataType: "json",
                    method: "POST",
                    url: url_base + "/crearformulario/listarparticipacion",
                    data: datos,
                }).done(function (json) {
                    if (json.estado) {
                        $("#participacion").empty().html(json.participacion);
                        Swal.fire("Participación!", json.msg, "success");
                        document.querySelector("#participacion").value = json.id;
                    } else {
                        Swal.fire("Participación!", json.msg, "error");
                    }
                }).fail(function () {

                }).always(function () {
                    div_cargando.style.display = "none";
                });
            }
        }
    })

    if (nombre) {

    }





}

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
            window.open(
                url_base + "/formulario", "_self"
            );
        } //result confirm
    });

}

function reset_form(form) {
    form.reset();
}