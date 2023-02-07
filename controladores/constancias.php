<?php

class constancias extends controladores
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

        if (!isset($_GET['id'])) {
            header('location: ' . url_base() . '/errores');
        }

        $datos_vista['titulo_ventana'] = "Reporte de Prueba";
        $datos_vista['titulo_pagina'] = "Reporte de Prueba";
        $datos_vista['nombre_pagina'] = "Reporte de Prueba";
        if (isset($_GET['id'])) {
            $id = limpiar($_GET['id']);
            $datos_vista['datos'] = $this->modelo->seleccionar_todos_sql("SELECT f.id AS id_formulario, f.nombres AS nombre_formulario, 
            f.apellidos AS apellido_formulario, f.token_unico, f.url, f.folio, (select p.nombre from participacion p where p.id=f.id_tipo_participacion) AS nombre_participacion, 
            (select e.nombre from eventos e where e.id=f.id_evento) AS nombre_evento, 
                    (select t.nombre from tipo_documento t where t.id=f.tipo_documento) as tipo_documento,
            f.nombre_evento_opcional AS evento_opcional, 
            f.fecha_evento AS fecha_evento, f.lugar_evento,
            f.fecha_expedicion
            FROM formularios AS f WHERE f.token_unico='$id'");



            if (!isset($datos_vista['datos']['datos'][0]['nombre_evento']) && $datos_vista['datos']['cuantos'] > 0) {
                $datos_vista['datos']['datos'][0]['nombre_evento'] = $datos_vista['datos']['datos'][0]['evento_opcional'];
            }
        }
        $this->vista->obtener_vista($this, "prueba", $datos_vista);
    }
}
