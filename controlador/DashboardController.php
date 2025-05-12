<?php
require_once 'modelos/Gasto.php'; // Importa el modelo de gastos

class Gasto {
    // Existing code

    // Method to obtain total expenses
    public static function obtenerTotalGastos() {
        // Replace the following line with actual logic to calculate total expenses
        return 0; // Example: returning 0 as a placeholder
    }
}

class DashboardController {
    public function index() {
        // Obtener el total de gastos desde el modelo
        $totalGastos = Gasto::obtenerTotalGastos();
        
        // Cargar la vista del dashboard y enviar la variable
        require_once 'vistas/dashboard.php';
    }
}
?>
