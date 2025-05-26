<?php
include 'modulos/ahorro/modelo.php';

class AhorroController {
    private $metaAhorroModel;

    public function __construct($db) {
        $this->metaAhorroModel = new MetaAhorro($db);
    }

    public function ahorro() {
        $id_usuario = $_SESSION['usuario_id'];

        if(isset($_GET['accion'])){
            $accion = $_GET['accion'];

            switch($accion){
                case 'eliminar':
                    $id = $_GET['id'];
                    $resultado = $this->metaAhorroModel->eliminarMetaPorId($id, $id_usuario);
                
                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_eliminada");
                        exit;
                    } else {
                        echo $resultado; // o redirigir con un mensaje de error
                    }

                case 'ahorroGuardar':
                    $meta_id = intval($_POST["meta_id"]);
                    $cantidad_ahorrada = floatval($_POST["cantidad_ahorrada"]);
                    $descripcion = $_POST["descripcion"] ?? null;

                    $resultado = $this->metaAhorroModel->añadirAhorroAMeta($meta_id, $cantidad_ahorrada, $descripcion, $id_usuario);

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=ahorro&mensaje=ahorro_guardado");
                        exit;
                    } else {
                        echo $resultado; //recibe el resultado ya veran si lo cambian 
                    }
            }

        }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['crearMeta'])){   //Verifica si viene algo con post, y este si el boton fue el de crear Meta
                $nombre_meta = $_POST['nombre_meta'];
                $cantidad_meta = $_POST['cantidad_meta'];
                $fecha_limite = $_POST['fecha_limite'];
                $descripcion = $_POST['descripcion'];
                $id_usuario = $_POST['id_usuario'];

                $mensaje = $this->metaAhorroModel->guardarMeta($nombre_meta, $cantidad_meta, $fecha_limite, $descripcion, $id_usuario); //Crea la meta en el modelo                
                // Redirige después de procesar el formulario (previene reenvío)
                header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_creada"); //mensaje se puede capturar mostrar la alerta
                exit; // 👈 Detiene aquí mismo el script después de una redirección con header().

            }elseif(isset($_POST['actualizarMeta'])){ 
                $id = $_POST['id'];
                $nombre_meta = $_POST['nombre_meta'];
                $cantidad_meta = $_POST['cantidad_meta'];
                $fecha_limite = $_POST['fecha_limite'];
                $descripcion = $_POST['descripcion'];

                $resultado = $this->metaAhorroModel->actualizarMeta($id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion, $id_usuario);                 
                if ($resultado === true) {
                    header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_actualizada");
                    exit;
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