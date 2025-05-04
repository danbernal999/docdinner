<?php
session_start();
require_once "config/conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// Consulta para obtener el total de gastos
$queryTotal = "SELECT SUM(monto) as total FROM gastos WHERE usuario_id = ?";
$stmtTotal = $conexion->prepare($queryTotal);
$stmtTotal->bind_param("i", $usuario_id);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$totalGastos = $resultTotal->fetch_assoc()["total"] ?? 0;
$stmtTotal->close();

// Consulta para obtener el gasto más alto registrado
$queryMax = "SELECT MAX(monto) as max_gasto FROM gastos WHERE usuario_id = ?";
$stmtMax = $conexion->prepare($queryMax);
$stmtMax->bind_param("i", $usuario_id);
$stmtMax->execute();
$resultMax = $stmtMax->get_result();
$gastoMasAlto = $resultMax->fetch_assoc()["max_gasto"] ?? 0;
$stmtMax->close();

// Consulta para obtener la categoría con más gastos
$queryCategoria = "SELECT categoria, SUM(monto) as total FROM gastos WHERE usuario_id = ? GROUP BY categoria ORDER BY total DESC LIMIT 1";
$stmtCategoria = $conexion->prepare($queryCategoria);
$stmtCategoria->bind_param("i", $usuario_id);
$stmtCategoria->execute();
$resultCategoria = $stmtCategoria->get_result();
$categoriaMasGastos = $resultCategoria->fetch_assoc()["categoria"] ?? "N/A";
$stmtCategoria->close();

// Respuesta en formato JSON
$response = [
    "total_gastos" => number_format($totalGastos, 2),
    "gasto_mas_alto" => number_format($gastoMasAlto, 2),
    "categoria_mas_gastos" => $categoriaMasGastos
];

echo json_encode($response);
exit;
