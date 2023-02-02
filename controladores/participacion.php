<?php

class participacion extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}

		$this->modelo->obtener_permisos_modulo(14, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function participacion()
	{


		$datos_vista['titulo_ventana'] = "Tipo de Participación";
		$datos_vista['titulo_pagina'] = "Tipo de Participación";
		$datos_vista['nombre_pagina'] = "Tipo de Participación";
		$datos_vista['archivo_funciones'] = "js_participacion.js";

		$this->vista->obtener_vista($this, "participacion", $datos_vista);
	}

	/*=======================================================
        			LISTADO DE REGISTROS
        =======================================================*/
	public function listar()
	{
		//imprimir(token_sesion());die();
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Participacion'])) {
				$consulta_datos = $this->modelo->seleccionar_todos_sin_where("participacion");
				if ($consulta_datos['estado'] == true) {
					$num_registros = $consulta_datos['cuantos'];
					$arr_datos = $consulta_datos['datos'];

					$htmlDatosTabla = "";
					for ($i = 0; $i < $num_registros; $i++) {
						$boton_editar = "";
						$boton_eliminar = "";

						if ($arr_datos[$i]['estado'] == 1) {
							$arr_datos[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
						} else {
							$arr_datos[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
						}

						if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Participacion'])) {
							$boton_editar = '<button type="button" class="btn btn-success btn-sm" onClick="fnt_editar_participacion(' . $arr_datos[$i]['id'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Participacion'])) {
							$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar_participacion(' . $arr_datos[$i]['id'] . ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
						}
						//agregamos los botones
						$arr_datos[$i]['acciones'] = '<div class="text-center"> ' . $boton_editar . ' ' . $boton_eliminar . '</div>';
						$htmlDatosTabla .= '<tr>
												<td>' . $arr_datos[$i]['id'] . '</td>
												<td>' . $arr_datos[$i]['nombre'] . '</td>
												<td>' . $arr_datos[$i]['estado'] . '</td>
												<td>' . $arr_datos[$i]['fecha_creacion'] . '</td>
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
        			INSERTAR O EDITAR REGISTROS
        =======================================================*/
	public function insertar()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if ($_POST) {
				$idparticipacion = intval($_POST['id']);
				$nombre =  limpiar($_POST['nombre']);
				$estado = intval($_POST['estado']);

				if ($idparticipacion == 0) { //Es una inserción
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Participacion'])) {
						$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM participacion WHERE nombre = '$nombre'");
						//imprimir($existe);die();
						if ($existe['estado'] == true) {
							if (empty($existe['datos'])) {

								//$token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};

								$campos = array("nombre" => $nombre, "estado" => $estado);
								//if (isset($_SESSION['permisos_'.nombreproyecto()]['Crear Roles'])) {
								$insertar = $this->modelo->insertar("participacion", $campos);
								//}
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
								$respuesta = array("estado" => false, "msg" => "La participación ya existe.");
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
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Participacion'])) {
						$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM participacion WHERE nombre = '$nombre' AND id != $idparticipacion");
						//imprimir($url_nombre);die();
						if ($existe_edicion['estado'] == true) {
							if (empty($existe_edicion['datos'])) {
								$campos = array("nombre" => $nombre, "estado" => $estado);

								//if (isset($_SESSION['permisos_'.nombreproyecto()]['Editar Roles'])) {
								$editar = $this->modelo->editar("participacion", $campos, 'id', $idparticipacion);
								//}
								//}
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
								$respuesta = array("estado" => false, "msg" => "La participación ya existe.");
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Participacion'])) {
				if ($_POST) {
					$idparticipacion = intval($_POST['id']);


					//if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Roles'])) {
					$datos = $this->modelo->seleccionar_unico_sql("SELECT * FROM participacion WHERE id = $idparticipacion");
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Participacion'])) {
				if ($_POST) {
					$idparticipacion = intval($_POST['id']);

					//if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Roles'])) {
					$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM empleados	where id_cargo = $idparticipacion");
					//}
					//imprimir($existe);die();
					if ($existe['estado'] == true) {
						if (empty($existe['datos'])) {
							//$token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};

							$eliminar = $this->modelo->eliminar("participacion", "id", $idparticipacion);

							if ($eliminar['estado'] == true) {
								$respuesta = array("estado" => true, "msg" => $eliminar['respuesta']);
								echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
								die();
							} else {
								$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
								echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
								die();
							}
						} else {
							$respuesta = array("estado" => false, "msg" => "No se puede eliminar ya que está asociado a un empleado.");
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
