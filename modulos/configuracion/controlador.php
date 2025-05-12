<?php

class ConfiguracionController {
    public function configuracion() {
        $nombre = $_SESSION["nombre"] ?? "Usuario";
        $apellido = $_SESSION["apellido"] ?? "xdxd";
        $usuario = $_SESSION["usuario"] ?? "xdxd";
        $info = "deaa";
        include 'modulos/configuracion/vista/perfil.php';
    }
}


?>