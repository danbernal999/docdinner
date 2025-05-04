<?php
include '../../config/database.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Database connection failed.");
}

$query = "SELECT tipo, SUM(cantidad) AS total FROM movimientos GROUP BY tipo";
$result = $conn->query($query);

$datos = ['ingresos' => 0, 'gastos' => 0];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row['tipo'] == 'ingreso') {
            $datos['ingresos'] = $row['total'];
        } elseif ($row['tipo'] == 'gasto') {
            $datos['gastos'] = $row['total'];
        }
    }
} else {
    error_log("Database query failed: " . $conn->error);
}

header('Content-Type: application/json');
echo json_encode($datos);
?>
