<?php
// Incluye la configuración de la base de datos.
require_once 'config/database.php';
// Incluye el modelo de productos para obtener datos de gastos.
include 'modulos/productos/modelo.php';
// Incluye el modelo de configuración para obtener el presupuesto.
include 'modulos/configuracion/modelo.php';

class ApiController {
    private $db;
    private $productoModel;
    private $configuracionModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productoModel = new Producto($this->db);
        $this->configuracionModel = new ConfiguracionModel($this->db);
    }

    /**
     * Genera y devuelve datos JSON para la gráfica de gastos mensuales y presupuesto.
     * Incluye los gastos de los últimos 12 meses y el presupuesto mensual actual.
     */
    public function gastosMensuales() {
        // Inicia la sesión si aún no ha sido iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica la autenticación del usuario.
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            http_response_code(401); // Código de estado HTTP 401: No autorizado.
            echo json_encode(['error' => 'Usuario no autenticado.']);
            exit();
        }

        $labels = [];          // Etiquetas para el eje X (meses).
        $data_gastos = [];     // Datos de gastos mensuales.
        $data_presupuesto = [];// Datos del presupuesto mensual (línea de referencia).

        // Obtener el presupuesto mensual actual del usuario.
        $config = $this->configuracionModel->obtenerConfiguracion($id_usuario); // Usamos el método existente
        $presupuesto_mensual = $config['presupuesto_mensual'] ?? 0;

        // Obtener datos de gastos para los últimos 12 meses.
        $hoy = new DateTime();
        for ($i = 11; $i >= 0; $i--) { // Itera desde hace 11 meses hasta el mes actual.
            $fecha = clone $hoy;
            $fecha->modify("-$i months");
            $mes = (int)$fecha->format('m');
            $anio = (int)$fecha->format('Y');
            $nombre_mes = $this->obtenerNombreMes($mes);
            
            // Añade la etiqueta del mes y año.
            $labels[] = $nombre_mes . ' ' . $anio;
            
            // Obtiene el total de gastos para el mes y año actuales.
            $total_gastos_mes = $this->productoModel->obtenerTotalGastosMensuales($id_usuario, $mes, $anio);
            $data_gastos[] = $total_gastos_mes;
            
            // El presupuesto mensual se repite para cada mes si no hay un historial de cambios.
            $data_presupuesto[] = $presupuesto_mensual; 
        }

        // Establece el encabezado para indicar que la respuesta es JSON.
        header('Content-Type: application/json');
        // Devuelve los datos en formato JSON.
        echo json_encode([
            'labels' => $labels,
            'gastosData' => $data_gastos,
            'presupuestoData' => $data_presupuesto
        ]);
    }

    /**
     * Helper para obtener el nombre corto del mes.
     * @param int $mes El número del mes (1-12).
     * @return string El nombre corto del mes.
     */
    private function obtenerNombreMes(int $mes): string {
        $nombres_meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        return $nombres_meses[$mes] ?? '';
    }
}
?>
