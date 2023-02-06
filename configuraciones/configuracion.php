<?php

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASSWORD", $_ENV['DB_PASSWORD']);
define("DB_CHARSET", $_ENV['DB_CHARSET']);

define("URL_BASE", $_ENV['URL_BASE']);
define("NOMBRE_PROYECTO", $_ENV['NOMBRE_PROYECTO']);
define("NOMBRE_PROYECTO_REAL", $_ENV['NOMBRE_PROYECTO_REAL']);
define("NOMBRE_LOGO_PROYECTO", $_ENV['NOMBRE_LOGO_PROYECTO']);

//COLORES PARA EL TEMA
//Pueden ser: primary, secondary, info, success, warning, danger, black, gray-dark, gray, light, Indigo, Lightblue, Navy, Purple, Fuchsia, Pink, Maroon, Orange, Orange, Teal, Olive
define("COLOR_TEMA", $_ENV['COLOR_TEMA']); //Color del tema, si es oscuro = dark-mode, y si es blanco dejelo vacio
define("COLOR_NAV_HORIZONTAL", $_ENV['COLOR_NAV_HORIZONTAL']); //Color barra superior horizontal
define("COLOR_NAV_HORIZONTAL_TEXTO", $_ENV['COLOR_NAV_HORIZONTAL_TEXTO']); //Color de la letra en la barra horizontal, puede ser light y dark. Si quieres letra blanca debes poner dark y viceversa
define("COLOR_NAV_LOGO", $_ENV['COLOR_NAV_LOGO']); //Color barra superior del logo
define("COLOR_SIDEBAR", $_ENV['COLOR_SIDEBAR']); //Color de fondo para el menu lateral
define("COLOR_SIDEBAR_ACTIVO", $_ENV['COLOR_SIDEBAR_ACTIVO']); //Color de item activo del menu lateral

//Zona horaria
date_default_timezone_set('America/Mexico_City');

//Deliminadores decimal y millar Ej. 24,1989.00
const DECIMAL = ".";
const MILLAR = ",";

//Simbolo de moneda
const MONEDA = "$";

//Datos envio de correo
const NOMBRE_REMITENTE = "-";
const EMAIL_REMITENTE = "-";
const NOMBRE_EMPRESA = "-";
const WEB_EMPRESA = "-";
