<?php

class reconocimiento extends controladores
{
    public function __construct()
    {
        parent::__construct();
    }

    /*=======================================================
        			LLAMADA A LA VISTA
        =======================================================*/
    public function reconocimiento()
    {

        $datos_vista['titulo_ventana'] = "Reconocimiento";
        $datos_vista['titulo_pagina'] = "Reconocimiento";
        $datos_vista['nombre_pagina'] = "Reconocimiento";
        $datos_vista['archivo_funciones'] = "reconocimiento.js";
        if (isset($_GET['token'])) {
            $id = intval($_GET['token']);
            $datos_vista['datos'] = $this->modelo->seleccionar_todos_sql("SELECT f.id AS id_formulario, f.nombres AS nombre_formulario, 
        f.apellidos AS apellido_formulario, f.token_unico, f.url, (select p.nombre from participacion p where p.id=f.id_tipo_participacion) AS nombre_participacion, 
        (select e.nombre from eventos e where e.id=f.id_evento) AS nombre_evento, 
        f.nombre_evento_opcional AS evento_opcional, 
        f.fecha_evento AS fecha_evento, f.lugar_evento,
        f.fecha_expedicion
        FROM formularios AS f WHERE f.token_unico=$id");


            if ($datos_vista['datos']['cuantos'] <= 0) {
                header('location: ' . url_base() . '/errores');
            }

            if (!isset($datos_vista['datos']['datos'][0]['nombre_evento'])) {
                $datos_vista['datos']['datos'][0]['nombre_evento'] = $datos_vista['datos']['datos'][0]['evento_opcional'];
            }
        } else {
            header('location: ' . url_base() . '/errores');
        }

        $this->vista->obtener_vista($this, "reconocimiento", $datos_vista);
    }
}
