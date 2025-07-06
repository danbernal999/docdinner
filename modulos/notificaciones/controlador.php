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
        
        // Metas de Ahorro
        $vencidas = $this->notificacionesModel->obtenerMetasVencidasNoCumplidas($hoy, $id_usuario);
        $proximas = $this->notificacionesModel->obtenerMetasProximasAVencer($hoy, $id_usuario, $proximos_7_dias);
        $cumplidas = $this->notificacionesModel->obtenerMetasCumplidas($id_usuario);
        $sinProgreso = $this->notificacionesModel->obtenerMetasSinProgreso($id_usuario);

        // Notificaciones de Gastos Recurrentes
        // Se notifica si el gasto recurrente está próximo a su fecha de vencimiento (3 días antes por defecto)
        $notificacionesGastosRecurrentes = $this->notificacionesModel->obtenerNotificacionesGastosRecurrentes($hoy, $id_usuario, 3);


        include 'modulos/notificaciones/vista/notificaciones.php';
    }
}
