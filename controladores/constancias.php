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
    public function reportePrueba()
    {


        $datos_vista['titulo_ventana'] = "Reporte de Prueba";
        $datos_vista['titulo_pagina'] = "Reporte de Prueba";
        $datos_vista['nombre_pagina'] = "Reporte de Prueba";

        $this->vista->obtener_vista($this, "prueba", $datos_vista);
    }

    /*=======================================================
        			LISTADO DE ASISTENCIA DE ACTIVIDADES
        =======================================================*/

    public function asistencia_actividades()
    {
        // var_dump($_GET['id']);
        $actividad = intval($_GET['id']);

        $datos_vista = $this->modelo->seleccionar_todos_sql("SELECT CONCAT(e.nombres,' ',e.apellidos) as nombre, v.title,(select COUNT(id_actividad) from detalle_events WHERE id_actividad=v.id) as child  from detalle_events d inner join expediente e on e.id=d.id_estudiante inner join events v on v.id=d.id_actividad where id_actividad=$actividad");

        if (count($datos_vista['datos']) <= 0) {
            $datos_vista = $this->modelo->seleccionar_todos_sql("SELECT v.title, (select COUNT(id_actividad) from detalle_events WHERE id_actividad=v.id) as child  from  events v inner join detalle_events d where v.id=$actividad");
        }

        $this->vista->obtener_vista($this, "Actividad_asistencia", $datos_vista);
    }


    public function actividades_finalizadas()
    {
        $actividad = intval($_GET['actividad']);
        $mes = intval($_GET['mes']);
        $year = intval($_GET['year']);

        $datos_vista = $this->modelo->seleccionar_todos_sql("SELECT e.id, e.descripcion_actividad , e.title, e.start,e.end , a.nombre   FROM  events e INNER JOIN areas_expediente a on e.area=a.id WHERE e.estado=1 and a.id=$actividad AND EXTRACT(MONTH FROM e.start)=$mes AND EXTRACT(YEAR FROM e.start)=$year");


        if ($datos_vista['datos'] > 0) {
            $datos_vista['mes'] = self::mes($mes);
            $datos_vista['year'] = $year;
            // $datos_vista['start'] = self::fechaFormat($datos_vista['datos'][0]['start']);
            // $datos_vista['end'] = self::fechaFormat($datos_vista['datos'][0]['end']);
        }

        $this->vista->obtener_vista($this, "reporteActividadesFinalizadas", $datos_vista);
    }

    public function edades()
    {
        $grafico = $_POST['graficoIMG'];
        $datos_vista = $this->modelo->seleccionar_todos_sql("SELECT TIMESTAMPDIFF(YEAR,e.fecha_nacimiento,CURDATE()) AS edad,COUNT(TIMESTAMPDIFF(YEAR,e.fecha_nacimiento,CURDATE())) as cantidad FROM expediente e where e.estado=1 GROUP BY TIMESTAMPDIFF(YEAR,e.fecha_nacimiento,CURDATE()) having edad<18");
        $datos_vista['grafico'] = $grafico;

        $this->vista->obtener_vista($this, "reporteEdades", $datos_vista);
    }


    public function actividades_por_area()
    {
        $grafico = $_POST['graficoIMG'];
        $datos_vista = $this->modelo->seleccionar_todos_sql("Select e.area,a.nombre,count(e.area) as cantidad from events e inner join areas_expediente a on a.id=e.area where e.estado=1 GROUP BY e.area");
        $datos_vista['grafico'] = $grafico;
        $this->vista->obtener_vista($this, "reporteActividadesArea", $datos_vista);
    }

    public function actividades_por_mes_anio()
    {

        if (!empty($_POST['combo_anios']) &&  !empty($_POST['mes']) && !empty($_POST['graficoIMG'])) {

            $anios = $_POST['combo_anios'];
            $mes = $_POST['mes'];
            $grafico = $_POST['graficoIMG'];
            $datos_vista = $this->modelo->seleccionar_todos_sql("SELECT e.id ,YEAR(e.start) as year, EXTRACT(MONTH FROM e.start) as mes, e.title, e.start,e.end , a.nombre   FROM  events e INNER JOIN areas_expediente a on e.area=a.id WHERE e.estado=1  AND EXTRACT(MONTH FROM e.start)=$mes AND YEAR(e.start)=$anios");
            $datos_vista['grafico'] = $grafico;
            if (count($datos_vista['datos'])) {
                $datos_vista['mes'] = self::mes($datos_vista['datos'][0]['mes']);
                $datos_vista['year'] = $datos_vista['datos'][0]['year'];
                for ($i = 0; $i < count($datos_vista['datos']); $i++) {
                    $datos_vista['datos'][$i]['mes'] = self::mes($datos_vista['datos'][$i]['mes']);
                }
            }
            $this->vista->obtener_vista($this, "reporteActividadesMesYear", $datos_vista);
        } else {
            $datos_vista['titulo_ventana'] = "Error";
            $datos_vista['titulo_pagina'] = "Error";
            $datos_vista['nombre_pagina'] = "Error";
            $datos_vista['archivo_funciones'] = "js_cargos.js";
            $this->vista->obtener_vista($this, "error", $datos_vista);
        }
    }

    public function actividades_por_mes_anio_general()
    {
        $grafico = $_POST['grafico'];
        $datos_vista = $this->modelo->seleccionar_todos_sql("SELECT YEAR(start) as year,MONTH(start) as mes, COUNT(MONTH(start)) as cantidad  from events where events.estado='1' and YEAR(start)=YEAR(CURRENT_DATE) GROUP BY YEAR(start),MONTH(start) ");
        $datos_vista['grafico'] = $grafico;
        if (count($datos_vista['datos'])) {
            $datos_vista['mes'] = self::mes($datos_vista['datos'][0]['mes']);
            $datos_vista['year'] = $datos_vista['datos'][0]['year'];
        }
        for ($i = 0; $i < count($datos_vista['datos']); $i++) {
            $datos_vista['datos'][$i]['mes'] = self::mes($datos_vista['datos'][$i]['mes']);
        }
        $this->vista->obtener_vista($this, "reporteActividadesMesYearGeneral", $datos_vista);
    }

    public function Expediente()
    {
        $id = $_GET['id'];
        $datos_generales = $this->modelo->seleccionar_todos_sql("SELECT e.id, e.turno,e.codigo,CONCAT(e.nombres,' ',e.apellidos) as nombre_completo,e.genero,e.fecha_nacimiento,e.grupo_edad,CONCAT(em.nombres,' ',em.apellidos) as nombre_completo_tutor,e.horario,e.foto_url from expediente e inner join empleados em on em.id=e.id_tutor where e.id=$id and e.estado=1");
        $datos_actividades = $this->modelo->seleccionar_todos_sql("SELECT e.area,a.nombre as nombre_area,de.id_estudiante,COUNT(a.nombre) as cantidad,EXTRACT(YEAR from e.start) as year from events e inner join detalle_events de on de.id_actividad=e.id inner join areas_expediente a on a.id=e.area inner join empleados em on em.id=e.empleado where de.id_estudiante=$id GROUP BY e.area,EXTRACT(YEAR from e.start)");
        $year_Actividades = $this->modelo->seleccionar_todos_sql("SELECT EXTRACT(YEAR from e.start) as year from events e inner join detalle_events de on de.id_actividad=e.id inner join areas_expediente a on a.id=e.area inner join empleados em on em.id=e.empleado where de.id_estudiante=$id GROUP BY EXTRACT(YEAR from e.start)");
        if (count($datos_generales['datos']) > 0) {
            $datos_generales['datos'][0]['genero'] = self::genero($datos_generales['datos'][0]['genero']);
        }

        $datos_vista['generales'] = $datos_generales;
        $datos_vista['actividades'] = $datos_actividades;
        $datos_vista['year'] = $year_Actividades;
        // $datos_vista['mes'] = self::mes($datos_vista['datos'][0]['mes']);
        // $datos_vista['year'] = $datos_vista['datos'][0]['year'];
        // for ($i = 0; $i < count($datos_vista['datos']); $i++) {
        //     $datos_vista['datos'][$i]['mes'] = self::mes($datos_vista['datos'][$i]['mes']);
        // }
        $this->vista->obtener_vista($this, "Expediente", $datos_vista);
    }

    public function genero($number)
    {
        if ($number == '1') {
            return 'Masculino';
        } else {
            return 'Femenino';
        }
    }

    public function mes($numero)
    {
        switch ($numero) {
            case '1':
                return 'Enero';
                break;
            case '2':
                return 'Febrero';
                break;
            case '3':
                return 'Marzo';
                break;
            case '4':
                return 'Abril';
                break;
            case '5':
                return 'Mayo';
                break;
            case '6':
                return 'Junio';
                break;
            case '7':
                return 'Julio';
                break;
            case '8':
                return 'Agosto';
                break;
            case '9':
                return 'Septiembre';
                break;
            case '10':
                return 'Octubre';
                break;
            case '11':
                return 'Noviembre';
                break;
            case '12':
                return 'Diciembre';
                break;

            default:
                return ' ';
                break;
        }
    }
}
