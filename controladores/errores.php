<?php 

	class errores extends controladores{
		public function __construct()
		{
			parent::__construct();
		}

		public function no_encontrado()
		{
			$datos_vista['titulo_ventana'] = "No encontrado";
			$datos_vista['titulo_pagina'] = "Página no encontrada";
			$datos_vista['nombre_pagina'] = "error";
			$this->vista->obtener_vista($this,"error",$datos_vista);
		}
	}

	$notFound = new errores();
	$notFound->no_encontrado();
