<?php 
	//$controlador = ucwords($controlador);
	$controlador = $controlador;
	$archivo_controlador = "controladores/".$controlador.".php"; //Creamos la ruta del archivo controlador
	if(file_exists($archivo_controlador)) //Si ese archivo existe
	{
		require_once($archivo_controlador); //Lo requerimos
		$controlador = new $controlador(); //Lo instanciamos
		if(method_exists($controlador, $metodo)) //Si existe el metodo
		{
			$controlador->{$metodo}($parametros); //Llamamos al metodo y mandamos los parametros
		}else{
			require_once("controladores/errores.php");
		}
	}else{
		require_once("controladores/errores.php");
	}

 ?>