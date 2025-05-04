<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre_gasto = $_POST['nombre_gasto'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE gastos_fijos SET 
                nombre_gasto = :nombre_gasto, 
                monto = :monto, 
                fecha = :fecha, 
                categoria = :categoria, 
                descripcion = :descripcion 
            WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':nombre_gasto' => $nombre_gasto,
        ':monto' => $monto,
        ':fecha' => $fecha,
        ':categoria' => $categoria,
        ':descripcion' => $descripcion,
        ':id' => $id
    ]);

    // Redirigir al listado principal
    header("Location: index.php");
}
?>
