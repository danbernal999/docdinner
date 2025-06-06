<?php

class DashboardController {
    public function Dashboard() {
        $foto = trim($_SESSION['foto'] ?? '');
        $rutaFoto = 'assets/icons/user-profile-icon-free-vector.jpg';
        // Validar que la ruta no esté vacía y que el archivo exista
        if ($foto !== '' && file_exists($foto)) {
            $rutaFoto = $foto;
        }
        include 'modulos/dashboard/vista/inicio.php';
    }
}


?>