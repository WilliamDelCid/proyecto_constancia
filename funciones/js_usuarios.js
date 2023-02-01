var formUsuarios = document.querySelector("#formUsuarios");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function(){
    cargar_datos();
    obtener_datos_selects();
    
    //AL DAR CLIC EN EL BOTON DE NUEVO SE ABRE EL MODAL
    $("#btn_nuevo_usuario").click(function(e) {
        e.preventDefault();
        $("#titulo_modal").empty().html("Nuevo Usuario");
        $("#idusuario").val(0);
        reset_form(formUsuarios);
       
       
        
        $('#modal_usuarios').modal('show');
    });
   
    //INICIALIZANDO LOS SELECT2
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
    $.validator.addMethod("formAlfa", function (value, element) {
      var pattern = /^[\w]+$/i;
      return this.optional(element) || pattern.test(value);
    }, "El campo debe tener un valor alfanumérico (azAZ09)");

    //SOLO LETRAS
    $.validator.addMethod("formLetras", function(value, element) {
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
    $("#formUsuarios").validate({
        errorPlacement: function(error, element) { error.appendTo('#invalid-' + element.attr('id')); },
        rules: {
            email : {
                    required: true,
                    formEmail: true,
                    email: true
                    },
            password : {
                    formAlfa: true
                    },
            rol : {
                    required: true
                    },
            estado : {
                    required: true
                    },
            empleado : {
                        required: true
                        },
          
            foto : {
                    extension: "jpg|jpeg|png"
                    },
        },
        messages : {
          email : {
                  required: "Este campo es requerido",
                  formEmail: "El correo tiene que ser válido",
                  email: "El correo tiene que ser válido"
                  },
          password : {
                  formAlfa: "La contraseña tiene que tener letras y números"
                  },
          rol : {
                  required: "Este campo es requerido",
                  },
          estado : {
                required: "Este campo es requerido",
                  },
          foto : {
                  extension: "Solo se aceptan formatos JPG, JPEG Y PNG"
                  },
        },
        errorElement : 'span'
    });
     
    /*---------------------------------------------------
            REGISTRO Y ACTUALIZACION
    ----------------------------------------------------*/
     //AL DAR CLIC EN EL BOTON DEL FORMULARIO
    $(document).on("submit","#formUsuarios",function(e){
      e.preventDefault();
      var datos = new FormData(formUsuarios);

        div_cargando.style.display = "flex";
		    $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/usuarios/insertar?token="+token,
            data : datos,
            processData: false, 
              contentType: false
        }).done(function(json) {
            if (json.estado === true) {
                $('#modal_usuarios').modal("hide");
                reset_form(formUsuarios);
                alerta_recargartabla('Usuarios', json.msg);
            }else{
              if (json.msg === "Token expirado"){alerta_token_exp("Usuarios", "El token está expirado. Inicie sesión nuevamente.")}
              else if (json.msg === "Token no existe"){alerta_token_exp("Usuarios", "El token no existe. Inicie sesión nuevamente.")}
              else{alerta_error('Roles de usuario', json.msg);}  
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
/*---------------------------------------------------
            ALERTA DE EXITO Y RECARGA TABLA
----------------------------------------------------*/
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
function cargar_datos(){
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/usuarios/listar?token="+token
    }).done(function(json) {    
        if (json.estado === true) {
          $('#tabla_usuarios').DataTable().destroy();
          $("#datos_tabla").empty().html(json.tabla);
            inicializar_tabla("tabla_usuarios");
        }else{
          if (json.msg === "Token expirado"){alerta_token_exp("Usuarios", "El token está expirado. Inicie sesión nuevamente.")}
          else if (json.msg === "Token no existe"){alerta_token_exp("Usuarios", "El token no existe. Inicie sesión nuevamente.")}
          else{alerta_error('Roles de usuario', json.msg);}  
        }
    }).fail(function(){

    }).always(function(){
        div_cargando.style.display = "none";
    });
}

/*---------------------------------------------------
            MUESTRA MODAL PARA EDITAR
----------------------------------------------------*/
function fnt_editar_usuario(idusuario){
    //obtener_datos_selects();
    $("#titulo_modal").empty().html("Actualizar Usuario");
    reset_form(formUsuarios);
    let datos = {"idusuario":idusuario};
    //console.log("Imprimiendo datos: ",datos);
    //mostrar_mensaje("Almacenando información","Por favor no recargue la página");
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/usuarios/obtener?token="+token,
        data : datos,
    }).done(function(json) {
      //console.log(json.datos[0]);
        if (json.estado) {
            $("#id").val(json.datos.id);
            //$("#tipousuario").val(json.datos.tipo_usuario).trigger("change"); 
            $("#email").val(json.datos.email);
            $("#estado").select2("val", json.datos.estado);
            //$("#lista_empleado").select2("val", json.datos[0].id_empleado_usuario);
            $("#rol").val(json.datos.id_rol).trigger("change"); 
            
            //llenar_select_usuario_y_seleccionar(json.datos.tipo_usuario);
            
            if(json.datos.tipo_usuario == 1){
              //console.log(json.datos.id_personal_academico);
              //$("#usuario").val(json.datos.id_personal_academico).trigger("change");
              //$("#usuario").select2("val", json.datos.id_personal_academico);
              llenar_select_usuario_y_seleccionar(json.datos.tipo_usuario, json.datos.id_personal_academico);
            }else{
              //$("#usuario").val(json.datos.id_integrante_admin).trigger("change");
              llenar_select_usuario_y_seleccionar(json.datos.tipo_usuario, json.datos.id_integrante_admin);
            }
            
            $('#modal_usuarios').modal('show');
          }else{
            if (json.msg === "Token expirado"){alerta_token_exp("Usuarios", "El token está expirado. Inicie sesión nuevamente.")}
            else if (json.msg === "Token no existe"){alerta_token_exp("Usuarios", "El token no existe. Inicie sesión nuevamente.")}
            else{alerta_error('Roles de usuario', json.msg);}  
          }
        
    }).fail(function(){

    }).always(function(){

    });

}

/*---------------------------------------------------
      RESTABLECER FORMULARIO
----------------------------------------------------*/
function reset_form(form){
   
    form.reset();
   // $("#lista_empleado").val(0).trigger("change");
    //$("#lista_rol").val(0).trigger("change");
    var validator = $("#formUsuarios").validate();
    validator.resetForm();
    

}





function fnt_eliminar_usuario(idusuario){
    let datos = {"idusuario":idusuario};
    Swal.fire({
        title: '<strong>Eliminar usuario</strong>',
        imageUrl: imagenes_alertas+"/usuario_advertencia.png",
        imageWidth: 100,
        imageHeight: 100,
        html: "Realmente desea eliminar el usuario?",
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                dataType: "json",
                method: "POST",
                url: url_base+"/usuarios/eliminar?token="+token,
                data : datos,
            }).done(function(json) {
            
                if (json.estado === true) {
                    alerta_recargartabla('Usuarios', json.msg);
                }else{
                    if (json.msg === "Token expirado"){alerta_token_exp("Usuarioso", "El token está expirado. Inicie sesión nuevamente.")}
                    else if (json.msg === "Token no existe"){alerta_token_exp("Usuarios", "El token no existe. Inicie sesión nuevamente.")}
                    else{alerta_error('Roles de usuario', json.msg);}  
                }
                
            }).fail(function(){
        
            }).always(function(){
        
            });


        } //result confirm
      });

}

/*---------------------------------------------------
            VER CONTRASEÑA EN EL INPUT
----------------------------------------------------*/
  function ver_contraseña() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

/*---------------------------------------------------
            LLENA LOS SELECT
----------------------------------------------------*/
  function obtener_datos_selects(){
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/usuarios/listar_selects"
    }).done(function(json) {    
        if(json.estado){
            $("#rol").empty().html(json.roles);
            $("#empleado").empty().html(json.empleados);
        }else{
          alerta_error('Usuarios', json.msg);
        }
            
        
    }).fail(function(){

    }).always(function(){
        //Swal.close();
    });
  }

  function llenar_select_usuario(tipo){
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/usuarios/llenar_select_usuario/"+tipo
    }).done(function(json) {    
        if(json.estado){
            $("#usuario").empty().html(json.usuarios);
        }else{
          alerta_error('Usuarios', json.msg);
        }
            
        
    }).fail(function(){

    }).always(function(){
        div_cargando.style.display = "none";
    });
  }



  function llenar_select_usuario_y_seleccionar(tipo, id){
    div_cargando.style.display = "flex";
    $.ajax({
        dataType: "json",
        method: "POST",
        url: url_base+"/usuarios/llenar_select_usuario/"+tipo
    }).done(function(json) {    
        if(json.estado){
            $("#usuario").empty().html(json.roles);
            $("#usuario").val(parseInt(id)).trigger("change");
            //llenar_select_usuario(tipo);
        }else{
          alerta_error('Usuarios', json.msg);
        }
            
        
    }).fail(function(){

    }).always(function(){
        div_cargando.style.display = "none";
    });
  }

