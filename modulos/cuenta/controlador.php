<?php
include 'modulos/cuenta/modelo.php';

 class CuentaController {
    private $usuarioModel;

    public function __construct($db) {
       $this->usuarioModel = new UsuarioModel($db);
    }

    public function cuenta() {

        $idUsuario = $_SESSION["usuario_id"]; //obtener el id del usuario actuali

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['changePass'])){
                $passwordActual = $_POST['password_actual'];
                $nuevaPassword = $_POST['nueva_password'];
            
                if (empty($passwordActual) || empty($nuevaPassword)) {
                    header("Location: index.php?ruta=main&modulo=cuenta&mensaje=campos_vacios");
                    exit();
                }
            
                $usuario = $this->usuarioModel->obtenerPasswordPorId($idUsuario);
            
                if ($usuario && password_verify($passwordActual, $usuario['password'])) {
                    
                    if ($this->usuarioModel->actualizarPassword($idUsuario, $nuevaPassword)) {
                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=contraseña_cambiada");
                        exit();
                    } else {
                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=no_cambio_clave");
                        exit();
                    }
                } else {
                    header("Location: index.php?ruta=main&modulo=cuenta&mensaje=contraseña_incorrecta");
                    exit();
                }
            }elseif(isset($_POST['changeCorreo'])){
                
                $nuevoCorreo = trim($_POST["nuevo_correo"]);//Recibimos el correo nuevo

               if (filter_var($nuevoCorreo, FILTER_VALIDATE_EMAIL)) {

                    $usuarioModel = new UsuarioModel($conn);
                    $resultado = $this->usuarioModel->actualizarCorreo($idUsuario, $nuevoCorreo);

                    if ($resultado === true) {
                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=correo_cambiado");
                        exit;
                    } else {
                        echo $resultado; //recibe el resultado ya veran si lo cambian 
                    }
                }else{
                    header("Location: index.php?ruta=main&modulo=cuenta&mensaje=correo_no_valido");
                    exit();
                }
            }
        }else{
            $usuario = $this->usuarioModel->obtenerUsuarioPorId($idUsuario);
            include 'modulos/cuenta/vista/cuenta.php';
        }
        

    }
}
?>