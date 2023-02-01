<?php 

	class expediente extends controladores{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if (empty($_SESSION['login_'.nombreproyecto()])) {
				header('location: '.url_base().'/login');
			}

			$this->modelo->obtener_permisos_modulo(5, $_SESSION['login_datos_'.nombreproyecto()]['id_rol']);
			$this->modelo->obtener_permisos_todos($_SESSION['login_datos_'.nombreproyecto()]['id_rol']);
		}

		/*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
		public function expediente()
		{
			if (!isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) { //Si no existe ese permiso
				header('location: '.url_base().'/inicio');
			}

			$datos_vista['titulo_ventana'] = "Expediente";
			$datos_vista['titulo_pagina'] = "Expediente";
			$datos_vista['nombre_pagina'] = "expediente";
			$datos_vista['archivo_funciones'] = "js_expediente.js";
	
			$this->vista->obtener_vista($this,"listado_expedientes", $datos_vista);
		}


		public function ver_expediente($idexpediente)
		{
			if (!isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) { //Si no existe ese permiso
				header('location: '.url_base().'/inicio');
			}
			$id_expediente = intval($idexpediente);
			$datos = $this->modelo->seleccionar_unico_sql("SELECT *, (SELECT concat(nombres, ' ', apellidos) FROM empleados WHERE id = ex.id_tutor) AS tutor 
															FROM expediente ex 
															WHERE ex.id = $id_expediente AND ex.estado = 1");
			
			if ($datos['estado'] == true) {
				if (empty($datos['datos'])) {
					$datos_vista['titulo_ventana'] = "Error";
					$datos_vista['titulo_pagina'] = "Ocurrió un error al recuperar información";
					$datos_vista['nombre_pagina'] = "error";
					$datos_vista['mensaje_pagina'] = "Ocurrió un error al recuperar información";
					$this->vista->obtener_vista($this,"error", $datos_vista);
				}else{
					/////////////////////////////////////////////////////////
					//OBTENGO TODAS LAS AREAS DEL EXPEDIENTE
					$nav_tabs_areas = '';
					$div_tab_por_area = '';
					$inicializacion_de_tablas = '';
					$areas = $this->modelo->seleccionar_todos_sql("SELECT * FROM areas_expediente WHERE estado = 1 ORDER BY id");
					if ($areas['estado'] == true){
						if (empty($areas['datos'])) {
							$datos_vista['titulo_ventana'] = "Error";
							$datos_vista['titulo_pagina'] = "Ocurrió un error al recuperar información";
							$datos_vista['nombre_pagina'] = "error";
							$datos_vista['mensaje_pagina'] = "Ocurrió un error al recuperar información";
							$this->vista->obtener_vista($this,"error", $datos_vista);
						}else{
							$arr_areas = $areas['datos'];
							//FOR DE LAS AREAS
							for ($i=0; $i < count($arr_areas); $i++) { 
								$idarea = $arr_areas[$i]['id'];
								//CREO LOS LINK DE TABS DE CADA AREA
								if($i == 0){
									$nav_tabs_areas .= '<li class="nav-item"><a class="nav-link active" href="#tab_'.$arr_areas[$i]['id'].'" data-toggle="tab">'.$arr_areas[$i]['nombre'].'</a></li>';
								}else{
									$nav_tabs_areas .= '<li class="nav-item"><a class="nav-link" href="#tab_'.$arr_areas[$i]['id'].'" data-toggle="tab">'.$arr_areas[$i]['nombre'].'</a></li>';
								}
								
								//INICIO EL TAB PARA EL AREA
								if($i == 0){
									$div_tab_por_area .= '<!--tab-pane -->
													  <div class="active tab-pane" id="tab_'.$arr_areas[$i]['id'].'">
													  <button type="button" class="btn btn-danger" onClick="fnt_agregar_anexo('.$arr_areas[$i]['id'].')" title="Agregar anexo">Nuevo anexo</button>
													  <br><br>';
								}else{
									$div_tab_por_area .= '<!--tab-pane -->
													  <div class="tab-pane" id="tab_'.$arr_areas[$i]['id'].'">
													  <button type="button" class="btn btn-danger" onClick="fnt_agregar_anexo('.$arr_areas[$i]['id'].')" title="Agregar anexo">Nuevo anexo</button>
													  <br><br>';
								}
								
								//OBTENGO LOS APARTADOS POR CADA AREA
								$apartados = $this->modelo->seleccionar_todos_sql("SELECT * FROM apartado_area WHERE estado = 1 AND id_area = $idarea ORDER BY id");
								//imprimir($apartados);die();
								if ($apartados['estado'] == true){
									if (!empty($apartados['datos'])) {
										
										$arr_apartados_por_area = $apartados['datos'];
										//FOR DE LOS APARTADOS POR AREA
										for ($j=0; $j < count($arr_apartados_por_area); $j++) {
											//CREO CADA ACORDEON
											$id_apartado_area = $arr_apartados_por_area[$j]['id'];
											$div_tab_por_area .= '<!--acordeon -->
																<div id="accordion_apart_'.$arr_apartados_por_area[$j]['id'].'_area_'.$arr_areas[$i]['id'].'">
																	<div class="card card-danger">
																		<div class="card-header">
																		<h4 class="card-title w-100">
																			<a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse_apart_'.$arr_apartados_por_area[$j]['id'].'_area_'.$arr_areas[$i]['id'].'" aria-expanded="false">
																			'.$arr_apartados_por_area[$j]['nombre'].'
																			</a>
																		</h4>
																		</div>
																		<div id="collapse_apart_'.$arr_apartados_por_area[$j]['id'].'_area_'.$arr_areas[$i]['id'].'" class="collapse" data-parent="#accordion_apart_'.$arr_apartados_por_area[$j]['id'].'_area_'.$arr_areas[$i]['id'].'">
																			
																			<div class="card-body">
																				
																				<div class="table-responsive">
																					<table class="table align-items-center table-hover" id="tabla_'.$arr_apartados_por_area[$j]['id'].'_area_'.$arr_areas[$i]['id'].'">
																						<thead class="bg-light">
																							<tr>
																								<th>Título</th>
																								<th>Descripcion</th>
																								<th>Fecha</th>
																								<th>Acciones</th>
																							</tr>
																						</thead>
																						<tbody>';
												//OBTENGO LOS APARTADOS POR CADA AREA
												$anexos_apartados = $this->modelo->seleccionar_todos_sql("SELECT 
																										exp.id as id_expediente,
																										exp.nombres as nombres_expediente,
																										exp.apellidos as apellidos_expediente,
																										det_exp.id as id_detalle_expediente,
																										det_exp.titulo as titulo_detalle,
																										det_exp.descripcion as descripcion_detalle,
																										det_exp.fecha as fecha_detalle,
																										apar.id as id_apartado_area,
																										apar.id_area as id_area 
																										FROM detalle_expediente det_exp
																										JOIN expediente exp ON exp.id = det_exp.id_expediente
																										JOIN apartado_area apar ON apar.id = det_exp.id_apartado_area
																										WHERE exp.id = $id_expediente AND apar.id_area = $idarea AND apar.id = $id_apartado_area
																										ORDER BY det_exp.fecha DESC");
												//imprimir($anexos_apartados);die();
												if ($anexos_apartados['estado'] == true){
													if (!empty($anexos_apartados['datos'])) {
														$arr_anexos_apartados_por_area = $anexos_apartados['datos'];
														//FOR DE LOS APARTADOS POR AREA
														for ($k=0; $k < count($arr_anexos_apartados_por_area); $k++) {
															$div_tab_por_area .= '<tr>
																					<td>'.$arr_anexos_apartados_por_area[$k]['titulo_detalle'].'</td>
																					<td>'.$arr_anexos_apartados_por_area[$k]['descripcion_detalle'].'</td>
																					<td>'.formatear_fecha($arr_anexos_apartados_por_area[$k]['fecha_detalle']).'</td>
																					<td>
																						<div class="text-center">
																							<button id="btn_ver_anexo_apar_area" onClick="fnt_ver_anexo('.$arr_anexos_apartados_por_area[$k]['id_detalle_expediente'].')" type="button" class="btn btn-'.COLOR_SIDEBAR_ACTIVO.' btn-sm"><i class="fas fa-eye"></i></button>
																						</div>
																					</td>
																				</tr>';
														}
													}
												}else{
													$datos_vista['titulo_ventana'] = "Error";
													$datos_vista['titulo_pagina'] = "Ocurrió un error al recuperar información";
													$datos_vista['nombre_pagina'] = "error";
													$datos_vista['mensaje_pagina'] = "Ocurrió un error al recuperar información";
													$this->vista->obtener_vista($this,"error", $datos_vista);
												}
																							
																						
															$div_tab_por_area .=		'</tbody>
																					</table>
																				
																				</div>
													
																			</div>
																		</div>
																	</div>
																</div> 
																<!-- /.acordeon -->';
											$inicializacion_de_tablas .= 'tabla_'.$arr_apartados_por_area[$j]['id'].'_area_'.$arr_areas[$i]['id'].';';
											
										}//FIN FOR DE LOS APARTADOS POR AREA
										
										
									}
								}else{
									$datos_vista['titulo_ventana'] = "Error";
									$datos_vista['titulo_pagina'] = "Ocurrió un error al recuperar información";
									$datos_vista['nombre_pagina'] = "error";
									$datos_vista['mensaje_pagina'] = "Ocurrió un error al recuperar información";
									$this->vista->obtener_vista($this,"error", $datos_vista);
								}
								//TERMINO EL TAB PARA EL AREA
								$div_tab_por_area .= '</div>
								<!-- /.tab-pane -->';
							}//FIN FOR DE LAS AREAS
							
						}
					}else{
						$datos_vista['titulo_ventana'] = "Error";
						$datos_vista['titulo_pagina'] = "Ocurrió un error al recuperar información";
						$datos_vista['nombre_pagina'] = "error";
						$datos_vista['mensaje_pagina'] = "Ocurrió un error al recuperar información";
						$this->vista->obtener_vista($this,"error", $datos_vista);
					}

					$datos_vista['titulo_ventana'] = "Expediente";
					$datos_vista['titulo_pagina'] = "Expediente";
					$datos_vista['nombre_pagina'] = "expediente";
					$datos_vista['id_expediente'] = $id_expediente;
					$datos_vista['datos_generales'] = $datos['datos'];
					$datos_vista['nav_tabs_areas'] = $nav_tabs_areas;
					$datos_vista['div_tab_por_area'] = $div_tab_por_area;
					$inicializacion_de_tablas = substr($inicializacion_de_tablas, 0, -1); //quitando la ultima coma
					$datos_vista['inicializacion_de_tablas'] = $inicializacion_de_tablas;
					$datos_vista['archivo_funciones'] = "js_verexpediente.js";
			
					$this->vista->obtener_vista($this,"expediente", $datos_vista);
				}
				
			}else{
				$datos_vista['titulo_ventana'] = "Error";
				$datos_vista['titulo_pagina'] = "Ocurrió un error al recuperar información";
				$datos_vista['nombre_pagina'] = "error";
				$datos_vista['mensaje_pagina'] = "Ocurrió un error al recuperar información";
				$this->vista->obtener_vista($this,"error", $datos_vista);
			}
			
		}

		/*=======================================================
        			LISTADO DE REGISTROS
        =======================================================*/
		public function listar()
		{
			//imprimir(token_sesion());die();
			$token = $_GET['token'];
			$validar_token = $this->modelo->validar_token($token);
			
			if($validar_token['estado'] == 1){ //el token no esta expirado

				if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) {
					$consulta_datos = $this->modelo->seleccionar_todos_sql("SELECT * FROM expediente WHERE estado != 0");
					if ($consulta_datos['estado'] == true) {
						$num_registros = $consulta_datos['cuantos'];
						$arr_datos = $consulta_datos['datos'];
	
						$htmlDatosTabla = "";
						for ($i=0; $i < $num_registros; $i++) {
							$boton_ver = "";
							$boton_editar = "";
							$boton_eliminar = "";
	
							if($arr_datos[$i]['estado'] == 1)
							{
								$arr_datos[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
							}else{
								$arr_datos[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
							}
	
							
							if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) {
								$boton_ver = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_editar_areas('.$arr_datos[$i]['id'].')" title="Ir a editar áreas"><i class="fas fa-file-import"></i></button>';
							}
							if (isset($_SESSION['permisos_'.nombreproyecto()]['Editar Expediente'])) {
								$boton_editar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_editar('.$arr_datos[$i]['id'].')" title="Editar"><i class="fas fa-edit"></i></button>';
							}
							if (isset($_SESSION['permisos_'.nombreproyecto()]['Dar de baja Expediente'])) {
								$boton_eliminar = '<button type="button" class="btn btn-danger btn-sm" onClick="fnt_eliminar('.$arr_datos[$i]['id'].')" title="Eliminar"><i class="fas fa-trash"></i></button>';
							}
							//agregamos los botones
							$arr_datos[$i]['acciones'] = '<div class="text-center">'.$boton_ver.' '.$boton_editar.' ' .$boton_eliminar.'</div>';
							$htmlDatosTabla.='<tr>
												<td>'.$arr_datos[$i]['codigo'].'</td>
												<td>'.$arr_datos[$i]['nombres'].'</td>
												<td>'.$arr_datos[$i]['apellidos'].'</td>
												<td>'.$arr_datos[$i]['estado'].'</td>
												<td>'.$arr_datos[$i]['acciones'].'</td>
											  </tr>';
						}
						
						$arr_respuesta = array('estado' => true, 'tabla' => $htmlDatosTabla);
					}else{
						$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
					}
					
					echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
				}else{
					$arr_respuesta = array("estado" => false, "msg" => 'Ops. No tiene permisos para ver.');
					echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
				}
				die();

			}else if($validar_token['estado'] == 2){ //el token esta expirado
				$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}else if($validar_token['estado'] == 0){ //el token no existe
				$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
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
			
			if($validar_token['estado'] == 1){ //el token no esta expirado
				if ($_POST) {
					
					$idexpediente = intval($_POST['id']);
					$codigo =  limpiar($_POST['codigo']);
					$nombres =  limpiar($_POST['nombres']);
					$apellidos =  limpiar($_POST['apellidos']);
					$fechanac =  limpiar($_POST['fechanac']);
					$turno = intval($_POST['turno']);
					$grupoedad =  limpiar($_POST['grupo_edad']);
					$genero =  intval($_POST['genero']);
					$idtutor = intval($_POST['tutor']);
					$estado = intval($_POST['estado']);

					//dias de la semana
					$horario = "";

					if(isset($_POST['lunes'])){$horario .= "Lunes - ";}
					if(isset($_POST['martes'])){$horario .= "Martes - ";}
					if(isset($_POST['miercoles'])){$horario .= "Miércoles - ";}
					if(isset($_POST['jueves'])){$horario .= "Jueves - ";}
					if(isset($_POST['viernes'])){$horario .= "Viernes - ";}
					$horario = substr($horario, 0, -2); //quitando el ultimo guion y espcio
					//imprimir($horario);die();
					if ($idexpediente == 0) { //Es una inserción
						if (isset($_SESSION['permisos_'.nombreproyecto()]['Crear Expediente'])) {
							$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM expediente WHERE codigo = '$codigo'");
							//imprimir($existe);die();
							if ($existe['estado'] == true) {
								if (empty($existe['datos'])) {

									$campos = array("codigo" => $codigo, 
													"nombres" => $nombres,
													"apellidos" => $apellidos,
													"fecha_nacimiento" => $fechanac,
													"grupo_edad" => $grupoedad,
													"genero" => $genero,
													"id_tutor" => $idtutor,
													"turno" => $turno,
													"horario" => $horario,
													"estado" => $estado
												);
									$insertar = $this->modelo->insertar("expediente", $campos);
									
									if ($insertar['estado'] == true) {
										//SI EXISTE FOTO
										if (empty($_FILES['foto_exp']['name'])) {
											$respuesta = array("estado" => true, "msg" => "Se registró el usuario pero no se subió foto.");
											echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
											die();
										}else{
											$foto = $_FILES['foto_exp'];
											$imgNombre = 'exp_'.limpiar($insertar['idcreado']).'_'.md5(date('d-m-Y H:i:s')).'.jpg';
											$urlcorta = 'vistas/expediente/fotos/' . $imgNombre;
											$url = $_SERVER['DOCUMENT_ROOT'] . '/'.nombreproyecto_real().'/'.$urlcorta;
											try {
												$subir_imagen = subir_imagen($foto, $url);
											} catch (Exception $e) {
												$respuesta = array("estado" => true, "msg" => "Se registró el usuario pero ocurrió un error al subir la foto.");
												echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
												die();
											}
											
											//SI SE SUBIO LA FOTO
											if($subir_imagen){
												//INGRESO LA URL DE LA FOTO A LA TABLA
												
												$campos = array("foto_url"=> $urlcorta);
												$ingresar_url = $this->modelo->editar("expediente", $campos, "id", $insertar['idcreado']);
											
												if ($ingresar_url['estado'] == true) {
													$respuesta = array("estado" => true, "msg" => "Se registraron los datos correctamente.");
													echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
													die();
												}else{
													$respuesta = array("estado" => false, "msg" => "Se registró el usuario pero ocurrió un error al subir la foto.");
													echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
													die();
												}

												
											}else{
												$respuesta = array("estado" => false, "msg" => "Se registró el usuario pero ocurrió un error al subir la foto.");
												echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
												die();
											}

										}
									}else{
										$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}

								}else{
									$respuesta = array("estado" => false, "msg" => "El Expediente ya existe.");
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
								
							}else{
								$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
						}else{
							$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para insertar.");
							echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
							die();
						}
					}else{ //actualizacion
						if (isset($_SESSION['permisos_'.nombreproyecto()]['Editar Expediente'])) {
							$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM expediente WHERE codigo = '$codigo' AND id != $idexpediente");
							
							if ($existe_edicion['estado'] == true) {
								if (empty($existe_edicion['datos'])) {
									$campos = array("codigo" => $codigo, 
													"nombres" => $nombres,
													"apellidos" => $apellidos,
													"fecha_nacimiento" => $fechanac,
													"grupo_edad" => $grupoedad,
													"genero" => $genero,
													"id_tutor" => $idtutor,
													"turno" => $turno,
													"horario" => $horario,
													"estado" => $estado
												);
									$editar = $this->modelo->editar("expediente", $campos, 'id', $idexpediente);
									//imprimir($editar);die();
									if ($editar['estado'] == true) {
										//SI EXISTE LA VARIABLE SE SUBIRA LA FOTO
										if (empty($_FILES['foto_exp']['name'])) {
											$respuesta = array("estado" => true, "msg" => "Se editó el usuario pero no se subió foto.");
											echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
											die();
										}else{
											$foto = $_FILES['foto_exp'];
											$imgNombre = 'exp_'.limpiar($idexpediente).'_'.md5(date('d-m-Y H:i:s')).'.jpg';
											$urlcorta = 'vistas/expediente/fotos/' . $imgNombre;
											$url = $_SERVER['DOCUMENT_ROOT'] . '/'.nombreproyecto_real().'/'.$urlcorta;
											try {
												$subir_imagen = subir_imagen($foto, $url);
											} catch (Exception $e) {
												$respuesta = array("estado" => true, "msg" => "Se editó el usuario pero ocurrió un error al subir la foto.");
												echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
												die();
											}
											
											//SI SE SUBIO LA FOTO
											if($subir_imagen){
												//OBTENGO LA URL DE LA FOTO QUE TENIA, SI ES QUE HABIA Y ELIMINO ESA FOTO
												$obtener_foto = $this->modelo->seleccionar_unico_sql("SELECT foto_url FROM expediente WHERE id = $idexpediente");
												if ($obtener_foto['estado'] == true) {
													$arr_datos = $obtener_foto['datos'];
													//SI EXISTE URL FOTO ELIMINO ESA FOTO
													if (!empty($arr_datos)) {
														if (file_exists("".$arr_datos['foto_url'])) { //si el archivo existe
															unlink("".$arr_datos['foto_url']);
														}
													}

												}
												
												//INGRESO LA URL DE LA FOTO A LA TABLA
												$campos = array("foto_url"=> $urlcorta);
												$ingresar_url = $this->modelo->editar("expediente", $campos, "id", $idexpediente);
											
												if ($ingresar_url['estado'] == true) {
													$respuesta = array("estado" => true, "msg" => "Se editaron los datos correctamente.");
													echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
													die();
												}else{
													$respuesta = array("estado" => false, "msg" => "Se editó el usuario pero ocurrió un error al subir la foto.");
													echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
													die();
												}

												
											}else{
												$respuesta = array("estado" => false, "msg" => "Se editó el usuario pero ocurrió un error al subir la foto.");
												echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
												die();
											}

										}
									}else{
										$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}
								}else{
									$respuesta = array("estado" => false, "msg" => "El Expediente ya existe.");
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
							}else{
								$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
						}else{
							$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para editar.");
							echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
							die();
						}
					} //else actualizacion

				}// if ($_POST)
			}else if($validar_token['estado'] == 2){ //el token esta expirado
				$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}else if($validar_token['estado'] == 0){ //el token no existe
				$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		/*=======================================================
        			OBTENER REGISTRO ESPECIFICO
        =======================================================*/
		public function ver_anexo_expediente($id)
		{
			$token = $_GET['token'];
			$validar_token = $this->modelo->validar_token($token);
			$id_det_exp = intval($id);
			if($validar_token['estado'] == 1){ //el token no esta expirado
				if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) {
					if ($_POST) {
						$idexpediente = intval($_POST['id']);
						$datos = $this->modelo->seleccionar_unico_sql("SELECT 
														exp.id as id_expediente,
														exp.nombres as nombres_expediente,
														exp.apellidos as apellidos_expediente,
														det_exp.id as detalle_expediente,
														det_exp.titulo as titulo_detalle,
														det_exp.descripcion as descripcion_detalle,
														det_exp.fecha as fecha_detalle,
														apar.id as id_apartado_area,
														apar.nombre as nombre_apartado,
														apar.id_area as id_area,
														area.nombre as nombre_area
														FROM detalle_expediente det_exp
														JOIN expediente exp ON exp.id = det_exp.id_expediente
														JOIN apartado_area apar ON apar.id = det_exp.id_apartado_area
														JOIN areas_expediente area on area.id = apar.id_area
														WHERE det_exp.id = $id_det_exp");
						
						if ($datos['estado'] == true) {
							if (empty($datos['datos'])) {
								$respuesta = array("estado" => false, "msg" => "Ops. No se encontraron los datos.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}else{
								$datos['datos']['fecha_detalle'] = formatear_fecha($datos['datos']['fecha_detalle']);
								$carrusel = "";
								$slides = "";
								$items = "";
								$imagenes = $this->modelo->seleccionar_todos_sql("SELECT * FROM archivos_detalle_expediente WHERE id_detalle_expediente = $id_det_exp AND tipo_archivo = '.jpg'");
								if ($imagenes['estado'] == true) {
									if (empty($imagenes['datos'])) { //es porque la consulta no trae nada, ni imagenes ni pdf
										$carrusel = "No hay fotografías agregadas";
									}else{
										$arr_imagenes = $imagenes['datos'];
										
										for ($i=0; $i < count($arr_imagenes); $i++) { 
											
												if($i == 0){
													$slides .= '<li data-target="#carousel-1" data-slide-to="0" class="active"></li>';
													$items .= '<div class="carousel-item active">
																	<img src="'.url_base().'/'.$arr_imagenes[$i]['url'].'" class="d-block w-100" alt="">
																	<div class="carousel-caption d-none d-md-block">
																		<button type="button" class="btn btn-danger">Eliminar foto</button>
																	</div>
																</div>';
												}else{
													$slides .= '<li data-target="#carousel-1" data-slide-to="'.$i.'"></li>';
													$items .= '<div class="carousel-item">
																	<img src="'.url_base().'/'.$arr_imagenes[$i]['url'].'" class="d-block w-100" alt="">
																	<div class="carousel-caption d-none d-md-block">
																		<button type="button" class="btn btn-danger">Eliminar foto</button>
																	</div>
																</div>';
												}
											
											
										} //fin for imagenes y archivos
										
											$carrusel .= '<div class="container justify-content-center">
														<div id="carousel-1" class="carousel slide" data-ride="carousel">
															<ol class="carousel-indicators">
																'.$slides.'
															</ol>
															<div class="carousel-inner" role="listbox">
																'.$items.'
															</div>
															
														</div>
													</div>';
										
										
									}
								}else{
									$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
								$respuesta = array("estado" => true, "datos" => $datos['datos'], "carrusel_img" => $carrusel);
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
					$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
					echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}
			}else if($validar_token['estado'] == 2){ //el token esta expirado
				$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}else if($validar_token['estado'] == 0){ //el token no existe
				$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
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
			
			if($validar_token['estado'] == 1){ //el token no esta expirado
				if (isset($_SESSION['permisos_'.nombreproyecto()]['Dar de baja Expediente'])) {
					if ($_POST) {
						$id = intval($_POST['id']);

						$existe = $this->modelo->seleccionar_unico_sql("SELECT * FROM expediente WHERE id = $id");
						
						if ($existe['estado'] == true) {
							if (!empty($existe['datos'])) {
								//imprimir($existe);die();
								$arr_datos = $existe['datos'];
									$campos = array("estado"=> 0, "foto_url" => "");
									$eliminar = $this->modelo->editar("expediente", $campos, "id", $id);
								
									if ($eliminar['estado'] == true) {

										//SI EXISTE URL FOTO ELIMINO ESA FOTO
										if (!empty($arr_datos)) {
											if (file_exists("".$arr_datos['foto_url'])) { //si el archivo existe
												unlink("".$arr_datos['foto_url']);
											}
										}
			
										$respuesta = array("estado" => true, "msg" => "Se ha eliminado el usuario");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}else{
										$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}
							}else{
									$respuesta = array("estado" => false, "msg" => "No se puede eliminar.");
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
					$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para dar de baja.");
					echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}
			}else if($validar_token['estado'] == 2){ //el token esta expirado
				$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}else if($validar_token['estado'] == 0){ //el token no existe
				$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		
		/*=======================================================
        			LISTAR LOS SELECT PARA FORMULARIO
        =======================================================*/
		public function listar_selects()
		{
			if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) {
				$htmlEmpleados = "";
				
				$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM empleados WHERE estado = 1 AND id_cargo = 1");
				if ($consulta_datos2['estado'] == true) {
					$arr_datos2 = $consulta_datos2['datos'];

					for ($i=0; $i < count($arr_datos2); $i++) { 
						$htmlEmpleados .= '<option value="'.$arr_datos2[$i]['id'].'">'.$arr_datos2[$i]['nombres'].' '.$arr_datos2[$i]['apellidos'].'</option>';
					}
					
				}else{
					$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
					echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}

				$arr_respuesta = array("estado" => true, 'tutores' => $htmlEmpleados);
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
				die();
			}else{
				$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
				die();
			}
			die();		
		}

		public function listar_select_apartado_area($idarea)
		{
			if (isset($_SESSION['permisos_'.nombreproyecto()]['Ver Expediente'])) {
				$htmlApar = "";
				$id_area = intval($idarea);
				$consulta_datos2 = $this->modelo->seleccionar_todos_sql("SELECT * FROM apartado_area WHERE estado = 1 AND id_area = $id_area");
				if ($consulta_datos2['estado'] == true) {
					$arr_datos2 = $consulta_datos2['datos'];

					for ($i=0; $i < count($arr_datos2); $i++) { 
						$htmlApar .= '<option value="'.$arr_datos2[$i]['id'].'">'.$arr_datos2[$i]['nombre'].'</option>';
					}
					
				}else{
					$arr_respuesta = array("estado" => false, "msg" => 'Ops. Ocurrió un error.');
					echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
					die();
				}

				$arr_respuesta = array("estado" => true, 'apartados' => $htmlApar);
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
				die();
			}else{
				$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para ver.");
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
				die();
			}
			die();		
		}

		public function insertar_anexo_area()
		{
			$token = $_GET['token'];
			$validar_token = $this->modelo->validar_token($token);
			
			if($validar_token['estado'] == 1){ //el token no esta expirado
				if ($_POST) {
					
					$idanexo = intval($_POST['idanexo']);
					$idexpediente = intval($_POST['idarea_expediente']);
					$idapartado = intval($_POST['apartado_area']);
					$idarea = intval($_POST['idarea']);
					$titulo =  limpiar($_POST['titulo']);
					$descripcion =  limpiar($_POST['descripcion']);
					$fecha =  limpiar($_POST['fecha']);
					
					
					//imprimir($_POST);die();
					if ($idanexo == 0) { //Es una inserción
						if (isset($_SESSION['permisos_'.nombreproyecto()]['Crear Expediente'])) {
							$existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM detalle_expediente WHERE id_apartado_area = $idapartado AND id_expediente = $idexpediente AND titulo = '$titulo' AND descripcion = '$descripcion' AND fecha = '$fecha'");
							
							if ($existe['estado'] == true) {
								if (empty($existe['datos'])) {

									$campos = array("id_expediente" => $idexpediente, 
													"id_apartado_area" => $idapartado,
													"titulo" => $titulo,
													"descripcion" => $descripcion,
													"fecha" => $fecha
												);
									$insertar = $this->modelo->insertar("detalle_expediente", $campos);
									//imprimir($_POST);die();
									if ($insertar['estado'] == true) {
										$respuesta = array("estado" => true, "msg" => $insertar['respuesta'], "idcreado" => $insertar['idcreado'], "idarea" => $idarea, "idapartado" => $idapartado);
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}else{
										$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}

								}else{
									$respuesta = array("estado" => false, "msg" => "Ese detalle del expediente ya existe.");
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
								
							}else{
								$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
						}else{
							$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para insertar.");
							echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
							die();
						}
					}

				}// if ($_POST)
			}else if($validar_token['estado'] == 2){ //el token esta expirado
				$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}else if($validar_token['estado'] == 0){ //el token no existe
				$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function insertar_imagenes_anexo_area($iddetalleexp)
		{
			$token = $_GET['token'];
			$validar_token = $this->modelo->validar_token($token);
			$id_det_exp = intval($iddetalleexp);
			if($validar_token['estado'] == 1){ //el token no esta expirado
				if ($_FILES) {
					if (($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/jpg")
					|| ($_FILES["file"]["type"] == "application/pdf")) {

						$foto = $_FILES["file"];
						if(($_FILES["file"]["type"] == "image/pjpeg")
						|| ($_FILES["file"]["type"] == "image/jpeg")
						|| ($_FILES["file"]["type"] == "image/png")
						|| ($_FILES["file"]["type"] == "image/jpg")){
							$extension = '.jpg';
						}else if($_FILES["file"]["type"] == "application/pdf"){
							$extension = '.pdf';
						}
						$imgNombre = 'det_exp_'.limpiar($id_det_exp).'_'.md5(date('d-m-Y H:i:s')).$extension;
						$urlcorta = 'archivos/archivos_detalles_expedientes/' . $imgNombre;
						$url = $_SERVER['DOCUMENT_ROOT'] . '/'.nombreproyecto_real().'/'.$urlcorta;
						try {
							$subir_imagen = subir_imagen($foto, $url);
							if ($subir_imagen) {
								$campos = array("id_detalle_expediente"=> $id_det_exp,
												"tipo_archivo" => $extension,
												"url" => $urlcorta);
								$ingresar_url = $this->modelo->insertar("archivos_detalle_expediente", $campos);
								//imprimir($campos);die();
								if ($ingresar_url['estado'] == true) {
									echo 'si';
								}
								
							} else {
								echo 'no';
							}
						} catch (Exception $e) {
							echo 'no';
						}
						
					
				}
				}// if ($_FILES)
			}else if($validar_token['estado'] == 2){ //el token esta expirado
				$arr_respuesta = array("estado" => false, "msg" => 'Token expirado');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}else if($validar_token['estado'] == 0){ //el token no existe
				$arr_respuesta = array("estado" => false, "msg" => 'Token no existe');
				echo json_encode($arr_respuesta,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		
		
	}


 ?>