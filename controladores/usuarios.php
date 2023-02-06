<?php

class usuarios extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}

		$this->modelo->obtener_permisos_modulo(4, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function usuarios()
	{
		if (!isset($_SESSION['permisos_' . nombreproyecto()]['Ver Usuarios'])) { //Si no existe ese permiso
			header('location: ' . url_base() . '/inicio');
		}

		$datos_vista['titulo_ventana'] = "Usuarios";
		$datos_vista['titulo_pagina'] = "Usuarios";
		$datos_vista['nombre_pagina'] = "usuarios";
		$datos_vista['archivo_funciones'] = "js_usuarios.js";
		$this->vista->obtener_vista($this, "usuarios", $datos_vista);
	}

	/*=======================================================
        			LISTADO DE REGISTROS
        =======================================================*/
	public function listar()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Usuarios'])) {
				$where_admin = "";
				if ($_SESSION['login_datos_' . nombreproyecto()]['id'] != 1) {
					$where_admin = " AND u.id != 1";
				}
				$consulta_datos = $this->modelo->seleccionar_todos_sql("SELECT 
																			u.id, u.email, u.estado, u.fecha_creacion, r.nombre as nombrerol, r.id as id_rol
																			FROM usuarios u 
																			INNER JOIN roles r ON r.id = u.id_rol" . $where_admin);

				if ($consulta_datos['estado'] == true) {
					$num_registros = $consulta_datos['cuantos'];
					$arr_datos = $consulta_datos['datos'];

					$htmlDatosTabla = "";
					for ($i = 0; $i < count($arr_datos); $i++) {
						$boton_ver = "";
						$boton_editar = "";
						$boton_eliminar = "";

						if ($arr_datos[$i]['estado'] == 1) {
							$arr_datos[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
						} else {
							$arr_datos[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
						}

						$arr_datos[$i]['fecha_creacion'] = formatear_fecha($arr_datos[$i]['fecha_creacion']);

						if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Usuarios'])) {

							if (($_SESSION['login_datos_' . nombreproyecto()]['id'] == 1 and $_SESSION['login_datos_' . nombreproyecto()]['id_rol'] == 1)
								|| ($_SESSION['login_datos_' . nombreproyecto()]['id_rol'] == 1 and $arr_datos[$i]['id_rol'] != 1)
							) {
								$boton_editar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_editar_usuario(' . $arr_datos[$i]['id'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
							} else {
								$boton_editar = '<button type="button" class="btn btn-danger btn-sm" disabled><i class="fas fa-edit"></i></button>';
							}
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Usuarios'])) {

							if (($_SESSION['login_datos_' . nombreproyecto()]['id'] == 1 and $_SESSION['login_datos_' . nombreproyecto()]['id_rol'] == 1)
								|| ($_SESSION['login_datos_' . nombreproyecto()]['id_rol'] == 1 and $arr_datos[$i]['id_rol'] != 1)
								and ($_SESSION['login_datos_' . nombreproyecto()]['id'] != $arr_datos[$i]['id'])
							) {
								$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar_usuario(' . $arr_datos[$i]['id'] . ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
							} else {
								$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" disabled><i class="fas fa-trash"></i></button>';
							}
						}

						$arr_datos[$i]['acciones'] = '<div class="text-center">' . $boton_ver . ' ' . $boton_editar . ' ' . $boton_eliminar . '</div>';

						$htmlDatosTabla .= '<tr>
												<td>' . $arr_datos[$i]['id'] . '</td>
												<td>' . $arr_datos[$i]['email'] . '</td>
												<td>' . $arr_datos[$i]['nombrerol'] . '</td>
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

				$idusuario = intval($_POST['id']);
				$correo =  limpiar($_POST['email']);
				$estado = intval($_POST['estado']);
				$rol = intval($_POST['rol']);
				$contrasena = $_POST['password'];
				$empleado = intval($_POST['empleado']);

				if ($idusuario == 0) { //Es una inserción
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Usuarios'])) {
						$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM usuarios WHERE email = '$correo'");

						if ($existe['estado'] == true) {
							$arr_datos = $existe['datos'];

							if (empty($arr_datos)) {

								if (empty($contrasena)) {
									$contragenerada = generar_contrasena(); //ESTA CONTRASEÑA SE LE DEBE ENVIAR AL CORREO, HAY QUE DESENCRIPTSARLA Y ENVIARLA
									$contra_encriptada = crypt($contragenerada, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH


									$campos = array(
										"email" => $correo,
										"password" => $contra_encriptada,
										"id_rol" => $rol,
										"estado" => $estado,
										"id_empleado" => $empleado

									);
								} else {
									$contra_encriptada = crypt($contrasena, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH

									$campos = array(
										"email" => $correo,
										"password" => $contra_encriptada,
										"id_rol" => $rol,
										"estado" => $estado,
										"id_empleado" => $empleado
									);
								}

								$insertar = $this->modelo->insertar("usuarios", $campos);

								if ($insertar['estado'] == true) {
									$respuesta = array("estado" => true, "msg" => "Se registraron los datos correctamente.");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								} else {
									$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								}
							} else {
								$respuesta = array("estado" => false, "msg" => "Ese correo ya está registrado.");
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
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Usuarios'])) {
						$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM usuarios WHERE email = '$correo' AND id != $idusuario");

						if ($existe['estado'] == true) {
							$arr_datos = $existe['datos'];

							if (empty($arr_datos)) {

								if (empty($contrasena)) {

									$campos = array(
										"email" => $correo,
										"id_rol" => $rol,
										"estado" => $estado,
										"id_empleado" => $empleado
									);
								} else {
									$contra_encriptada = crypt($contrasena, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH

									$campos = array(
										"email" => $correo,
										"password" => $contra_encriptada,
										"id_rol" => $rol,
										"estado" => $estado,
										"id_empleado" => $empleado
									);
								}

								$editar = $this->modelo->editar("usuarios", $campos, "id", $idusuario);

								if ($editar['estado'] == true) {

									$respuesta = array("estado" => true, "msg" => "Se editaron los datos correctamente.");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								} else {
									$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								}
							} else {
								$respuesta = array("estado" => false, "msg" => "Ese correo ya está registrado.");
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
				}
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Usuarios'])) {
				if ($_POST) {
					$idusuario = intval($_POST['idusuario']);
					$existe = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE id = $idusuario");
					if ($existe['estado'] == true) {
						$arr_datos = $existe['datos'];
						//SI NO EXISTE ESE USUARIO
						if (empty($arr_datos)) {
							$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
							echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
							die();
						} else {
							$respuesta = array("estado" => true, "datos" => $arr_datos);
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
        			ELIMINAR REGISTRO
        =======================================================*/
	public function eliminar()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Usuarios'])) {
				if ($_POST) {
					$idusuario = intval($_POST['idusuario']);
					$usuario = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE id = $idusuario");
					if ($usuario['estado'] == true) {
						$arr_datos = $usuario['datos'];
					}

					$eliminar = $this->modelo->eliminar("usuarios", "id", $idusuario);
					if ($eliminar['estado'] == true) {


						$respuesta = array("estado" => true, "msg" => "Se ha eliminado el usuario");
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
        			LISTAR LOS SELECT PARA FORMULARIO
        =======================================================*/
	public function listar_selects()
	{
		if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Usuarios'])) {
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
		} else {
			$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
			echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
			die();
		}
		die();
	}
}
