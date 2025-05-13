<?php

class AnalisisController {
    public function analisis() {
        //Fechas para modulo analisis
        $fechaInicio = isset($_GET['inicio']) ? $_GET['inicio'] : date('Y-m-d');
        $fechaFin    = isset($_GET['fin']) ? $_GET['fin'] : date('Y-m-d');
        include 'modulos/analisis/vista/filtrar.php';
    }
}


?>