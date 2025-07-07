<?php
// Incluye el modelo de notificaciones.
include 'modulos/notificaciones/modelo.php';
// Asegúrate de que la conexión a la base de datos esté disponible.
require_once 'config/database.php';

class NotificacionesController {
    private $notificacionesModel; // Instancia del modelo de notificaciones.

    // Constructor que recibe la conexión a la base de datos.
    public function __construct(PDO $conn) {
        $this->notificacionesModel = new Notificaciones($conn);
    }

    // Método principal para manejar la lógica de las notificaciones.
    public function notificaciones() {
        // Inicia la sesión si aún no está iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica si el usuario está autenticado. Si no, redirige al login.
        if (!isset($_SESSION["usuario_id"]) || empty($_SESSION["usuario_id"])) {
            header("Location: index.php?ruta=login");
            exit();
        }

        $id_usuario = $_SESSION['usuario_id']; // Obtiene el ID del usuario de la sesión.

        $hoy = date('Y-m-d'); // Fecha actual.
        $proximos_7_dias = date('Y-m-d', strtotime('+7 days')); // Fecha dentro de 7 días.

        // --- Notificaciones de Metas de Ahorro ---
        $vencidas = $this->notificacionesModel->obtenerMetasVencidasNoCumplidas($hoy, $id_usuario);
        $proximas = $this->notificacionesModel->obtenerMetasProximasAVencer($hoy, $id_usuario, $proximos_7_dias);
        $cumplidas = $this->notificacionesModel->obtenerMetasCumplidas($id_usuario);
        $sinProgreso = $this->notificacionesModel->obtenerMetasSinProgreso($id_usuario);

        // --- Notificaciones de Gastos Recurrentes ---
        $notificacionesGastosRecurrentes = $this->notificacionesModel->obtenerNotificacionesGastosRecurrentes($hoy, $id_usuario, 3);

        // --- Notificación de Gasto Demasiado Alto ---
        // Se define un umbral del 20% del saldo total (saldo inicial + otros ingresos).
        // Este es un buen punto de partida para una "buena gestión de gastos",
        // ya que alerta sobre gastos individuales significativos.
        $notificacionesGastoAlto = $this->notificacionesModel->generarNotificacionGastoAlto($id_usuario, 0.20, 7); // 20% del saldo, en los últimos 7 días.
        
        // Inicializa $notificacionesProductos si no está definida para evitar errores.
        // Luego, fusiona las notificaciones de gastos altos con las existentes o crea un nuevo array.
        $notificacionesProductos = []; 
        // Si tienes otras notificaciones que originalmente llenaban $notificacionesProductos, agrégalas aquí.
        // Por ejemplo: $notificacionesProductos = array_merge($notificacionesProductos, $otrasNotificacionesDeProductos);

        // Fusiona las notificaciones de gastos altos en $notificacionesProductos.
        $notificacionesProductos = array_merge($notificacionesProductos, $notificacionesGastoAlto);


        // --- Notificación de Presupuesto Mensual Casi Agotado ---
        // Se define un umbral, por ejemplo, si se ha gastado el 80% o más del presupuesto mensual.
        $notificacionesPresupuesto = $this->notificacionesModel->generarNotificacionPresupuestoCasiAgotado($id_usuario, 0.80); // 80% del presupuesto.

        // Incluye la vista de notificaciones, pasando todas las variables necesarias.
        // La vista notificaciones.php se mantiene sin cambios estéticos.
        include 'modulos/notificaciones/vista/notificaciones.php';
    }
}
