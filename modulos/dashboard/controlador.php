<?php

include 'modulos/ahorro/modelo.php'; //Modelo de los ahorros
include 'modulos/productos/modelo.php'; //Modelo de Porducto

class DashboardController {
     private $AhorroModel;

    public function __construct($db) {
        $this->AhorroModel = new MetaAhorro($db);
        $this->productoModel = new Producto($db);
    }
    public function Dashboard() {
        $id_usuario = $_SESSION['usuario_id']; //Id del usuario

        $foto = trim($_SESSION['foto'] ?? '');
        $rutaFoto = 'assets/icons/user-profile-icon-free-vector.jpg';
        // Validar que la ruta no esté vacía y que el archivo exista
        if ($foto !== '' && file_exists($foto)) {
            $rutaFoto = $foto;
        }
        //Funciones gastos, card abajo a la izquierda
        $total_gastos = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario); //Para obtener el Total gastos (Productos)
        $gastoMasAlto = $this->productoModel->obtenerGastoFijoMasAlto($id_usuario); //Para obtener el Total gastos (Productos)

        //funcion ahorro, card arriba a la derecha
        $result = $this->AhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario); //Para la Visualizacion Metas
        include 'modulos/dashboard/vista/inicio.php';
    }
}


?>