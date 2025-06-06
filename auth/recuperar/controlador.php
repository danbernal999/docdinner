<?php
include_once 'auth/recuperar/modelo.php';

class RecuperarController {
    private $recuperarModel;

    public function __construct($db) {
        $this->recuperarModel = new ModeloRecuperar($db);
    }

    public function recuperar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recuperar'])) {
            $correo = trim($_POST['correo']);
            $usuario = $this->recuperarModel->verificarCorreo($correo);

            if ($usuario) {
                // 1. Generar token único
                $token = bin2hex(random_bytes(32));
                $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

                // 2. Guardar token
                $this->recuperarModel->guardarToken($correo, $token, $expira);

                // 3. Enviar correo
                require_once 'utils/phpmailer.php';
                $asunto = 'Recuperación de contraseña - DocDinner';
                $mensajeHtml = "
                    <h2>Recuperación de contraseña</h2>
                    <p>Hola, has solicitado restablecer tu contraseña. Haz clic en el siguiente botón para continuar:</p>
                    <p><a href='' style='background-color:#4f46e5;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Restablecer contraseña: $token</a></p>
                    <p>Si no hiciste esta solicitud, puedes ignorar este mensaje.</p>
                ";
                $mensajeTextoPlano = "Hola, visita este enlace para restablecer tu contraseña: $token";

                $resultado = enviarCorreo($correo, $asunto, $mensajeHtml, $mensajeTextoPlano, 'Nombre del Usuario');

                // JSON Response
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'El enlace de recuperación fue enviado a tu correo.'
                ]);
                exit;
            } else {
                // Usuario no encontrado
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'El correo no está registrado.'
                ]);
                exit;
            }
        }

        // Si es GET o no POST válido, mostrar vista HTML
        include 'auth/recuperar/recovery.php';
    }
}

?>

