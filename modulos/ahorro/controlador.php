<?php
include 'modulos/ahorro/modelo.php';

class AhorroController {
    private $metaAhorroModel;

    public function __construct($db) {
        $this->metaAhorroModel = new MetaAhorro($db);
    }

    public function ahorro() {
        // Asegúrate de que la sesión se haya iniciado antes de acceder a $_SESSION
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $id_usuario = $_SESSION['usuario_id'];

        if(isset($_GET['accion'])){
            $accion = $_GET['accion'];

            switch($accion){
                case 'eliminar':
                    $id = $_GET['id'];
                    $resultado = $this->metaAhorroModel->eliminarMetaPorId($id, $id_usuario);
                
                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_eliminada");
                        exit; // Importante: detener la ejecución después de la redirección
                    } else {
                        echo $resultado; // o redirigir con un mensaje de error
                    }
                    break; 

                case 'ahorroGuardar':
                    $meta_id = intval($_POST["meta_id"]);
                    $cantidad_ahorrada = floatval($_POST["cantidad_ahorrada"]);
                    $descripcion = $_POST["descripcion"] ?? null;

                    $resultado = $this->metaAhorroModel->añadirAhorroAMeta($meta_id, $cantidad_ahorrada, $descripcion, $id_usuario);

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=ahorro&mensaje=ahorro_guardado");
                        exit; // Importante: detener la ejecución después de la redirección
                    } else {
                        echo $resultado; //recibe el resultado ya veran si lo cambian 
                    }
                    break; 

                case 'deshacerAhorro':
                    $historial_id = intval($_GET['historial_id']);
                    $meta_id = intval($_GET['meta_id']);
                    $cantidad = floatval($_GET['cantidad']);

                    $resultado = $this->metaAhorroModel->deshacerAhorro($historial_id, $meta_id, $cantidad, $id_usuario);

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=ahorro&mensaje=ahorro_deshecho");
                        exit; // Importante: detener la ejecución después de la redirección
                    } else {
                        echo "Error al deshacer el ahorro: " . $resultado; // O manejar el error de otra manera
                    }
                    break; 
            }

        }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['crearMeta'])){ 
                $nombre_meta = $_POST['nombre_meta'];
                $cantidad_meta = $_POST['cantidad_meta'];
                $fecha_limite = $_POST['fecha_limite'];
                $descripcion = $_POST['descripcion'];
                $id_usuario = $_POST['id_usuario'];

                $mensaje = $this->metaAhorroModel->guardarMeta($nombre_meta, $cantidad_meta, $fecha_limite, $descripcion, $id_usuario); 
                
                if($mensaje === "✅ Meta guardada exitosamente."){ 
                    header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_creada"); 
                    exit; 
                }else{
                    header("Location: index.php?ruta=main&modulo=ahorro&mensaje=error_al_crear"); 
                    exit;
                }

            }elseif(isset($_POST['actualizarMeta'])){ 
                $id = $_POST['id'];
                $nombre_meta = $_POST['nombre_meta'];
                $cantidad_meta = $_POST['cantidad_meta'];
                $fecha_limite = $_POST['fecha_limite'];
                $descripcion = $_POST['descripcion'];

                // Asegúrate de que $id_usuario esté disponible aquí.
                // En este contexto, $id_usuario ya debería estar definido al inicio del método ahorro().
                $resultado = $this->metaAhorroModel->actualizarMeta($id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion, $id_usuario); 
                
                if ($resultado === true) {
                    header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_actualizada");
                    exit; // Importante: detener la ejecución después de la redirección
                } else {
                    echo $resultado;
                } 
            }

        }else{
            // Consulta metas de ahorro
            $result = $this->metaAhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario);
            include 'modulos/ahorro/vista/ahorro.php';
        }
        
    }
}
?>