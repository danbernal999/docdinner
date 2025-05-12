<?php
class Producto{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Obtener todos los gastos
    public function obtenerTodos() {
        $sql = "SELECT * FROM gastos_fijos";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de todos los gastos
    public function obtenerTotalGastos() {
        $sql = "SELECT SUM(monto) AS total_gastos FROM gastos_fijos";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_gastos'] ?? 0;
    }

    // Buscar gastos por categoría
    public function buscarPorCategoria($categoria) {
        $sql = "SELECT * FROM gastos_fijos WHERE categoria = :categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener total por categoría
    public function obtenerTotalPorCategoria($categoria) {
        $sql = "SELECT SUM(monto) AS total_categoria FROM gastos_fijos WHERE categoria = :categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_categoria'] ?? 0;
    }

    // Obtener gastos ordenados por fecha o monto
    public function obtenerOrdenado($orden) {
        $columna = ($orden === 'fecha') ? 'fecha' : 'monto';
        $sql = "SELECT * FROM gastos_fijos ORDER BY $columna DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}




?>