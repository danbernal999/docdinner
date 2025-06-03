<?php
class ModeloRecuperar {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function verificarCorreo($correo) {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarToken($correo, $token, $expira) {
        $stmt = $this->db->prepare("UPDATE usuarios SET reset_token = :token, reset_expires = :expires WHERE correo = :correo");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':expires', $expira, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        return $stmt->execute();
    }

    
}
?>
