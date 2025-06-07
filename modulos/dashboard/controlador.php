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

        require_once 'utils/fotoPerfil.php';
        $foto = $_SESSION['foto'] ?? '';
        $rutaFoto = obtenerRutaFoto($foto);
        //Funciones gastos, card abajo a la izquierda
        $total_gastos = $this->productoModel->obtenerTotalGastosPorUsuario($id_usuario); //Para obtener el Total gastos (Productos)
        $gastoMasAlto = $this->productoModel->obtenerGastoFijoMasAlto($id_usuario); //Para obtener el Total gastos (Productos)

        //funcion ahorro, card arriba a la derecha
        $result = $this->AhorroModel->obtenerTodasLasMetasPorUsuario($id_usuario); //Para la Visualizacion Metas
        include 'modulos/dashboard/vista/inicio.php';
    }
}


?>