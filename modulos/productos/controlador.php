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

        // Manejo de acciones GET
        if (isset($_GET['accion'])) {
            $accion = $_GET['accion'];

            switch ($accion) {

                case 'eliminar':
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $resultado = $this->productoModel->eliminarGasto($id);

                        if ($resultado === true) {
                            header("Location: index.php?ruta=main&modulo=productos&mensaje=gasto_eliminado");
                        } else {
                            echo $resultado;
                        }
                        exit();
                    } else {
                        echo "ID no recibido.";
                        exit();
                    }
            }
        }

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

                        // Guardar en base de datos con IVA
            $resultado = $this->productoModel->guardarGastoFijo(
                $nombre, $monto, $valorSinIVA, $valorIVA, $categoria, $descripcion, $fecha, $idUsuario
            );

                if ($resultado === true) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=gasto_guardado');
                } else {
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

                if ($id) {
                    $resultado = $this->productoModel->actualizarGasto($id, $nombre, $monto, $fecha, $categoria, $descripcion);

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=productos&mensaje=gasto_actualizado");
                        exit();
                    } else {
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
                $gastos = $this->productoModel->buscarPorCategoria($categoriaSeleccionada);
            }

            // Ver total por categoría
            if (isset($_POST['ver_total_categoria'])) {
                $categoriaSeleccionada = $_POST['categoria'] ?? '';
                $total_categoria = $this->productoModel->obtenerTotalPorCategoria($categoriaSeleccionada);
            }

            // Ordenar
            if (isset($_POST['ordenar_por'])) {
                $ordenSeleccionado = $_POST['orden'] ?? '';
                $gastos = $this->productoModel->obtenerOrdenado($ordenSeleccionado);
            }

            // Si no hay filtros aplicados, cargar todos
            if (empty($gastos)) {
                $gastos = $this->productoModel->obtenerTodosPorUsuario($id_usuario);
            }

            include 'modulos/productos/vista/productos.php';
            return;
        }

        //

        // Si no hay POST ni GET, mostrar todos los gastos
        $gastos = $this->productoModel->obtenerTodosPorUsuario($id_usuario);
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
?>
