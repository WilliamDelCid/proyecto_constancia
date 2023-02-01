<?php
//USO DE LA LIBRERIA VLUCAS/PHPDOTENV
	require_once(__DIR__."/vendor/autoload.php");
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	
    /*=======================================================
    Mostrar errores
    =======================================================*/
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', "C:/laragon/www/blog/php_error_log");

	

    /*=======================================================
    Requerimientos
    =======================================================*/
    
	require_once("configuraciones/configuracion.php");
	require_once("ayuda/ayuda.php");
	
	
	$url = !empty($_GET['url']) ? $_GET['url'] : 'login/'; //Obtiene url y si esta vacia le dice que sera el login
	$array_url = explode("/", $url); //Obtiene el array de la url, con el controlador, metodo y parametros
	
	//Si en la url no tiene nada, entonces:
	$controlador = $array_url[0]; //El controlador sera el que esta en la posicion 0
	$metodo = $array_url[0]; //El metodo sera el que esta en la posicion 0
	$parametros = "";

	//Si la url no esta vacia, se valida
	if(!empty($array_url[1])) //Si trae algo en la posicion 1
	{
		if($array_url[1] != "")
		{
			$metodo = $array_url[1]; //El metodo esta en la posicion 1	
		}
	}

	if(!empty($array_url[2])) //Si trae algo en la posicion 2
	{
		if($array_url[2] != "")
		{
			//Hay que obtener los parametros
			for ($i=2; $i < count($array_url); $i++) { //Hacemos un for del array url pero desde la posicion 2, ya que ahi inician los parametros
				$parametros .=  $array_url[$i].',';
			}
			$parametros = trim($parametros,','); //Quitamos la ultima coma de los parametros
		}
	}
	require_once("librerias/app/autocarga.php");
	require_once("librerias/app/cargar.php");
