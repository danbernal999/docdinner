document.getElementById('recovery-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevenir el envío tradicional del formulario

    const form = e.target;
    const formData = new FormData(form);
    formData.append('recuperar', '1');

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('recovery-container').innerHTML = `
                <div class="text-center">
                    <h1 class="text-2xl font-bold mb-4 text-green-600">¡Revisa tu correo!</h1>
                    <p class="text-gray-700">${data.message}</p>
                </div>
            `;
        } else {
             mostrarAlerta("alerta-recuperar", data.message, "error");
        }
    })
});