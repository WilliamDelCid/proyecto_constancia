<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'librerias/phpmailer/Exception.php';
    require 'librerias/phpmailer/PHPMailer.php';
    require 'librerias/phpmailer/SMTP.php';

	//Retorla la url del proyecto
	function url_base()
	{
		return URL_BASE;
	}

    function token_sesion()
	{
		return $_SESSION['login_datos_'.nombreproyecto()]['token'];
	}


    function nombreproyecto()
	{
		return NOMBRE_PROYECTO  ;
	}

    function nombreproyecto_real()
	{
		return NOMBRE_PROYECTO_REAL  ;
	} 
    //Retorla la url de Assets
    function archivos()
    {
        return URL_BASE."/archivos";
    }

    function imagenes_alertas()
    {
        return URL_BASE."/archivos/imagenes/alertas";
    }

    function imagenes_botones()
    {
        return URL_BASE."/archivos/imagenes/botones";
    }

    function funciones()
    {
        return URL_BASE."/funciones";
    }

    function template()
    {
        return URL_BASE."/template";
    }

    function cabecera($datos_vista="")
    {
        $archivo = "vistas/modulos/cabecera.php";
        require_once ($archivo);
    }

    function barra_horizontal($datos_vista="")
    {
        $archivo = "vistas/modulos/barra_horizontal.php";
        require_once ($archivo);
    }

    function menu_lateral($datos_vista="")
    {
        $archivo = "vistas/modulos/menu_lateral.php";
        require_once ($archivo);
    }

    function piepagina($datos_vista="")
    {
        $archivo = "vistas/modulos/pie_pagina.php";
        require_once ($archivo);        
    }

	//Muestra información formateada
	function imprimir($datos_vista)
    {
        $formato  = print_r('<pre>');
        $formato .= print_r($datos_vista);
        $formato .= print_r('</pre>');
        return $formato;
    }

    function obtener_modal(string $nombre_modal, $datos_vista)
    {
        $modal = "vistas/modales/{$nombre_modal}.php";
        require_once $modal;        
    }



    //Metodo que formatea la fecha
    function formatear_fecha($fecha){
        if($fecha != null){
            $tiempo = strtotime($fecha); 
            $nueva_fecha = date("d-m-Y", $tiempo );
            return $nueva_fecha;
        }else{
            return "";
        }
        
    }
 
    function obtener_edad_segun_fecha($fecha_nacimiento)
    {
        $nacimiento = new DateTime($fecha_nacimiento);
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($nacimiento);
        return $diferencia->format("%y");
    }

    function subir_imagen(array $data, string $ruta){
        $url_temp = $data['tmp_name'];
        $destino = $ruta;        
        $move = move_uploaded_file($url_temp, $destino);
        return $move;
    }

    //Genera una contraseña de 10 caracteres
	function generar_contrasena($length = 10)
    {
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    function getFile(string $url, $data)
    {
        ob_start();
        require_once("Views/{$url}.php");
        $file = ob_get_clean();
        return $file;        
    }

    //Envio de correos
    function enviar_correo($datos, $plantilla)
    {
        $asunto = $datos['asunto']; //nombre del correo
        $emailDestino = $datos['correo']; //el correo al que se le enviara
        $empresa = NOMBRE_REMITENTE; //nombre de la empresa
        $remitente = EMAIL_REMITENTE; //correo desde donde se esta enviando este correo
        //ENVIO DE CORREO
        $de = "MIME-Version: 1.0\r\n"; //encabezados de correo, version
        $de .= "Content-type: text/html; charset=UTF-8\r\n"; //tipo de contenido que se enviara (html)
        $de .= "From: {$empresa} <{$remitente}>\r\n"; //de donde se esta enviando el correo
        ob_start(); //cargamos en buffer todos los datos que vamos a utilizar
        require_once("vistas/plantillas_correo/".$plantilla.".php"); //el archivo que va a cargar es
        $mensaje = ob_get_clean(); //nos devolvera el archivo que hemos cargado
        $send = mail($emailDestino, $asunto, $mensaje, $de); //envio de correos
        return $send;
    }

    
     //Envio de correos
    function enviar_correo_phpmailer($datos, $plantilla)
    {
          //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            ob_start();
            require_once("vistas/plantillas_correo/".$plantilla.".php");
            $mensaje = ob_get_clean();

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'palaciosweb.online';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'sis_evaluacion@palaciosweb.online';          //SMTP username
                $mail->Password   = 'sis_evaluacion$2022';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                

                //Recipients
                $mail->setFrom('sis_evaluacion@palaciosweb.online', 'Sistema de Evaluación del Desempeño UES FMP');
                $mail->addAddress($datos['correo']);     //Add a recipient
                if(!empty($datos['correo_copia'])){
                    $mail->addBCC($datos['correo_copia']);
                }
                $mail->CharSet = 'UTF-8';
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $datos['asunto'];
                $mail->Body    = $mensaje;
                
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            } 
    }

 
    
    function borrar_archivo(string $url)
    {
        unlink($url);
    }
    
    //Elimina exceso de espacios entre palabras
    function limpiar($strCadena)
    {
        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string); // Elimina las \ invertidas
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }
    
    function clear_cadena(string $cadena)
    {
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
 
        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
        array('N', 'n', 'C', 'c','','','',''),
        $cadena
        );
        return $cadena;
    }
    
    //Genera un token
    function token()
    {
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }

    //Formato para valores monetarios
    function formatear_moneda($cantidad)
    {
        $cantidad = number_format($cantidad,2,DECIMAL,MILLAR);
        return $cantidad;
    }
    
    function Meses()
    {
        $meses = array("Enero", 
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
                      "Diciembre");
        return $meses;
    }

 ?>