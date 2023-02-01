var formLogin = document.querySelector("#formLogin");
let div_cargando = document.querySelector('#div_cargando');
document.addEventListener('DOMContentLoaded', function(){
    
    //AL DAR CLIC EN EL BOTON DEL FORMULARIO
   
    $(document).on("submit","#formLogin",function(e){
        e.preventDefault();
        
        let datos = new FormData(formLogin);
        let email = $("#txt_email").val();
        let contrasena = $("#txt_contrasena").val();
        

        if (email == '' || contrasena == '') {
            alerta_error('Atención!', "Ingrese todos los campos.");
            return false;
        }

        div_cargando.style.display = "flex";
            $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/login/iniciar_sesion",
            data : datos,
            processData: false, // tell jQuery not to process the data
            contentType: false
        }).done(function(json) {
            
            if (json.estado === true) {
                formLogin.reset();
                alerta_redireccionar('Usuarios', json.msg);
                
            }else{
                alerta_error('Inicio de sesión', json.msg);
            }
            
            
        }).fail(function(){

        }).always(function(){
            div_cargando.style.display = "none";
        });


    });


    $(document).on("submit","#form_enviar_correo_restablecer",function(e){
        e.preventDefault();
        var form_enviar_correo_restablecer = document.querySelector("#form_enviar_correo_restablecer");
        let datos = new FormData(form_enviar_correo_restablecer);
        let email_recuperacion = $("#txt_email_restablecer").val();
        

        if (email_recuperacion == '') {
            alerta_error('Atención!', "Ingrese todos los campos.");
            return false;
        }

        div_cargando.style.display = "flex";
            $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/login/enviar_correo_restablecer",
            data : datos,
            processData: false, // tell jQuery not to process the data
            contentType: false
        }).done(function(json) {
            
            if (json.estado === true) {
                form_enviar_correo_restablecer.reset();
                alerta_redireccionar('Usuarios', json.msg);
                
            }else{
                alerta_error('Atención!', json.msg);
            }
            
            
        }).fail(function(){

        }).always(function(){
            div_cargando.style.display = "none";
        });


    });

    $(document).on("submit","#formRestablecerContra",function(e){
        e.preventDefault();
        var formRestablecerContra = document.querySelector("#formRestablecerContra");
        let datos = new FormData(formRestablecerContra);
        let contra = $("#txt_rest_pass").val();
        let contra2 = $("#txt_rest_pass2").val();
        

        if (contra == '' || contra2 == '') {
            alerta_error('Atención!', "Ingrese todos los campos.");
            return false;
        }

        div_cargando.style.display = "flex";
            $.ajax({
            dataType: "json",
            method: "POST",
            url: url_base+"/login/restablecer_contraseña",
            data : datos,
            processData: false, // tell jQuery not to process the data
            contentType: false
        }).done(function(json) {
            
            if (json.estado === true) {
                formRestablecerContra.reset();
                alerta_redireccionar('Usuarios', json.msg);
                
            }else{
                alerta_error('Atención!', json.msg);
            }
            
            
        }).fail(function(){

        }).always(function(){
            div_cargando.style.display = "none";
        });


    });

    
}, false);



function alerta_redireccionar(titulo, mensaje){

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
            window.location = url_base+'/inicio';
        } //result confirm
      });

}

