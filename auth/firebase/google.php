<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $nombre = $data['name'];
    $email = $data['email'];
    $uid = $data['uid'];
    $foto = $data['photo'];

    $conn = new mysqli("localhost", "usuario", "clave", "basededatos");

    if ($conn->connect_error) {
        http_response_code(500);
        exit;
    }

    // Verificar si ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, uid, foto) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $uid, $foto);
        $stmt->execute();
    }

    $_SESSION['user'] = $nombre;
    echo json_encode(['status' => 'ok']);
}
?>
