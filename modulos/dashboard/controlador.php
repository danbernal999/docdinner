<?php

// Incluye el modelo de metas de ahorro.
include 'modulos/ahorro/modelo.php';
// Incluye el modelo de productos/gastos.
include 'modulos/productos/modelo.php';
// Incluimos el modelo de configuración para obtener los datos del usuario (saldo inicial, otros ingresos).
// Es crucial para obtener los valores de configuración desde la base de datos.
include 'modulos/configuracion/modelo.php'; 
// Incluye la utilidad para obtener la ruta de la foto de perfil.
require_once 'utils/fotoPerfil.php';

class DashboardController {
    private $AhorroModel;
    private $productoModel;
    private $configuracionModel; // Añadimos la propiedad para el modelo de configuración.
    private $fotoPerfil; // Se mantiene si es parte de una estructura más grande, aunque no se inicializa aquí.
    private $db;

    // Constructor que inicializa los modelos con la conexión a la base de datos.
    public function __construct($db) {
        $this->db = $db;
        $this->AhorroModel = new MetaAhorro($this->db);
        $this->productoModel = new Producto($this->db);
        // Inicializamos el modelo de configuración aquí.
        $this->configuracionModel = new ConfiguracionModel($this->db); 
    }

    public function dashboard() {
        // Inicia la sesión si aún no ha sido iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header('Location: index.php?ruta=login');
            exit;
        }

        // --- Cargar datos de configuración del usuario si no están en sesión ---
        // Esto es VITAL para que 'saldo_inicial' y 'otros_ingresos' se obtengan de la BD
        // y estén disponibles para los cálculos.
        if (!isset($_SESSION['saldo_inicial']) || !isset($_SESSION['otros_ingresos']) || !isset($_SESSION['moneda']) || !isset($_SESSION['presupuesto_mensual'])) {
            $config_data = $this->configuracionModel->obtenerConfiguracion($id_usuario);
            $_SESSION['saldo_inicial'] = $config_data['saldo_inicial'] ?? 0;
            $_SESSION['otros_ingresos'] = $config_data['otros_ingresos'] ?? 0;
            $_SESSION['moneda'] = $config_data['moneda'] ?? 'COP';
            $_SESSION['presupuesto_mensual'] = $config_data['presupuesto_mensual'] ?? 0;
        }

        // --- Obtener Saldo Inicial BASE y Otros Ingresos desde la sesión ---
        // Estos valores ya han sido cargados o actualizados desde la BD/sesión.
        $saldoInicialBase = $_SESSION['saldo_inicial'] ?? 0;
        $otrosIngresosTotal = $_SESSION['otros_ingresos'] ?? 0;

        // --- Calcular el Saldo Total Disponible ---
        // Este es el valor que se mostrará en la tarjeta "Saldo Total".
        $saldoInicial = $saldoInicialBase + $otrosIngresosTotal;

        // Obtener el total de gastos del usuario.
        // Se asegura que la variable se llame $totalGastos para coincidir con la vista.
        $totalGastos = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario);

        // Calcular disponible y deuda.
        $disponible = max(0, $saldoInicial - $totalGastos); // Usamos $totalGastos aquí
        $deuda = max(0, $totalGastos - $saldoInicial);     // Usamos $totalGastos aquí
        $_SESSION['saldo_disponible'] = $disponible;

        // Obtener el IVA mensual actual y anterior.
        $mesActual = date('n');
        $anioActual = date('Y');
        $mesAnterior = $mesActual == 1 ? 12 : $mesActual - 1;
        $anioAnterior = $mesActual == 1 ? $anioActual - 1 : $anioActual;

        $ivaActual = $this->productoModel->obtenerIVAMensualPorUsuario($id_usuario, $mesActual, $anioActual);
        $ivaAnterior = $this->productoModel->obtenerIVAMensualPorUsuario($id_usuario, $mesAnterior, $anioAnterior);

        $variacion = 0;
        if ($ivaAnterior > 0) {
            $variacion = (($ivaActual - $ivaAnterior) / $ivaAnterior) * 100;
        }

        $foto = $_SESSION['foto'] ?? '';
        $rutaFoto = obtenerRutaFoto($foto);

        $gastoMasAlto = $this->productoModel->obtenerGastoFijoMasAlto($id_usuario);
        $result = $this->AhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario);
        
        // Incluye la vista del dashboard, pasando todas las variables.
        include 'modulos/dashboard/vista/inicio.php';
    }
}

?>
