<?php

class formulario extends controladores
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/login');
		}

		$this->modelo->obtener_permisos_modulo(16, $_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
		$this->modelo->obtener_permisos_todos($_SESSION['login_datos_' . nombreproyecto()]['id_rol']);
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function formulario()
	{


		$datos_vista['titulo_ventana'] = "Formulario";
		$datos_vista['titulo_pagina'] = "Formulario";
		$datos_vista['nombre_pagina'] = "Formulario";
		$datos_vista['archivo_funciones'] = "js_formulario.js";

		$this->vista->obtener_vista($this, "formulario", $datos_vista);
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

			if (isset($_SESSION['permisos_' . nombreproyecto()]['Ver Formulario'])) {
				$consulta_datos = $this->modelo->seleccionar_todos_sql("SELECT f.id AS id_formulario, f.nombres AS nombre_formulario, 
				f.apellidos AS apellido_formulario,p.nombre AS nombre_participacion, 
				e.nombre AS nombre_evento, 
				f.nombre_evento_opcional AS evento_opcional, 
				f.fecha_evento AS fecha_evento, f.lugar_evento,
				f.fecha_expedicion
				FROM formularios AS f
				INNER JOIN participacion AS p ON f.id_tipo_participacion = p.id INNER JOIN eventos e on f.id_evento=e.id ");

				if ($consulta_datos['estado'] == true) {
					$arr_datos = $consulta_datos['datos'];

					$htmlDatosTabla = "";
					for ($i = 0; $i < count($arr_datos); $i++) {
						$boton_editar = "";
						$boton_eliminar = "";

						if (empty($arr_datos[$i]['nombre_evento'])) {
							$arr_datos[$i]['nombre_evento'] = $arr_datos[$i]['evento_opcional'];
						}

						if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Formulario'])) {
							$boton_editar = '<button type="button" class="btn btn-danger btn-sm abrir" data-id="' . $arr_datos[$i]['id_formulario'] . '" onClick="editarFormulario(' . $arr_datos[$i]['id_formulario'] . ')" title="Editar"><i class="fas fa-edit"></i></button>';
						}
						if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Formulario'])) {
							$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar_formulario(' . $arr_datos[$i]['id_formulario'] . ')" title="Eliminar"><i class="fas fa-trash"></i></button>';
						}
						$boton_detalle = '<button type="button" class="btn btn-primary btn-sm" onClick="verFormulario(' . $arr_datos[$i]['id_formulario'] . ')" title="Ver detalles"><i class="fas fa-eye"></i></button>';

						//agregamos los botones
						$arr_datos[$i]['acciones'] = '<div class="text-center"> ' . $boton_editar . ' ' . $boton_eliminar . ' ' . $boton_detalle . '</div>';
						$htmlDatosTabla .= '<tr>
												<td>' . $arr_datos[$i]['id_formulario'] . '</td>
												<td>' . $arr_datos[$i]['nombre_formulario'] . '</td>
												<td>' . $arr_datos[$i]['apellido_formulario'] . '</td>
												<td>' . $arr_datos[$i]['fecha_evento'] . '</td>
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
        			EDITAR REGISTROS
        =======================================================*/

	public  function fechaReducida($fecha_evento)
	{
		$fechas = explode(',', $fecha_evento);
		$fechas2 = [];
		for ($i = 0; $i < count($fechas); $i++) {
			$fechas2[$i] = explode('/', $fechas[$i]);
		}

		// Obtenemos los meses
		$meses = [];
		for ($j = 0; $j < count($fechas2); $j++) {

			$meses[$j] = $fechas2[$j][1];
		}

		// eliminamos los meses duplicados
		$meses = array_values(array_unique($meses));

		// Concatenamos las fechas con las que matchean los meses
		$fechaReducida = '';
		for ($k = 0; $k < count($meses); $k++) {
			for ($l = 0; $l < count($fechas2); $l++) {
				// var_dump(in_array($meses[$k], $fechas2[$l]));
				// die();
				if (in_array($meses[$k], $fechas2[$l])) {
					if ($l == 0) {
						$fechaReducida .= $fechas2[$l][0];
					} else {
						$fechaReducida .= ', ' . $fechas2[$l][0];
					}
					// echo ($fechas2[$l][0]);
				}
			}
			// si es la ultima iteracion del mes concatenamos el mes
			$ultimaIteracion = $k + 1;
			if ($ultimaIteracion < count($meses)) {
				$fechaReducida .= ' de ' . $meses[$k];
			} else {
				$fechaReducida .= ' de ' . $meses[$k] . ' de ' . $fechas2[0][2];
			}
		}
		return $fechaReducida;
	}


	public function editar()
	{



		$token = $_GET['token'];
		$validar_token = $this->modelo->validar_token($token);

		if ($validar_token['estado'] == 1) { //el token no esta expirado
			if ($_POST) {
				$idformulario = intval($_POST['id']);
				$nombre =  limpiar($_POST['nombre']);
				$apellido =  limpiar($_POST['apellido']);
				$idparticipacion = intval($_POST['participacion']);
				$idevento = intval($_POST['evento']);
				$fecha_evento = limpiar($_POST['fecha_evento']);
				$lugar_evento = limpiar($_POST['lugar_evento']);
				$fecha_expedicion = limpiar($_POST['fecha_expedicion']);

				if (isset($_POST['evento_opcional'])) {
					$evento_opcional = ($_POST['evento_opcional']);
					$idevento = null;
				} else {
					$evento_opcional = null;
				}

				// $fechaReducida = self::fechaReducida($fecha_evento);


				if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Formulario'])) {



					$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM formularios WHERE id != $idformulario AND nombres = '$nombre'");
					//imprimir($url_nombre);die();
					if ($existe_edicion['estado'] == true) {
						if (empty($existe_edicion['datos'])) {
							// $token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};
							// $url = "roles?token=".$token."&tabla=usuarios&sufijo=usuario&nombreid=id_rol&id=".$idrol;
							// $campos = array("nombres" => $nombre, "apellidos" => $apellido, "id_tipo_participacion" => $idparticipacion, "id_evento" => $idevento, "nombre_evento_opcional" => $evento_opcional, "fecha_evento" => $fechaReducida, "lugar_evento" => $lugar_evento, "fecha_expedicion" => $fecha_expedicion);
							$campos = array("nombres" => $nombre, "apellidos" => $apellido, "id_tipo_participacion" => $idparticipacion, "id_evento" => $idevento, "nombre_evento_opcional" => $evento_opcional, "lugar_evento" => $lugar_evento, "fecha_expedicion" => $fecha_expedicion);

							//if (isset($_SESSION['permisos_'.nombreproyecto()]['Editar Roles'])) {
							$editar = $this->modelo->editar("formularios", $campos, 'id', $idformulario);
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
							$respuesta = array("estado" => false, "msg" => "El formulario ya existe.");
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Editar Formulario'])) {
				if ($_POST) {
					$idformulario = intval($_POST['id']);


					//if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Roles'])) {
					$datos = $this->modelo->seleccionar_unico_sql("SELECT * FROM formularios WHERE id = $idformulario");
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
			if (isset($_SESSION['permisos_' . nombreproyecto()]['Dar de baja Empleado'])) {
				if ($_POST) {
					$idempleado = intval($_POST['id']);

					//if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Roles'])) {
					$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM expediente 
																				WHERE id_tutor = $idempleado");
					//}
					//imprimir($existe);die();
					if ($existe['estado'] == true) {
						if (empty($existe['datos'])) {
							//$token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};

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
						} else {
							$respuesta = array("estado" => false, "msg" => "No se puede eliminar ya que está asociado en el expediente.");
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
