<?php

class inicio extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}
		$this->modelo->obtener_permisos_modulo(1, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	public function inicio()
	{
		$datos_vista['titulo_ventana'] = "Inicio";
		$datos_vista['titulo_pagina'] = "Inicio";
		$datos_vista['nombre_pagina'] = "inicio";
		$datos_vista['archivo_funciones'] = "js_inicio.js";

		$this->vista->obtener_vista($this, "inicio", $datos_vista);
	}
}
