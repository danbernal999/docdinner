import { auth, provider } from "firebase.js";
import { signInWithPopup } from "firebase/auth";

document.getElementById("googleLogin").addEventListener("click", () => {
  signInWithPopup(auth, provider)
    .then((result) => {
      const user = result.user;

      fetch("/docdinner/auth/firebase/login.js", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: user.displayName,
          email: user.email,
          uid: user.uid,
          photo: user.photoURL
        })
      }).then(res => {
        if (res.ok) {
          window.location.href = "/dashboard.php";
        }
      });
    })
    .catch((error) => {
      console.error("Error con Google Sign-In", error);
    });
});
