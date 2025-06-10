const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', ()=> {
    container.classList.add("active");
});

loginBtn.addEventListener('click', ()=> {
    container.classList.remove("active");
});


//script para el boton de google
 
window.onload = function () {
  google.accounts.id.initialize({
    client_id: "663492966810-6s64kqnulk4gkcr9vuevbl9o10f2i42b.apps.googleusercontent.com",
    callback: handleCredentialResponse
  });

  google.accounts.id.renderButton(
    document.getElementById("g_id_signin"),
    {
      theme: "outline",
      size: "large",
      type: "icon"  // Solo el logo, sin texto
    }
  );

  google.accounts.id.prompt(); // Opcional: para mostrar el prompt automáticamente
};

function handleCredentialResponse(response) {
    console.log("Token recibido:", response.credential);

    // Enviar token al servidor
    fetch("procesar_google_login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "credential=" + encodeURIComponent(response.credential)
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        window.location.href = "index.php?ruta=main";
      } else {
        alert("Error en el inicio de sesión con Google.");
      }
    });
}

