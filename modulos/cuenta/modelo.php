<?php
class UsuarioModel {
    private $conn;

    // Constructor con la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener usuario por ID
    public function obtenerUsuarioPorId($id) {
        try {
            $sql = "SELECT nombre, correo, fecha_registro, ultimo_login FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Puedes guardar errores en logs si prefieres no mostrar el mensaje
            error_log("Error al obtener usuario por ID: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPasswordPorId($id) {
        $stmt = $this->conn->prepare("SELECT password FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPassword($id, $nuevaPassword) {
        $nuevoHash = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
        $stmt->bindParam(":password", $nuevoHash);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function actualizarCorreo($id, $nuevoCorreo) {
    
        $stmt = $this->conn->prepare("UPDATE usuarios SET correo = :correo WHERE id = :id");
        $stmt->bindParam(":correo", $nuevoCorreo);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return "Falla al realizar cambio de correo";
        }
    }
}

?>