<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM gastos_fijos WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

header("Location: index.php");
?>
