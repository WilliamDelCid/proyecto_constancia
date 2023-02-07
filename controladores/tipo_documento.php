<?php

class tipo_documento extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}

		$this->modelo->obtener_permisos_modulo(17, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function tipo_documento()
	{


		$datos_vista['titulo_ventana'] = "Tipo de documento";
		$datos_vista['titulo_pagina'] = "Tipo de documento";
		$datos_vista['nombre_pagina'] = "Tipo de documento";
		$datos_vista['archivo_funciones'] = "js_tipo_documento.js";

		$this->vista->obtener_vista($this, "tipo_documento", $datos_vista);
	}

	/*=======================================================
        			LISTADO DE REGISTROS
        =======================================================*/
	public function listar()
	{

		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Tipo Documento'])) {
				$consulta_datos = $this->modelo->seleccionar_todos_sin_where("tipo_documento");
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

						if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Tipo Documento'])) {
							$boton_editar = '<button type="button" class="btn btn-success btn-sm" onClick="fnt_editar_tipo_documento(' . $arr_datos[$i]['id'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Tipo Documento'])) {
							$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar_tipo_documento(' . $arr_datos[$i]['id'] . ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
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
				$idtipo_documento = intval($_POST['id']);
				$nombre =  limpiar($_POST['nombre']);
				$estado = intval($_POST['estado']);

				if ($idtipo_documento == 0) { //Es una inserción
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Tipo Documento'])) {
						$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM tipo_documento WHERE nombre = '$nombre'");
						if ($existe['estado'] == true) {
							if (empty($existe['datos'])) {


								$campos = array("nombre" => $nombre, "estado" => $estado);
								$insertar = $this->modelo->insertar("tipo_documento", $campos);

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
								$respuesta = array("estado" => false, "msg" => "El tipo de documento ya existe.");
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
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Tipo Documento'])) {
						$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM tipo_documento WHERE nombre = '$nombre' AND id != $idtipo_documento");

						if ($existe_edicion['estado'] == true) {
							if (empty($existe_edicion['datos'])) {
								$campos = array("nombre" => $nombre, "estado" => $estado);

								$editar = $this->modelo->editar("tipo_documento", $campos, 'id', $idtipo_documento);

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
								$respuesta = array("estado" => false, "msg" => "El tipo de documento ya existe.");
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Tipo Documento'])) {
				if ($_POST) {
					$id_tipo_documento = intval($_POST['id']);

					$datos = $this->modelo->seleccionar_unico_sql("SELECT * FROM tipo_documento WHERE id = $id_tipo_documento");

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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Tipo Documento'])) {
				if ($_POST) {
					$id_tipo_documento = intval($_POST['id']);

					$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM formularios where tipo_documento = $id_tipo_documento");

					if ($existe['estado'] == true) {
						if (empty($existe['datos'])) {

							$eliminar = $this->modelo->eliminar("tipo_documento", "id", $id_tipo_documento);

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
							$respuesta = array("estado" => false, "msg" => "No se puede eliminar ya que está asociado a un formulario.");
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
