<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php'; // para Google Client
include 'config/database.php';
include 'utils/fotoPerfil.php';
session_start();

if (!isset($_POST['credential'])) {
    echo json_encode(['success' => false, 'message' => 'Token no recibido']);
    exit;
}

$token = $_POST['credential'];

$client = new Google_Client(['client_id' => '663492966810-6s64kqnulk4gkcr9vuevbl9o10f2i42b.apps.googleusercontent.com']);

try {
    // Verifica y decodifica el token
    $payload = $client->verifyIdToken($token);
    if ($payload) {
        $nombre = $payload['name'] ?? '';
        $correo = $payload['email'] ?? '';
        $foto = $payload['picture'] ?? '';

        if (empty($correo)) {
            echo json_encode(['success' => false, 'message' => 'Correo no encontrado en el token']);
            exit;
        }

        $pdo = getDB();

        // Verificamos si el usuario existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            // Insertamos usuario nuevo, sin password porque es Google
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password, foto, auth_provider) VALUES (:nombre, :correo, '', :foto, 'google')");
            $stmt->execute([
                'nombre' => $nombre,
                'correo' => $correo,
                'foto' => $foto
            ]);
            $usuarioId = $pdo->lastInsertId();
        } else {
            $usuarioId = $usuario['id'];
        }

        // Creamos sesión
        $_SESSION['usuario_id'] = $usuarioId;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
        $_SESSION['foto'] = $foto;
        $_SESSION['auth_provider'] = 'google';

        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Token inválido']);
        exit;
    }
} catch (Exception $e) {
    error_log('Error validando token Google: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno']);
    exit;
}

?>