<?php

class MetaAhorro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todas las metas de ahorro por usuario
    public function obtenerTodasLasMetasPorUsuario($id_usuario) {
        $sql = "SELECT * FROM metas_ahorro WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $id_usuario]);
        
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
    public function guardarMeta($nombre_meta, $cantidad_meta, $fecha_limite, $descripcion, $id_usuario) {
        try{
            $sql = "INSERT INTO metas_ahorro (usuario_id ,nombre_meta, cantidad_meta, fecha_limite, descripcion) 
                    VALUES (:usuario_id, :nombre, :cantidad, :fecha, :descripcion)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre_meta,
                ':cantidad' => $cantidad_meta,
                ':fecha' => $fecha_limite,
                ':descripcion' => $descripcion,
                ':usuario_id' => $id_usuario
            ]);
            return "✅ Meta guardada exitosamente.";

        } catch (PDOException $e) {
            return "❌ Error al guardar la meta: " . $e->getMessage();
        }
    }

    // Funcion para la eliminacion de Metas de Ahorro
    public function eliminarMetaPorId($id, $id_usuario) {
        try {
            $sql = "DELETE FROM metas_ahorro WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':usuario_id' => $id_usuario
            ]);
            return $stmt->rowCount() > 0; // Retorna true si se eliminó al menos una fila
        } catch (PDOException $e) {
            // Puedes loguear esto en lugar de hacer echo directamente
            return "Error al eliminar: " . $e->getMessage();
        }
    }

    //funcion para obtener meta por id
    public function obtenerMetaPorId($id) {
        try {
            $sql = "SELECT * FROM metas_ahorro WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]); // Asegúrate de que el usuario tenga acceso a esta meta
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al obtener la meta: " . $e->getMessage();
        }
    }

    //funcion para actualizar los datos en una meta de ahorro
    public function actualizarMeta($id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion, $id_usuario) {
        try {
            $sql = "UPDATE metas_ahorro 
                    SET nombre_meta = :nombre_meta, 
                        cantidad_meta = :cantidad_meta, 
                        fecha_limite = :fecha_limite, 
                        descripcion = :descripcion 
                    WHERE id = :id AND usuario_id = :usuario_id";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nombre_meta' => $nombre_meta,
                ':cantidad_meta' => $cantidad_meta,
                ':fecha_limite' => $fecha_limite,
                ':descripcion' => $descripcion,
                ':id' => $id,
                ':usuario_id' => $id_usuario 
            ]);
    
            return $stmt->rowCount() > 0; // Retorna true si se actualizó al menos una fila
        } catch (PDOException $e) {
            return "Error al actualizar la meta: " . $e->getMessage();
        }
    } 

    //Funcion sirve para actualizar las metas añadiendonle una cantidad 
    public function añadirAhorroAMeta($meta_id, $cantidad_ahorrada, $descripcion = null, $id_usuario) {
        if ($cantidad_ahorrada <= 0) {
            return "La cantidad ahorrada debe ser mayor a 0.";
        }

        $meta = $this->obtenerMetaPorId($meta_id);
        if (!$meta) {
            return "Meta de ahorro no encontrada o no pertenece al usuario.";
        }

        try {
            $this->conn->beginTransaction();

            $sql_update = "UPDATE metas_ahorro SET ahorrado = ahorrado + :cantidad WHERE id = :id AND usuario_id = :usuario_id";
            $stmt_update = $this->conn->prepare($sql_update);
            $stmt_update->execute([
                ':cantidad' => $cantidad_ahorrada,
                ':id' => $meta_id,
                ':usuario_id' => $id_usuario
            ]);

            $sql_historial = "INSERT INTO historial_ahorros (meta_id, cantidad, descripcion1) VALUES (:meta_id, :cantidad, :descripcion)";
            $stmt_historial = $this->conn->prepare($sql_historial);
            $stmt_historial->execute([
                ':meta_id' => $meta_id,
                ':cantidad' => $cantidad_ahorrada,
                ':descripcion' => $descripcion
            ]);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "Error al añadir el ahorro: " . $e->getMessage();
        }
    }

}
