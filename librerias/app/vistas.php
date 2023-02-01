<?php 
	
	class vistas
	{
		//Esta funcion recibe el nombre del controlador, nombre de la vista, y puede recibir un arrayu de datos para que este disponible en la vista
		function obtener_vista($controlador, $vista, $datos_vista="")
		{
			$controlador = get_class($controlador); //Obtiene el controlador
			$vista = "vistas/".$controlador."/".$vista.".php"; //Crea la url de la vista
			
			require_once ($vista); //Obtiene la vista
		}

		
	}

 ?>