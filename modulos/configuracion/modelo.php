<?php
class ConfiguracionModel {
    private $db; // Propiedad para la conexión a la base de datos.

    // Constructor que recibe la conexión PDO a la base de datos.
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Guarda o actualiza la configuración de saldo, moneda y otros ingresos para un usuario.
     * Se ha eliminado el parámetro $presupuesto_mensual.
     * @param int $id_usuario El ID del usuario.
     * @param float $saldo_inicial El saldo inicial del usuario.
     * @param string $moneda La moneda seleccionada por el usuario.
     * @param float $otros_ingresos Los otros ingresos del usuario (nuevo campo).
     * @return bool Verdadero si la operación fue exitosa, falso en caso contrario.
     */
    public function guardarConfiguracion($id_usuario, $saldo_inicial, $moneda, $otros_ingresos) {
        try {
            // Prepara la consulta SQL para actualizar los campos en la tabla 'usuarios'.
            // Se ha eliminado 'presupuesto_mensual' de la consulta.
            $sql = "UPDATE usuarios SET saldo_inicial = ?, moneda = ?, otros_ingresos = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            // Ejecuta la consulta con los valores proporcionados.
            return $stmt->execute([$saldo_inicial, $moneda, $otros_ingresos, $id_usuario]);
        } catch (PDOException $e) {
            // Manejo de errores: Puedes loguear el error o devolver falso.
            error_log("Error al guardar configuración: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Reinicia la configuración de saldo y otros ingresos a cero para un usuario.
     * Se ha eliminado el reinicio de presupuesto_mensual.
     * @param int $id_usuario El ID del usuario.
     * @return bool Verdadero si la operación fue exitosa, falso en caso contrario.
     */
    public function reiniciarConfiguracion($id_usuario) {
        try {
            // Prepara la consulta SQL para reiniciar los campos.
            // Se ha eliminado 'presupuesto_mensual' de la consulta.
            $sql = "UPDATE usuarios SET saldo_inicial = 0, otros_ingresos = 0 WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            // Ejecuta la consulta.
            return $stmt->execute([$id_usuario]);
        } catch (PDOException $e) {
            error_log("Error al reiniciar configuración: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene la configuración de saldo, moneda y otros ingresos de un usuario.
     * Se ha eliminado la selección de presupuesto_mensual.
     * @param int $id_usuario El ID del usuario.
     * @return array Un array asociativo con los datos de configuración o un array vacío si no se encuentra.
     */
    public function obtenerConfiguracion($id_usuario) {
        try {
            // Prepara la consulta SQL para seleccionar los campos.
            // Se ha eliminado 'presupuesto_mensual' de la selección.
            $sql = "SELECT saldo_inicial, moneda, otros_ingresos FROM usuarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_usuario]);
            // Devuelve los datos como un array asociativo.
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: []; // Devuelve un array vacío si no hay resultados.
        } catch (PDOException $e) {
            error_log("Error al obtener configuración: " . $e->getMessage());
            return [];
        }
    }
}
