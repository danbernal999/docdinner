<?php
// C:\xampp\htdocs\docdinner\modulos\analisis\controlador.php

// Incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

class AnalisisController {
    private $conn;
    private $usuario_id;

    public function __construct() {
        $this->conn = getDB();

        // Inicia la sesión si no está activa. Es crucial que session_start() se llame
        // antes de cualquier salida al navegador. En un entorno MVC, lo ideal es
        // que se inicie en un "bootstrap" o "front controller" principal.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // CORRECCIÓN CLAVE: Usar 'usuario_id' para leer de la sesión,
        // ya que así es como lo configuras en tus archivos de login.
        // Si no hay un 'usuario_id' en sesión, usa 10 como fallback (para pruebas).
        // En producción, es recomendable forzar la redirección a login si no hay sesión.
        $this->usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 10;

        // --- Bloque de depuración (puedes eliminarlo o comentarlo una vez que funcione) ---
        /*
        echo "<pre>";
        echo "--- Debugging AnalisisController __construct ---\n";
        echo "Session Status: " . (session_status() == PHP_SESSION_NONE ? 'NONE' : 'ACTIVE') . "\n";
        echo "Contenido de \$_SESSION:\n";
        print_r($_SESSION);
        echo "\nValor que se usará para \$usuario_id: " . $this->usuario_id . "\n";
        echo "---------------------------------------------\n";
        echo "</pre>";
        // Si descomentas la línea de abajo, la ejecución se detendrá aquí para que veas la depuración
        // die("Depuración de sesión activa. Revisa la salida anterior.");
        */
        // --- Fin del bloque de depuración ---
    }

    /**
     * Función principal para manejar la lógica de la página de análisis.
     * Recopila los datos necesarios y los pasa a la vista.
     */
    public function analisis() {
        // Obtener parámetros de la URL para filtrar datos
        // Establecer fechas por defecto si no se proporcionan
        $fechaInicio = isset($_GET['inicio']) && $_GET['inicio'] != '' ? $_GET['inicio'] : date('Y-m-01'); // Primer día del mes actual
        $fechaFin    = isset($_GET['fin']) && $_GET['fin'] != '' ? $_GET['fin'] : date('Y-m-d'); // Fecha actual
        $categoria   = isset($_GET['categoria']) && $_GET['categoria'] != '' ? $_GET['categoria'] : 'todas';
        $granularidad = isset($_GET['granularidad']) && $_GET['granularidad'] != '' ? $_GET['granularidad'] : 'mensual';

        // Obtener datos para los diferentes gráficos y KPIs
        $datosGastos = $this->getDatosGastos($fechaInicio, $fechaFin, $categoria, $granularidad);
        // Esta función ahora calcula el ahorro acumulado
        $datosAhorroComparativo = $this->getDatosAhorroComparativo($fechaInicio, $fechaFin, $granularidad);
        $datosDesgloseCategorias = $this->getDatosDesgloseCategorias($fechaInicio, $fechaFin, $categoria);
        $kpis = $this->getKpis($fechaInicio, $fechaFin, $categoria);

        // Incluir la vista que mostrará los datos
        // Asegúrate de que esta ruta sea correcta para tu proyecto
        include 'modulos/analisis/vista/filtrar.php';
    }

    /**
     * Obtiene datos de gastos fijos por período para el gráfico de tendencia.
     * @param string $fechaInicio Fecha de inicio del rango.
     * @param string $fechaFin Fecha de fin del rango.
     * @param string $categoria Categoría a filtrar ('todas' o un nombre de categoría).
     * @param string $granularidad Granularidad de los datos ('diaria', 'mensual', 'anual').
     * @return array Datos formateados para el gráfico de gastos.
     */
    private function getDatosGastos($fechaInicio, $fechaFin, $categoria, $granularidad) {
        $labels = [];
        $data = [];
        $groupByFormat = ''; // Formato para agrupar en SQL (ej. %Y-%m)
        $phpDateFormat = ''; // Formato para mostrar en PHP/JS (ej. M Y)

        // Determina el formato de agrupación y visualización según la granularidad
        switch ($granularidad) {
            case 'diaria':
                $groupByFormat = '%Y-%m-%d';
                $phpDateFormat = 'd M'; // Ej: 19 Jun
                break;
            case 'mensual':
                $groupByFormat = '%Y-%m';
                $phpDateFormat = 'M Y'; // Ej: Jun 2025
                break;
            case 'anual':
                $groupByFormat = '%Y';
                $phpDateFormat = 'Y'; // Ej: 2025
                break;
            default: // Mensual por defecto
                $groupByFormat = '%Y-%m';
                $phpDateFormat = 'M Y';
                break;
        }

        // Si la categoría seleccionada no es 'todas' o 'gastos', no hay datos de gastos fijos relevantes
        // Esto asume que el filtro de categoría se aplica solo a los gastos.
        if ($categoria !== 'todas' && $categoria !== 'gastos') {
            return [
                'labels' => json_encode([]),
                'datasets' => json_encode([
                    [
                        'label' => 'Gastos',
                        'data' => [],
                        'backgroundColor' => 'rgba(255, 99, 132, 0.3)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 2,
                        'fill' => true,
                        'tension' => 0.4
                    ]
                ])
            ];
        }

        // Consulta SQL para obtener los gastos agrupados por período y filtrados por usuario
        $query = "SELECT DATE_FORMAT(fecha, :groupByFormat) as periodo,
                         SUM(monto) as total_gasto
                  FROM gastos_fijos
                  WHERE usuario_id = :usuario_id
                    AND fecha BETWEEN :fechaInicio AND :fechaFin";
        $query .= " GROUP BY periodo ORDER BY periodo ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->bindParam(':groupByFormat', $groupByFormat);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Crear un mapa para los resultados obtenidos de la base de datos
        // Esto permite acceder rápidamente a los datos de un período
        $db_data_map = [];
        foreach ($results as $row) {
            $db_data_map[$row['periodo']] = (float) $row['total_gasto'];
        }

        // Generar la secuencia completa de períodos dentro del rango para asegurar
        // que todos los puntos en el tiempo estén representados, incluso si no hay gastos.
        $start_dt = new DateTime($fechaInicio);
        $end_dt = new DateTime($fechaFin);
        $interval_spec = '';

        switch ($granularidad) {
            case 'diaria': $interval_spec = 'P1D'; break; // Intervalo de 1 día
            case 'mensual': $interval_spec = 'P1M'; break; // Intervalo de 1 mes
            case 'anual': $interval_spec = 'P1Y'; break; // Intervalo de 1 año
        }
        // Ajuste para DatePeriod: el segundo parámetro es exclusivo, así que sumamos 1 día/mes/año al final
        $period = new DatePeriod($start_dt, new DateInterval($interval_spec), $end_dt->modify('+1 day'));

        foreach ($period as $dt) {
            $labels[] = $dt->format($phpDateFormat); // Etiqueta para el eje X (ej. "Jun 2025")
            // Formato de clave para buscar en el mapa de datos de la BD (ej. "2025-06")
            $sql_period_key = $dt->format(str_replace(['%Y', '%m', '%d'], ['Y', 'm', 'd'], $groupByFormat));
            $data[] = $db_data_map[$sql_period_key] ?? 0; // Obtener el monto para el período o 0 si no hay datos
        }

        return [
            'labels' => json_encode(array_values(array_unique($labels))), // Asegurar etiquetas únicas y en orden
            'datasets' => json_encode([
                [
                    'label' => 'Gastos',
                    'data' => $data,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.3)', // Color para el área del gráfico
                    'borderColor' => 'rgba(255, 99, 132, 1)',    // Color del borde de la línea
                    'borderWidth' => 2,
                    'fill' => true,      // Rellenar el área bajo la línea
                    'tension' => 0.4     // Suavidad de la línea
                ]
            ])
        ];
    }

    /**
     * Obtiene datos de ahorro acumulado para comparar el período actual con el anterior.
     * Calcula la suma acumulada de 'cantidad' en historial_ahorros para cada período.
     * @param string $fechaInicio Fecha de inicio del rango.
     * @param string $fechaFin Fecha de fin del rango.
     * @param string $granularidad Granularidad de los datos ('diaria', 'mensual', 'anual').
     * @return array Datos formateados para el gráfico de ahorro comparativo.
     */
    private function getDatosAhorroComparativo($fechaInicio, $fechaFin, $granularidad) {
        $labels = [];
        $dataEstePeriodo = [];
        $dataPeriodoAnterior = [];

        $groupByFormat = '';
        $phpDateFormat = '';

        // Determina el formato de agrupación y visualización según la granularidad
        switch ($granularidad) {
            case 'diaria': $groupByFormat = '%Y-%m-%d'; $phpDateFormat = 'd M'; break;
            case 'mensual': $groupByFormat = '%Y-%m'; $phpDateFormat = 'M Y'; break;
            case 'anual': $groupByFormat = '%Y'; $phpDateFormat = 'Y'; break;
            default: // Por defecto, si granularidad es inválida
                $groupByFormat = '%Y-%m';
                $phpDateFormat = 'M Y';
                break;
        }

        // Función auxiliar anónima para ejecutar la consulta de ahorro por período (no acumulado aún)
        // Se define aquí para no duplicar código, ya que se usa para el período actual y el anterior.
        $fetchAhorroDataByPeriod = function($start_date, $end_date, $groupByFormat) {
            $query = "SELECT DATE_FORMAT(ha.fecha, :groupByFormat) as periodo,
                             SUM(ha.cantidad) as total_ahorro_periodo
                      FROM historial_ahorros ha
                      JOIN metas_ahorro ma ON ha.meta_id = ma.id
                      WHERE ma.usuario_id = :usuario_id
                        AND ha.fecha BETWEEN :startDate AND :endDate
                      GROUP BY periodo ORDER BY periodo ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':startDate', $start_date);
            $stmt->bindParam(':endDate', $end_date);
            $stmt->bindParam(':groupByFormat', $groupByFormat);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        };

        // 1. Obtener datos del período actual (sumas por período, no acumuladas todavía)
        $resultsEstePeriodo = $fetchAhorroDataByPeriod($fechaInicio, $fechaFin, $groupByFormat);

        // 2. Calcular fechas para el período anterior (mismo lapso, pero un año antes)
        $startPrevPeriod = (new DateTime($fechaInicio))->modify('-1 year')->format('Y-m-d');
        $endPrevPeriod = (new DateTime($fechaFin))->modify('-1 year')->format('Y-m-d');
        $resultsPeriodoAnterior = $fetchAhorroDataByPeriod($startPrevPeriod, $endPrevPeriod, $groupByFormat);

        // --- Lógica para calcular la suma ACUMULADA ---
        // Esta función toma los resultados por período y los convierte en una serie de datos acumulados
        $calculateAccumulatedData = function($results_per_period, $start_dt_range, $end_dt_range, $interval_spec, $groupByFormat) {
            $mapData = [];
            // Mapea los resultados de la BD a un array asociativo por 'periodo' para fácil acceso
            foreach ($results_per_period as $row) {
                // Ajusta el formato de la clave para que coincida con lo que DatePeriod generará
                $key_format = str_replace(['%Y', '%m', '%d'], ['Y', 'm', 'd'], $groupByFormat);
                $mapData[$row['periodo']] = (float) $row['total_ahorro_periodo'];
            }

            $accumulated_data = [];
            $current_accumulated_sum = 0;

            // DatePeriod para generar todos los puntos en el rango y granularidad,
            // asegurando que se procesen todos los períodos incluso si no hay datos.
            // Se usa modify('+1 day') en el fin para incluir el último día/mes/año en el período.
            $period_generator = new DatePeriod($start_dt_range, new DateInterval($interval_spec), $end_dt_range->modify('+1 day'));

            foreach ($period_generator as $dt) {
                // Generar la clave de período para buscar en el mapa de datos de la BD
                $sql_period_key = $dt->format(str_replace(['%Y', '%m', '%d'], ['Y', 'm', 'd'], $groupByFormat));

                // Obtener el monto para este período (o 0 si no hay depósitos)
                $amount_for_current_period = $mapData[$sql_period_key] ?? 0;

                // Sumar al acumulado total
                $current_accumulated_sum += $amount_for_current_period;
                $accumulated_data[] = $current_accumulated_sum;
            }
            return $accumulated_data;
        };

        // Preparar objetos DateTime para los rangos de fechas (para el generador de períodos)
        $start_dt_current_range = new DateTime($fechaInicio);
        $end_dt_current_range = new DateTime($fechaFin);
        $start_dt_prev_range = (new DateTime($fechaInicio))->modify('-1 year');
        $end_dt_prev_range = (new DateTime($fechaFin))->modify('-1 year');

        // Determinar el intervalo de la granularidad para DatePeriod
        $interval_spec = '';
        switch ($granularidad) {
            case 'diaria': $interval_spec = 'P1D'; break;
            case 'mensual': $interval_spec = 'P1M'; break;
            case 'anual': $interval_spec = 'P1Y'; break;
        }

        // Calcular los datos acumulados para ambos períodos
        $dataEstePeriodo = $calculateAccumulatedData($resultsEstePeriodo, $start_dt_current_range, $end_dt_current_range, $interval_spec, $groupByFormat);
        $dataPeriodoAnterior = $calculateAccumulatedData($resultsPeriodoAnterior, $start_dt_prev_range, $end_dt_prev_range, $interval_spec, $groupByFormat);

        // Generar los labels (etiquetas) para el eje X, basados en el período actual
        $temp_labels = [];
        // Se recrea el DatePeriod porque el anterior modify('+1 day') cambió el objeto $end_dt_current_range
        $period_labels_generator = new DatePeriod(new DateTime($fechaInicio), new DateInterval($interval_spec), (new DateTime($fechaFin))->modify('+1 day'));
        foreach ($period_labels_generator as $dt) {
            $temp_labels[] = $dt->format($phpDateFormat);
        }

        return [
            'labels' => json_encode(array_values(array_unique($temp_labels))),
            'datasets' => json_encode([
                [
                    'label' => 'Ahorro Acumulado ' . (new DateTime($fechaInicio))->format('Y'), // Etiqueta más informativa
                    'data' => $dataEstePeriodo,
                    'borderColor' => 'rgba(6, 182, 212, 1)',
                    'backgroundColor' => 'rgba(6, 182, 212, 0.2)',
                    'fill' => true,
                    'tension' => 0.4
                ],
                [
                    'label' => 'Ahorro Acumulado ' . (new DateTime($fechaInicio))->modify('-1 year')->format('Y'), // Etiqueta más informativa
                    'data' => $dataPeriodoAnterior,
                    'borderColor' => 'rgba(234, 179, 8, 1)',
                    'backgroundColor' => 'rgba(234, 179, 8, 0.2)',
                    'fill' => true,
                    'tension' => 0.4
                ]
            ])
        ];
    }

    /**
     * Obtiene el desglose de gastos por categoría para el gráfico de pastel/doughnut.
     * @param string $fechaInicio Fecha de inicio del rango.
     * @param string $fechaFin Fecha de fin del rango.
     * @param string $categoria Categoría a filtrar ('todas' o un nombre de categoría).
     * @return array Datos formateados para el gráfico de desglose de categorías.
     */
    private function getDatosDesgloseCategorias($fechaInicio, $fechaFin, $categoria) {
        // Si la categoría seleccionada no es 'todas' o 'gastos', no hay datos de desglose de categorías relevantes
        if ($categoria !== 'todas' && $categoria !== 'gastos') {
            return [
                'labels' => json_encode([]),
                'data' => json_encode([]),
                'backgroundColor' => json_encode([])
            ];
        }

        // Consulta SQL para obtener la suma de gastos por categoría, filtrados por usuario
        $query = "SELECT categoria, SUM(monto) as total_gasto
                  FROM gastos_fijos
                  WHERE usuario_id = :usuario_id
                    AND fecha BETWEEN :fechaInicio AND :fechaFin
                  GROUP BY categoria
                  ORDER BY total_gasto DESC"; // Ordenar por el total para mejor visualización

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $data = [];
        // Paleta de colores para las categorías
        $colores = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#C9CBCF', '#A3D900', '#F7464A', '#46BFBD',
            '#FDB45C', '#949FB1', '#8C564B', '#E377C2', '#7F7F7F'
        ];
        $assigned_colors = [];

        foreach ($results as $index => $row) {
            $labels[] = $row['categoria'];
            $data[] = (float) $row['total_gasto'];
            // Asignar colores cíclicamente desde la paleta
            $assigned_colors[] = $colores[$index % count($colores)];
        }

        return [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            'backgroundColor' => json_encode($assigned_colors)
        ];
    }

    /**
     * Calcula los Indicadores Clave de Rendimiento (KPIs).
     * @param string $fechaInicio Fecha de inicio del rango.
     * @param string $fechaFin Fecha de fin del rango.
     * @param string $categoria Categoría (no utilizada directamente en los KPIs, pero se pasa).
     * @return array Array con los valores de los KPIs.
     */
    private function getKpis($fechaInicio, $fechaFin, $categoria) {
        // Total de ahorro en el período actual (suma directa de depósitos, no acumulada para KPI)
        $totalAhorroActual = $this->getTotalAhorro($fechaInicio, $fechaFin);

        // Fechas para el período anterior (un año antes) para la comparación de crecimiento
        $startPrevPeriod = (new DateTime($fechaInicio))->modify('-1 year')->format('Y-m-d');
        $endPrevPeriod = (new DateTime($fechaFin))->modify('-1 year')->format('Y-m-d');
        $totalAhorroAnterior = $this->getTotalAhorro($startPrevPeriod, $endPrevPeriod);

        $porcentajeCrecimiento = 0;
        if ($totalAhorroAnterior > 0) {
            $porcentajeCrecimiento = (($totalAhorroActual - $totalAhorroAnterior) / $totalAhorroAnterior) * 100;
        } elseif ($totalAhorroActual > 0) {
            // Si no había ahorro antes y ahora sí, es un crecimiento del 100%
            $porcentajeCrecimiento = 100;
        }
        $porcentajeCrecimiento = round($porcentajeCrecimiento, 2); // Redondear a 2 decimales

        // Margen de ahorro: (Ahorro total / (Ahorro total + Gasto total)) * 100
        // Este KPI indica qué porcentaje de tus ingresos (si Ahorro + Gasto es tu ingreso) va a ahorro.
        $totalGastoActual = $this->getTotalGastos($fechaInicio, $fechaFin);
        $margenAhorro = 0;
        if (($totalAhorroActual + $totalGastoActual) > 0) {
            $margenAhorro = ($totalAhorroActual / ($totalAhorroActual + $totalGastoActual)) * 100;
        }
        $margenAhorro = round($margenAhorro, 2); // Redondear a 2 decimales

        // Progreso de metas de ahorro (suma de lo ahorrado dividido por el total de las metas)
        $queryMetas = "SELECT SUM(cantidad_meta) as total_meta, SUM(ahorrado) as total_ahorrado_en_metas
                       FROM metas_ahorro
                       WHERE usuario_id = :usuario_id"; // Filtrado por usuario
        $stmtMetas = $this->conn->prepare($queryMetas);
        $stmtMetas->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmtMetas->execute();
        $resMetas = $stmtMetas->fetch(PDO::FETCH_ASSOC);

        $progresoMetasTexto = "N/A"; // Valor por defecto si no hay metas o datos
        if ($resMetas['total_meta'] > 0) {
            $progreso = ($resMetas['total_ahorrado_en_metas'] / $resMetas['total_meta']) * 100;
            $progresoMetasTexto = number_format($progreso, 2) . '%';
        } else {
            $progresoMetasTexto = "Sin metas"; // Mensaje si el usuario no tiene metas establecidas
        }

        return [
            'porcentajeCrecimiento' => $porcentajeCrecimiento . '%',
            'margenAhorro' => $margenAhorro . '%',
            'objetivoVentas' => $progresoMetasTexto // Renombrado a objetivoVentas por consistencia, pero es Progreso de Metas
        ];
    }

    /**
     * Auxiliar: Obtiene el total de ahorro para un rango de fechas dado (suma directa de depósitos).
     * Utilizado para KPIs, no para la gráfica acumulada.
     * @param string $fechaInicio Fecha de inicio del rango.
     * @param string $fechaFin Fecha de fin del rango.
     * @return float Suma total de los ahorros.
     */
    private function getTotalAhorro($fechaInicio, $fechaFin) {
        $query = "SELECT SUM(ha.cantidad) as total_ahorro
                  FROM historial_ahorros ha
                  JOIN metas_ahorro ma ON ha.meta_id = ma.id
                  WHERE ma.usuario_id = :usuario_id
                    AND ha.fecha BETWEEN :fechaInicio AND :fechaFin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $result['total_ahorro'];
    }

    /**
     * Auxiliar: Obtiene el total de gastos para un rango de fechas dado.
     * @param string $fechaInicio Fecha de inicio del rango.
     * @param string $fechaFin Fecha de fin del rango.
     * @return float Suma total de los gastos.
     */
    private function getTotalGastos($fechaInicio, $fechaFin) {
        $query = "SELECT SUM(monto) as total_gasto
                  FROM gastos_fijos
                  WHERE usuario_id = :usuario_id
                    AND fecha BETWEEN :fechaInicio AND :fechaFin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $result['total_gasto'];
    }
}
?>