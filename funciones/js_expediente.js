var formExpediente = document.querySelector("#formExpediente");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function(){
    cargar_datos();
    obtener_datos_selects();
    /*---------------------------------------------------
      AL DAR CLIC EN EL BOTON DE NUEVO SE ABRE EL MODAL
    ----------------------------------------------------*/
    
    $("#btn_nuevo_expediente").click(function(e) {
        e.preventDefault();
        $("#titulo_modal").empty().html("Nuevo Expediente");
        $("#id").val(0);
        //reset_form(formExpediente);
        $('#modal_expediente').modal('show');
    });

    $("#fechanac").change(function(){
        let fecha = $("#fechanac").val();
        $("#edad").val(calcularEdad(fecha) + ' años');
       });

    /*---------------------------------------------------
                INICIALIZANDO LOS SELECT2
    ----------------------------------------------------*/
    
    $('.select2').select2({
        "language": {
            "noResults": function(){
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
    $.validator.addMethod("formLetras", function(value, element) {
        var pattern = /^[a-z\-\s-áéíóú_.,ñ]+$/i;
        return this.optional(element) || pattern.test(value);
      }, "Este campo solo acepta letras");

    //SOLO NUMEROS Y GUION
    $.validator.addMethod("formNumGuion", function(value, element) {
        var pattern = /^[0-9\-\s]+$/i;
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
    $("#formExpediente").validate({
        rules: {
            codigo : {
                    required: true,
                    formAlphanumeric: true
                    },
            nombres : {
                required: true,
                formLetras: true
                },
            apellidos : {
                required: true,
                formLetras: true
                },
            fechanac : {
                required: true
                },
            turno : {
                required: true,
                },
            grupo_edad : {
                required: true,
                formNumGuion: true
                },
            genero : {
                required: true,
                },
            tutor : {
                required: true,
                },
            estado : {
                    required: true
                     },
            edad : {
            required: true
                },
                foto_exp : {
                extension: "jpg|jpeg|png"
                }
        },
        messages : {
            codigo : {
                required: "Este campo es requerido",
                formAlphanumeric: "Este campo solo acepta letras y números"
                },
            nombres : {
                required: "Este campo es requerido",
                formLetras: "Este campo solo acepta letras"
                },
            apellidos : {
                required: "Este campo es requerido",
                formLetras: "Este campo solo acepta letras"
                },
            fechanac : {
                required: "Este campo es requerido"
                },
            turno : {
                required: "Este campo es requerido",
                },
            grupo_edad : {
                required: "Este campo es requerido",
                formNumGuion: "Este campo solo acepta números y guión"
                },
            genero : {
                required: "Este campo es requerido",
                },
            tutor : {
                required: "Este campo es requerido",
                },
            estado : {
                    required: "Este campo es requerido"
                    },
            edad : {
                required: "Este campo es requerido"
                },
                foto_exp : {
                extension: "Solo se aceptan formatos JPG, JPEG Y PNG"
                }
        },
        errorElement : 'span'
    });
     
    /*---------------------------------------------------
            EVENTO CLIC EN EL FORMULARIO
    ----------------------------------------------------*/
   
    $(document).on("submit","#formExpediente",function(e){
		e.preventDefault();
        var datos = new FormData(formExpediente);
        div_cargando.style.display = "flex";
		$.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/expediente/insertar?token="+token,
            data : datos,
            processData: false, 
              contentType: false
        }).done(function(json) {
        	$('#modal_expediente').modal("hide");
            formExpediente.reset();
            if (json.estado === true) {
                alerta_recargartabla('Expediente', json.msg);
            }else{
                if (json.msg === "Token expirado"){alerta_token_exp("Expediente", "El token está expirado. Inicie sesión nuevamente.")}
                else if (json.msg === "Token no existe"){alerta_token_exp("Expediente", "El token no existe. Inicie sesión nuevamente.")}
                else{alerta_error('Expediente', json.msg);}  
            }
        }).fail(function(){

        }).always(function(){
            div_cargando.style.display = "none";
        });


	});
    
}, false);


function alerta_token_exp(titulo, mensaje){

    Swal.fire({
      title: '<strong>'+titulo+'</strong>',
      imageUrl: imagenes_alertas+"/usuario_error.png",
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
          window.location = url_base+'/logout';
      } //result confirm
    });

}

function alerta_recargartabla(titulo, mensaje){

      Swal.fire({
        title: '<strong>'+titulo+'</strong>',
        imageUrl: imagenes_alertas+"/usuario_exito.png",
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
function cargar_datos(){
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/expediente/listar?token="+token
    }).done(function(json) {    
        if (json.estado === true) {
            
            $('#tabla_expedientes').DataTable().destroy();
            $("#datos_tabla").empty().html(json.tabla);
            inicializar_tabla("tabla_expedientes");
        }else{
            if (json.msg === "Token expirado"){alerta_token_exp("Expediente", "El token está expirado. Inicie sesión nuevamente.")}
            else if (json.msg === "Token no existe"){alerta_token_exp("Expediente", "El token no existe. Inicie sesión nuevamente.")}
            else{alerta_error('Expediente', json.msg);}  
        }
    }).fail(function(){

    }).always(function(){
        div_cargando.style.display = "none";
    });
}


/*---------------------------------------------------
                EDITAR
----------------------------------------------------*/
function fnt_editar_areas(id){

    window.location = url_base+'/expediente/ver_expediente/'+id;
}

function fnt_editar(id){
    
        $("#titulo_modal").empty().html("Actualizar Expediente");
        reset_form(formExpediente);
        let datos = {"id":id};
        //console.log("Imprimiendo datos: ",datos);
        div_cargando.style.display = "flex";
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/expediente/obtener?token="+token,
            data : datos,
        }).done(function(json) {
        
            if (json.estado) {
                $("#id").val(json.datos.id);
                $("#codigo").val(json.datos.codigo);
                $("#nombres").val(json.datos.nombres);
                $("#apellidos").val(json.datos.apellidos);
                $("#fechanac").val(json.datos.fecha_nacimiento);
                $("#edad").val(calcularEdad(json.datos.fecha_nacimiento) + ' años');
                $("#turno").val(json.datos.turno).trigger("change");
                $("#grupo_edad").val(json.datos.grupo_edad);
                $("#genero").val(json.datos.genero).trigger("change");
                $("#tutor").val(json.datos.id_tutor).trigger("change");
                //$("#estado").select2("val", json.datos.estado);
                $("#estado").val(json.datos.estado).trigger("change");
                //console.log(json.datos.horario);
                if(json.datos.horario != null){
                    if(json.datos.horario.indexOf("Lunes") > -1){
                       $("#lunes").prop("checked", true);
                    }
                    if(json.datos.horario.indexOf("Martes") > -1){
                        $("#martes").prop("checked", true);
                    }
                    if(json.datos.horario.indexOf("Miércoles") > -1){
                        $("#miercoles").prop("checked", true);
                    }
                    if(json.datos.horario.indexOf("Jueves") > -1){
                        $("#jueves").prop("checked", true);
                    }
                    if(json.datos.horario.indexOf("Viernes") > -1){
                        $("#viernes").prop("checked", true);
                    }
                }
                
                
                $('#modal_expediente').modal('show');
            }else{
                if (json.msg === "Token expirado"){alerta_token_exp("Expediente", "El token está expirado. Inicie sesión nuevamente.")}
                else if (json.msg === "Token no existe"){alerta_token_exp("Expediente", "El token no existe. Inicie sesión nuevamente.")}
                else{alerta_error('Expediente', json.msg);}  
            }
            
        }).fail(function(){
    
        }).always(function(){
            div_cargando.style.display = "none";
        });
        
    }



function reset_form(form){
    form.reset();
}


function fnt_eliminar(id){
    let datos = {"id":id};
    Swal.fire({
        title: '<strong>Dar de baja al Expediente</strong>',
        imageUrl: imagenes_alertas+"/usuario_advertencia.png",
        imageWidth: 100,
        imageHeight: 100,
        html: "Realmente desea eliminar el expediente?",
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
                url: url_base+"/expediente/eliminar?token="+token,
                data : datos,
            }).done(function(json) {
            
                if (json.estado === true) {
                    alerta_recargartabla('Expediente', json.msg);
                }else{
                    if (json.msg === "Token expirado"){alerta_token_exp("Expediente", "El token está expirado. Inicie sesión nuevamente.")}
                    else if (json.msg === "Token no existe"){alerta_token_exp("Expediente", "El token no existe. Inicie sesión nuevamente.")}
                    else{alerta_error('Expediente', json.msg);}  
                }
                
            }).fail(function(){
        
            }).always(function(){
                div_cargando.style.display = "none";
            });


        } //result confirm
      });

}


function obtener_datos_selects(){
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/expediente/listar_selects"
    }).done(function(json) {    
        if(json.estado){
            $("#tutor").empty().html(json.tutores);
        }else{
          alerta_error('Expediente', json.msg);
        }
            
        
    }).fail(function(){

    }).always(function(){
        //Swal.close();
    });
  }

  function calcularEdad(fecha) { //años, meses, dias
    // Si la fecha es correcta, calculamos la edad

    if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
        fecha = formatDate(fecha, "yyyy-MM-dd");
    }

    var values = fecha.split("-");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth() + 1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;
    if (ahora_mes < mes) {
        edad--;
    }
    if ((mes == ahora_mes) && (ahora_dia < dia)) {
        edad--;
    }
    if (edad > 1900) {
        edad -= 1900;
    }

    // calculamos los meses
    var meses = 0;

    if (ahora_mes > mes && dia > ahora_dia)
        meses = ahora_mes - mes - 1;
    else if (ahora_mes > mes)
        meses = ahora_mes - mes
    if (ahora_mes < mes && dia < ahora_dia)
        meses = 12 - (mes - ahora_mes);
    else if (ahora_mes < mes)
        meses = 12 - (mes - ahora_mes + 1);
    if (ahora_mes == mes && dia > ahora_dia)
        meses = 11;

    // calculamos los dias
    var dias = 0;
    if (ahora_dia > dia)
        dias = ahora_dia - dia;
    if (ahora_dia < dia) {
        ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
    }

    //return edad + " años, " + meses + " meses y " + dias + " días";
    return edad;
}