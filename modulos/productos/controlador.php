<?php

include 'modulos/productos/modelo.php';

class ProductosController {
    private $productoModel;

    public function __construct($db) {
        $this->productoModel = new Producto($db);
    }

    public function productos() {
        // Inicialización de variables
        $gastos = [];
        $total_gastos = null;
        $total_categoria = null;
        $categoriaSeleccionada = null;
        $ordenSeleccionado = null;
        $mensaje = null;
        $id_usuario = $_SESSION['usuario_id'] ?? null;

        // Manejo de acciones POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear gasto
            if (isset($_POST['crearGasto'])) {
                $nombre = $_POST['nombre_gasto'] ?? '';
                $monto = $_POST['monto'] ?? '';
                $categoria = $_POST['categoria'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $fecha = $_POST['fecha'] ?? '';
                $idUsuario = $_POST['id_usuario'] ?? '';

                // Nuevos campos para recurrencia
                $esRecurrente = isset($_POST['es_recurrente']) ? 1 : 0;
                $frecuenciaRecurrencia = $_POST['frecuencia_recurrencia'] ?? null;

                // Nuevos campos para cuotas
                $total_cuotas = $_POST['total_cuotas'] ?? 0;
                $cuotas_pagadas = $_POST['cuotas_pagadas'] ?? 0;

                // Calcular IVA si aplica
                $incluyeIVA = isset($_POST['incluir_iva']);
                $tasaIVA = $incluyeIVA ? floatval($_POST['tasa_iva']) : 0;
                $valorSinIVA = $incluyeIVA ? $monto / (1 + $tasaIVA / 100) : $monto;
                $valorIVA = $monto - $valorSinIVA;

                // Validación simple
                if (empty($nombre) || empty($monto) || empty($categoria) || empty($descripcion) || empty($fecha)) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=error_campos');
                    exit();
                }

                if ($esRecurrente && empty($frecuenciaRecurrencia)) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=error_frecuencia_recurrencia');
                    exit();
                }

                // Guardar en base de datos
                $resultado = $this->productoModel->guardarGastoFijo(
                    $nombre, $monto, $valorSinIVA, $valorIVA, 
                    $categoria, $fecha, $idUsuario, 
                    $esRecurrente, $frecuenciaRecurrencia, 
                    $total_cuotas, $cuotas_pagadas, 
                    $descripcion
                );


                if ($resultado === true) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=gasto_guardado');
                } else {
                    error_log("Error al guardar gasto: " . $resultado);
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=error_bd');
                }
                exit();
            }

            // Actualizar gasto
            if (isset($_POST['actualizarGasto'])) {
                $id = $_POST['id'] ?? null;
                $nombre = $_POST['nombre_gasto'] ?? '';
                $monto = $_POST['monto'] ?? '';
                $fecha = $_POST['fecha'] ?? '';
                $categoria = $_POST['categoria'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';

                $esRecurrente = isset($_POST['es_recurrente']) ? 1 : 0;
                $frecuenciaRecurrencia = $_POST['frecuencia_recurrencia'] ?? null;

                // Nuevos campos para cuotas
                $total_cuotas = $_POST['total_cuotas'] ?? 0;
                $cuotas_pagadas = $_POST['cuotas_pagadas'] ?? 0;

                if ($id) {
                    $resultado = $this->productoModel->actualizarGasto(
                        $id, $nombre, $monto, $fecha, $categoria, 
                        $descripcion, $esRecurrente, $frecuenciaRecurrencia,
                        $total_cuotas, $cuotas_pagadas
                    );

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=productos&mensaje=gasto_actualizado");
                        exit();
                    } else {
                        error_log("Error al actualizar gasto: " . $resultado);
                        echo $resultado;
                        exit();
                    }
                }
            }

            // Ver total general
            if (isset($_POST['ver_total'])) {
                $total_gastos = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario);
            }

            // Buscar por categoría
            if (isset($_POST['buscar_categoria'])) {
                $categoriaSeleccionada = $_POST['categoria'] ?? '';
                $gastos = $this->productoModel->buscarPorCategoria($categoriaSeleccionada, $id_usuario);
            }

            // Ver total por categoría
            if (isset($_POST['ver_total_categoria'])) {
                $categoriaSeleccionada = $_POST['categoria'] ?? '';
                $total_categoria = $this->productoModel->obtenerTotalPorCategoria($categoriaSeleccionada, $id_usuario);
            }

            // Ordenar
            if (isset($_POST['ordenar_por'])) {
                $ordenSeleccionado = $_POST['orden'] ?? '';
                $gastos = $this->productoModel->obtenerOrdenado($ordenSeleccionado, $id_usuario);
            }
        }

        if (empty($gastos) && $id_usuario) {
            $gastos = $this->productoModel->obtenerTodosPorUsuario($id_usuario);
        }

        // Calcular pendiente
        if (!empty($gastos)) {
            foreach ($gastos as &$gasto) {
                if (isset($gasto['total_cuotas'], $gasto['cuotas_pagadas']) && $gasto['total_cuotas'] > 0) {
                    $gasto['pendiente'] = ($gasto['total_cuotas'] - $gasto['cuotas_pagadas']) 
                                        * ($gasto['monto'] / $gasto['total_cuotas']);
                } else {
                    $gasto['pendiente'] = 0;
                }
            }
            unset($gasto);
        }

        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
        }

        include 'modulos/productos/vista/productos.php';
    }

    public function apiGastos($valores) {
        $id_usuario = $_SESSION['usuario_id'] ?? null;

        switch ($valores){
            case 'gastosMensuales':
                $this->productoModel->obtenerGastosMensuales($id_usuario);
                exit();
        }
    }
}
