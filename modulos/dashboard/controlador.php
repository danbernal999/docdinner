<?php

// Incluye el modelo de metas de ahorro.
include 'modulos/ahorro/modelo.php';
// Incluye el modelo de productos/gastos.
include 'modulos/productos/modelo.php';
// Incluye el modelo de configuración.
include 'modulos/configuracion/modelo.php'; 
// Incluye la utilidad para obtener la ruta de la foto de perfil.
require_once 'utils/fotoPerfil.php';

class DashboardController {
    private $AhorroModel;
    private $productoModel;
    private $configuracionModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->AhorroModel = new MetaAhorro($this->db);
        $this->productoModel = new Producto($this->db);
        $this->configuracionModel = new ConfiguracionModel($this->db); 
    }

    public function dashboard() {
        // Iniciar sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header('Location: index.php?ruta=login');
            exit;
        }

        // --- CONFIGURACIÓN DEL USUARIO ---
        if (!isset($_SESSION['saldo_inicial']) || 
            !isset($_SESSION['otros_ingresos']) || 
            !isset($_SESSION['moneda']) || 
            !isset($_SESSION['presupuesto_mensual'])) 
        {
            $config_data = $this->configuracionModel->obtenerConfiguracion($id_usuario);
            $_SESSION['saldo_inicial'] = $config_data['saldo_inicial'] ?? 0;
            $_SESSION['otros_ingresos'] = $config_data['otros_ingresos'] ?? 0;
            $_SESSION['moneda'] = $config_data['moneda'] ?? 'COP';
            $_SESSION['presupuesto_mensual'] = $config_data['presupuesto_mensual'] ?? 0;
        }

        // --- SALDOS ---
        $saldoInicialBase = $_SESSION['saldo_inicial'] ?? 0;
        $otrosIngresosTotal = $_SESSION['otros_ingresos'] ?? 0;
        $saldoInicial = $saldoInicialBase + $otrosIngresosTotal;

        // Total de gastos
        $totalGastos = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario);

        // Disponible y deuda
        $disponible = max(0, $saldoInicial - $totalGastos);
        $deuda = max(0, $totalGastos - $saldoInicial);
        $_SESSION['saldo_disponible'] = $disponible;

        // --- IVA MENSUAL ---
        $mesActual = date('n');
        $anioActual = date('Y');
        $mesAnterior = $mesActual == 1 ? 12 : $mesActual - 1;
        $anioAnterior = $mesActual == 1 ? $anioActual - 1 : $anioActual;

        $ivaActual = $this->productoModel->obtenerIVAMensualPorUsuario($id_usuario, $mesActual, $anioActual);
        $ivaAnterior = $this->productoModel->obtenerIVAMensualPorUsuario($id_usuario, $mesAnterior, $anioAnterior);

        $variacion = ($ivaAnterior > 0) 
            ? (($ivaActual - $ivaAnterior) / $ivaAnterior) * 100 
            : 0;

        // --- FOTO DE PERFIL ---
        $foto = $_SESSION['foto'] ?? '';
        $rutaFoto = obtenerRutaFoto($foto);

        // --- DATOS VARIOS ---
        $gastoMasAlto = $this->productoModel->obtenerGastoFijoMasAlto($id_usuario);
        $result = $this->AhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario);
        $proximoGasto = $this->productoModel->obtenerProximoGastoPorUsuario($id_usuario);

        // --- GASTOS Y PRODUCTOS CON CUOTAS ---
        $gastosDash = $this->productoModel->obtenerTodosPorUsuario($id_usuario);
        $productosDash = $this->productoModel->obtenerGastosConCuotas($id_usuario);

        $cuotasPagadasTot = 0;
        $totalCuotasTot   = 0;
        $pendienteTot     = 0.0;

        // Sumar cuotas de gastos_fijos (si usas allí también cuotas)
        foreach ($gastosDash as $g) {
            $tc = (int)($g['total_cuotas'] ?? 0);
            $cp = (int)($g['cuotas_pagadas'] ?? 0);
            $monto = (float)($g['monto'] ?? 0);

            if ($tc > 0) {
                $totalCuotasTot += $tc;
                $cuotasPagadasTot += $cp;
                $pendienteTot += max(0, ($tc - $cp) * ($monto / $tc));
            }
        }

        // Variables para la vista
        $cuotas_pagadas_total = $cuotasPagadasTot;
        $total_cuotas_total   = $totalCuotasTot;
        $pendiente_total      = $pendienteTot;


        // En DashboardController->dashboard()
        $gastosTimeline = $this->productoModel->obtenerTodosPorUsuario($id_usuario); 
        $ahorrosTimeline = $this->AhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario);


        // --- INCLUIR LA VISTA DEL DASHBOARD ---
        include 'modulos/dashboard/vista/inicio.php';
    }
}

