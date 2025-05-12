<?php
require_once 'auth/modelo.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST["login"])) {
                $correo = trim($_POST["correo"]);
                $password = trim($_POST["password"]);
                
                if (empty($correo) || empty($password)) {
                    $error = "Correo y contraseña son obligatorios.";
                } else {
    
                    $user = $this->userModel->iniciar($correo, $password);
                    
                    if ($user) {
                        session_start();
                        $_SESSION["usuario_id"] = $user["id"];
                        $_SESSION["nombre"] = $user["nombre"];
                        header('Location: index.php?ruta=main');
                        exit;
                    } else {
                        $error = "Credenciales incorrectas";
                        include 'auth/vista/login.php';
                    }
                }
                
            } else if(isset($_POST["registro"])){
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
                    $resultado = $this->userModel->registro($nombre, $correo, $password);

                    if (!$resultado['success']) {
                        $error = $resultado['message'];
                    }else{
                        $mensaje = $resultado['message'];
                    }
                }
                include 'auth/vista/login.php';
    
            }
        }else {
            include 'auth/vista/login.php';
        }
    }
}


?>