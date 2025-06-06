<?php

class ConfiguracionController {
    public function configuracion() {
        $nombre = $_SESSION["nombre"] ?? "Usuario";
        $apellido = $_SESSION["apellido"] ?? "";
        $usuario = $_SESSION["usuario"] ?? "";
        $info = "";
        //Foto de Perfil
        $foto = trim($_SESSION['foto'] ?? '');
        $rutaFoto = 'assets/icons/user-profile-icon-free-vector.jpg';
        // Validar que la ruta no esté vacía y que el archivo exista
        if ($foto !== '' && file_exists($foto)) {
            $rutaFoto = $foto;
        }
        include 'modulos/configuracion/vista/perfil.php';
    }
}


?>