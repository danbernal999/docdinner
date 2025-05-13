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

    // Funcion para la eliminacion de Metas de Ahorro
    public function eliminarMetaPorId($id) {
        try {
            $sql = "DELETE FROM metas_ahorro WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
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
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al obtener la meta: " . $e->getMessage();
        }
    }

    //funcion para actualizar los datos en una meta de ahorro
    public function actualizarMeta($id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion) {
        try {
            $sql = "UPDATE metas_ahorro 
                    SET nombre_meta = :nombre_meta, 
                        cantidad_meta = :cantidad_meta, 
                        fecha_limite = :fecha_limite, 
                        descripcion = :descripcion 
                    WHERE id = :id";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nombre_meta' => $nombre_meta,
                ':cantidad_meta' => $cantidad_meta,
                ':fecha_limite' => $fecha_limite,
                ':descripcion' => $descripcion,
                ':id' => $id
            ]);
    
            return true; // Actualización exitosa
        } catch (PDOException $e) {
            return "Error al actualizar la meta: " . $e->getMessage();
        }
    } 

    //Funcion sirve para actualizar las metas añadiendonle una cantidad 
    public function añadirAhorroAMeta($meta_id, $cantidad_ahorrada, $descripcion = null) {
        // Validar que la cantidad ingresada sea válida
        if ($cantidad_ahorrada <= 0) {
            return "La cantidad ahorrada debe ser mayor a 0.";
        }
    
        // Verificar si la meta existe
        $meta = $this->obtenerMetaPorId($meta_id);
        if (!$meta) {
            return "Meta de ahorro no encontrada.";
        }
    
        try {
            // Iniciar transacción
            $this->conn->beginTransaction(); //es de PDO inicia una transacción de base de datos .
            //Luego puedes ejecutar varias consultas (INSERT, UPDATE, DELETE...) con el commit y el rollback.
    
            // Actualizar la meta
            $sql_update = "UPDATE metas_ahorro SET ahorrado = ahorrado + :cantidad WHERE id = :id";
            $stmt_update = $this->conn->prepare($sql_update);
            $stmt_update->execute([
                ':cantidad' => $cantidad_ahorrada,
                ':id' => $meta_id
            ]);
    
            // Registrar en historial
            $sql_historial = "INSERT INTO historial_ahorros (meta_id, cantidad, descripcion1) VALUES (:meta_id, :cantidad, :descripcion)";
            $stmt_historial = $this->conn->prepare($sql_historial);
            $stmt_historial->execute([
                ':meta_id' => $meta_id,
                ':cantidad' => $cantidad_ahorrada,
                ':descripcion' => $descripcion
            ]);
    
            $this->conn->commit(); // Confirmar la transacción
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack(); // Deshacer si hay error
            return "Error al añadir el ahorro: " . $e->getMessage();
        }
    }
}
