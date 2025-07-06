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
                
                // Nuevos campos para recurrencia
                $esRecurrente = isset($_POST['es_recurrente']) ? 1 : 0; // 1 si está marcado, 0 si no
                $frecuenciaRecurrencia = $_POST['frecuencia_recurrencia'] ?? null;

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

                // Si es recurrente, la frecuencia no puede ser nula
                if ($esRecurrente && empty($frecuenciaRecurrencia)) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=error_frecuencia_recurrencia');
                    exit();
                }

                // Guardar en base de datos con IVA y recurrencia
                $resultado = $this->productoModel->guardarGastoFijo(
                    $nombre, $monto, $valorSinIVA, $valorIVA, $categoria, $descripcion, $fecha, $idUsuario, $esRecurrente, $frecuenciaRecurrencia
                );

                if ($resultado === true) {
                    header('Location: index.php?ruta=main&modulo=productos&mensaje=gasto_guardado');
                } else {
                    // Puedes loguear $resultado para depuración
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

                // Nuevos campos para recurrencia en edición
                $esRecurrente = isset($_POST['es_recurrente']) ? 1 : 0;
                $frecuenciaRecurrencia = $_POST['frecuencia_recurrencia'] ?? null;

                // Recalcular IVA para la actualización (asumiendo que el modal de edición no tiene la lógica de IVA en el frontend)
                // Para simplificar, si no se envía la tasa de IVA en la edición, se asume que no se cambia el IVA.
                // Si necesitas recalcular el IVA, deberías obtener el gasto actual de la DB primero
                // o añadir los campos de IVA al formulario de edición.
                // Por ahora, solo actualizaremos los campos de recurrencia y los existentes.
                // Si el IVA es dinámico en la edición, necesitarías más lógica aquí.

                if ($id) {
                    $resultado = $this->productoModel->actualizarGasto(
                        $id, $nombre, $monto, $fecha, $categoria, $descripcion, $esRecurrente, $frecuenciaRecurrencia
                    );

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=productos&mensaje=gasto_actualizado");
                        exit();
                    } else {
                        error_log("Error al actualizar gasto: " . $resultado);
                        echo $resultado; // Mostrar error para depuración
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

        // Si no hay POST ni GET de acciones específicas, o si los filtros no llenaron $gastos,
        // cargar todos los gastos del usuario.
        if (empty($gastos) && $id_usuario) {
            $gastos = $this->productoModel->obtenerTodosPorUsuario($id_usuario);
        }

        // Manejo de mensajes de éxito/error de la URL
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            // Aquí podrías añadir lógica para mostrar estos mensajes en la vista
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
