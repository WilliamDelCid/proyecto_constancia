<?php 
    require_once "vendor/autoload.php";
    use Firebase\JWT\JWT;

	class login extends controladores{
		public function __construct()
		{
			session_start();
			if (isset($_SESSION['login_'.nombreproyecto()])) {
				header('location: '.url_base().'/inicio');
			}
			parent::__construct();
		}

		public function login()
		{
			$datos_vista['titulo_ventana'] = "Login";
			$datos_vista['titulo_pagina'] = "Login";
			$datos_vista['nombre_pagina'] = "login";
			$datos_vista['archivo_funciones'] = "js_login.js";
			$this->vista->obtener_vista($this,"login", $datos_vista);
		}

		public function olvidaste_contraseña()
		{
			$datos_vista['titulo_ventana'] = "Login";
			$datos_vista['titulo_pagina'] = "Login";
			$datos_vista['nombre_pagina'] = "login";
			$datos_vista['archivo_funciones'] = "js_login.js";
			$this->vista->obtener_vista($this,"olvidaste-contraseña", $datos_vista);
		}

		public function plantilla()
		{
			$datos_vista['titulo_ventana'] = "Login";
			$datos_vista['titulo_pagina'] = "Login";
			$datos_vista['nombre_pagina'] = "login";
			$datos_vista['archivo_funciones'] = "js_login.js";
			$this->vista->obtener_vista($this,"plantilla-correo-restablecer", $datos_vista);
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
						echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
						die();
					}else{ //SI EXISTE
						//si existe una contraseña
						if($existe_usuario['datos']['password'] != null){
							$contra_encriptada = crypt($contra, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH
							//imprimir($existe_usuario['datos']['password']);
							//imprimir($contra_encriptada);die();
							//comparo la contraseña
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
									if ($datos_sesion['estado'] == true AND $datos_sesion2['estado'] == true) {
										unset($datos_sesion['datos']['token']); //elimino el token del array de usuario
										unset($datos_sesion['datos']['token_exp']); //elimino la expiracion del array de usuario
										$arr_datos_sesion = array_merge($datos_sesion['datos'], $datos_sesion2['datos'], $datos_sesion3['datos']);
										

										unset($arr_datos_sesion['token_exp']); //elimino la expiracion del array
										//CREO LAS VARIABLES DE SESION
										$_SESSION['login_'.nombreproyecto()] = true;
										$_SESSION['login_datos_'.nombreproyecto()] = $arr_datos_sesion;
										//imprimir($_SESSION['login_datos_'.nombreproyecto()]);die();
										$respuesta = array("estado" => true, "msg" => "Inicio de Sesión correctamente");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}
								}else{
									$respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error al obtener datos de sesión.');
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
							}else{
								$respuesta = array("estado" => false, "msg" => "La contraseña es incorrecta.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
						}else{
							$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
							echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
							die();
						}
					}
				}else{
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}	
				
			}
		}

		public function enviar_correo_restablecer()
		{
			if ($_POST) {
				$correo = limpiar($_POST['txt_email_restablecer']);
				$existe_usuario = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE email = '$correo' AND estado = 1");
				
				if ($existe_usuario['estado'] == true) {
					$arr_datos = $existe_usuario['datos'];
					//SI NO EXISTE ESE USUARIO
					if (empty($arr_datos)) {
						$respuesta = array("estado" => false, "msg" => "No existe ese usuario.");
						echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
						die();
					}else{ //SI EXISTE
						
							//Creamos el token
							$token = $this->modelo->token_jwt($existe_usuario['datos']['id'], $existe_usuario['datos']['email']);
							//generamos el token JWT
							$llave = 'mi_contrasena_secreta_es_ues2022$';
							$jwt = JWT::encode($token, $llave, "HS256");
							//Actualizamos la base de datos con el token
							$datos_token = array(
								"token" => $jwt,
								"token_exp" => $token["exp"]
							);

							$idusuario = $existe_usuario['datos']['id'];
							$tipo_usuario = intval($existe_usuario['datos']['tipo_usuario']);
							//obtenemos el nombre de ese usuario
							if($tipo_usuario == 1){
								$id_personal_academico = intval($existe_usuario['datos']['id_personal_academico']);
								$obtener_nombre = $this->modelo->seleccionar_unico_sql("SELECT * FROM personal_academico WHERE id = $id_personal_academico");
								//imprimir($obtener_nombre);die();
								$nombre_usuario = $obtener_nombre['datos']['nombres'].' '.$obtener_nombre['datos']['apellidos'];
							}else if($tipo_usuario == 2){
								$id_integrante_admin = intval($existe_usuario['datos']['id_integrante_admin']);
								$obtener_nombre = $this->modelo->seleccionar_unico_sql("SELECT * FROM integrantes_comite_administrativos WHERE id = $id_integrante_admin");
								$nombre_usuario = $obtener_nombre['datos']['nombre'];
							}
							
							

							$url_recuperacion = url_base().'/login/confirmar_usuario/'.$correo.'/'.$jwt; //url que le mandara al correo para el reinicio de contra
							//preparando el correo para recuperar la cuenta
							$datos_usuario = array('nombre_usuario' => $nombre_usuario,
													'correo' => $correo,
													'asunto' => 'Recuperar Cuenta - '.NOMBRE_REMITENTE,
													'url_recuperacion' => $url_recuperacion);

							//actualiza el token en la base
							$editar = $this->modelo->editar("usuarios", $datos_token, "id", $existe_usuario['datos']['id']);
							//si se edito el token
							if ($editar['estado'] == true) {
								
								//enviar el email
								$enviar_correo = enviar_correo_phpmailer($datos_usuario, 'plantilla-correo-restablecer');
								//var_dump($enviar_correo);die();
								if ($enviar_correo) {
									$respuesta = array('estado' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña');
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}else{
									$respuesta = array('estado' => false, 'msg' => 'No es posible realizar el proceso, intenta mas tarde');
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
							}else{
								$respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
							
						
					}
				}else{
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}	
				
			}
		}

		public function confirmar_usuario(string $parametros){
			if (empty($parametros)) {
				header('Location: '.url_base());
			}else{
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
						echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
						die();
					}else{ //SI EXISTE
						$datos_vista['titulo_ventana'] = "Restablecer Contraseña";
						$datos_vista['titulo_pagina'] = "Restablecer Contraseña";
						$datos_vista['nombre_pagina'] = "restablecer_contraseña";
						$datos_vista['archivo_funciones'] = "js_login.js";
						$datos_vista['email'] = $correo;
						$datos_vista['token'] = $token;
						$datos_vista['idusuario'] = $existe_usuario['datos']['id'];
						$this->vista->obtener_vista($this,"restablecer_contraseña", $datos_vista);
							
							
						
					}
				}else{
					$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
					echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}


				
			}
			die();
		}

		public function restablecer_contraseña()
		{
	
		
			if ($_POST) {
				$idusuario= intval($_POST['id']);
				$token = limpiar($_POST['token']);
				$contra = limpiar($_POST['txt_rest_pass']);
				$contra2 = limpiar($_POST['txt_rest_pass2']);

				if($contra != $contra2){
					$respuesta = array("estado" => false, "msg" => "Las contraseñas no coinciden!");
					echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}else{
					$existe_usuario = $this->modelo->seleccionar_unico_sql("SELECT * FROM usuarios WHERE id = $idusuario AND token = '$token' AND estado = 1");

					if ($existe_usuario['estado'] == true) {
						$arr_datos = $existe_usuario['datos'];
						//SI NO EXISTE ESE USUARIO
						if (empty($arr_datos)) {
							$respuesta = array("estado" => false, "msg" => "No existe ese usuario.");
							echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
							die();
						}else{ //SI EXISTE
							$contra_encriptada = crypt($contra, '$2a$07$azybxcagsrp23425rpazybxcags098$'); //CRYPT_BLOWFISH
							$campos = array("password" => $contra_encriptada, "token" => "", "token_exp" => "");
							$editar = $this->modelo->editar("usuarios", $campos, 'id', $existe_usuario['datos']['id']);
							if ($editar['estado'] == true) {
								$respuesta = array("estado" => true, "msg" => "Se ha restablecido su contraseña");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}else{
								$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error. Intente mas tarde.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
								
							
						}
					}else{
						$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
						echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
						die();
					}
				}

				
				
				die();
			}
			
			
		}

	}


 ?>