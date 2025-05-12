<?php

class Notificaciones {
    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function obtenerMetasVencidasNoCumplidas(string $hoy): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite < :hoy AND cumplida = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':hoy' => $hoy]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasProximasAVencer(string $hoy, string $proximos7Dias): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro 
                WHERE fecha_limite BETWEEN :hoy AND :proximos 
                AND cumplida = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':hoy' => $hoy, ':proximos' => $proximos7Dias]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasCumplidas(): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado >= cantidad_meta";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasSinProgreso(): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado = 0";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }
}
