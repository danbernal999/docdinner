<?php
include_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Connection();
    $db = $database->open();

    try {
        $sql = "UPDATE  metas_ahorro 
                SET nombre_meta = :nombre_meta, 
                    cantidad_meta = :cantidad_meta, 
                    fecha_limite = :fecha_limite, 
                    descripcion = :descripcion 
                WHERE id = :id";

        $stmt = $db->prepare($sql); //proteje de inyecciones SQL
        $stmt->execute([
            ':nombre_meta' => $_POST['nombre_meta'],
            ':cantidad_meta' => $_POST['cantidad_meta'],
            ':fecha_limite' => $_POST['fecha_limite'],
            ':descripcion' => $_POST['descripcion'],
            ':id' => $_POST['id']
        ]);

        header("Location: index.php"); //redirigir a la pagina principal
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $database->close();
}
?>
