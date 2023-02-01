<?php


class eventHandler extends controladores{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login_'.nombreproyecto()])) {
            header('location: '.url_base().'/login');
        }

        $this->modelo->obtener_permisos_modulo(3, $_SESSION['login_datos_'.nombreproyecto()]['id_rol']);
        $this->modelo->obtener_permisos_todos($_SESSION['login_datos_'.nombreproyecto()]['id_rol']);
    }

    public function insertar()
		{
			$token = $_GET['token'];
			$validar_token = $this->modelo->validar_token($token);
			
			if($validar_token['estado'] == 1){ //el token no esta expirado
				if ($_POST) {
					$idrol = intval($_POST['id']);
					$nombre_actividad =  limpiar($_POST['nombre_actividad']); //HAY QUE CAMBIAR AQUI
					$descripcion_actividad = limpiar($_POST['descripcion_actividad']);
					$presupuesto = floatval($_POST['presupuesto']);
					$empleado = intVal($_POST['empleado']);
					$start = $_POST['start'];
					$end = $_POST['end'];
					$estado = 0;
					$arreglo1 = $_POST['arreglo'];
					$arreglo = explode(',',$arreglo1);
					$area = intVal($_POST['area']);
					if ($idrol == 0) { //Es una inserción
						// if (isset($_SESSION['permisos_'.nombreproyecto()]['Crear Roles'])) {
							
                            $existe = $this->modelo->seleccionar_todos_sql("SELECT * FROM events WHERE (title = '$nombre_actividad' and descripcion_actividad = '$descripcion_actividad') and start = '$start' and end = '$end'");//HAY QUE CAMBIAR AQUI
							//imprimir($existe);die();
							if ($existe['estado'] == true) {
								if (empty($existe['datos'])) {

									//$token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};
									$id = $this->modelo->generar_id();
									
									$campos = array("id"=>$id,"title" => $nombre_actividad, "descripcion_actividad" => $descripcion_actividad,"presupuesto" => $presupuesto,"start" => $start,"end" => $end,"empleado" => $empleado,"estado" => $estado,"area"=>$area);
									//if (isset($_SESSION['permisos_'.nombreproyecto()]['Crear Roles'])) {
									$insertar = $this->modelo->insertar("events", $campos);
									//}
									if ($arreglo[0]>0) {
										for ($i=0; $i < count($arreglo) ; $i++) { 
											$campos = array("id_actividad" => $id,"id_estudiante"=>$arreglo[$i]);
										$insertar = $this->modelo->insertar("detalle_events", $campos);
										}
									}
									if ($insertar['estado'] == true) {
										$respuesta = array("estado" => true, "msg" => $insertar['respuesta']);
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}else{
										$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}

								}else{
									$respuesta = array("estado" => false, "msg" => "La actividad ya existe");
									echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
									die();
								}
								
							}else{
								$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
								echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
								die();
							}
						// }else{
						// 	$respuesta = array("estado" => false, "msg" => "Ops. No tiene permisos para insertar.");
						// 	echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
						// 	die();
						// }
					}else{ //actualizacion
						if (isset($_SESSION['permisos_'.nombreproyecto()]['Editar Roles'])) {
							$existe_edicion = $this->modelo->seleccionar_todos_sql("SELECT * FROM roles WHERE nombre = '$nombre' AND id != $idrol");
							//imprimir($url_nombre);die();
							if ($existe_edicion['estado'] == true) {
								if (empty($existe_edicion['datos'])) {
									//$token = $_SESSION['login_datos_'.nombreproyecto()]->{'token_usuario'};
									//$url = "roles?token=".$token."&tabla=usuarios&sufijo=usuario&nombreid=id_rol&id=".$idrol;
									$campos = array("nombre" => $nombre, "estado" => $estado);
									
									//if (isset($_SESSION['permisos_'.nombreproyecto()]['Editar Roles'])) {
										$editar = $this->modelo->editar("roles", $campos, 'id', $idrol);
										//}
									//}
									if ($editar['estado'] == true) {
										$respuesta = array("estado" => true, "msg" => $editar['respuesta']);
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}else{
										$respuesta = array("estado" => false, "msg" => "Ops. Ocurrió un error.");
										echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
										die();
									}
								}else{
									$respuesta = array("estado" => false, "msg" => "El rol ya existe.");
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
}




// require_once "conexion.php";
// $jsonStr = file_get_contents('php://input'); 
// $jsonObj = json_decode($jsonStr); 
 
// if($jsonObj->request_type == 'addEvent'){ 
//     $start = $jsonObj->start; 
//     $end = $jsonObj->end; 
 
//     $event_data = $jsonObj->event_data; 
//     $eventTitle = !empty($event_data[0])?$event_data[0]:''; 
//     $eventDesc = !empty($event_data[1])?$event_data[1]:''; 
//     $eventURL = !empty($event_data[2])?$event_data[2]:''; 
     
//     if(!empty($eventTitle)){ 
//         // Insert event data into the database 
//         $sqlQ = "INSERT INTO events (title,descripcion,url,start,end) VALUES (?,?,?,?,?)"; 
//         $stmt = $db->prepare($sqlQ); 
//         $stmt->bind_param("sssss", $eventTitle, $eventDesc, $eventURL, $start, $end); 
//         $insert = $stmt->execute(); 
 
//         if($insert){ 
//             $output = [ 
//                 'status' => 1 
//             ]; 
//             echo json_encode($output); 
//         }else{ 
//             echo json_encode(['error' => 'Event Add request failed!']); 
//         } 
//     } 
// }elseif($jsonObj->request_type == 'deleteEvent'){ 
//     $id = $jsonObj->event_id; 
 
//     $sql = "DELETE FROM events WHERE id=$id"; 
//     $delete = $db->query($sql); 
//     if($delete){ 
//         $output = [ 
//             'status' => 1 
//         ]; 
//         echo json_encode($output); 
//     }else{ 
//         echo json_encode(['error' => 'Event Delete request failed!']); 
//     } 
// } 