<?php

class MetaAhorro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todas las metas de ahorro
    public function obtenerTodasLasMetas(){
        $sql = "SELECT * FROM metas_ahorro";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener historial de ahorros por ID de meta
    public function obtenerHistorialPorMeta(int $metaId){
        $sql = "SELECT * FROM historial_ahorros WHERE meta_id = :meta_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':meta_id' => $metaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Funcion para crear una nueva meta de ahorro 
    public function guardarMeta($nombre_meta, $cantidad_meta, $fecha_limite, $descripcion) {
        try{
            $sql = "INSERT INTO metas_ahorro (nombre_meta, cantidad_meta, fecha_limite, descripcion) 
                    VALUES (:nombre, :cantidad, :fecha, :descripcion)";
            
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute([
                ':nombre' => $nombre_meta,
                ':cantidad' => $cantidad_meta,
                ':fecha' => $fecha_limite,
                ':descripcion' => $descripcion
            ]);
            return "✅ Meta guardada exitosamente.";

        } catch (PDOException $e) {
            return "❌ Error al guardar la meta: " . $e->getMessage();
        }
    }
}
