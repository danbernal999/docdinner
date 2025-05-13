<?php
class Producto{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Obtener todos los gastos
    public function obtenerTodos() {
        $sql = "SELECT * FROM gastos_fijos";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de todos los gastos
    public function obtenerTotalGastos() {
        $sql = "SELECT SUM(monto) AS total_gastos FROM gastos_fijos";
        $stmt = $this->conn->query($sql);
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
    public function guardarGastoFijo($nombre, $monto, $categoria, $descripcion, $fecha) {
        try {
            $sql = "INSERT INTO gastos_fijos (nombre_gasto, monto, categoria, descripcion, fecha) 
                    VALUES (:nombre_gasto, :monto, :categoria, :descripcion, :fecha)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
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