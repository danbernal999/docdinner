<?php
require_once 'config/db.php'; // Archivo de conexión a la base de datos

class Gasto {
    public static function obtenerTotalGastos() {
        try {
            $conn = Database::conectar(); // Obtener conexión
            $sql = "SELECT SUM(monto) AS total_gastos FROM gastos_fijos";
            $stmt = $conn->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_gastos'] ?? 0;
        } catch (PDOException $e) {
            die("Error al obtener total de gastos: " . $e->getMessage());
        }
    }
}
?>
