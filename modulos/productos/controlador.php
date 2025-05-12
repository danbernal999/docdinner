<?php

include 'modulos/productos/modelo.php';

class ProductosController {
    private $productoModel;

    public function __construct($db) {
        $this->productoModel = new Producto($db);
    }

    public function productos() {
        // Obtener todos los gastos fijos por defecto
        $gastos = $this->productoModel->obtenerTodos();

        // Mostrar el total si se presiona el botón
        if (isset($_POST['ver_total'])) {
            $total_gastos = $this->productoModel->obtenerTotalGastos();
        }
        // Manejar la búsqueda por categoría
        if (isset($_POST['buscar_categoria'])) {
            $categoriaSeleccionada = $_POST['categoria'];
            $gastos = $this->productoModel->buscarPorCategoria($categoriaSeleccionada);
        }
        // Calcular el total de una categoría seleccionada
        if (isset($_POST['ver_total_categoria'])) {
            $categoriaSeleccionada = $_POST['categoria'];
            $total_categoria = $this->productoModel->obtenerTotalPorCategoria($categoriaSeleccionada);
        }
        // Manejar el orden por fecha o monto
        if (isset($_POST['ordenar_por'])) {
            $ordenSeleccionado = $_POST['orden'];
            $gastos = $this->productoModel->obtenerOrdenado($ordenSeleccionado);
        }


        include 'modulos/productos/vista/productos.php';
    }
}


?>