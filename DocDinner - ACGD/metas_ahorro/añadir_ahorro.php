<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "control_gastos");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si la solicitud es POST y si los datos fueron enviados correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["meta_id"]) && isset($_POST["cantidad_ahorrada"])) {
    $meta_id = intval($_POST["meta_id"]);
    $cantidad_ahorrada = floatval($_POST["cantidad_ahorrada"]);
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : NULL; // Aquí obtenemos la descripción si está presente

    // Validar que la cantidad ingresada sea positiva y no vacía
    if ($cantidad_ahorrada <= 0) {
        $_SESSION['error'] = "La cantidad ahorrada debe ser mayor a 0.";
        header("Location: index.php");
        exit();
    }

    // Verificar si la meta existe
    $sql_check = "SELECT * FROM metas_ahorro WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $meta_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Meta de ahorro no encontrada.";
        header("Location: index.php");
        exit();
    }

    // Actualizar la cantidad ahorrada en la meta
    $sql_update = "UPDATE metas_ahorro SET ahorrado = ahorrado + ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("di", $cantidad_ahorrada, $meta_id);
    
    // Guardar el registro en historial_ahorros
    $sql_historial = "INSERT INTO historial_ahorros (meta_id, cantidad, descripcion1) VALUES (?, ?, ?)";
    $stmt_historial = $conn->prepare($sql_historial);
    $stmt_historial->bind_param("ids", $meta_id, $cantidad_ahorrada, $descripcion); // Aquí estamos asegurándonos de que la descripción sea almacenada correctamente

    // Intentar ejecutar las consultas y redirigir dependiendo del resultado
    if ($stmt_update->execute() && $stmt_historial->execute()) {
        $_SESSION['success'] = "Ahorro añadido correctamente.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al añadir el ahorro. Intenta de nuevo.";
        header("Location: index.php");
        exit();
    }

    // Cerrar conexiones
    $stmt_check->close();
    $stmt_update->close();
    $stmt_historial->close();
} else {
    $_SESSION['error'] = "Datos no recibidos correctamente.";
    header("Location: index.php");
exit();
}
?>