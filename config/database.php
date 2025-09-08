<?php
function getDB() {
    $host = getenv("DB_HOST") ?: "localhost";
    $dbname = getenv("DB_NAME") ?: "control_gastos";
    $username = getenv("DB_USER") ?: "root";
    $password = getenv("DB_PASSWORD") ?: "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}
?>





