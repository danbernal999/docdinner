<?php
include 'modulos/notificaciones/modelo.php';

class NotificacionesController {
    private $notificacionesModel;

    public function __construct(PDO $conn) {
        $this->notificacionesModel = new Notificaciones($conn);
    }

    public function notificaciones() {

        $id_usuario = $_SESSION['usuario_id'];

        $hoy = date('Y-m-d');
        $proximos_7_dias = date('Y-m-d', strtotime('+7 days'));
        
        // Metas vencidas pero no cumplidas
        $vencidas = $this->notificacionesModel->obtenerMetasVencidasNoCumplidas($hoy, $id_usuario);

        // Metas próximas a vencer (menos de 7 días)
        $proximas = $this->notificacionesModel->obtenerMetasProximasAVencer($hoy, $id_usuario, $proximos_7_dias);

        // Metas cumplidas
        $cumplidas = $this->notificacionesModel->obtenerMetasCumplidas($id_usuario);

        // Metas sin progreso
        $sinProgreso = $this->notificacionesModel->obtenerMetasSinProgreso($id_usuario);


        include 'modulos/notificaciones/vista/notificaciones.php';
    }
}


?>