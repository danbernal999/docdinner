<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_gasto = $_POST['nombre_gasto'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO gastos_fijos (nombre_gasto, monto, fecha, categoria, descripcion) VALUES (:nombre_gasto, :monto, :fecha, :categoria, :descripcion)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nombre_gasto' => $nombre_gasto,
        ':monto' => $monto,
        ':fecha' => $fecha,
        ':categoria' => $categoria,
        ':descripcion' => $descripcion,
    ]);

    header("Location: index.php");
}
?>
