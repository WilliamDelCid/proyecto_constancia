<?php
require_once "vendor/autoload.php";

use Firebase\JWT\JWT;

class login extends controladores
{
	public function __construct()
	{
		session_start();
		if (isset($_SESSION['login_' . nombreproyecto()])) {
			header('location: ' . url_base() . '/inicio');
		}
		parent::__construct();
	}

	public function login()
	{
		$datos_vista['titulo_ventana'] = "Login";
		$datos_vista['titulo_pagina'] = "Login";
		$datos_vista['nombre_pagina'] = "login";
		$datos_vista['archivo_funciones'] = "js_login.js";
		$this->vista->obtener_vista($this, "login", $datos_vista);
	}

	public function olvidaste_contraseña()
	{
		$datos_vista['titulo_ventana'] = "Login";
		$datos_vista['titulo_pagina'] = "Login";
		$datos_vista['nombre_pagina'] = "login";
		$datos_vista['archivo_funciones'] = "js_login.js";
		$this->vista->obtener_vista($this, "olvidaste-contraseña", $datos_vista);
	}

	public function plantilla()
	{
		$datos_vista['titulo_ventana'] = "Login";
		$datos_vista['titulo_pagina'] = "Login";
		$datos_vista['nombre_pagina'] = "login";
		$datos_vista['archivo_funciones'] = "js_login.js";
		$this->vista->obtener_vista($this, "plantilla-correo-restablecer", $datos_vista);
	}

	public function iniciar_sesion()
	{
		if ($_POST) {
			$correo = limpiar($_POST['txt_email']);
			$contra = $_POST['txt_pass'];


			$existe_usuario = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE email = '$correo'");

			if ($existe_usuario['estado'] == true) {
				$arr_datos = $existe_usuario['datos'];
				//SI NO EXISTE ESE USUARIO
				if (empty($arr_datos)) {
					$respuesta = array("estado" => false, "msg" => "No existe ese usuario.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				} else { //SI EXISTE

					if ($existe_usuario['datos']['password'] != null) {
						$contra_encriptada = crypt($contra, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH

						if ($existe_usuario['datos']['password'] == $contra_encriptada) {

							//Creamos el token
							$token = $this->modelo->token_jwt($existe_usuario['datos']['id'], $existe_usuario['datos']['email']);
							//generamos el token JWT
							$llave = 'mi_contrasena_secreta_es_ues2022$';
							$jwt = JWT::encode($token, $llave, "HS256");
							//Actualizamos la base de datos con el token
							$datos_token = array(
								"token" => $jwt,
								"token_exp" => $token["exp"],
								"id_sesion" => session_id(),
								"id_usuario" => $existe_usuario['datos']['id']
							);
							//$editar = $this->modelo->editar("usuarios", $datos_token, "id", $existe_usuario['datos']['id']);
							$editar = $this->modelo->insertar("sesiones", $datos_token);

							//si se edito el token
							$idusuario = $existe_usuario['datos']['id'];
							if ($editar['estado'] == true) {
								//obtengo los datos de sesion
								$id_sesion_creado = $editar['idcreado'];
								$datos_sesion = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE id = $idusuario");
								$idrol = $datos_sesion['datos']['id_rol'];
								$datos_sesion3 = $this->modelo->seleccionar_unico_sql("SELECT nombre as nombrerol FROM roles WHERE id = $idrol");
								$datos_sesion2 = $this->modelo->seleccionar_unico_sql("SELECT id as idsesion, token, token_exp, id_sesion, id_usuario FROM sesiones WHERE id = $id_sesion_creado");
								if ($datos_sesion['estado'] == true and $datos_sesion2['estado'] == true) {
									unset($datos_sesion['datos']['token']); //elimino el token del array de usuario
									unset($datos_sesion['datos']['token_exp']); //elimino la expiracion del array de usuario
									$arr_datos_sesion = array_merge($datos_sesion['datos'], $datos_sesion2['datos'], $datos_sesion3['datos']);


									unset($arr_datos_sesion['token_exp']); //elimino la expiracion del array
									//CREO LAS VARIABLES DE SESION
									$_SESSION['login_' . nombreproyecto()] = true;
									$_SESSION['login_datos_' . nombreproyecto()] = $arr_datos_sesion;

									$respuesta = array("estado" => true, "msg" => "Inicio de Sesión correctamente");
									echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
									die();
								}
							} else {
								$respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error al obtener datos de sesión.');
								echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
								die();
							}
						} else {
							$respuesta = array("estado" => false, "msg" => "La contraseña es incorrecta.");
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
				$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
				echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
				die();
			}
		}
	}


	public function confirmar_usuario(string $parametros)
	{
		if (empty($parametros)) {
			header('Location: ' . url_base());
		} else {
			//obteniendo los parametros
			$array_parametros = explode(',', $parametros);
			$correo = limpiar($array_parametros[0]);
			$token = limpiar($array_parametros[1]);
			$existe_usuario = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE email = '$correo' AND token = '$token' AND estado = 1");

			if ($existe_usuario['estado'] == true) {
				$arr_datos = $existe_usuario['datos'];
				//SI NO EXISTE ESE USUARIO
				if (empty($arr_datos)) {
					$respuesta = array("estado" => false, "msg" => "No existe ese usuario.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				} else { //SI EXISTE
					$datos_vista['titulo_ventana'] = "Restablecer Contraseña";
					$datos_vista['titulo_pagina'] = "Restablecer Contraseña";
					$datos_vista['nombre_pagina'] = "restablecer_contraseña";
					$datos_vista['archivo_funciones'] = "js_login.js";
					$datos_vista['email'] = $correo;
					$datos_vista['token'] = $token;
					$datos_vista['idusuario'] = $existe_usuario['datos']['id'];
					$this->vista->obtener_vista($this, "restablecer_contraseña", $datos_vista);
				}
			} else {
				$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
				echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
				die();
			}
		}
		die();
	}

	public function restablecer_contraseña()
	{


		if ($_POST) {
			$idusuario = intval($_POST['id']);
			$token = limpiar($_POST['token']);
			$contra = limpiar($_POST['txt_rest_pass']);
			$contra2 = limpiar($_POST['txt_rest_pass2']);

			if ($contra != $contra2) {
				$respuesta = array("estado" => false, "msg" => "Las contraseñas no coinciden!");
				echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
				die();
			} else {
				$existe_usuario = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE id = $idusuario AND token = '$token' AND estado = 1");

				if ($existe_usuario['estado'] == true) {
					$arr_datos = $existe_usuario['datos'];
					//SI NO EXISTE ESE USUARIO
					if (empty($arr_datos)) {
						$respuesta = array("estado" => false, "msg" => "No existe ese usuario.");
						echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
						die();
					} else { //SI EXISTE
						$contra_encriptada = crypt($contra, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH
						$campos = array("password" => $contra_encriptada, "token" => "", "token_exp" => "");
						$editar = $this->modelo->editar("usuarios", $campos, 'id', $existe_usuario['datos']['id']);
						if ($editar['estado'] == true) {
							$respuesta = array("estado" => true, "msg" => "Se ha restablecido su contraseña");
							echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
							die();
						} else {
							$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error. Intente mas tarde.");
							echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
							die();
						}
					}
				} else {
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
					die();
				}
			}



			die();
		}
	}
}
