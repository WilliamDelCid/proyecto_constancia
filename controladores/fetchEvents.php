<?php
require_once "conexion.php";
$where_sql = '';
if(!empty($_GET['start']) && !empty($_GET['end'])){
    $where_sql .= "WHERE start BETWEEN '".$_GET['start']."'AND'".$_GET['end']."' and estado=0";
}

$result = $db->query("SELECT * FROM events $where_sql");
$eventsArr = array();

if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        array_push($eventsArr,$row);
    }
}
for ($i=0; $i < ($result->num_rows) ; $i++) { 
    $eventsArr[$i]["title"] = utf8_encode($eventsArr[$i]["title"]);
    $eventsArr[$i]["descripcion_actividad"] = utf8_encode($eventsArr[$i]["descripcion_actividad"]);

}

echo json_encode($eventsArr);