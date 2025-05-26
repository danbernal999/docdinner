<?php
class Producto{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Obtener todos los gastos por cada usuario
    public function obtenerTodosPorUsuario($id_usuario) {
        $sql = "SELECT * FROM gastos_fijos WHERE usuario_id = :usuario_id ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $id_usuario
            ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de todos los gastos
    public function obtenerTotalGastosPorUsuario($id_usuario) {
        $sql = "SELECT SUM(monto) AS total_gastos FROM gastos_fijos WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $id_usuario
            ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_gastos'] ?? 0;
    }

    // Buscar gastos por categoría
    public function buscarPorCategoria($categoria) {
        $sql = "SELECT * FROM gastos_fijos WHERE categoria = :categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener total por categoría
    public function obtenerTotalPorCategoria($categoria) {
        $sql = "SELECT SUM(monto) AS total_categoria FROM gastos_fijos WHERE categoria = :categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_categoria'] ?? 0;
    }

    // Obtener gastos ordenados por fecha o monto
    public function obtenerOrdenado($orden) {
        $columna = ($orden === 'fecha') ? 'fecha' : 'monto';
        $sql = "SELECT * FROM gastos_fijos ORDER BY $columna DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Funcion para guardar o crear un nuevo producto(Gastos)
    public function guardarGastoFijo($nombre, $monto, $categoria, $descripcion, $fecha, $idUsuario) {
        try {
            $sql = "INSERT INTO gastos_fijos (usuario_id, nombre_gasto, monto, categoria, descripcion, fecha) 
                    VALUES (:id_usuario, :nombre_gasto, :monto, :categoria, :descripcion, :fecha)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $idUsuario,
                ':nombre_gasto' => $nombre,
                ':monto' => $monto,
                ':categoria' => $categoria,
                ':descripcion' => $descripcion,
                ':fecha' => $fecha
            ]);
            return true;
        } catch (PDOException $e) {
            return "Error al guardar gasto fijo: " . $e->getMessage();
        }
    }

    //Funcion para actualizar el producto(Gasto)
    public function actualizarGasto($id, $nombre, $monto, $fecha, $categoria, $descripcion) {
        try {
            $sql = "UPDATE gastos_fijos SET 
                        nombre_gasto = :nombre, 
                        monto = :monto, 
                        fecha = :fecha, 
                        categoria = :categoria, 
                        descripcion = :descripcion 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nombre' => $nombre,
                ':monto' => $monto,
                ':fecha' => $fecha,
                ':categoria' => $categoria,
                ':descripcion' => $descripcion,
                ':id' => $id
            ]);

            return true; // Retornar true si todo fue bien
        } catch (PDOException $e) {
            return "Error al actualizar gasto: " . $e->getMessage();
        }
    }

    //Funcion para eliminar un gasto recibiendo el ID
    public function eliminarGasto($id) {
        try {
            $sql = "DELETE FROM gastos_fijos WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            return "Error al eliminar gasto: " . $e->getMessage();
        }
    }
}




?>