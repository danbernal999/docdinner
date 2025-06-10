<?php
include 'modulos/cuenta/modelo.php';

class CuentaController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new UsuarioModel($db);
    }

    public function cuenta() {

        $idUsuario = $_SESSION["usuario_id"];
        $nombre = $_SESSION["nombre"] ?? "Usuario";
        $apellido = $_SESSION["apellido"] ?? "";
        $usuario = $_SESSION["usuario"] ?? "";
        $info = ""; //obtener el id del usuario actuali
        
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
            }elseif(isset($_POST['changeFoto']) && isset($_FILES['foto_perfil'])) {
                $foto = $_FILES['foto_perfil'];

                if ($foto['error'] === UPLOAD_ERR_OK) {
                    $nombreTemporal = $foto['tmp_name'];

                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $nombreTemporal);
                    finfo_close($finfo);

                    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
                    $tamanoMax = 2 * 1024 * 1024; // 2MB

                    if (!in_array($mime, $tiposPermitidos)) {
                        // Manejar error tipo no válido
                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=tipo_invalido");
                        exit();
                    }

                    if ($foto['size'] > $tamanoMax) {
                        // Manejar error tamaño
                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=tamano_excedido");
                        exit();
                    }

                    $extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
                    $extension = strtolower($extension);

                    $nombreFinal = uniqid("perfil_") . '.' . $extension;
                    $rutaDestino = 'uploads/' . $nombreFinal;

                    if (move_uploaded_file($nombreTemporal, $rutaDestino)) {
                        $this->usuarioModel->actualizarFoto($idUsuario, $rutaDestino);
                        $_SESSION['foto'] = $rutaDestino;

                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=foto_cambiada");
                        exit();
                    } else {
                        header("Location: index.php?ruta=main&modulo=cuenta&mensaje=error_subida");
                        exit();
                    }
                } else {
                    header("Location: index.php?ruta=main&modulo=cuenta&mensaje=archivo_invalido");
                    exit();
                }
            }
        }else {
            $usuario = $this->usuarioModel->obtenerUsuarioPorId($idUsuario);
            require_once 'utils/fotoPerfil.php';
            $foto = $_SESSION['foto'] ?? '';
            $rutaFoto = obtenerRutaFoto($foto);
            include 'modulos/cuenta/vista/cuenta.php';
        }

        

    }
}
?>