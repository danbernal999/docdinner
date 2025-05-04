<?php
session_start(); // Asegúrate de que la sesión esté iniciada
include_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_meta = $_POST['nombre_meta'];
    $cantidad_meta = $_POST['cantidad_meta'];
    $fecha_limite = $_POST['fecha_limite'];
    $descripcion = $_POST['descripcion'];

    // Abre la conexión a la base de datos
    $database = new Connection();
    $db = $database->open();
    //INTENTO DE GUARDAR LOS DATOS//
    try {
        // Preparar la consulta SQL
        $sql = "INSERT INTO metas_ahorro (nombre_meta, cantidad_meta, fecha_limite, descripcion) 
                VALUES (:nombre, :cantidad, :fecha, :descripcion)";

        // Preparar el statement
        $stmt = $db->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([
            ':nombre' => $nombre_meta,
            ':cantidad' => $cantidad_meta,
            ':fecha' => $fecha_limite,
            ':descripcion' => $descripcion
        ]);

        // Mensaje de éxito
        $_SESSION['message'] = 'Meta guardada correctamente';
    } catch (PDOException $e) {
        // Si hay un error, guardarlo en el mensaje
        $_SESSION['message'] = 'Error al guardar la meta: ' . $e->getMessage();
    }

    // Cerrar la conexión
    $database->close();

    // Redirigir al índice
    header('location: index.php');
    exit();
}
?>
