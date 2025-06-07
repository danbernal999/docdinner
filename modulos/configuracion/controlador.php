<?php

class ConfiguracionController {
    public function configuracion() {
        $nombre = $_SESSION["nombre"] ?? "Usuario";
        $apellido = $_SESSION["apellido"] ?? "";
        $usuario = $_SESSION["usuario"] ?? "";
        $info = "";
        //Foto de Perfil
        require_once 'utils/fotoPerfil.php';
        $foto = $_SESSION['foto'] ?? '';
        $rutaFoto = obtenerRutaFoto($foto);
        include 'modulos/configuracion/vista/perfil.php';
    }
}


?>