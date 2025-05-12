<?php
include 'modulos/ahorro/modelo.php';

class AhorroController {
    private $metaAhorroModel;

    public function __construct($db) {
        $this->metaAhorroModel = new MetaAhorro($db);
    }

    public function ahorro() {

        if(isset($_GET['accion'])){
            $accion = $_GET['accion'];

            switch($accion){
                case 'crear':
                    include 'modulos/ahorro/vista/crear.php';
                    break;
            }

        }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['crearMeta'])){   //Verifica si viene algo con post, y este si el boton fue el de crear Meta
                $nombre_meta = $_POST['nombre_meta'];
                $cantidad_meta = $_POST['cantidad_meta'];
                $fecha_limite = $_POST['fecha_limite'];
                $descripcion = $_POST['descripcion'];

                $mensaje = $this->metaAhorroModel->guardarMeta($nombre_meta, $cantidad_meta, $fecha_limite, $descripcion); //Crea la meta en el modelo                
                // Redirige después de procesar el formulario (previene reenvío)
                header("Location: index.php?ruta=main&modulo=ahorro&mensaje=meta_creada"); //mensaje se puede capturar mostrar la alerta
                exit; // 👈 Detiene aquí mismo el script después de una redirección con header().
            }

        }else{
            // Consulta metas de ahorro
            $result = $this->metaAhorroModel->obtenerTodasLasMetas();
            include 'modulos/ahorro/vista/ahorro.php';
        }
        
    }
}


?>