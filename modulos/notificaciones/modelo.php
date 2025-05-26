<?php

class Notificaciones {
    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function obtenerMetasVencidasNoCumplidas(string $hoy, $id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite < :hoy AND cumplida = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':hoy' => $hoy,
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasProximasAVencer(string $hoy, $id_usuario, string $proximos7Dias): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite BETWEEN :hoy AND :proximos AND cumplida = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':hoy' => $hoy, 
            ':proximos' => $proximos7Dias, 
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasCumplidas($id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado >= cantidad_meta AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasSinProgreso($id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
