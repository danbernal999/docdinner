<?php
include 'modulos/notificaciones/modelo.php';

class NotificacionesController {
    private $notificacionesModel;

    public function __construct(PDO $conn) {
        $this->notificacionesModel = new Notificaciones($conn);
    }

    public function notificaciones() {
        
        $hoy = date('Y-m-d');
        $proximos_7_dias = date('Y-m-d', strtotime('+7 days'));
        
        // Metas vencidas pero no cumplidas
        $vencidas = $this->notificacionesModel->obtenerMetasVencidasNoCumplidas($hoy);

        // Metas próximas a vencer (menos de 7 días)
        $proximas = $this->notificacionesModel->obtenerMetasProximasAVencer($hoy, $proximos_7_dias);

        // Metas cumplidas
        $cumplidas = $this->notificacionesModel->obtenerMetasCumplidas();

        // Metas sin progreso
        $sinProgreso = $this->notificacionesModel->obtenerMetasSinProgreso();


        include 'modulos/notificaciones/vista/notificaciones.php';
    }
}


?>