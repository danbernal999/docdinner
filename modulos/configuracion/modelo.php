<?php

class ConfiguracionModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function actualizarSaldoInicial($id, $saldo) {
        $query = "UPDATE usuarios SET saldo_inicial = :saldo WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':saldo' => $saldo,
            ':id' => $id
        ]);
    }
}
?>
