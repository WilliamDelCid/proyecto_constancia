<?php 
	class controladores
	{
		public $api;

		public function __construct()
		{
			$this->vista = new vistas();
			$this->cargar_modelo();
			

		}

		public function cargar_modelo()
		{
			$modelo = "modelo";
			$clase_modelo = "librerias/app/modelo.php";
			if(file_exists($clase_modelo)){
				require_once($clase_modelo);
				$this->modelo = new $modelo();
			}
			
		}
	}

 ?>