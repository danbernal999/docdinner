<?php
require_once '../metas_ahorro/db_connect.php';

// Verificar si $conn está definido
if (!isset($conn)) {
    die("Error: La conexión a la base de datos no está establecida.");
}

// Obtener saldo inicial desde la base de datos
$stmt = $conn->prepare("SELECT valor FROM configuracion WHERE clave = 'saldo_inicial'");
$stmt->execute();
$saldoInicial = $stmt->fetchColumn() ?? 0;

// Obtener ingresos adicionales
$stmt = $conn->prepare("SELECT SUM(monto) FROM ingresos");
$stmt->execute();
$ingresosAdicionales = $stmt->fetchColumn() ?? 0;

// Obtener total de gastos
$stmt = $conn->prepare("SELECT SUM(monto) FROM gastos_fijos");
$stmt->execute();
$totalGastos = $stmt->fetchColumn() ?? 0;

// Calcular saldo actual
$saldoActual = $saldoInicial + $ingresosAdicionales - $totalGastos;

// Actualizar saldo manualmente si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_saldo'])) {
    $nuevoSaldo = floatval($_POST['nuevo_saldo']);
    $stmt = $conn->prepare("UPDATE configuracion SET valor = :valor WHERE clave = 'saldo_inicial'");
    $stmt->execute(['valor' => $nuevoSaldo]);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financiero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: white;
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
        }
        .card {
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 10px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            font-size: 1.5em;
        }
        .highlight {
            color: rgb(9, 255, 95);
            font-weight: bold;
        }
        form {
            margin-top: 20px;
        }
        input {
            padding: 8px;
            font-size: 1em;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: white;
            width: 100px;
            text-align: center;
        }
        button {
            padding: 10px 15px;
            background-color: rgb(9, 255, 95);
            color: black;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        button:hover {
            background-color: rgb(30, 206, 233);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Financiero</h1>

        <div class="card">
            <p>Saldo Inicial: <span class="highlight">$<?= number_format($saldoInicial, 2) ?></span></p>
        </div>

        <div class="card">
            <p>Ingresos Adicionales: <span class="highlight">$<?= number_format($ingresosAdicionales, 2) ?></span></p>
        </div>

        <div class="card">
            <p>Total Gastos: <span class="highlight">$<?= number_format($totalGastos, 2) ?></span></p>
        </div>

        <div class="card">
            <p>Saldo Actual: <span class="highlight">$<?= number_format($saldoActual, 2) ?></span></p>
        </div>

        <form method="POST">
            <label for="nuevo_saldo">Ajustar Saldo Inicial:</label>
            <input type="number" name="nuevo_saldo" id="nuevo_saldo" step="0.01" required>
            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>