<?php
include_once('db_connect.php');

//Comprobar si el id esta presente
if (isset($_GET['id'])) {
    $id = $_GET['id'];
//Establece conexion activa y almacena
    $database = new Connection();
    $db = $database->open();

    try {
        $sql = "DELETE FROM metas_ahorro WHERE id = :id"; //Fk
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]); //$id identifica el registro que se desea eliminar

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $database->close();
}
?>
