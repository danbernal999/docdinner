<?php
// C:\xampp\htdocs\docdinner\modulos\analisis\controlador.php

// 1. Incluir el archivo de configuración de la base de datos
// Ajusta la ruta si tu estructura es diferente. __DIR__ es el directorio actual del archivo.
require_once __DIR__ . '/../../config/database.php';

// 2. ¡IMPORTANTE! Incluir el autoloader de Composer para Dompdf
// Ajusta la ruta si tu estructura es diferente.
require_once __DIR__ . '/../../vendor/autoload.php';

// Usar las clases de Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

class AnalisisController {
    private $conn;
    private $usuario_id;

    public function __construct() {
        // Obtener la conexión a la base de datos
        try {
            $this->conn = getDB();
        } catch (PDOException $e) {
            // Error en la conexión a la DB
            error_log("Error de conexión a la base de datos en AnalisisController: " . $e->getMessage());
            die("Error interno del servidor. Por favor, intente de nuevo más tarde.");
        }

        // Iniciar sesión si no está iniciada (necesario para $_SESSION['usuario_id'])
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario está logueado y obtener su ID
        if (!isset($_SESSION['usuario_id'])) {
            // Si el usuario no está logueado, redirigir al login o mostrar un mensaje de error
            // Puedes cambiar esto a header("Location: index.php?vista=login"); exit();
            die("Acceso denegado. No se ha encontrado el ID de usuario en la sesión.");
        }
        $this->usuario_id = $_SESSION['usuario_id'];
    }

    /**
     * Función principal para la vista web del análisis.
     * Recopila los datos necesarios y los pasa a la vista para mostrar los gráficos interactivos.
     */
    public function analisis() {
        // Definir fechas por defecto para el año actual
        $currentYear = date('Y');
        $fechaInicioDefault = $currentYear . '-01-01';
        $fechaFinDefault = $currentYear . '-12-31';

        // Obtener fechas de los parámetros GET o usar los por defecto
        $fechaInicio = $_GET['inicio'] ?? '';
        $fechaFin    = $_GET['fin']    ?? '';

        // Validar y sanear fechas
        if (empty($fechaInicio) || !DateTime::createFromFormat('Y-m-d', $fechaInicio)) {
            $fechaInicio = $fechaInicioDefault;
        }
        if (empty($fechaFin) || !DateTime::createFromFormat('Y-m-d', $fechaFin)) {
            $fechaFin = $fechaFinDefault;
        }

        $dtFechaInicio = DateTime::createFromFormat('Y-m-d', $fechaInicio);
        $dtFechaFin = DateTime::createFromFormat('Y-m-d', $fechaFin);

        if (!$dtFechaInicio || !$dtFechaFin || $dtFechaInicio > $dtFechaFin) {
            // Si hay un error en las fechas o están invertidas, se restablecen a las del año actual
            $fechaInicio = $fechaInicioDefault;
            $fechaFin = $fechaFinDefault;
        }

        // Obtener otros parámetros de la URL
        $categoria    = isset($_GET['categoria']) && $_GET['categoria'] != '' ? $_GET['categoria'] : 'todas';
        $granularidad = isset($_GET['granularidad']) && $_GET['granularidad'] != '' ? $_GET['granularidad'] : 'mensual';

        // Obtener datos para los gráficos y KPIs (estos datos son JSON para Chart.js)
        $datosGastos = $this->getDatosGastos($fechaInicio, $fechaFin, $categoria, $granularidad);
        $datosAhorroComparativo = $this->getDatosAhorroComparativo($fechaInicio, $fechaFin, $granularidad);
        $datosDesgloseCategorias = $this->getDatosDesgloseCategorias($fechaInicio, $fechaFin, $categoria);
        $kpis = $this->getKpis($fechaInicio, $fechaFin, $categoria);

        // Incluir la vista que mostrará los datos para la interfaz web.
        // La ruta es relativa al directorio raíz del proyecto desde donde se carga el controlador.
        include 'modulos/analisis/vista/filtrar.php';
    }

    /**
     * Método para generar el PDF detallado del análisis financiero.
     * Recopila los mismos datos que la función `analisis()` pero los formatea
     * para la plantilla HTML del PDF, que luego Dompdf renderiza.
     */
    public function generarPdf() {
        // --- Depuración: Confirma que este método es llamado ---
        error_log("DEBUG: generarPdf() en AnalisisController ha sido llamado.");

        // Replicar la lógica de obtención y validación de parámetros de analisis()
        // Esto asegura que el PDF usa los mismos filtros que la vista web
        $currentYear = date('Y');
        $fechaInicioDefault = $currentYear . '-01-01';
        $fechaFinDefault = $currentYear . '-12-31';

        $fechaInicio = $_GET['inicio'] ?? '';
        $fechaFin    = $_GET['fin']    ?? '';

        if (empty($fechaInicio) || !DateTime::createFromFormat('Y-m-d', $fechaInicio)) {
            $fechaInicio = $fechaInicioDefault;
        }
        if (empty($fechaFin) || !DateTime::createFromFormat('Y-m-d', $fechaFin)) {
            $fechaFin = $fechaFinDefault;
        }

        $dtFechaInicio = DateTime::createFromFormat('Y-m-d', $fechaInicio);
        $dtFechaFin = DateTime::createFromFormat('Y-m-d', $fechaFin);

        if (!$dtFechaInicio || !$dtFechaFin || $dtFechaInicio > $dtFechaFin) {
            $fechaInicio = $fechaInicioDefault;
            $fechaFin = $fechaFinDefault;
        }

        $categoria    = isset($_GET['categoria']) && $_GET['categoria'] != '' ? $_GET['categoria'] : 'todas';
        $granularidad = isset($_GET['granularidad']) && $_GET['granularidad'] != '' ? $_GET['granularidad'] : 'mensual';

        // Obtener los datos usando los mismos métodos que para la vista web
        // Estas variables NO son JSON, son los arrays PHP puros para la plantilla PDF.
        // La plantilla de PDF se encargará de formatearlos o mostrarlos directamente.
        $datosGastos = $this->getDatosGastos($fechaInicio, $fechaFin, $categoria, $granularidad);
        $datosAhorroComparativo = $this->getDatosAhorroComparativo($fechaInicio, $fechaFin, $granularidad);
        $datosDesgloseCategorias = $this->getDatosDesgloseCategorias($fechaInicio, $fechaFin, $categoria);
        $kpis = $this->getKpis($fechaInicio, $fechaFin, $categoria);

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');         // Fuente predeterminada para el PDF
        $options->set('isHtml5ParserEnabled', true);      // Habilitar el parser HTML5
        $options->set('isRemoteEnabled', true);           // ¡IMPORTANTE! Permitir cargar recursos remotos (imágenes, fuentes, CSS externos)
                                                          // Asegúrate de que las URLs de tus imágenes son accesibles por Dompdf.

        $dompdf = new Dompdf($options);

        // Iniciar el "buffering" de salida para capturar el HTML que generará la plantilla del PDF
        ob_start();
        // Incluir la plantilla HTML del PDF. Las variables definidas antes serán accesibles dentro de ella.
        // '__DIR__' asegura que la ruta es relativa al directorio actual del controlador.
        // --- Depuración: Confirma que la plantilla se está incluyendo ---
        error_log("DEBUG: Incluyendo plantilla PDF: " . __DIR__ . '/vista/reporte_pdf.php');
        include __DIR__ . '/vista/reporte_pdf.php';
        $html = ob_get_clean(); // Capturar todo el HTML generado por la inclusión de la plantilla

        // --- Depuración: Guarda el HTML para inspección ---
        // file_put_contents('debug_reporte_analisis.html', $html);
        // error_log("DEBUG: HTML generado guardado en debug_reporte_analisis.html");

        // Cargar el HTML capturado en Dompdf
        $dompdf->loadHtml($html);

        // Configurar tamaño y orientación del papel
        $dompdf->setPaper('A4', 'portrait'); // 'portrait' para vertical, 'landscape' para horizontal

        // Renderizar el HTML a PDF
        $dompdf->render();

        // Enviar el PDF al navegador
        // "Attachment" => false es CLAVE para que se abra en una nueva pestaña y no se descargue automáticamente
        $filename = "Reporte_Analisis_DocDinner_" . date('Ymd_His') . ".pdf";
        error_log("DEBUG: Stream PDF con nombre: " . $filename);
        $dompdf->stream($filename, ["Attachment" => false]);

        exit(); // Es crucial terminar la ejecución después de enviar el PDF
    }

    /**
     * Métodos para obtener datos (getDatosGastos, getDatosAhorroComparativo, getDatosDesgloseCategorias, getKpis, getTotalAhorro, getTotalGastos)
     * Se mantienen como en la última versión, ya que su lógica de extracción de datos es correcta.
     * Solo asegúrate de que devuelvan arrays PHP (no JSON codificado) si se usan directamente en la plantilla PDF.
     * Los he ajustado para que los datos devueltos para el PDF no estén JSON-encoded, mientras que para la vista web (Chart.js) sí.
     */

    private function getDatosGastos($fechaInicio, $fechaFin, $categoria, $granularidad) {
        // ... (Tu lógica existente para obtener datos de gastos) ...
        $labels = [];
        $data = [];
        $groupByFormat = '';
        $phpDateFormat = '';

        switch ($granularidad) {
            case 'diaria': $groupByFormat = '%Y-%m-%d'; $phpDateFormat = 'd M'; break;
            case 'mensual': $groupByFormat = '%Y-%m'; $phpDateFormat = 'M Y'; break;
            case 'anual': $groupByFormat = '%Y'; $phpDateFormat = 'Y'; break;
            default: $groupByFormat = '%Y-%m'; $phpDateFormat = 'M Y'; break;
        }

        if ($categoria !== 'todas' && $categoria !== 'gastos') {
            // Para el PDF, devuelve un array vacío si no hay datos de gastos relevantes
            if (isset($_GET['action']) && $_GET['action'] == 'generar_pdf') {
                return ['labels' => [], 'datasets' => [['label' => 'Gastos', 'data' => []]]];
            }
            // Para Chart.js (JSON), devuelve el formato esperado
            return ['labels' => json_encode([]), 'datasets' => json_encode([['label' => 'Gastos', 'data' => []]])];
        }

        $query = "SELECT DATE_FORMAT(fecha, :groupByFormat) as periodo, SUM(monto) as total_gasto
                  FROM gastos_fijos WHERE usuario_id = :usuario_id AND fecha BETWEEN :fechaInicio AND :fechaFin";
        if ($categoria !== 'todas') { $query .= " AND categoria = :categoria"; }
        $query .= " GROUP BY periodo ORDER BY periodo ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->bindParam(':groupByFormat', $groupByFormat);
        if ($categoria !== 'todas') { $stmt->bindParam(':categoria', $categoria); }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $db_data_map = [];
        foreach ($results as $row) { $db_data_map[$row['periodo']] = (float) $row['total_gasto']; }

        $start_dt = new DateTime($fechaInicio);
        $end_dt = new DateTime($fechaFin);
        $interval_spec = '';
        switch ($granularidad) {
            case 'diaria': $interval_spec = 'P1D'; break;
            case 'mensual': $interval_spec = 'P1M'; break;
            case 'anual': $interval_spec = 'P1Y'; break;
            default: $interval_spec = 'P1M'; break;
        }
        $period = new DatePeriod($start_dt, new DateInterval($interval_spec), $end_dt->modify('+1 day'));

        foreach ($period as $dt) {
            $labels[] = $dt->format($phpDateFormat);
            $sql_period_key = $dt->format(str_replace(['%Y', '%m', '%d'], ['Y', 'm', 'd'], $groupByFormat));
            $data[] = $db_data_map[$sql_period_key] ?? 0;
        }

        // Determinar si es para la vista web (Chart.js) o para la plantilla PDF
        if (isset($_GET['action']) && $_GET['action'] == 'generar_pdf') {
            return [
                'labels' => array_values(array_unique($labels)),
                'datasets' => [
                    [
                        'label' => 'Gastos',
                        'data' => $data,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.3)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 2,
                        'fill' => true,
                        'tension' => 0.4
                    ]
                ]
            ];
        } else {
            return [
                'labels' => json_encode(array_values(array_unique($labels))),
                'datasets' => json_encode([
                    [
                        'label' => 'Gastos',
                        'data' => $data,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.3)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 2,
                        'fill' => true,
                        'tension' => 0.4
                    ]
                ])
            ];
        }
    }

    private function getDatosAhorroComparativo($fechaInicio, $fechaFin, $granularidad) {
        // ... (Tu lógica existente para obtener datos de ahorro comparativo) ...
        $labels = [];
        $groupByFormat = '';
        $phpDateFormat = '';
        $interval_spec = '';

        switch ($granularidad) {
            case 'diaria': $groupByFormat = '%Y-%m-%d'; $phpDateFormat = 'd M'; $interval_spec = 'P1D'; break;
            case 'mensual': $groupByFormat = '%Y-%m'; $phpDateFormat = 'M Y'; $interval_spec = 'P1M'; break;
            case 'anual': $groupByFormat = '%Y'; $phpDateFormat = 'Y'; $interval_spec = 'P1Y'; break;
            default: $groupByFormat = '%Y-%m'; $phpDateFormat = 'M Y'; $interval_spec = 'P1M'; break;
        }

        $fetchAhorroDataByPeriod = function($start_date, $end_date, $groupByFormat) {
            $query = "SELECT DATE_FORMAT(ha.fecha, :groupByFormat) as periodo, SUM(ha.cantidad) as total_ahorro_periodo
                              FROM historial_ahorros ha JOIN metas_ahorro ma ON ha.meta_id = ma.id
                              WHERE ma.usuario_id = :usuario_id AND ha.fecha BETWEEN :startDate AND :endDate
                              GROUP BY periodo ORDER BY periodo ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':startDate', $start_date);
            $stmt->bindParam(':endDate', $end_date);
            $stmt->bindParam(':groupByFormat', $groupByFormat);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        };

        $resultsEstePeriodo = $fetchAhorroDataByPeriod($fechaInicio, $fechaFin, $groupByFormat);
        $startPrevPeriod = (new DateTime($fechaInicio))->modify('-1 year')->format('Y-m-d');
        $endPrevPeriod = (new DateTime($fechaFin))->modify('-1 year')->format('Y-m-d');
        $resultsPeriodoAnterior = $fetchAhorroDataByPeriod($startPrevPeriod, $endPrevPeriod, $groupByFormat);

        $calculateAccumulatedData = function($results_per_period, $start_dt_range_str, $end_dt_range_str, $groupByFormat) use ($interval_spec) {
            $mapData = []; foreach ($results_per_period as $row) {
                $key_format = str_replace(['%Y', '%m', '%d'], ['Y', 'm', 'd'], $groupByFormat);
                $mapData[$row['periodo']] = (float) $row['total_ahorro_periodo'];
            }
            $accumulated_data = [];
            $current_accumulated_sum = 0;
            $start_dt_range = new DateTime($start_dt_range_str);
            $end_dt_range = (new DateTime($end_dt_range_str))->modify('+1 day'); // Incluir el último período
            $period_generator = new DatePeriod($start_dt_range, new DateInterval($interval_spec), $end_dt_range);

            foreach ($period_generator as $dt) {
                $sql_period_key = $dt->format(str_replace(['%Y', '%m', '%d'], ['Y', 'm', 'd'], $groupByFormat));
                $amount_for_current_period = $mapData[$sql_period_key] ?? 0;
                $current_accumulated_sum += $amount_for_current_period;
                $accumulated_data[] = $current_accumulated_sum;
            }
            return $accumulated_data;
        };

        $dataEstePeriodo = $calculateAccumulatedData($resultsEstePeriodo, $fechaInicio, $fechaFin, $groupByFormat);
        $dataPeriodoAnterior = $calculateAccumulatedData($resultsPeriodoAnterior, $startPrevPeriod, $endPrevPeriod, $groupByFormat);

        $temp_labels = [];
        $period_labels_generator = new DatePeriod(new DateTime($fechaInicio), new DateInterval($interval_spec), (new DateTime($fechaFin))->modify('+1 day'));
        foreach ($period_labels_generator as $dt) { $temp_labels[] = $dt->format($phpDateFormat); }


        if (isset($_GET['action']) && $_GET['action'] == 'generar_pdf') {
            return [
                'labels' => array_values(array_unique($temp_labels)),
                'datasets' => [
                    ['label' => 'Ahorro Acumulado ' . (new DateTime($fechaInicio))->format('Y'), 'data' => $dataEstePeriodo],
                    ['label' => 'Ahorro Acumulado ' . (new DateTime($fechaInicio))->modify('-1 year')->format('Y'), 'data' => $dataPeriodoAnterior]
                ]
            ];
        } else {
            return [
                'labels' => json_encode(array_values(array_unique($temp_labels))),
                'datasets' => json_encode([
                    [
                        'label' => 'Ahorro Acumulado ' . (new DateTime($fechaInicio))->format('Y'),
                        'data' => $dataEstePeriodo,
                        'borderColor' => 'rgba(6, 182, 212, 1)',
                        'backgroundColor' => 'rgba(6, 182, 212, 0.2)',
                        'fill' => true,
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Ahorro Acumulado ' . (new DateTime($fechaInicio))->modify('-1 year')->format('Y'),
                        'data' => $dataPeriodoAnterior,
                        'borderColor' => 'rgba(234, 179, 8, 1)',
                        'backgroundColor' => 'rgba(234, 179, 8, 0.2)',
                        'fill' => true,
                        'tension' => 0.4
                    ]
                ])
            ];
        }
    }

    private function getDatosDesgloseCategorias($fechaInicio, $fechaFin, $categoria) {
        // ... (Tu lógica existente para obtener datos de desglose por categoría) ...
        if ($categoria !== 'todas' && $categoria !== 'gastos') {
            if (isset($_GET['action']) && $_GET['action'] == 'generar_pdf') {
                return ['labels' => [], 'data' => [], 'backgroundColor' => []];
            }
            return ['labels' => json_encode([]), 'data' => json_encode([]), 'backgroundColor' => json_encode([])];
        }

        $query = "SELECT categoria, SUM(monto) as total_gasto FROM gastos_fijos
                  WHERE usuario_id = :usuario_id AND fecha BETWEEN :fechaInicio AND :fechaFin";
        if ($categoria !== 'todas') { $query .= " AND categoria = :categoria"; }
        $query .= " GROUP BY categoria ORDER BY total_gasto DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        if ($categoria !== 'todas') { $stmt->bindParam(':categoria', $categoria); }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $data = [];
        $colores = [
            '#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d', '#17a2b8', '#6610f2', '#e83e8c',
            '#fd7e14', '#20c997', '#6f42c1', '#f8f9fa', '#343a40', '#007bff', '#28a745'
        ];
        $assigned_colors = [];

        foreach ($results as $index => $row) {
            $labels[] = $row['categoria'];
            $data[] = (float) $row['total_gasto'];
            $assigned_colors[] = $colores[$index % count($colores)];
        }

        if (isset($_GET['action']) && $_GET['action'] == 'generar_pdf') {
            return [
                'labels' => $labels,
                'data' => $data,
                'backgroundColor' => $assigned_colors
            ];
        } else {
            return [
                'labels' => json_encode($labels),
                'data' => json_encode($data),
                'backgroundColor' => json_encode($assigned_colors)
            ];
        }
    }

    private function getKpis($fechaInicio, $fechaFin, $categoria) { /* ... (igual que antes) ... */
        // KPI 1: Crecimiento Ahorro Anual (comparación con el año anterior)
        $totalAhorroActual = $this->getTotalAhorro($fechaInicio, $fechaFin);

        $startPrevPeriod = (new DateTime($fechaInicio))->modify('-1 year')->format('Y-m-d');
        $endPrevPeriod = (new DateTime($fechaFin))->modify('-1 year')->format('Y-m-d');
        $totalAhorroAnterior = $this->getTotalAhorro($startPrevPeriod, $endPrevPeriod);

        $porcentajeCrecimiento = 0;
        if ($totalAhorroAnterior > 0) {
            $porcentajeCrecimiento = (($totalAhorroActual - $totalAhorroAnterior) / $totalAhorroAnterior) * 100;
        } elseif ($totalAhorroActual > 0) {
            $porcentajeCrecimiento = 100;
        }
        $porcentajeCrecimiento = number_format($porcentajeCrecimiento, 2);

        // KPI 2: Margen de Ahorro (Ahorro / (Ahorro + Gasto)) * 100
        $totalGastoActual = $this->getTotalGastos($fechaInicio, $fechaFin);
        $margenAhorro = 0;
        if (($totalAhorroActual + $totalGastoActual) > 0) {
            $margenAhorro = ($totalAhorroActual / ($totalAhorroActual + $totalGastoActual)) * 100;
        }
        $margenAhorro = number_format($margenAhorro, 2);

        // KPI 3: Progreso General de Metas (Ahorrado en Metas / Total de Metas) * 100
        $queryMetas = "SELECT SUM(cantidad_meta) as total_meta, SUM(ahorrado) as total_ahorrado_en_metas
                        FROM metas_ahorro
                        WHERE usuario_id = :usuario_id";
        $stmtMetas = $this->conn->prepare($queryMetas);
        $stmtMetas->bindParam(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $stmtMetas->execute();
        $resMetas = $stmtMetas->fetch(PDO::FETCH_ASSOC);

        $progresoMetasTexto = "N/A";
        if ($resMetas['total_meta'] > 0) {
            $progreso = ($resMetas['total_ahorrado_en_metas'] / $resMetas['total_meta']) * 100;
            $progresoMetasTexto = number_format($progreso, 2) . '%';
        } else {
            $progresoMetasTexto = "Sin metas definidas";
        }

        return [
            'porcentajeCrecimiento' => $porcentajeCrecimiento . '%',
            'margenAhorro' => $margenAhorro . '%',
            'objetivoVentas' => $progresoMetasTexto
        ];
    }

    private function getTotalAhorro($fechaInicio, $fechaFin) { /* ... (igual que antes) ... */
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

    private function getTotalGastos($fechaInicio, $fechaFin) { /* ... (igual que antes) ... */
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