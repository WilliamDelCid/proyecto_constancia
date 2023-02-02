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
    return $_SESSION['login_datos_' . nombreproyecto()]['token'];
}


function nombreproyecto()
{
    return NOMBRE_PROYECTO;
}

function nombreproyecto_real()
{
    return NOMBRE_PROYECTO_REAL;
}
//Retorla la url de Assets
function archivos()
{
    return URL_BASE . "/archivos";
}

function imagenes_alertas()
{
    return URL_BASE . "/archivos/imagenes/alertas";
}

function imagenes_botones()
{
    return URL_BASE . "/archivos/imagenes/botones";
}

function funciones()
{
    return URL_BASE . "/funciones";
}

function template()
{
    return URL_BASE . "/template";
}

function cabecera($datos_vista = "")
{
    $archivo = "vistas/modulos/cabecera.php";
    require_once($archivo);
}

function barra_horizontal($datos_vista = "")
{
    $archivo = "vistas/modulos/barra_horizontal.php";
    require_once($archivo);
}

function menu_lateral($datos_vista = "")
{
    $archivo = "vistas/modulos/menu_lateral.php";
    require_once($archivo);
}

function piepagina($datos_vista = "")
{
    $archivo = "vistas/modulos/pie_pagina.php";
    require_once($archivo);
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
function formatear_fecha($fecha)
{
    if ($fecha != null) {
        $tiempo = strtotime($fecha);
        $nueva_fecha = date("d-m-Y", $tiempo);
        return $nueva_fecha;
    } else {
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

function subir_imagen(array $data, string $ruta)
{
    $url_temp = $data['tmp_name'];
    $destino = $ruta;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

//Genera una contraseña de 10 caracteres
function generar_contrasena($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
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





function borrar_archivo(string $url)
{
    unlink($url);
}

//Elimina exceso de espacios entre palabras
function limpiar($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}



//Genera un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}
