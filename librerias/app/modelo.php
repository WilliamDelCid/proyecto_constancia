<?php 
	require_once 'conexion.php';
	class modelo
	{
		function __construct()
		{
			$this->conexion = Conexion::getInstance()->getDb();
		}

		public function crear_tabla_todos(array $columnas, array $array_valores)
		{
			//ESTRUCTURA DE LA CABECERA THEAD
			$cabecera = '<thead class="thead-light">';
			$cabecera .= '<tr>';

			for ($i=0; $i < count($columnas); $i++)
			{
				$cabecera .= '<th>'.$columnas[$i].'</th>';
			}

			$cabecera .= '</tr>';
			$cabecera .= '</thead>';

			//ESTRUCTURA DEL CUERPO BODY
	 		$cuerpo = "";
			$cuerpo .= "<body>";
			

			for ($i=0; $i < count($array_valores); $i++)
			{
				$cuerpo .= "<tr>";
				foreach(array_keys($array_valores[$i]) as $llave_array ) {
					$cuerpo .= '<td>'.$array_valores[$i][$llave_array].'</td>';
				}
				$cuerpo .= "</tr>";
			}

			
			
			$cuerpo .= "</body>";
			
			 $tabla = $cabecera.$cuerpo;
			 return $tabla;
		}

		public function crear_tabla(array $columnas, array $array_valores)
		{
			//ESTRUCTURA DE LA CABECERA THEAD
			$cabecera = '<thead class="thead-light">';
			$cabecera .= '<tr>';
			/*
			for ($i=0; $i < count($columnas); $i++)
			{
				$cabecera .= '<th>'.$columnas[$i].'</th>';
			}*/

			foreach(array_keys($columnas) as $llave_columnas ) {
				
				$nombre = $llave_columnas;
			    $valor = $columnas[$llave_columnas];
				$cabecera .= '<th>'.$valor.'</th>';
			  
			}

			$cabecera .= '</tr>';
			$cabecera .= '</thead>';

			//ESTRUCTURA DEL CUERPO BODY
	 		$cuerpo = "";
			$cuerpo .= "<body>";
			

			for ($i=0; $i < count($array_valores); $i++)
			{
				$cuerpo .= "<tr>";
				foreach(array_keys($array_valores[$i]) as $llave_array ) {

					foreach(array_keys($columnas) as $llave_columnas ) {
						if ($llave_array == $llave_columnas) {
							$cuerpo .= '<td>'.$array_valores[$i][$llave_array].'</td>';
						}
					  
					}
					
				}
				$cuerpo .= "</tr>";
			}

			
			
			$cuerpo .= "</body>";
			
			 $tabla = $cabecera.$cuerpo;
			 return $tabla;
		}
		
		/*=======================================================
        			INSERTAR REGISTROS AUTOMATICAMENTE
        =======================================================*/
		//$tabla = nombre de la tabla donde se insertará
		//$datos = un array con los nombres de los campos y sus respectivos values
		//ej: array("nombre" => "nombre", "apellido" => "apellido");

		public function insertar(string $tabla, array $datos)
		{
            //Creando sentencia
            $columnas = "";
            $parametros = "";

            foreach ($datos as $key => $value) {
                $columnas .= $key . ",";
                $parametros .= ":" . $key . ",";
            }

            $columnas = substr($columnas, 0, -1); //quitando la ultima coma
            $parametros = substr($parametros, 0, -1); //quitando la ultima coma

            $sql = "INSERT INTO $tabla($columnas) VALUES($parametros)";
            
			try 
			{
				//Enlazando los parametros
				$stmt = $this->conexion->prepare($sql);
				foreach ($datos as $key => $value) {
					$stmt -> bindParam(":".$key, $datos[$key], PDO::PARAM_STR);
				}

				if ($stmt -> execute()) {
					$respuesta = array(
									"idcreado" =>  $this->conexion->lastInsertId(),
									"estado" => true,
									"respuesta" => "Los datos se insertaron correctamente"              
									);
					return $respuesta;
				}
			} catch (Exception $e) {
				return array(
							"idcreado" =>  0,
							"estado" => false,
							"respuesta" => "Ocurrió un error al insertar"   ,
							"error" =>  $e->getMessage(),
							"linea" => $e->getLine()
							);
			}
            
        }

		/*=======================================================
        			EDITAR REGISTROS AUTOMATICAMENTE
        =======================================================*/
		//Actualizar registros automaticamente
		// $tabla = nombre de la tabla donde se actualizará
		//$datos = un array con los nombres de los campos y sus respectivos values, pero en la posicion 0 debe estar el identificador con su value
		// ej: array("id" => 8, "nombre" => "nombre", "apellido" => "apellido");

		public function editar(string $tabla, array $datos, string $nombreid, int $id)
		{
			//Creando sentencia
			$sentencia_set = "";

			foreach ($datos as $key => $value) {
				$sentencia_set .= $key." = :".$key. ",";
			}

			$sentencia_set = substr($sentencia_set, 0, -1); //quitando la ultima coma

			$sql = "UPDATE $tabla SET $sentencia_set WHERE $nombreid = :$nombreid";

			try 
			{
				$stmt = $this->conexion->prepare($sql);

				foreach ($datos as $key => $value) {
					$stmt -> bindParam(":".$key, $datos[$key], PDO::PARAM_STR);
				}

				$stmt -> bindParam(":".$nombreid, $id, PDO::PARAM_STR);

				if ($stmt -> execute()) {
					$respuesta = array(
									"ideditado" => $id,
									"estado" => true,
									"respuesta" => "Los datos se editaron correctamente!"              
									);
					
					return $respuesta;
				}

			} catch (Exception $e) {
				return array(
							"ideditado" =>  0,
							"estado" => false,
							"respuesta" => "Ocurrió un error al editar"   ,
							"error" =>  $e->getMessage(),
							"linea" => $e->getLine()
							);
			}
		}
		
		/*=======================================================
        			ELIMINAR REGISTROS AUTOMATICAMENTE
        =======================================================*/

		public function eliminar($tabla, $nombreid, $id)
		{
			//Creando sentencia

			$sql = "DELETE FROM $tabla WHERE $nombreid = :$nombreid";

			try 
			{
				$stmt = $this->conexion->prepare($sql);
				$stmt -> bindParam(":".$nombreid, $id, PDO::PARAM_STR);

				if ($stmt -> execute()) {
					$respuesta = array(
									"ideliminado" => $id,
									"estado" => true,
									"respuesta" => "Los datos se eliminaron correctamente!"              
									);
					return $respuesta;
				}
			} catch (Exception $e) {
				return array(
							"ideliminado" =>  0,
							"estado" => false,
							"respuesta" => "Ocurrió un error al eliminar"   ,
							"error" =>  $e->getMessage(),
							"linea" => $e->getLine()
							);
			}
        }
		
		/*=======================================================
        	SELECCIONAR REGISTROS AUTOMATICAMENTE SIN WHERE
        =======================================================*/
		//Metodo que selecciona todos los registros de una tabla que recibe de parametro

		public function seleccionar_todos_sin_where(string $tabla)
		{
			$sql="SELECT * FROM $tabla";
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
	       		$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {
					return array(
								"estado" => true,
								"respuesta" => "Hay datos",
								"datos" => $respuesta_seleccionar,
								"cuantos" => $cuantos         
								);
		        }else{
					return array(
								"estado" => true,
								"respuesta" => "No hay datos",
								"datos" => $respuesta_seleccionar,
								"cuantos" => $cuantos         
								);
		        }
	       		
			} catch (Exception $e) {
				return array(
							"estado" => false,
							"respuesta" => "Ocurrió un error al seleccionar",
							"error" =>  $e->getMessage(),
							"linea" => $e->getLine()         
							);
			}
		}

		/*=======================================================
        	SELECCIONAR REGISTRO OBJETO AUTOMATICAMENTE SIN WHERE
        =======================================================*/
		//Metodo que selecciona un registro de una tabla que recibe de parametro
		public function seleccionar_obj_sin_where(string $tabla)
		{
			$sql="SELECT * FROM $tabla";
			try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
				$respuesta_seleccionar = $seleccionar->fetch(PDO::FETCH_ASSOC);
				$cuantos = $seleccionar->rowCount();
				if(!empty($respuesta_seleccionar))
				{
					return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
				}else{
					return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
				}
					
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}

		/*=======================================================
        	SELECCIONAR REGISTROS TODOS SQL COMPLETO
        =======================================================*/
		//Metodo que selecciona todos los registros, pero debe recibir de parametro toda la sentencia del select

		public function seleccionar_todos_sql(string $sql)
		{
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
				$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {
		        	return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }else{
		        	return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}

		/*=======================================================
        SELECCIONAR REGISTROS TODOS CON WHERE, EL 1 ELEMENTO ES EL IDENTIFICADOR
        =======================================================*/
		//Metodo que selecciona todos los registros de una tabla con where
		public function seleccionar_todos_con_where(string $tabla, array $array_valores)
		{
			$nombre_identificador = "";
	 		$valor_identificador = "";
			$contador = 0;

			foreach(array_keys($array_valores) as $llave_array ) {
	 			$contador++;
	 			if ($contador === 1) {//En la posicion 1 está el identificador
	 				$nombre_identificador= $llave_array;
	 				$valor_identificador = $array_valores[$llave_array];
	 			}
	 		}

			$sql="SELECT * FROM $tabla WHERE $nombre_identificador = '$valor_identificador'";
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
	       		$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {
		        	return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }else{
		        	return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}

		/*=======================================================
        SELECCIONAR OBJETO CON WHERE, EL 1 ELEMENTO ES EL IDENTIFICADOR
        =======================================================*/
		//Metodo que selecciona todos los registros de una tabla con where
		public function seleccionar_obj_con_where(string $tabla, array $array_valores)
		{
			$nombre_identificador = "";
	 		$valor_identificador = "";
			$contador = 0;

			foreach(array_keys($array_valores) as $llave_array ) {
	 			$contador++;
	 			if ($contador === 1) {//En la posicion 1 está el identificador
	 				$nombre_identificador= $llave_array;
	 				$valor_identificador = $array_valores[$llave_array];
	 			}
	 		}

			$sql="SELECT * FROM $tabla WHERE $nombre_identificador = '$valor_identificador'";
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetch(PDO::FETCH_ASSOC);
	       		$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {
		        	return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }else{
		        	return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}

		/*=======================================================
        	SELECCIONAR REGISTRO OBJETO SQL COMPLETO
        =======================================================*/
		//Metodo que selecciona un solo registro de la base, pero debe recibir de parametro toda la sentencia del select

		public function seleccionar_unico_sql(string $sql)
		{
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetch(PDO::FETCH_ASSOC);

	       		if(!empty($respuesta_seleccionar))
		        {
		        	return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar        
						);
		        }else{
		        	return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar       
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}

		/*=======================================================
        	SELECCIONAR CAMPOS CON O SIN WHERE
        =======================================================*/
		//Metodo que selecciona los campos recibidos y los registros de una tabla con where o sin where
		public function seleccionar_campos_consin_where(string $tabla, array $array_valores, string $where)
		{
			$nombre_identificador = "";
	 		$valor_identificador = "";
	 		$nombre_campos = "";
			$contador = 0;
			$sql = "";
			foreach(array_keys($array_valores) as $llave_array ) {
	 			$contador++;
	 			if ($contador === 1) {//En la posicion 1 está el identificador
	 				$nombre_identificador= $llave_array;
	 				$valor_identificador = $array_valores[$llave_array];
	 			}
	 				$nombre_campos .= $llave_array;
					
					if ($contador < count($array_valores)) 
					{
						$nombre_campos.=", ";
					}
	 			
	 		}

	 		if ($where === "si") {
	 			$sql="SELECT $nombre_campos FROM $tabla WHERE $nombre_identificador = '$valor_identificador'";
	 		}else{
	 			$sql="SELECT $nombre_campos FROM $tabla";
	 		}

			
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
	       		$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {
		        	return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }else{
		        	return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}

		/*=======================================================
        	SELECCIONAR TODOS CON WHERE DINAMICO
        =======================================================*/
		//Metodo que selecciona todos los registros de una tabla que recibe de parametro, y si tiene un where tambien lo recibe
		public function seleccionar_todos_where_dinamico(string $tabla, string $where)
		{
			$sql="SELECT * FROM $tabla $where";
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
	       		$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {
		        	return array(
						"estado" => true,
						"respuesta" => "Hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }else{
		        	return array(
						"estado" => true,
						"respuesta" => "No hay datos",
						"datos" => $respuesta_seleccionar,
						"cuantos" => $cuantos         
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}
		}


		/*=======================================================
        				ENCRIPTAR CONTRASEÑA
        =======================================================*/
		//Metodo que encripta la contraseña

		public function encriptar_contrasena($contrasena)
		{
			$contra_encrip = password_hash($contrasena, PASSWORD_DEFAULT);
			return $contra_encrip;
		}

		/*=======================================================
        			COMPARAR CONTRASEÑA ENCRIPTADA
        =======================================================*/
		//Metodo que compara la contraseña encriptada con la contraseña encriptada que esta en la base de datos

		public function comparar_contrasena_encriptada($contra_recibida, $contra_bd)
		{
			if (password_verify($contra_recibida, $contra_bd)) { 
				return array(
					"estado" => true,
					"respuesta" => "Coinciden"        
					);
			}else {
			    return array(
					"estado" => false,
					"respuesta" => "No Coinciden"        
					);
			}
		}

		/*=======================================================
        				FORMATEAR FECHA
        =======================================================*/
		//Metodo que formatea la fecha

		public function formatear_fecha($fecha)
		{
			$pos = strpos($fecha, "/");
			if ($pos === false) $fecha = explode("-",$fecha);
			else $fecha = explode("/",$fecha);
			$dia1 = (strlen($fecha[0])==1) ? '0'.$fecha[0] : $fecha[0];
			$fecha1 = $fecha[2].'-'.$fecha[1].'-'.$dia1;
	        return $fecha1;
		}

		/*=======================================================
        			ENCRIPTAR UNA CADENA DE TEXTO
        =======================================================*/
		//Se utiliza un código secreto, que es el que se pone en $key y que cuando desencriptemos necesitaremos saberlo para que lo haga correctamente.
        //Para encriptar una cadena escribimos
        //$cadena_encriptada = encriptar_string("LA CADENA A ENCRIPTAR","LA CLAVE");

		public function encriptar_string($string, $key) 
		{
			$result = '';
			for($i=0; $i<strlen($string); $i++) {
			   $char = substr($string, $i, 1);
			   $keychar = substr($key, ($i % strlen($key))-1, 1);
			   $char = chr(ord($char)+ord($keychar));
			   $result.=$char;
			}
			return base64_encode($result);
		}
 
		/*=======================================================
        			DESENCRIPTAR UNA CADENA DE TEXTO
        =======================================================*/
		 //$cadena_desencriptada = desencriptar_string("LA CADENA ENCRIPTADA","LA CLAVE QUE SE USÓ PARA ENCRIPTARLA");

		public function desencriptar_string($string, $key) 
		{
			$result = '';
			$string = base64_decode($string);
			for($i=0; $i<strlen($string); $i++) {
			   $char = substr($string, $i, 1);
			   $keychar = substr($key, ($i % strlen($key))-1, 1);
			   $char = chr(ord($char)-ord($keychar));
			   $result.=$char;
			}
			return $result;
		}
		
		/*=======================================================
        			OBTENER NUEVO ID STRING
        =======================================================*/
		//Metodo para obtener un id string donde el formato será la fecha con minutos y segundos seguidos por un guion y un correlativo
		public function obtener_nuevo_id_string($tabla)
		{
			$sql = "SELECT COUNT(*) FROM $tabla";
			$consulta = $this->conexion->prepare($sql);
			$consulta->execute();
        	$resultado = $consulta->fetchall(PDO::FETCH_COLUMN, 0);
        	return date("Yidisus").'-'.($resultado[0] + 1);
		}

		 /*=======================================================
        Generar token de auntenticacion
        =======================================================*/
        static public function token_jwt($id, $email)
		{
            $tiempo = time();
            
            //Creando array del token
            $token = array(
                        "iat" => $tiempo, //Tiempo en que inicia el token
                        "exp" => $tiempo + (60*60*24), //Tiempo de expiracion del token 1 dia (60s*60m*24h)
                        "data" => [
                                    "id" => $id,
                                    "email" => $email
                                  ]
                        );

            

           //JWT::decode($jwt, $llave, array('HS256'));
            return $token;

        }

		/*=======================================================
        Validar token de seguridad
        =======================================================*/
        public function validar_token($token)
		{
            /*=======================================================
            Traemos el usuario de acuerdo al token
            =======================================================*/
		

			try 
			{
				//Ejecutamos la consulta
				$sql = "SELECT id, token_exp FROM sesiones WHERE token = '$token'";
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetch(PDO::FETCH_ASSOC);
				//imprimir($sql);die();
	       		if(!empty($respuesta_seleccionar))
		        {
					$tiempo_actual = time();
					if ($tiempo_actual < $respuesta_seleccionar['token_exp']) {
						return array(
							"estado" => 1,
							"respuesta" => "No esta expirado",
							"datos" => $respuesta_seleccionar        
							);
					}else{
						$token_expirado = $respuesta_seleccionar['id'];
						$sql = "DELETE FROM sesiones WHERE id = $token_expirado";
						$stmt = $this->conexion->prepare($sql);
						$stmt->execute();

						return array(
							"estado" => 2,
							"respuesta" => "Esta expirado",
							"datos" => $respuesta_seleccionar        
							);
					}
		        }else{
		        	return array(
						"estado" => 0,
						"respuesta" => "No existe",
						"datos" => $respuesta_seleccionar       
						);
		        }
	       		
			} catch (Exception $e) {
				return array(
					"estado" => false,
					"respuesta" => "Ocurrió un error al seleccionar",
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()         
					);
			}

        }

		public function obtener_permisos_modulo(int $idmodulo, int $idrol)
		{
			$sql = "SELECT
					pr.id AS idpermisorol,
					pr.estado AS estadopermisorol,
					p.id AS idpermiso,
					p.nombre AS nombrepermiso,
					p.id_modulo AS idmodulo,
					r.id AS idrol,
					r.nombre AS rol,
					r.estado AS estadorol
					FROM
					permisosrol pr 
					INNER JOIN permisos p ON p.id = pr.id_permiso
					INNER JOIN roles r ON r.id = pr.id_rol
					WHERE p.id_modulo = $idmodulo AND r.id = $idrol AND pr.estado = 1";
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
				$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {

						$datos =  $respuesta_seleccionar;

						$permisos = array();
						for ($i=0; $i < count($datos); $i++) {  //iterando el array de obj
							$permisos[$datos[$i]['nombrepermiso']] = true; //añadiendo al arr permisos el nombre del permiso pero en su llave
						}
						
						$_SESSION['permisos_'.NOMBRE_PROYECTO] = $permisos;

						
		        }else{


						$datos =  $respuesta_seleccionar;

						$permisos = array();
						for ($i=0; $i < count($datos); $i++) {  //iterando el array de obj
							$permisos[$datos[$i]['nombrepermiso']] = true; //añadiendo al arr permisos el nombre del permiso pero en su llave
						}
						
						$_SESSION['permisos_'.NOMBRE_PROYECTO] = $permisos;
		        }
	       		
			} catch (Exception $e) {

			}
		}

		public function obtener_permisos_todos(int $idrol)
		{
			$sql = "SELECT
					pr.id AS idpermisorol,
					pr.estado AS estadopermisorol,
					p.id AS idpermiso,
					p.nombre AS nombrepermiso,
					p.id_modulo AS idmodulo,
					r.id AS idrol,
					r.nombre AS rol,
					r.estado AS estadorol
					FROM
					permisosrol pr 
					INNER JOIN permisos p ON p.id = pr.id_permiso
					INNER JOIN roles r ON r.id = pr.id_rol
					WHERE r.id = $idrol AND pr.estado = 1";
        	try 
			{
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetchall(PDO::FETCH_ASSOC);
				$cuantos = $seleccionar->rowCount();
	       		if(!empty($respuesta_seleccionar))
		        {

						$datos =  $respuesta_seleccionar;

						$permisos = array();
						for ($i=0; $i < count($datos); $i++) {  //iterando el array de obj
							$permisos[$datos[$i]['nombrepermiso']] = true; //añadiendo al arr permisos el nombre del permiso pero en su llave
						}
						
						$_SESSION['todos_permisos_'.NOMBRE_PROYECTO] = $permisos;

						
		        }else{


						$datos =  $respuesta_seleccionar;

						$permisos = array();
						for ($i=0; $i < count($datos); $i++) {  //iterando el array de obj
							$permisos[$datos[$i]['nombrepermiso']] = true; //añadiendo al arr permisos el nombre del permiso pero en su llave
						}
						
						$_SESSION['todos_permisos_'.NOMBRE_PROYECTO] = $permisos;
		        }
	       		
			} catch (Exception $e) {

			}
		}
		
		public function transaccion(string $tabla, array $datos_generales, string $tabla_detalles, array $datos_detalles)
		{

			
			try {  
				$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  
				$this->conexion->beginTransaction();
				
				//INSERTO A LA TABLA GENERAL DE REALIZACION DE EVALUACION

				//Creando sentencia
				$columnas_general = "";
				$parametros_general = "";
	
				foreach ($datos_generales as $key => $value) {
					$columnas_general .= $key . ",";
					$parametros_general .= "'".$datos_generales[$key] . "',";
				}
	
				$columnas = substr($columnas_general, 0, -1); //quitando la ultima coma
				$parametros = substr($parametros_general, 0, -1); //quitando la ultima coma
	
				$sql_general = "INSERT INTO $tabla($columnas) VALUES($parametros)";
				//var_dump($sql_general);die();
				$this->conexion->exec($sql_general);
				//var_dump($this->conexion->lastInsertId());die();
				$id_creado_realizacion = $this->conexion->lastInsertId();
			
				//INSERTO LOS DETALLES DE CRITERIO Y LA NOTA
				

				foreach(array_keys($datos_detalles) as $key ) { 
					$info_criterio = explode("-", $key);
					$id_criterio = intval($info_criterio[1]);
					$nota = intval($datos_detalles[$key]);
					
					$sql_detalle = "INSERT INTO $tabla_detalles(id_realizacion_evaluaciones_academicas, id_criterio, nota) VALUES($id_creado_realizacion, $id_criterio, $nota)";
					$this->conexion->exec($sql_detalle);
					//var_dump($sql_detalle);die();
				}
				$this->conexion->commit();
				
				
				$respuesta = array(
					"idcreado" => $id_creado_realizacion,
					"estado" => true,
					"respuesta" => "Los datos se insertaron correctamente"              
					);
				return $respuesta;
			  } catch (Exception $e) {
				$this->conexion->rollBack();
				return array(
					"idcreado" =>  0,
					"estado" => false,
					"respuesta" => "Ocurrió un error al insertar"   ,
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()
					);
			  }
            
        }

		public function transaccion_admin(string $tabla, array $datos_generales, string $tabla_detalles, array $datos_detalles)
		{

			
			try {  
				$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  
				$this->conexion->beginTransaction();
				
				//INSERTO A LA TABLA GENERAL DE REALIZACION DE EVALUACION

				//Creando sentencia
				$columnas_general = "";
				$parametros_general = "";
	
				foreach ($datos_generales as $key => $value) {
					$columnas_general .= $key . ",";
					$parametros_general .= "'".$datos_generales[$key] . "',";
				}
	
				$columnas = substr($columnas_general, 0, -1); //quitando la ultima coma
				$parametros = substr($parametros_general, 0, -1); //quitando la ultima coma
	
				$sql_general = "INSERT INTO $tabla($columnas) VALUES($parametros)";
				//var_dump($sql_general);die();
				$this->conexion->exec($sql_general);
				//var_dump($this->conexion->lastInsertId());die();
				$id_creado_realizacion = $this->conexion->lastInsertId();
			
				//INSERTO LOS DETALLES DE CRITERIO Y LA NOTA
				
				foreach(array_keys($datos_detalles) as $key ) { 
					$info_opcion = explode("-", $key);
					$id_opcion = intval($info_opcion[1]);
					$nota = intval($datos_detalles[$key]);
					
					$sql_detalle = "INSERT INTO $tabla_detalles(id_realizacion_evaluaciones_administrativo, id_opcion, nota) VALUES($id_creado_realizacion, $id_opcion, $nota)";
					$this->conexion->exec($sql_detalle);
					//var_dump($sql_detalle);die();
				}
				$this->conexion->commit();
				
				
				$respuesta = array(
					"idcreado" => $id_creado_realizacion,
					"estado" => true,
					"respuesta" => "Los datos se insertaron correctamente"              
					);
				return $respuesta;
			  } catch (Exception $e) {
				$this->conexion->rollBack();
				return array(
					"idcreado" =>  0,
					"estado" => false,
					"respuesta" => "Ocurrió un error al insertar"   ,
					"error" =>  $e->getMessage(),
					"linea" => $e->getLine()
					);
			  }
            
        }

		function dismount($object)
		{ 
			$reflectionClass = new ReflectionClass(get_class($object)); 
			$array = array(); 
			foreach ($reflectionClass->getProperties() as $property) 
			{ 
				$property->setAccessible(true); 
				$array[$property->getName()] = $property->getValue($object); 
				$property->setAccessible(false); 
			} return $array; 
		}

		//Convert Multi-Dimentional Object to Array
		
		function objectToArray($objeto) {
			if (is_object($objeto)) {
				$objeto = get_object_vars($objeto);
			}
			if (is_array($objeto)) {
				return array_map(array($this, 'objectToArray'), $objeto);
			}
			else {
				return $objeto;
			}
		}
		//---------------------------------------------------------------------------------------------------------------------------

		public function generar_id()
		{
			$sql="SELECT id FROM events order by id desc limit 1";
				//Ejecutamos la consulta
				$seleccionar = $this->conexion->prepare($sql);
				$seleccionar->execute();
	       		$respuesta_seleccionar = $seleccionar->fetch(PDO::FETCH_ASSOC);
				$id = intval($respuesta_seleccionar["id"])+1;
				return $id;
		}

		

		

	

		

		

		

		

		


		

		
		

		
	}


 ?>

