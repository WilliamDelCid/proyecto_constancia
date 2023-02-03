<?php

class crearformulario extends controladores
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
		if (!isset($_SESSION['permisos_' . nombreproyecto()]['Crear Formulario'])) {
			header('location: ' . url_base() . '/login');
		}
	}

	/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
	public function crearformulario()
	{

		$datos_vista['titulo_ventana'] = "Crear Formulario";
		$datos_vista['titulo_pagina'] = "Crear Formulario";
		$datos_vista['nombre_pagina'] = "Crear Formulario";
		$datos_vista['archivo_funciones'] = "js_crearformulario.js";
		$this->vista->obtener_vista($this, "crearformulario", $datos_vista);
	}

	/*=======================================================
        			COMBO CARGO
        =======================================================*/
	public function listarparticipacion()
	{
		if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Formulario'])) {
			$htmlC = "";
			$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM participacion 
																		WHERE participacion.estado = 1");
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
			$arr_respuesta = array("estado" => true, 'participacion' => $htmlC);
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
        			COMBO CARGO
        =======================================================*/
	public function listarevento()
	{
		if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Formulario'])) {
			$htmlC = "";
			$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM eventos 
																			WHERE eventos.estado = 1");
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
			$arr_respuesta = array("estado" => true, 'evento' => $htmlC);
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
        	FUNCION PARA GENERAR STRING DE FECHAS
	=======================================================*/


	public  function fechaReducida($fecha_evento)
	{
		// separamos las fechas
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
					$fechaReducida .= $fechas2[$l][0] . ', ';
					// echo ($fechas2[$l][0]);
				}
			}
			// si es la ultima iteracion del mes concatenamos el mes
			$ultimaIteracion = $k + 1;
			if ($ultimaIteracion < count($meses)) {
				$fechaReducida .= 'de ' . $meses[$k] . ' y ';
			} else {
				$fechaReducida .= 'de ' . $meses[$k];
			}
		}
		return $fechaReducida;
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
				$idformulario = intval($_POST['id']);
				$nombre =  limpiar($_POST['nombre']);
				$apellido =  limpiar($_POST['apellido']);
				$idparticipacion = intval($_POST['participacion']);
				$idevento = intval($_POST['evento']);
				$evento_opcional = intval($_POST['evento_opcional']);
				$fecha_evento = limpiar($_POST['fecha_evento']);
				$lugar_evento = limpiar($_POST['lugar_evento']);
				$fecha_expedicion = limpiar($_POST['fecha_expedicion']);

				if ($evento_opcional == 0) {
					$evento_opcional = null;
				}


				$fechaReducida = self::fechaReducida($fecha_evento);
				var_dump($fechaReducida);

				die();


				if (isset($_SESSION['permisos_' . nombreproyecto()]['Crear Formulario'])) {
					$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM formularios WHERE id = $idformulario");
					//imprimir($existe);die();
					if ($existe['estado'] == true) {
						if (empty($existe['datos'])) {

							//$token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};

							$campos = array("nombres" => $nombre, "apellidos" => $apellido, "id_tipo_participacion" => $idparticipacion, "id_evento" => $idevento, "nombre_evento_opcional" => $evento_opcional, "fecha_evento" => $fecha_evento, "lugar_evento" => $lugar_evento, "fecha_expedicion" => $fecha_expedicion);
							//if (isset($_SESSION['permisos_'.nombreproyecto()]['Crear Roles'])) {
							$insertar = $this->modelo->insertar("formularios", $campos);
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
					$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para insertar.");
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
}
