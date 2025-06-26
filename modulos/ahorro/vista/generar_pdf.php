<?php
// C:\xampp\htdocs\docdinner\modulos\ahorro\vista\generar_pdf.php

// 1. Incluir el archivo de configuración de la base de datos
require_once '../../../config/database.php';

// 2. Incluir el autoloader de Composer para Dompdf
require_once '../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Iniciar sesión si no está iniciada (necesario para $_SESSION['usuario_id'])
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado y obtener su ID
if (!isset($_SESSION['usuario_id'])) {
    die("Acceso denegado. No se ha encontrado el ID de usuario en la sesión.");
}
$id_usuario = $_SESSION['usuario_id'];

// Obtener el ID de la meta desde la URL
if (!isset($_GET['meta_id']) || !is_numeric($_GET['meta_id'])) {
    die("Error: ID de meta no especificado o inválido.");
}
$meta_id = intval($_GET['meta_id']);

// Obtener la conexión a la base de datos usando la función getDB()
try {
    $db = getDB(); // Llama a la función definida en database.php para obtener la conexión
} catch (PDOException $e) {
    die("Error al obtener la conexión a la base de datos: " . $e->getMessage());
}

// Lógica para obtener los datos de LA meta de ahorro específica del usuario
$meta = null;
try {
    $stmt = $db->prepare("SELECT id, nombre_meta, cantidad_meta, fecha_limite, descripcion, ahorrado, cumplida FROM metas_ahorro WHERE id = :meta_id AND usuario_id = :id_usuario LIMIT 1");
    $stmt->bindParam(':meta_id', $meta_id, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $meta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$meta) {
        die("Error: Meta no encontrada o no pertenece al usuario.");
    }

    // Obtener el historial de ahorros para esta meta específica
    $stmtHistorial = $db->prepare("SELECT cantidad, fecha, descripcion1 FROM historial_ahorros WHERE meta_id = :meta_id ORDER BY fecha DESC");
    $stmtHistorial->bindParam(':meta_id', $meta['id'], PDO::PARAM_INT);
    $stmtHistorial->execute();
    $historial = $stmtHistorial->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al obtener la meta de ahorro o su historial: " . $e->getMessage());
}

// Configurar opciones de Dompdf
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Contenido HTML para el PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historial de Ahorro para ' . htmlspecialchars($meta['nombre_meta']) . ' - DocDinner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff; /* Color de DocDinner */
        }
        .header img {
            max-width: 80px; /* Tamaño del logo */
            vertical-align: middle;
            margin-right: 10px;
        }
        .header h1 {
            display: inline-block;
            vertical-align: middle;
            color: #007bff; /* Color de DocDinner */
            font-size: 24px;
            margin: 0;
        }
        h2 {
            text-align: center;
            color: #555;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .meta-summary-table {
            width: 90%;
            margin: 0 auto 30px auto;
            border-collapse: collapse;
        }
        .meta-summary-table th, .meta-summary-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .meta-summary-table th {
            background-color: #e0e0e0; /* Un gris claro */
            color: #444;
            font-weight: bold;
            font-size: 14px;
        }
        .meta-summary-table td {
            font-size: 14px;
        }
        .progress-bar-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            height: 20px;
            margin-top: 5px;
        }
        .progress-bar {
            height: 100%;
            background-color: #28a745; /* Verde Bootstrap */
            text-align: center;
            color: white;
            line-height: 20px;
            font-size: 12px;
            white-space: nowrap;
        }
        .estado-cumplida {
            color: #28a745; /* Verde para cumplida */
            font-weight: bold;
        }
        .estado-pendiente {
            color: #ffc107; /* Amarillo/naranja para pendiente */
            font-weight: bold;
        }
        .estado-alcanzada {
            color: #17a2b8; /* Azul claro para alcanzada */
            font-weight: bold;
        }
        .historial-table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .historial-table th, .historial-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .historial-table th {
            background-color: #f8f9fa; /* Fondo más claro para historial */
            color: #555;
            font-weight: bold;
            font-size: 13px;
        }
        .historial-table td {
            font-size: 13px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DocDinner - Reporte de Ahorros</h1>
    </div>

    <h2>Historial de Ahorros para: <br>' . htmlspecialchars($meta['nombre_meta']) . '</h2>

    <table class="meta-summary-table">
        <thead>
            <tr>
                <th>Cantidad Meta</th>
                <th>Ahorrado</th>
                <th>Fecha Límite</th>
                <th>Descripción de Meta</th>
                <th>Progreso</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>';
                $progreso_porcentaje = ($meta['cantidad_meta'] > 0) ? round(($meta['ahorrado'] / $meta['cantidad_meta']) * 100, 2) : 0;
                if ($progreso_porcentaje > 100) $progreso_porcentaje = 100;

                $estado_texto = '';
                $estado_clase = '';
                if ($meta['cumplida'] == 1) {
                    $estado_texto = 'Cumplida';
                    $estado_clase = 'estado-cumplida';
                } elseif ($meta['ahorrado'] >= $meta['cantidad_meta']) {
                    $estado_texto = 'Alcanzada';
                    $estado_clase = 'estado-alcanzada';
                } else {
                    $estado_texto = 'Pendiente';
                    $estado_clase = 'estado-pendiente';
                }

                $html .= '
                <td>$' . number_format($meta['cantidad_meta'], 2, ',', '.') . '</td>
                <td>$' . number_format($meta['ahorrado'], 2, ',', '.') . '</td>
                <td>' . htmlspecialchars($meta['fecha_limite']) . '</td>
                <td>' . (empty($meta['descripcion']) ? 'Sin descripción' : htmlspecialchars($meta['descripcion'])) . '</td>
                <td>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: ' . $progreso_porcentaje . '%;">' . $progreso_porcentaje . '%</div>
                    </div>
                </td>
                <td><span class="' . $estado_clase . '">' . $estado_texto . '</span></td>
            </tr>
        </tbody>
    </table>

    <div class="historial-section">
        <h2>Detalle de Aportes</h2>';

        if (empty($historial)) {
            $html .= '<p class="no-data">No hay registros de ingresos para esta meta de ahorro.</p>';
        } else {
            $html .= '<table class="historial-table">
                        <thead>
                            <tr>
                                <th>Fecha del Aporte</th>
                                <th>Cantidad Aportada</th>
                                <th>Descripción del Aporte</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($historial as $aporte) {
                $html .= '
                            <tr>
                                <td>' . htmlspecialchars($aporte['fecha']) . '</td>
                                <td>$' . number_format($aporte['cantidad'], 2, ',', '.') . '</td>
                                <td>' . (empty($aporte['descripcion1']) ? 'Sin descripción' : htmlspecialchars($aporte['descripcion1'])) . '</td>
                            </tr>';
            }
            $html .= '
                        </tbody>
                    </table>';
        }

$html .= '
    </div>

    <div class="footer">
        Reporte generado por DocDinner el ' . date('d/m/Y H:i:s') . '<br>
        Gestiona tus finanzas de forma inteligente.
    </div>
</body>
</html>';

$dompdf->loadHtml($html);

// Renderizar el PDF
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF al navegador (abrir en nueva ventana/pestaña)
$filename = "historial_ahorro_" . htmlspecialchars($meta['nombre_meta']) . "_" . date('YmdHis') . ".pdf";
$dompdf->stream($filename, ["Attachment" => false]);

?>