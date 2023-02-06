<?php

class roles extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}

		$this->modelo->obtener_permisos_modulo(3, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function roles()
	{


		$datos_vista['titulo_ventana'] = "Roles de Usuario";
		$datos_vista['titulo_pagina'] = "Roles de Usuario";
		$datos_vista['nombre_pagina'] = "roles";
		$datos_vista['archivo_funciones'] = "js_roles.js";

		$this->vista->obtener_vista($this, "roles", $datos_vista);
	}

	/*=======================================================
        			LISTADO DE REGISTROS
        =======================================================*/
	public function listar()
	{

		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Roles'])) {
				$consulta_datos = $this->modelo->seleccionar_todos_sin_where("roles");
				if ($consulta_datos['estado'] == true) {
					$num_registros = $consulta_datos['cuantos'];
					$arr_datos = $consulta_datos['datos'];

					$htmlDatosTabla = "";
					for ($i = 0; $i < $num_registros; $i++) {
						$boton_ver = "";
						$boton_editar = "";
						$boton_eliminar = "";

						if ($arr_datos[$i]['estado'] == 1) {
							$arr_datos[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
						} else {
							$arr_datos[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
						}

						if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Roles'])) {
							$boton_ver = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_permisos_rol(' . $arr_datos[$i]['id'] . ',\'' . $arr_datos[$i]['nombre'] . '\')" title="Permisos"><i class="fas fa-key"></i></button>';
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Roles'])) {
							$boton_editar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_editar_rol(' . $arr_datos[$i]['id'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Roles'])) {
							$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar_rol(' . $arr_datos[$i]['id'] . ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
						}
						//agregamos los botones
						$arr_datos[$i]['acciones'] = '<div class="text-center">' . $boton_ver . ' ' . $boton_editar . ' ' . $boton_eliminar . '</div>';
						$htmlDatosTabla .= '<tr>
												<td>' . $arr_datos[$i]['id'] . '</td>
												<td>' . $arr_datos[$i]['nombre'] . '</td>
												<td>' . $arr_datos[$i]['estado'] . '</td>
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
				$idrol = intval($_POST['id']);
				$nombre =  limpiar($_POST['nombre']);
				$estado = intval($_POST['estado']);

				if ($idrol == 0) { //Es una inserción
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Roles'])) {
						$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM roles WHERE nombre = '$nombre'");

						if ($existe['estado'] == true) {
							if (empty($existe['datos'])) {

								$campos = array("nombre" => $nombre, "estado" => $estado);

								$insertar = $this->modelo->insertar("roles", $campos);

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
								$respuesta = array("estado" => false, "msg" => "El rol ya existe.");
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
					if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Roles'])) {
						$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM roles WHERE nombre = '$nombre' AND id != $idrol");

						if ($existe_edicion['estado'] == true) {
							if (empty($existe_edicion['datos'])) {

								$campos = array("nombre" => $nombre, "estado" => $estado);

								$editar = $this->modelo->editar("roles", $campos, 'id', $idrol);

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
								$respuesta = array("estado" => false, "msg" => "El rol ya existe.");
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Roles'])) {
				if ($_POST) {
					$idrol = intval($_POST['id']);

					$datos = $this->modelo->seleccionar_unico_sql("SELECT * FROM roles WHERE id = $idrol");

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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Roles'])) {
				if ($_POST) {
					$idrol = intval($_POST['id']);

					$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM usuarios WHERE id_rol = $idrol");

					if ($existe['estado'] == true) {
						if (empty($existe['datos'])) {

							$eliminar = $this->modelo->eliminar("roles", "id", $idrol);

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
							$respuesta = array("estado" => false, "msg" => "No se puede eliminar ya que está asociado a un usuario.");
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

	/*=======================================================
        		OBTENER LOS PERMISOS Y MOSTRAR EL MODAL
        =======================================================*/
	public function obtener_permisos_rol()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Roles'])) {
				$idrol = intval($_POST['idrol']);
				if ($idrol > 0) {

					$seleccionar_modulos = $this->modelo->seleccionar_todos_sql("SELECT * FROM modulos WHERE estado = 1 ORDER BY id ASC");

					if ($seleccionar_modulos['estado'] == true) {

						$arr_modulos = $seleccionar_modulos['datos'];

						$modulos = "";
						$lista_permisos = "";
						$contadorboton = 0;

						for ($i = 0; $i < count($arr_modulos); $i++) {
							$idmodulo = $arr_modulos[$i]['id'];
							$nombremodulo = $arr_modulos[$i]['nombre'];
							$moduloactivo = "";
							$contenidoactivo = "";
							if ($i == 0) {
								$moduloactivo = "active";
								$contenidoactivo = "show active";
							} else {
								$moduloactivo = "";
								$contenidoactivo = "";
							}

							$modulos .= '<a class="nav-link ' . $moduloactivo . '" id="v-pills-' . $idmodulo . '-tab" data-toggle="pill" href="#v-pills-' . $idmodulo . '" role="tab" aria-controls="v-pills-' . $idmodulo . '" aria-selected="true"> ' . $nombremodulo . '</a>';

							$lista_permisos .= '<div class="tab-pane fade ' . $contenidoactivo . '" id="v-pills-' . $idmodulo . '" role="tabpanel" aria-labelledby="v-pills-' . $idmodulo . '-tab">
														<div class="table-responsive">
															<table class="table">
																<thead>
																<tr>
																	<th>Nombre del permiso</th>
																	<th>Estado</th>
																</tr>
																</thead>
																<tbody>';

							$seleccionar_lista_permisos = $this->modelo->seleccionar_todos_sql("SELECT
																									p.id AS idpermiso,
																									p.nombre AS nombrepermiso,
																									p.id_modulo,
																									m.id AS idmodulo,
																									m.nombre AS nombremodulo
																									FROM permisos p 
																									INNER JOIN modulos m ON m.id = p.id_modulo 
																									WHERE p.id_modulo = $idmodulo");

							if ($seleccionar_lista_permisos['estado'] == true) {

								$arr_lista_permisos = $seleccionar_lista_permisos['datos'];

								for ($j = 0; $j < count($arr_lista_permisos); $j++) {
									$idpermisomodulo = $arr_lista_permisos[$j]['idpermiso'];
									$nombrepermisomodulo = $arr_lista_permisos[$j]['nombrepermiso'];

									$existe_permiso = $this->modelo->seleccionar_todos_sql("SELECT 
																								pr.id AS idpermisorol,
																								pr.id_permiso AS idpermiso,
																								pr.id_rol AS id_rol,
																								pr.estado AS estado_permisorol,
																								p.nombre AS permiso,
																								p.id_modulo AS idmodulo
																								FROM permisosrol pr 
																								INNER JOIN permisos p ON p.id = pr.id_permiso
																								INNER JOIN roles r ON r.id = pr.id_rol
																								WHERE pr.id_permiso = $idpermisomodulo AND p.id_modulo = $idmodulo AND pr.id_rol = $idrol");

									if ($existe_permiso['estado'] == true) {

										$arr_existepermiso = $existe_permiso['datos'];

										$lista_permisos .= '<tr>';
										$lista_permisos .= '<td>' . $nombrepermisomodulo . '</td>';
										$contadorboton++;
										$idboton = 'boton-' . $contadorboton;
										if (!empty($arr_existepermiso)) {
											if ($arr_existepermiso[0]['estado_permisorol'] == 1) {

												$lista_permisos .= '<td><div id="' . $idboton . '" onChange="fnt_desactivar_permisorol(' . $arr_existepermiso[0]['idpermisorol'] . ',\'' . $idboton . '\')" title="Desactivar permiso" class="custom-control custom-switch custom-switch-off-light custom-switch-on-' . COLOR_SIDEBAR_ACTIVO . '">
																		<input type="checkbox" class="custom-control-input" id="customSwitch' . $idboton . '" value="1" checked>
																		<label class="custom-control-label" for="customSwitch' . $idboton . '"></label>
																	</div></td>';
											} else {

												$lista_permisos .= '<td><div id="' . $idboton . '" onChange="fnt_activar_permisorol(' . $arr_existepermiso[0]['idpermisorol'] . ',\'' . $idboton . '\')" title="Activar permiso" class="custom-control custom-switch custom-switch-off-light custom-switch-on-' . COLOR_SIDEBAR_ACTIVO . '">
																		<input type="checkbox" class="custom-control-input" id="customSwitch' . $idboton . '">
																		<label class="custom-control-label" for="customSwitch' . $idboton . '"></label>
																	</div></td>';
											}
										} else {

											$lista_permisos .= '<td><div id="' . $idboton . '" onChange="fnt_insertar_permisorol(' . $idrol . ',' . $idpermisomodulo . ',\'' . $idboton . '\')" title="Activar permiso" class="custom-control custom-switch custom-switch-off-light custom-switch-on-' . COLOR_SIDEBAR_ACTIVO . '">
																		<input type="checkbox" class="custom-control-input" id="customSwitch' . $idboton . '">
																		<label class="custom-control-label" for="customSwitch' . $idboton . '"></label>
																	</div></td>';
										}

										$lista_permisos .= '</tr>';
									} else {
										$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
										echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
										die();
									}
								} //fin for
								$lista_permisos .= '</tbody>
													</table>
												</div>
											</div>';
							} else {
								$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
								echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
								die();
							}
						} //fin for
					} else { //fin if ($seleccionar_modulos['estado'] == true)
						$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
						echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
						die();
					} //fin else if ($seleccionar_modulos->estado == 200)


					$arr_respuesta = array('estado' => true, 'modulos' => $modulos, 'contenidos' => $lista_permisos);
					echo json_encode($arr_respuesta, JSON_UNESCAPED_UNICODE);
					die();
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
        INSERTAR PERMISO A LA TABLA DE LOS PERMISOS DE CADA ROL
        =======================================================*/
	public function insertar_permiso_rol()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if ($_POST) {
				$idpermiso = intval($_POST['idpermiso']);
				$idrol = intval($_POST['idrol']);

				$campos = array("id_permiso" => $idpermiso, "id_rol" => $idrol, "estado" => 1);
				$insertar = $this->modelo->insertar("permisosrol", $campos);

				if ($insertar['estado'] == true) {
					$respuesta = array("estado" => true, "msg" => "Se ha insertado el permiso", "idpermisorol" => $insertar['idcreado']);
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				} else {
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				}

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
        			DESACTIVA PERMISO DE UN ROL
        =======================================================*/
	public function desactivar_permiso_rol()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if ($_POST) {
				$idpermisorol = intval($_POST['idpermisorol']);

				$campos = array("estado" => 0);
				$editar = $this->modelo->editar("permisosrol", $campos, 'id', $idpermisorol);
				if ($editar['estado'] == true) {
					$respuesta = array("estado" => true, "msg" => "Se ha desactivado el permiso");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				} else {
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				}

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
        			ACTIVA PERMISO DE UN ROL
        =======================================================*/
	public function activar_permiso_rol()
	{
		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado

			if ($_POST) {
				$idpermisorol = intval($_POST['idpermisorol']);

				$campos = array("estado" => 1);
				$editar = $this->modelo->editar("permisosrol", $campos, 'id', $idpermisorol);
				if ($editar['estado'] == true) {
					$respuesta = array("estado" => true, "msg" => "Se ha desactivado el permiso");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				} else {
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				}

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
