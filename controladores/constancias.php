<?php

class constancias extends controladores
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
    public function reconocimiento()
    {


        $datos_vista['titulo_ventana'] = "Reporte de Prueba";
        $datos_vista['titulo_pagina'] = "Reporte de Prueba";
        $datos_vista['nombre_pagina'] = "Reporte de Prueba";
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $datos_vista['datos'] = $this->modelo->seleccionar_todos_sql("SELECT f.id AS id_formulario, f.nombres AS nombre_formulario, 
        f.apellidos AS apellido_formulario, f.token_unico, f.url, (select p.nombre from participacion p where p.id=f.id_tipo_participacion) AS nombre_participacion, 
        (select e.nombre from eventos e where e.id=f.id_evento) AS nombre_evento, 
        f.nombre_evento_opcional AS evento_opcional, 
        f.fecha_evento AS fecha_evento, f.lugar_evento,
        f.fecha_expedicion
        FROM formularios AS f WHERE f.token_unico=$id");

            // var_dump(isset($datos_vista['datos']['datos'][0]['evento_opcional']));
            // die();
            if (!isset($datos_vista['datos']['datos'][0]['nombre_evento'])) {
                $datos_vista['datos']['datos'][0]['nombre_evento'] = $datos_vista['datos']['datos'][0]['evento_opcional'];
            }

            // var_dump($datos_vista['datos']['datos'][0]['nombre_evento']);
            // die();
        }
        $this->vista->obtener_vista($this, "prueba", $datos_vista);
    }
}
