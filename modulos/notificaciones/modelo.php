<?php

class Notificaciones {
    private PDO $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    /**
     * Obtiene las metas de ahorro vencidas y no cumplidas para un usuario.
     * @param string $hoy La fecha actual en formato 'YYYY-MM-DD'.
     * @param int $id_usuario El ID del usuario.
     * @return array Una lista de nombres de metas vencidas.
     */
    public function obtenerMetasVencidasNoCumplidas(string $hoy, $id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite < :hoy AND cumplida = 0 AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':hoy' => $hoy,
            ':usuario_id' => $id_usuario
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Obtiene las metas de ahorro próximas a vencer para un usuario.
     * @param string $hoy La fecha actual.
     * @param int $id_usuario El ID del usuario.
     * @param string $proximos7Dias La fecha de los próximos 7 días.
     * @return array Una lista de nombres de metas próximas a vencer.
     */
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

    /**
     * Obtiene las metas de ahorro ya cumplidas para un usuario.
     * @param int $id_usuario El ID del usuario.
     * @return array Una lista de nombres de metas cumplidas.
     */
    public function obtenerMetasCumplidas($id_usuario): array {
        $sql = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado >= cantidad_meta AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $id_usuario
        ]);
        // Nota: La lógica original en el controlador podría estar usando 'cumplida = 1' para metas cumplidas.
        // Si hay un campo 'cumplida' en la tabla 'metas_ahorro', es recomendable usarlo junto con la condición de 'ahorrado >= cantidad_meta'.
        // Por ahora, se mantiene la lógica original del modelo.
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Obtiene las metas de ahorro sin progreso (ahorrado es 0) para un usuario.
     * @param int $id_usuario El ID del usuario.
     * @return array Una lista de nombres de metas sin progreso.
     */
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
        $sql = "SELECT nombre_gasto, monto, fecha, frecuencia_recurrencia 
                FROM gastos_fijos 
                WHERE es_recurrente = 1 
                AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $id_usuario]);
        $gastosRecurrentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hoy_obj = new DateTime($hoy);

        foreach ($gastosRecurrentes as $gasto) {
            $nombre_gasto = htmlspecialchars($gasto['nombre_gasto']);
            $monto_gasto = floatval($gasto['monto']);
            $fecha_base_str = $gasto['fecha'];
            $frecuencia = $gasto['frecuencia_recurrencia'];

            $dia_base = (new DateTime($fecha_base_str))->format('d');

            $proximo_pago_mes_actual = clone $hoy_obj;
            $proximo_pago_mes_actual->setDate($hoy_obj->format('Y'), $hoy_obj->format('m'), min((int)$dia_base, $proximo_pago_mes_actual->format('t')));

            if ($proximo_pago_mes_actual < $hoy_obj && (int)$dia_base <= (int)$hoy_obj->format('d')) {
                $proximo_pago_mes_actual->modify('+1 month');
                $proximo_pago_mes_actual->setDate($proximo_pago_mes_actual->format('Y'), $proximo_pago_mes_actual->format('m'), min((int)$dia_base, $proximo_pago_mes_actual->format('t')));
            }

            $diff_dias = $hoy_obj->diff($proximo_pago_mes_actual)->days;
            $es_futuro = $proximo_pago_mes_actual >= $hoy_obj;


            if ($es_futuro && $diff_dias <= $dias_antes) {
                $notificaciones[] = "El gasto recurrente '{$nombre_gasto}' por $" . number_format($monto_gasto, 2) . " (pago {$frecuencia}) vence el {$proximo_pago_mes_actual->format('d/m/Y')}.";
            } elseif (!$es_futuro && $diff_dias > 0 && $diff_dias <= $dias_antes) {
                $notificaciones[] = "El gasto recurrente '{$nombre_gasto}' por $" . number_format($monto_gasto, 2) . " (pago {$frecuencia}) venció el {$proximo_pago_mes_actual->format('d/m/Y')}.";
            }
        }
        return $notificaciones;
    }

    /**
     * Obtiene la configuración financiera de un usuario (saldo inicial, presupuesto, otros ingresos).
     * @param int $id_usuario El ID del usuario.
     * @return array Un array asociativo con los datos de configuración o un array vacío si no se encuentra.
     */
    public function obtenerConfiguracionUsuario(int $id_usuario): array {
        $sql = "SELECT saldo_inicial, presupuesto_mensual, otros_ingresos FROM usuarios WHERE id = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Obtiene los gastos fijos recientes de un usuario.
     * @param int $id_usuario El ID del usuario.
     * @param int $dias_atras Número de días hacia atrás para considerar gastos "recientes".
     * @return array Una lista de arrays asociativos con los detalles de los gastos.
     */
    public function obtenerGastosRecientes(int $id_usuario, int $dias_atras = 7): array {
        $fecha_limite = date('Y-m-d', strtotime("-{$dias_atras} days"));
        $sql = "SELECT nombre_gasto, monto, fecha FROM gastos_fijos WHERE usuario_id = :id_usuario AND fecha >= :fecha_limite ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':fecha_limite' => $fecha_limite
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Genera notificaciones para gastos individuales que son considerados "demasiado altos".
     * Se compara cada gasto reciente con un porcentaje del saldo inicial del usuario.
     * Un buen límite para una gestión de gastos podría ser el 10-20% del saldo total disponible para gastos individuales.
     * @param int $id_usuario El ID del usuario.
     * @param float $porcentaje_umbral El porcentaje del saldo inicial que se considera un gasto alto (ej. 0.20 para 20%).
     * @param int $dias_recientes Número de días hacia atrás para buscar gastos.
     * @return array Una lista de strings con las notificaciones de gastos altos.
     */
    public function generarNotificacionGastoAlto(int $id_usuario, float $porcentaje_umbral = 0.20, int $dias_recientes = 7): array {
        $notificaciones = [];
        $configuracion = $this->obtenerConfiguracionUsuario($id_usuario);
        // Suma el saldo inicial y otros ingresos para obtener el saldo total disponible.
        $saldo_total_disponible = ($configuracion['saldo_inicial'] ?? 0) + ($configuracion['otros_ingresos'] ?? 0); 

        if ($saldo_total_disponible <= 0) {
            // Si no hay saldo configurado, no se puede calcular un umbral significativo.
            return ["No se puede generar notificación de gasto alto sin un saldo inicial configurado."];
        }

        $umbral_gasto_alto = $saldo_total_disponible * $porcentaje_umbral;
        $gastos_recientes = $this->obtenerGastosRecientes($id_usuario, $dias_recientes);

        foreach ($gastos_recientes as $gasto) {
            if ($gasto['monto'] > $umbral_gasto_alto) {
                $notificaciones[] = "¡Alerta! Has realizado un gasto alto de '{$gasto['nombre_gasto']}' por $" . number_format($gasto['monto'], 2) . " el " . (new DateTime($gasto['fecha']))->format('d/m/Y') . ".";
            }
        }
        return $notificaciones;
    }

    /**
     * Obtiene el total de gastos fijos para el mes actual de un usuario.
     * @param int $id_usuario El ID del usuario.
     * @return float El monto total de gastos en el mes actual.
     */
    public function obtenerTotalGastosMesActual(int $id_usuario): float {
        $primer_dia_mes = date('Y-m-01');
        $ultimo_dia_mes = date('Y-m-t'); // 't' devuelve el número de días en el mes dado.

        $sql = "SELECT SUM(monto) as total_gastos FROM gastos_fijos WHERE usuario_id = :id_usuario AND fecha BETWEEN :primer_dia AND :ultimo_dia";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':primer_dia' => $primer_dia_mes,
            ':ultimo_dia' => $ultimo_dia_mes
        ]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return floatval($resultado['total_gastos'] ?? 0);
    }

    /**
     * Genera notificaciones si el presupuesto mensual está cerca de agotarse.
     * @param int $id_usuario El ID del usuario.
     * @param float $porcentaje_alerta El porcentaje del presupuesto que activa la alerta (ej. 0.80 para 80%).
     * @return array Una lista de strings con las notificaciones de presupuesto.
     */
    public function generarNotificacionPresupuestoCasiAgotado(int $id_usuario, float $porcentaje_alerta = 0.80): array {
        $notificaciones = [];
        $configuracion = $this->obtenerConfiguracionUsuario($id_usuario);
        $presupuesto_mensual = $configuracion['presupuesto_mensual'] ?? 0;

        if ($presupuesto_mensual <= 0) {
            return ["No se puede generar notificación de presupuesto sin un presupuesto mensual configurado."];
        }

        $total_gastos_mes = $this->obtenerTotalGastosMesActual($id_usuario);
        // Evitar división por cero
        $porcentaje_gastado = ($presupuesto_mensual > 0) ? ($total_gastos_mes / $presupuesto_mensual) * 100 : 0;

        if ($porcentaje_gastado >= $porcentaje_alerta * 100) {
            $notificaciones[] = "¡Atención! Has gastado el " . number_format($porcentaje_gastado, 0) . "% de tu presupuesto mensual ($" . number_format($presupuesto_mensual, 2) . "). Llevas $" . number_format($total_gastos_mes, 2) . " gastados este mes.";
        }
        return $notificaciones;
    }
}
