<?php
require_once "../modelo/gasto.php";
require_once "../config/database.php";

class Gasto {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function agregarGasto($monto, $descripcion, $fecha) {
        $sql = "INSERT INTO gastos (monto, descripcion, fecha) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("dss", $monto, $descripcion, $fecha);
        return $stmt->execute();
    }
}

?>