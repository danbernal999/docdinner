// firebase.js
import { auth, provider } from './firebase.js';
import { signInWithPopup } from "firebase/auth";

const googleBtn = document.getElementById("google-login-btn");

if (googleBtn) {
  googleBtn.addEventListener("click", () => {
    signInWithPopup(auth, provider)
      .then((result) => {
        const user = result.user;
        alert(`Bienvenido, ${user.displayName}`);
        // Redirige a la página que quieras después del login
        window.location.href = "../vista/dashboard.php"; 
      })
      .catch((error) => {
        console.error("Error en el login con Google:", error);
        alert("No se pudo iniciar sesión con Google.");
      });
  });
} else {
  console.error("No se encontró el botón de login con Google");
}


