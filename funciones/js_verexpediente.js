var formAnexoExpediente = document.querySelector("#formAnexoExpediente");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function(){
    //cargar_datos();
    //obtener_datos_selects();
    
    //dropzone();
    
    $( document ).ready(function(){
        $('.carousel').carousel({
          interval: 2000
        })
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

     let tablas = $("#inicializaciondetablas").val();
     let arr_tablas = tablas.split(';');
     //inicializar_tabla("tabla_1_area_1");
    
    for (let i = 0; i < arr_tablas.length; i++) {
       // console.log(arr_tablas[i]);
        inicializar_tabla(arr_tablas[i]);
        
    }
    /*---------------------------------------------------
    METODOS PERSONALIZADOS DE VALIDACION DE FORMULARIOS
    ----------------------------------------------------*/

    //SOLO ALFANUMERICO
    $.validator.addMethod("formAlphanumeric", function (value, element) {
        var pattern = /^[\w\s]+$/i;
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
    $("#formAnexoExpediente").validate({
        rules: {
            apartado_area : {
                    required: true,
                    },
            titulo : {
                required: true,
                formAlphanumeric: true
                },
            descripcion : {
                required: true,
                formAlphanumeric: true
                },
            fecha : {
                required: true
                }
            
        },
        messages : {
            apartado_area : {
                required: "Este campo es requerido",
                },
            titulo : {
                required: "Este campo es requerido",
                formLetras: "Este campo solo acepta letras"
                },
            descripcion : {
                required: "Este campo es requerido",
                formLetras: "Este campo solo acepta letras"
                },
            fecha : {
                required: "Este campo es requerido"
                }
            
        },
        errorElement : 'span'
    });
     
    /*---------------------------------------------------
            EVENTO CLIC EN EL FORMULARIO
    ----------------------------------------------------*/
   
    $(document).on("submit","#formAnexoExpediente",function(e){
		e.preventDefault();
        var datos = new FormData(formAnexoExpediente);
        div_cargando.style.display = "flex";
		$.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/expediente/insertar_anexo_area?token="+token,
            data : datos,
            processData: false, 
              contentType: false
        }).done(function(json) {
        	$('#modal_anexo_expediente').modal("hide");
            formAnexoExpediente.reset();
            if (json.estado === true) {
                //alerta_recargartabla('Expediente', json.msg);
                Swal.fire({
                    title: '<strong>Expediente</strong>',
                    imageUrl: imagenes_alertas+"/usuario_exito.png",
                    imageWidth: 100,
                    imageHeight: 100,
                    html: json.msg,
                    showCloseButton: true,
                    focusConfirm: true,
                    confirmButtonText:
                      '<i class="ti-check"></i> Aceptar!',
                      confirmButtonColor: "#AA0000"
                  }).then((result) => {
                    if (result.isConfirmed) {
                        $("#id_det_expediente_creado").val(json.idcreado);
                        //$('#tabla_usuarios').DataTable().destroy();
                        //$("#datos_tabla").empty().html(json.tabla);
                        //inicializar_tabla("tabla_usuarios");
                        dropzone(json.idcreado);
                        $('#modal_anexo_expediente_imagenes').modal('show');
                    } //result confirm
                  });
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

function dropzone(id_det_exp){
    // Get the template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);
    
    var id_det_expp = id_det_exp;
    //console.log(id_det_exp);
    var myDropzone = new Dropzone(document.body, {
        url: url_base+"/expediente/insertar_imagenes_anexo_area/"+id_det_expp+"?token="+token,
        paramName: "file",
        acceptedFiles: 'image/jpeg,image/png,image/jpg,.pdf',
        maxFilesize: 2,
        maxFiles: 3,
        thumbnailWidth: 160,
        thumbnailHeight: 160,
        thumbnailMethod: 'contain',
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: true,
        previewsContainer: "#previews",
        clickable: ".fileinput-button"
    });
    
    myDropzone.on("addedfile", function(file) {
        $('.dropzone-here').hide();
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
    });
    
    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });
    
    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });
    
    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        //document.querySelector("#total-progress").style.opacity = "0";
    });
    
    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };
    
    $('#previews').sortable({
        items:'.file-row',
        cursor: 'move',
        opacity: 0.5,
        containment: "parent",
        distance: 20,
        tolerance: 'pointer',
        update: function(e, ui){
            //actions when sorting
        }
    });
}


function fnt_agregar_anexo(id){
    $("#idanexo").val(0);
    $("#idarea").val(id);
    $("#idarea_expediente").val($("#id_expediente").val());
    //reset_form(formAnexoExpediente);
    obtener_datos_selects(id);
    $('#modal_anexo_expediente').modal('show');
}

function fnt_ver_anexo(id_detalle_exp){
    

        let datos = {"id":id_detalle_exp};
        //console.log("Imprimiendo datos: ",datos);
        div_cargando.style.display = "flex";
        $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/expediente/ver_anexo_expediente/"+id_detalle_exp+"?token="+token,
            data : datos,
        }).done(function(json) {
        
            if (json.estado) {
                $("#id_ver_det_expediente_creado").val(json.datos.detalle_expediente);
                $("#vertitulo").html(json.datos.titulo_detalle);
                $("#verdescripcion").html(json.datos.descripcion_detalle);
                $("#verfecha").html(json.datos.fecha_detalle);
                $("#imagenes_carrusel").html(json.carrusel_img);
                //$("#fechanac").val(json.datos.fecha_nacimiento);
                //$("#edad").val(calcularEdad(json.datos.fecha_nacimiento) + ' años');
                //$("#turno").val(json.datos.turno).trigger("change");
                //$("#grupo_edad").val(json.datos.grupo_edad);
                //$("#genero").val(json.datos.genero).trigger("change");
                //$("#tutor").val(json.datos.id_tutor).trigger("change");
                //$("#estado").select2("val", json.datos.estado);
                //$("#estado").val(json.datos.estado).trigger("change");
                
                
                
                $('#modal_ver_anexo_expediente_imagenes').modal('show');
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


function obtener_datos_selects(idarea){
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/expediente/listar_select_apartado_area/"+idarea
    }).done(function(json) {    
        if(json.estado){
            $("#apartado_area").empty().html(json.apartados);
        }else{
          alerta_error('Expediente', json.msg);
        }
            
        
    }).fail(function(){

    }).always(function(){
        div_cargando.style.display = "none";
    });
  }

  