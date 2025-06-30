<?php
include 'modulos/configuracion/modelo.php';
require_once 'config/database.php';

class ConfiguracionController {
    private $configuracionModel;

    public function __construct($db) {
        $this->configuracionModel = new ConfiguracionModel($db);
    }

    public function configuracion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario está autenticado
        if (!isset($_SESSION["usuario_id"]) || empty($_SESSION["usuario_id"])) {
            header("Location: index.php?ruta=login");
            exit();
        }

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: index.php?ruta=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"];

        // Guardar configuración
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardarSaldo'])) {
            $saldo = floatval($_POST['saldo_inicial']);
            $presupuesto = floatval($_POST['presupuesto_mensual']);
            $moneda = $_POST['moneda'];

            // ⚠️ Este campo debe llamarse igual que el name en el input HTML
            $otros_ingresos = isset($_POST['otros_ingresos']) && $_POST['otros_ingresos'] !== '' 
                ? floatval($_POST['otros_ingresos']) 
                : 0;

            // ✅ Sumar si hay otros ingresos
            $saldo_total = $saldo + $otros_ingresos;

            $this->configuracionModel->guardarConfiguracion($id_usuario, $saldo, $presupuesto);

            // Guardar en sesión
            $_SESSION['saldo_inicial'] = $saldo;
            $_SESSION['presupuesto_mensual'] = $presupuesto;
            $_SESSION['moneda'] = $moneda;

            header("Location: index.php?ruta=main&modulo=configuracion&mensaje=actualizado");
            exit;
        }

        // Reiniciar configuración
        if (isset($_GET['reset']) && $_GET['reset'] == 1) {
            $this->configuracionModel->reiniciarConfiguracion($id_usuario);

            unset($_SESSION['saldo_inicial'], $_SESSION['presupuesto_mensual']);

            header("Location: index.php?ruta=main&modulo=configuracion");
            exit;
        }

        // Cargar configuración si no está en sesión
        if (!isset($_SESSION['saldo_inicial']) || !isset($_SESSION['presupuesto_mensual'])) {
            $datos = $this->configuracionModel->obtenerConfiguracion($id_usuario);
            $_SESSION['saldo_inicial'] = $datos['saldo_inicial'] ?? 0;
            $_SESSION['presupuesto_mensual'] = $datos['presupuesto_mensual'] ?? 0;
        }

        include 'modulos/configuracion/vista/perfil.php';
    }
}
?>