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


        $datos_vista['titulo_ventana'] = "Cargos";
        $datos_vista['titulo_pagina'] = "Cargos";
        $datos_vista['nombre_pagina'] = "cargos";
        $datos_vista['archivo_funciones'] = "reconocimiento.js";

        $this->vista->obtener_vista($this, "reconocimiento", $datos_vista);
    }
}
