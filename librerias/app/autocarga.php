<?php 
	//Se ocupa para la herencia
	spl_autoload_register(function($class){
		if(file_exists("librerias/".'app/'.$class.".php")){
			require_once("librerias/".'app/'.$class.".php");
		}
	});
 ?>