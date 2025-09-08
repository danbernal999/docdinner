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

    // Buscar gastos por categoría (asegúrate de incluir id_usuario)
    public function buscarPorCategoria($categoria, $id_usuario) {
        $sql = "SELECT * FROM gastos_fijos WHERE categoria = :categoria AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':categoria' => $categoria, ':usuario_id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener total por categoría (asegúrate de incluir id_usuario)
    public function obtenerTotalPorCategoria($categoria, $id_usuario) {
        $sql = "SELECT SUM(monto) AS total_categoria FROM gastos_fijos WHERE categoria = :categoria AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':categoria' => $categoria, ':usuario_id' => $id_usuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_categoria'] ?? 0;
    }

    // Obtener gastos ordenados por fecha o monto (asegúrate de incluir id_usuario)
    public function obtenerOrdenado($orden, $id_usuario) {
        $columna = ($orden === 'fecha') ? 'fecha' : 'monto';
        $sql = "SELECT * FROM gastos_fijos WHERE usuario_id = :usuario_id ORDER BY $columna DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Funcion para guardar o crear un nuevo producto(Gastos)
    public function guardarGastoFijo($nombre, $monto, $valorSinIVA, $valorIVA, $categoria, $fecha, $idUsuario, $esRecurrente, $frecuenciaRecurrencia, $total_cuotas = 0, $cuotas_pagadas = 0, $descripcion = null) {
        try {
            $sql = "INSERT INTO gastos_fijos 
                    (usuario_id, nombre_gasto, monto, valor_sin_iva, valor_iva, categoria, descripcion, fecha, es_recurrente, frecuencia_recurrencia, total_cuotas, cuotas_pagadas) 
                    VALUES 
                    (:id_usuario, :nombre_gasto, :monto, :valor_sin_iva, :valor_iva, :categoria, :descripcion, :fecha, :es_recurrente, :frecuencia_recurrencia, :total_cuotas, :cuotas_pagadas)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $idUsuario,
                ':nombre_gasto' => $nombre,
                ':monto' => $monto,
                ':valor_sin_iva' => $valorSinIVA,
                ':valor_iva' => $valorIVA,
                ':categoria' => $categoria,
                ':descripcion' => $descripcion,
                ':fecha' => $fecha,
                ':es_recurrente' => $esRecurrente,
                ':frecuencia_recurrencia' => $frecuenciaRecurrencia,
                ':total_cuotas' => $total_cuotas,
                ':cuotas_pagadas' => $cuotas_pagadas
                ]);
                return true;
            } catch (PDOException $e) {
                return "Error al guardar gasto fijo: " . $e->getMessage();
        }
    }

    // Funcion para actualizar el producto(Gasto) - Ahora incluye campos de recurrencia
    public function actualizarGasto($id, $nombre, $monto, $fecha, $categoria, $esRecurrente, $frecuenciaRecurrencia, $total_cuotas = 0, $cuotas_pagadas = 0, $descripcion = null) {
        try {
            if (!$esRecurrente) {
                $frecuenciaRecurrencia = null;
            }

            $sql = "UPDATE gastos_fijos SET 
                        nombre_gasto = :nombre, 
                        monto = :monto, 
                        fecha = :fecha, 
                        categoria = :categoria, 
                        descripcion = :descripcion,
                        es_recurrente = :es_recurrente,
                        frecuencia_recurrencia = :frecuencia_recurrencia,
                        total_cuotas = :total_cuotas,
                        cuotas_pagadas = :cuotas_pagadas
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nombre' => $nombre,
                ':monto' => $monto,
                ':fecha' => $fecha,
                ':categoria' => $categoria,
                ':descripcion' => $descripcion,
                ':es_recurrente' => $esRecurrente,
                ':frecuencia_recurrencia' => $frecuenciaRecurrencia,
                ':total_cuotas' => $total_cuotas,
                ':cuotas_pagadas' => $cuotas_pagadas,
                ':id' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            return "Error al actualizar gasto: " . $e->getMessage();
        }
    }

    // Funcion para eliminar un gasto recibiendo el ID
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

    // Función para obtener el gasto fijo más alto de un usuario
    public function obtenerGastoFijoMasAlto($idUsuario) {
        try {
            $sql = "SELECT nombre_gasto, monto, categoria 
                    FROM gastos_fijos 
                    WHERE usuario_id = :id_usuario 
                    ORDER BY monto DESC 
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_usuario' => $idUsuario]);

            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna nombre_gasto, monto y categoría
        } catch (PDOException $e) {
            return "Error al obtener gasto más alto: " . $e->getMessage();
        }
    }

    //Funcion para obtener los valores de la grafia de Balance general Anual
    public function obtenerGastosMensuales($usuario_id){
        $sql = "SELECT 
                    MONTH(fecha) AS mes_num,
                    SUM(monto) AS total_gastos
                FROM 
                    gastos_fijos
                WHERE 
                    usuario_id = :usuario_id
                GROUP BY 
                    mes_num
                ORDER BY 
                    mes_num";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        $resultado = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [mes_num => total_gastos]

        // Armar array con los 12 meses (enero a diciembre)
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = isset($resultado[$i]) ? floatval($resultado[$i]) : 0;
        }

        echo json_encode([
            'labels' => [ // Si quieres, puedes incluirlo desde PHP o usar el fijo del JS
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
            'data' => $data
        ]);
    }

    public function obtenerIVAMensualPorUsuario($id_usuario, $mes, $anio) {
        $sql = "SELECT SUM(valor_iva) AS total_iva
                FROM gastos_fijos
                WHERE usuario_id = :id_usuario
                AND MONTH(fecha) = :mes
                AND YEAR(fecha) = :anio";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':mes' => $mes,
            ':anio' => $anio
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_iva'] ?? 0;
    }

    public function obtenerProximoGastoPorUsuario($usuario_id) {
        $sql = "SELECT id, nombre_gasto, fecha, monto, categoria 
                FROM gastos_fijos
                WHERE usuario_id = :usuario_id 
                AND fecha >= CURDATE()
                ORDER BY fecha ASC 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerGastosConCuotas($id_usuario) {
        $sql = "SELECT id, nombre_gasto, monto, total_cuotas, cuotas_pagadas 
                FROM gastos_fijos 
                WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
