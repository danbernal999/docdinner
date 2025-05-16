<?php

class ConfiguracionController {
    public function configuracion() {
        $nombre = $_SESSION["nombre"] ?? "Usuario";
        $apellido = $_SESSION["apellido"] ?? "";
        $usuario = $_SESSION["usuario"] ?? "";
        $info = "";
        include 'modulos/configuracion/vista/perfil.php';
    }
}


?>