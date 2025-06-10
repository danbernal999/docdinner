<?php
  class LogoutController {
      public function logout() {
          session_start();

            // 2. Limpiar todas las variables de sesión
                $_SESSION = array();

            // 3. Eliminar la cookie de sesión (si existe)
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
            );
            }
          session_destroy();
          header("Location: index.php");
          exit();
      }
  }
?>
