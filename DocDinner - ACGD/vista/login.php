<?php
include '../config/database.php';
session_start();
/* session_start();

Inicia una sesión en PHP o reanuda una sesión existente.
Permite manejar variables de sesión, lo que es útil para autenticar usuarios, almacenar información temporal, etc. */

$mensaje = ""; // Variable para éxito
$error = "";   // Variable para errores

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["registro"])) { // Si el usuario se está registrando
        $nombre = trim($_POST["nombre"]);
        $correo = trim($_POST["correo"]);
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Validar datos
        if (empty($nombre) || empty($correo) || empty($password) || empty($confirm_password)) {
            $error = "Todos los campos son obligatorios.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = "Formato de correo inválido.";
        } elseif ($password !== $confirm_password) {
            $error = "Las contraseñas no coinciden.";
        } else {
            // Hash de contraseña
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Verificar si el correo ya existe
                $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = :correo");
                $stmt->bindParam(":correo", $correo);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $error = "Este correo ya está registrado.";
                } else {
                    // Insertar usuario
                    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (:nombre, :correo, :password)");
                    $stmt->bindParam(":nombre", $nombre);
                    $stmt->bindParam(":correo", $correo);
                    $stmt->bindParam(":password", $password_hashed);

                    if ($stmt->execute()) {
                        $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
                    } else {
                        $error = "Error al registrar usuario.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Error en la consulta: " . $e->getMessage();
            }
        }
    }

    if (isset($_POST["login"])) { // Si el usuario inicia sesión
        $correo = trim($_POST["correo"]);
        $password = $_POST["password"];

        if (empty($correo) || empty($password)) {
            $error = "Correo y contraseña son obligatorios.";
        } else {
            try {
                $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = :correo");
                $stmt->bindParam(":correo", $correo);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && password_verify($password, $usuario["password"])) {
                    $_SESSION["usuario_id"] = $usuario["id"];
                    $_SESSION["nombre"] = $usuario["nombre"];
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Correo o contraseña incorrectos.";
                }
            } catch (PDOException $e) {
                $error = "Error en la consulta: " . $e->getMessage();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login_style.css">
    <link rel="shortcut icon" href="../assets/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <title>Login / Registro</title>
</head>
<body class="body-login">
    <div class="container" id="container">

        <!-- Mostramos mensajes -->
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?= $error ?></p>
        <?php endif; ?>

        <?php if (isset($mensaje)): ?>
            <p style="color: green; text-align: center;"><?= $mensaje ?></p>
        <?php endif; ?>

        <!-- REGISTRO -->
        <div class="form-container sign-up">
            <form action="login.php" method="POST">
                <h1>Crear Cuenta</h1>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="correo" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="confirm_password" placeholder="Confirmar contraseña" required>
                <button type="submit" name="registro">Crear Cuenta</button>
                <span>o utiliza tu correo electrónico para registrarte</span>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="ri-google-fill"></i></a>
                    <a href="#" class="icon"><i class="ri-facebook-fill"></i></a>
                    <a href="#" class="icon"><i class="ri-github-fill"></i></a>
                    <a href="#" class="icon"><i class="ri-linkedin-fill"></i></a>
                </div>
            </form>
        </div>

        <!-- LOGIN -->
        <div class="form-container sign-in">
            <form action="login.php" method="POST">
                <h1>Iniciar Sesión</h1>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <a href="#">Olvidaste tu contraseña?</a>
                <button type="submit" name="login">Iniciar Sesión</button>
                <span>o continuar con</span>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="ri-google-fill"></i></a>
                    <a href="#" class="icon"><i class="ri-facebook-fill"></i></a>
                    <a href="#" class="icon"><i class="ri-github-fill"></i></a>
                    <a href="#" class="icon"><i class="ri-linkedin-fill"></i></a>
                </div>
            </form>
        </div>

        <!-- ANIMACIÓN ENTRE LOGIN Y REGISTRO -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bienvenido, Amigo!</h1>
                    <p>Introduzca sus datos personales para utilizar todas las funciones del sitio</p>
                    <button class="hidden" id="login">Iniciar Sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hola, Amigo!</h1>
                    <p>Regístrese con datos personales para utilizar todas las funciones del sitio.</p>
                    <button class="hidden" id="register">Crear Cuenta</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
