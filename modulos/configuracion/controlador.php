<?php
// Incluye el modelo de configuración para interactuar con la base de datos.
include 'modulos/configuracion/modelo.php';
// Incluye la configuración de la base de datos.
require_once 'config/database.php';

class ConfiguracionController {
    private $configuracionModel; // Propiedad para la instancia del modelo.

    // Constructor que recibe la conexión a la base de datos.
    public function __construct($db) {
        $this->configuracionModel = new ConfiguracionModel($db);
    }

    // Método principal para manejar la lógica de la configuración.
    public function configuracion() {
        // Inicia la sesión si aún no está iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica si el usuario está autenticado. Si no, redirige al login.
        if (!isset($_SESSION["usuario_id"]) || empty($_SESSION["usuario_id"])) {
            header("Location: index.php?ruta=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"]; // Obtiene el ID del usuario de la sesión.

        // Manejo de la solicitud POST para guardar la configuración.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar Saldo Inicial y Moneda
            if (isset($_POST['guardarConfiguracionPrincipal'])) {
                $saldo_inicial = floatval($_POST['saldo_inicial']);
                $moneda = htmlspecialchars($_POST['moneda']);

                // Obtener el valor actual de otros_ingresos para no sobrescribirlo
                $datos_actuales = $this->configuracionModel->obtenerConfiguracion($id_usuario);
                $otros_ingresos_actuales = $datos_actuales['otros_ingresos'] ?? 0;

                // Guardar saldo inicial, moneda y mantener otros_ingresos
                $this->configuracionModel->guardarConfiguracion($id_usuario, $saldo_inicial, $moneda, $otros_ingresos_actuales);

                // Actualizar sesión
                $_SESSION['saldo_inicial'] = $saldo_inicial;
                $_SESSION['moneda'] = $moneda;
                // No se modifica $_SESSION['otros_ingresos'] aquí, ya que este botón no lo gestiona.

                header("Location: index.php?ruta=main&modulo=configuracion&mensaje=actualizado");
                exit;
            } 
            // Lógica para guardar Otros Ingresos
            else if (isset($_POST['guardarOtrosIngresos'])) {
                $otros_ingresos = isset($_POST['otros_ingresos']) && $_POST['otros_ingresos'] !== '' 
                    ? floatval($_POST['otros_ingresos']) 
                    : 0;
                
                // Obtener el saldo inicial y moneda actuales para no sobrescribirlos
                $datos_actuales = $this->configuracionModel->obtenerConfiguracion($id_usuario);
                $saldo_inicial_actual = $datos_actuales['saldo_inicial'] ?? 0;
                $moneda_actual = $datos_actuales['moneda'] ?? 'COP';

                // Guardar solo otros_ingresos, manteniendo saldo inicial y moneda
                $this->configuracionModel->guardarConfiguracion($id_usuario, $saldo_inicial_actual, $moneda_actual, $otros_ingresos);

                // Actualizar sesión
                $_SESSION['otros_ingresos'] = $otros_ingresos;
                // No se modifican $_SESSION['saldo_inicial'] ni $_SESSION['moneda'] aquí.

                header("Location: index.php?ruta=main&modulo=configuracion&mensaje=actualizado");
                exit;
            }
        }

        // Manejo de la solicitud GET para reiniciar la configuración.
        if (isset($_GET['reset']) && $_GET['reset'] == 1) {
            $this->configuracionModel->reiniciarConfiguracion($id_usuario);

            unset($_SESSION['saldo_inicial'], $_SESSION['moneda'], $_SESSION['otros_ingresos']);

            header("Location: index.php?ruta=main&modulo=configuracion");
            exit;
        }

        // Carga la configuración del usuario desde la base de datos si no está en sesión.
        if (!isset($_SESSION['saldo_inicial']) || !isset($_SESSION['otros_ingresos']) || !isset($_SESSION['moneda'])) {
            $datos = $this->configuracionModel->obtenerConfiguracion($id_usuario);
            $_SESSION['saldo_inicial'] = $datos['saldo_inicial'] ?? 0;
            $_SESSION['moneda'] = $datos['moneda'] ?? 'COP';
            $_SESSION['otros_ingresos'] = $datos['otros_ingresos'] ?? 0;
        }

        // Incluye la vista para mostrar el formulario de configuración.
        include 'modulos/configuracion/vista/perfil.php';
    }
}
