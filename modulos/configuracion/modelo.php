<?php
class ConfiguracionModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function guardarConfiguracion($id_usuario, $saldo, $presupuesto) {
        $sql = "UPDATE usuarios SET saldo_inicial = ?, presupuesto_mensual = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$saldo, $presupuesto, $id_usuario]);
    }

    public function reiniciarConfiguracion($id_usuario) {
        $sql = "UPDATE usuarios SET saldo_inicial = 0, presupuesto_mensual = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario]);
    }

    public function obtenerConfiguracion($id_usuario) {
        $sql = "SELECT saldo_inicial, presupuesto_mensual FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>


