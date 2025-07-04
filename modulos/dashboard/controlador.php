<?php

include 'modulos/ahorro/modelo.php';       // Modelo de metas de ahorro
include 'modulos/productos/modelo.php';    // Modelo de productos/gastos
require_once 'utils/fotoPerfil.php';       // Utilidad para obtener ruta de foto

class DashboardController {
    private $AhorroModel;
    private $productoModel;
    private $fotoPerfil;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function dashboard() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->AhorroModel   = new MetaAhorro($this->db);
        $this->productoModel = new Producto($this->db);

        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header('Location: index.php?ruta=login');
            exit;
        }

        $saldoInicial = $_SESSION['saldo_inicial'] ?? 0;

        // salto total gastos y saldo disponible
        $totalGastos  = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario);

        
        // Calcular disponible y deuda
        $disponible = max(0, $saldoInicial - $totalGastos);
        $deuda = max(0, $totalGastos - $saldoInicial);
        $_SESSION['saldo_disponible'] = $disponible;

        // Obtener el IVA mensual actual y anterior
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


        $foto     = $_SESSION['foto'] ?? '';
        $rutaFoto = obtenerRutaFoto($foto);

        $total_gastos = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario);
        $gastoMasAlto = $this->productoModel->obtenerGastoFijoMasAlto($id_usuario);
        $result       = $this->AhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario);



        
        include 'modulos/dashboard/vista/inicio.php';
    }
}

?>
