<?php

include 'modulos/productos/modelo.php';

class ProductosController {
    private $productoModel;

    public function __construct($db) {
        $this->productoModel = new Producto($db);
    }

    public function productos() {
        $total_gastos = null;
        $categoriaSeleccionada = null;
        $total_categoria = null;
        $gastos = [];
        $ordenSeleccionado = null;
        $resultado = null;
        $mensaje = null;
        $id = null;

        if(isset($_GET['accion'])){
            $accion = $_GET['accion'];

            switch($accion){
                case 'crear':
                    include 'modulos/productos/vista/crear.php';
                    break;
                case 'eliminar':
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $resultado = $this->productoModel->eliminarGasto($id);
                    
                        if ($resultado === true) {
                            header("Location: index.php?ruta=main&modulo=productos&mensaje=gasto_eliminado");
                            exit();
                        } else {
                            echo $resultado;
                        }
                    } else {
                        echo "ID no recibido.";
                    }
            }

        }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['crearGasto'])){
                $nombre_gasto = $_POST['nombre_gasto'];
                $monto = $_POST['monto'];
                $categoria = $_POST['categoria'];
                $descripcion = $_POST['descripcion'];
                $fecha = $_POST['fecha'];
            
                // Validación simple
                if (empty($nombre_gasto) || empty($monto) || empty($categoria) || empty($descripcion) || empty($fecha)) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=error');
                    exit();
                }
            
                $resultado = $this->productoModel->guardarGastoFijo($nombre_gasto, $monto, $categoria, $descripcion, $fecha);
            
                if ($resultado === true) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=gasto_guardado');
                } else {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=error_bd');
                    // También podrías guardar el error en $_SESSION si lo deseas mostrar en la vista.
                }
                exit();
                
            }elseif(isset($_POST['actualizarGasto'])){
                $id = $_POST['id'];
                $nombre = $_POST['nombre_gasto'];
                $monto = $_POST['monto'];
                $fecha = $_POST['fecha'];
                $categoria = $_POST['categoria'];
                $descripcion = $_POST['descripcion'];
            

                $resultado = $this->productoModel->actualizarGasto($id, $nombre, $monto, $fecha, $categoria, $descripcion);
            
                if ($resultado === true) {
                    header("Location: index.php?ruta=main&modulo=productos&mensaje=gasto_actualizado");
                    exit();
                } else {
                    echo $resultado; // Muestra el mensaje de error
                }
            }
            // Mostrar el total si se presiona el botón
            if (isset($_POST['ver_total'])) {
                $total_gastos = $this->productoModel->obtenerTotalGastos();
            }
            // Manejar la búsqueda por nombre
            $gastos = $this->productoModel->obtenerTodos();
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

        }else{
            // Obtener todos los gastos fijos por defecto
            $gastos = $this->productoModel->obtenerTodos();
            include 'modulos/productos/vista/productos.php';
        }

    }
}
?>