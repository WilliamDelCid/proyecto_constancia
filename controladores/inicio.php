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

	public function listar()
	{
		//imprimir(token_sesion());die();
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			$consulta_datos = $this->modelo->seleccionar_todos_sin_where("expediente");
			if ($consulta_datos['estado'] == true) {
				$num_registros = $consulta_datos['cuantos'];
				$arr_datos = $consulta_datos['datos'];

				$htmlDatosTabla = "";
				for ($i = 0; $i < $num_registros; $i++) {
					$boton_ver = "";
					$boton_editar = "";
					$boton_eliminar = "";



					if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Roles'])) {
						$boton_ver = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_permisos_rol(' . $arr_datos[$i]['id'] . ',\'' . $arr_datos[$i]['nombre'] . '\')" title="Permisos"><i class="fas fa-key"></i></button>';
					}
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Roles'])) {
						$boton_editar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_editar_rol(' . $arr_datos[$i]['id'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
					}

					$boton_eliminar = '<input id="btn_estudiantes" name="btn_estudiantes" class="id_estudiantes" type="checkbox"  data-id="' . $arr_datos[$i]['id'] . '" >';

					//agregamos los botones
					$arr_datos[$i]['acciones'] = '<div class="text-center">' . $boton_ver . ' ' . $boton_editar . ' ' . $boton_eliminar . '</div>';
					$htmlDatosTabla .= '<tr>
												<td>' . $arr_datos[$i]['id'] . '</td>
												<td>' . $arr_datos[$i]['nombres'] . '</td>
												<td>' . $arr_datos[$i]['edad'] . '</td>
												<td>' . $arr_datos[$i]['acciones'] . '</td>
											  </tr>';
				}

				$arr_respuesta = array('estado' => true, 'tabla' => $htmlDatosTabla);
			} else {
				$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
			}

			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);

			die();
		} else if ($validar_token['estado'] == 2) { //el token esta expirado
			$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		} else if ($validar_token['estado'] == 0) { //el token no existe
			$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function listar_selects()
	{
		$htmlRoles = "";
		$htmlEmpleados = "";
		$where_admin = "";
		if ($_SESSION['login_datos_' . nombreproyecto()]['id'] != 1) {
			$where_admin = " AND id != 1";
		}
		$consulta_datos = $this->modelo->seleccionar_todos_sql("SELECT * FROM roles WHERE estado = 1" . $where_admin);
		if ($consulta_datos['estado'] == true) {
			$num_registros = $consulta_datos['cuantos'];
			$arr_datos = $consulta_datos['datos'];

			for ($i = 0; $i < count($arr_datos); $i++) {
				$htmlRoles .= '<option value="' . $arr_datos[$i]['id'] . '">' . $arr_datos[$i]['nombre'] . '</option>';
			}
		} else {
			$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			die();
		}

		$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM empleados WHERE estado = 1");
		if ($consulta_datos2['estado'] == true) {
			$arr_datos2 = $consulta_datos2['datos'];

			for ($i = 0; $i < count($arr_datos2); $i++) {
				$htmlEmpleados .= '<option value="' . $arr_datos2[$i]['id'] . '">' . $arr_datos2[$i]['nombres'] . ' ' . $arr_datos2[$i]['apellidos'] . '</option>';
			}
		} else {
			$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			die();
		}

		$arr_respuesta = array("estado" => true, 'roles' => $htmlRoles, 'empleados' => $htmlEmpleados);
		echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		die();

		die();
	}


	public function listar_selects_areas()
	{
		$htmlRoles = "";
		$htmlEmpleados = "";
		$where_admin = "";
		if ($_SESSION['login_datos_' . nombreproyecto()]['id'] != 1) {
			$where_admin = " AND id != 1";
		}
		$consulta_datos = $this->modelo->seleccionar_todos_sql("SELECT * FROM roles WHERE estado = 1" . $where_admin);
		if ($consulta_datos['estado'] == true) {
			$num_registros = $consulta_datos['cuantos'];
			$arr_datos = $consulta_datos['datos'];

			for ($i = 0; $i < count($arr_datos); $i++) {
				$htmlRoles .= '<option value="' . $arr_datos[$i]['id'] . '">' . $arr_datos[$i]['nombre'] . '</option>';
			}
		} else {
			$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			die();
		}

		$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM areas_expediente WHERE estado = 1");
		if ($consulta_datos2['estado'] == true) {
			$arr_datos2 = $consulta_datos2['datos'];

			for ($i = 0; $i < count($arr_datos2); $i++) {
				$htmlEmpleados .= '<option value="' . $arr_datos2[$i]['id'] . '">' . $arr_datos2[$i]['nombre'] . ' </option>';
			}
		} else {
			$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			die();
		}

		$arr_respuesta = array("estado" => true, 'roles' => $htmlRoles, 'areas' => $htmlEmpleados);
		echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		die();

		die();
	}

	public function obtener()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			// if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Roles'])) {
			if ($_POST) {
				$idactividad = intval($_POST['id']);

				//if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Roles'])) {
				$datos = $this->modelo->seleccionar_unico_sql("SELECT * FROM events WHERE id = $idactividad");
				//}

				if ($datos['estado'] == true) {
					if (empty($datos['datos'])) {
						$respuesta = array("estado" => false, "msg" => "Ops. No se encontraron los datos.");
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					} else {
						$respuesta = array("estado" => true, "datos" => $datos['datos']);
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					}
				} else {
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				}
			}
			// }else{
			// 	$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
			// 	echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
			// 	die();
			// }
		} else if ($validar_token['estado'] == 2) { //el token esta expirado
			$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		} else if ($validar_token['estado'] == 0) { //el token no existe
			$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}
