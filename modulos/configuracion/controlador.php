<?php
include 'modulos/configuracion/modelo.php';
require_once 'config/database.php'; // Asegúrate de que este archivo exista y contenga la clase Database

class ConfiguracionController {
    private $configuracionModel;

    public function __construct($db) {
        // Corrección aquí: usar la propiedad correcta
        $this->configuracionModel = new ConfiguracionModel($db);
    }

    public function configuracion() {
        if (!isset($_SESSION["usuario_id"])) {
            header("Location: index.php?ruta=login");
            exit();
        }

        $idUsuario = $_SESSION["usuario_id"];

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardarSaldo'])) {
            $saldo = floatval($_POST['saldo_inicial']);

            if ($this->configuracionModel->actualizarSaldoInicial($idUsuario, $saldo)) {
                $_SESSION['saldo_inicial'] = $saldo;
                header("Location: index.php?ruta=main&modulo=configuracion&mensaje=actualizado");
                exit();
            } else {
                echo "<p class='text-red-500'>Error al actualizar el saldo.</p>";
            }
        }

        include 'modulos/configuracion/vista/perfil.php';
    }
}
?>

