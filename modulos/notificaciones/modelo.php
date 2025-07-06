<?php

class Notificaciones {
    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function obtenerMetasVencidasNoCumplidas(string $hoy, $id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite < :hoy AND cumplida = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':hoy' => $hoy,
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasProximasAVencer(string $hoy, $id_usuario, string $proximos7Dias): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite BETWEEN :hoy AND :proximos AND cumplida = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':hoy' => $hoy,
            ':proximos' => $proximos7Dias,
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasCumplidas($id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado >= cantidad_meta AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerMetasSinProgreso($id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Obtiene los gastos fijos recurrentes cuya fecha base está próxima a la fecha actual.
     * Esta función notifica si la fecha del gasto fijo está en los próximos N días o si ya pasó la fecha
     * en el mes actual y se considera "próxima" si estamos cerca del día de pago original.
     *
     * @param string $hoy La fecha actual en formato 'YYYY-MM-DD'.
     * @param int $id_usuario El ID del usuario.
     * @param int $dias_antes Número de días antes de la fecha del gasto para notificar.
     * @return array Una lista de strings con las notificaciones de gastos recurrentes.
     */
    public function obtenerNotificacionesGastosRecurrentes(string $hoy, int $id_usuario, int $dias_antes = 3): array {
        $notificaciones = [];
        $sql = "SELECT nombre_gasto, fecha, frecuencia_recurrencia 
                FROM gastos_fijos 
                WHERE es_recurrente = 1 
                AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $id_usuario]);
        $gastosRecurrentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hoy_obj = new DateTime($hoy);

        foreach ($gastosRecurrentes as $gasto) {
            $nombre_gasto = htmlspecialchars($gasto['nombre_gasto']);
            $fecha_base_str = $gasto['fecha'];
            $frecuencia = $gasto['frecuencia_recurrencia'];

            // Extraer el día de la fecha base del gasto
            $dia_base = (new DateTime($fecha_base_str))->format('d');

            // Calcular la fecha esperada del próximo pago en el mes actual
            $proximo_pago_mes_actual = clone $hoy_obj;
            $proximo_pago_mes_actual->setDate($hoy_obj->format('Y'), $hoy_obj->format('m'), min((int)$dia_base, $proximo_pago_mes_actual->format('t'))); // Asegura que el día sea válido para el mes

            // Si el día base ya pasó en el mes actual, se considera el próximo mes
            if ($proximo_pago_mes_actual < $hoy_obj && (int)$dia_base <= (int)$hoy_obj->format('d')) {
                 $proximo_pago_mes_actual->modify('+1 month');
                 $proximo_pago_mes_actual->setDate($proximo_pago_mes_actual->format('Y'), $proximo_pago_mes_actual->format('m'), min((int)$dia_base, $proximo_pago_mes_actual->format('t')));
            }

            $diff_dias = $hoy_obj->diff($proximo_pago_mes_actual)->days;
            $es_futuro = $proximo_pago_mes_actual >= $hoy_obj;


            if ($es_futuro && $diff_dias <= $dias_antes) {
                // Si el pago es en los próximos 'dias_antes'
                $notificaciones[] = "El gasto recurrente '{$nombre_gasto}' (pago {$frecuencia}) vence el {$proximo_pago_mes_actual->format('d/m/Y')}.";
            } elseif (!$es_futuro && $diff_dias > 0 && $diff_dias <= $dias_antes) {
                // Si el pago era hace 'dias_antes' días y está pendiente
                $notificaciones[] = "El gasto recurrente '{$nombre_gasto}' (pago {$frecuencia}) venció el {$proximo_pago_mes_actual->format('d/m/Y')}.";
            }
        }
        return $notificaciones;
    }
}
