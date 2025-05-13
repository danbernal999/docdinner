<?php
class User {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function iniciar($correo, $password) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }else{
            return false;      
        }
    }

    public function registro($nombre, $correo, $password) {
        // Verificar si el correo ya existe
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return ['success' => false, 'message' => "El correo ya está registrado."];
        }
    
        // Hashear la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
        // Insertar usuario
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (:nombre, :correo, :password)");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":password", $passwordHash);
    
        if ($stmt->execute()) {
            return ['success' => true, 'message' => "Registro exitoso. Ahora puedes iniciar sesión."];
        } else {
            return ['success' => false, 'message' => "Error al registrar usuario."];
        }
    }    
}
