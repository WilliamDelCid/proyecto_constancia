<?php

class empleados extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}

		$this->modelo->obtener_permisos_modulo(6, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function empleados()
	{
		$datos_vista['titulo_ventana'] = "Empleados";
		$datos_vista['titulo_pagina'] = "Empleados";
		$datos_vista['nombre_pagina'] = "empleados";
		$datos_vista['archivo_funciones'] = "js_empleados.js";
		$this->vista->obtener_vista($this, "empleados", $datos_vista);
	}

	/*=======================================================
        			LISTADO DE REGISTROS
        =======================================================*/
	public function listar()
	{

		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Empleado'])) {
				$consulta_datos = $this->modelo->seleccionar_todos_sql("SELECT e.id AS idempleado, e.nombres AS nombreempleado, 
						e.apellidos AS apellidoempleado, 
						e.estado AS estadoempleado, e.id_cargo AS idcargo,
						e.fecha_creacion AS fechacrempleado, c.nombre AS nombrecargo
						FROM empleados AS e
						INNER JOIN cargos AS c ON e.id_cargo = c.id");
				if ($consulta_datos['estado'] == true) {
					$arr_datos = $consulta_datos['datos'];

					$htmlDatosTabla = "";
					for ($i = 0; $i < count($arr_datos); $i++) {
						$boton_editar = "";
						$boton_eliminar = "";

						if ($arr_datos[$i]['estadoempleado'] == 1) {
							$arr_datos[$i]['estadoempleado'] = '<span class="badge badge-success">Activo</span>';
						} else {
							$arr_datos[$i]['estadoempleado'] = '<span class="badge badge-danger">Inactivo</span>';
						}

						if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Empleado'])) {
							$boton_editar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_editar_empleado(' . $arr_datos[$i]['idempleado'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Empleado'])) {
							$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar_empleado(' . $arr_datos[$i]['idempleado'] . ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
						}

						$arr_datos[$i]['acciones'] = '<div class="text-center"> ' . $boton_editar . ' ' . $boton_eliminar . '</div>';
						$htmlDatosTabla .= '<tr>
												<td>' . $arr_datos[$i]['idempleado'] . '</td>
												<td>' . $arr_datos[$i]['nombreempleado'] . '</td>
												<td>' . $arr_datos[$i]['apellidoempleado'] . '</td>
												<td>' . $arr_datos[$i]['nombrecargo'] . '</td>
												<td>' . $arr_datos[$i]['estadoempleado'] . '</td>
												<td>' . $arr_datos[$i]['fechacrempleado'] . '</td>
												<td>' . $arr_datos[$i]['acciones'] . '</td>
											  </tr>';
					}

					$arr_respuesta = array('estado' => true, 'tabla' => $htmlDatosTabla);
				} else {
					$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
				}

				echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			} else {
				$arr_respuesta = array("estado" => false, "msg" => 'Ops. No tiene permisos para ver.');
				echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			}
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

	/*=======================================================
        			COMBO CARGO
        =======================================================*/
	public function listarc()
	{
		if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Empleado'])) {
			$htmlC = "";

			$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM cargos 
																		WHERE cargos.estado = 1");
			if ($consulta_datos2['estado'] == true) {
				$arr_datos2 = $consulta_datos2['datos'];

				for ($i = 0; $i < count($arr_datos2); $i++) {
					$htmlC .= '<option value="' . $arr_datos2[$i]['id'] . '">' . $arr_datos2[$i]['nombre'] . '</option>';
				}
			} else {
				$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
				echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
				die();
			}

			$arr_respuesta = array("estado" => true, 'cargos' => $htmlC);
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
			die();
		} else {
			$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
			echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
			die();
		}
		die();
	}

	/*=======================================================
        			INSERTAR O EDITAR REGISTROS
        =======================================================*/
	public function insertar()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if ($_POST) {
				$idempleado = intval($_POST['id']);
				$nombre =  limpiar($_POST['nombre']);
				$apellido =  limpiar($_POST['apellido']);
				$idcargo = intval($_POST['cargo']);
				$estado = intval($_POST['estado']);

				if ($idempleado == 0) { //Es una inserción
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Empleado'])) {
						$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM empleados WHERE id = $idempleado");
						if ($existe['estado'] == true) {
							if (empty($existe['datos'])) {

								$campos = array("nombres" => $nombre, "apellidos" => $apellido, "estado" => $estado, "id_cargo" => $idcargo);

								$insertar = $this->modelo->insertar("empleados", $campos);

								if ($insertar['estado'] == true) {
									$respuesta = array("estado" => true, "msg" => $insertar['respuesta']);
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								} else {
									$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								}
							} else {
								$respuesta = array("estado" => false, "msg" => "El empleado ya existe.");
								echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
								die();
							}
						} else {
							$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
							echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
							die();
						}
					} else {
						$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para insertar.");
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					}
				} else { //actualizacion
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Empleado'])) {
						$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM empleados WHERE id != $idempleado AND nombres = '$nombre'");

						if ($existe_edicion['estado'] == true) {
							if (empty($existe_edicion['datos'])) {

								$campos = array("nombres" => $nombre, "apellidos" => $apellido, "estado" => $estado, "id_cargo" => $idcargo);

								$editar = $this->modelo->editar("empleados", $campos, 'id', $idempleado);

								if ($editar['estado'] == true) {
									$respuesta = array("estado" => true, "msg" => $editar['respuesta']);
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								} else {
									$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								}
							} else {
								$respuesta = array("estado" => false, "msg" => "El empleado ya existe.");
								echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
								die();
							}
						} else {
							$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
							echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
							die();
						}
					} else {
						$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para editar.");
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					}
				} //else actualizacion

			} // if ($_POST)
		} else if ($validar_token['estado'] == 2) { //el token esta expirado
			$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		} else if ($validar_token['estado'] == 0) { //el token no existe
			$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	/*=======================================================
        			OBTENER REGISTRO ESPECIFICO
        =======================================================*/
	public function obtener()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Empleado'])) {
				if ($_POST) {
					$idempleado = intval($_POST['id']);

					$datos = $this->modelo->seleccionar_unico_sql("SELECT * FROM empleados WHERE id = $idempleado");

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
			} else {
				$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
				echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
				die();
			}
		} else if ($validar_token['estado'] == 2) { //el token esta expirado
			$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		} else if ($validar_token['estado'] == 0) { //el token no existe
			$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
			echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	/*=======================================================
        			ELIMINAR REGISTRO
        =======================================================*/
	public function eliminar()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Empleado'])) {
				if ($_POST) {
					$idempleado = intval($_POST['id']);
					$eliminar = $this->modelo->eliminar("empleados", "id", $idempleado);

					if ($eliminar['estado'] == true) {
						$respuesta = array("estado" => true, "msg" => $eliminar['respuesta']);
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					} else {
						$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					}
				}
			} else {
				$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para dar de baja.");
				echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
				die();
			}
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
