<?php

class MainController {
    public function main() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: index.php?ruta=login");
            exit;
        }

        $nombreUsuario = $_SESSION["nombre"] ?? "Usuario"; // valor por defecto

        $moduloActivo = $_GET['modulo'] ?? '';

        $vista = __DIR__ . '/vista/main.php';
        if (file_exists($vista)) {
            include $vista;
        } else {
            echo "<h2>Error: No se encontró la vista del dashboard</h2>";
        }
    }
}
