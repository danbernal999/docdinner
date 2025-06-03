<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <!-- Estilos Personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Recuperar Contraseña</title>
</head>
<body class="bg-neutral-950">
    <div class="bg-neutral-950 relative h-screen bg-gray-100 flex items-center justify-center">
        <!-- Botón Volver -->
        <div class="absolute top-10 left-10 text-2xl">
            <a href="index.php?ruta=login" class="flex items-center text-white">
                <i class="ri-arrow-left-s-line mt-1 font-bold"></i><span>Volver</span>
            </a>
        </div>

        <!-- RECUPERAR CONTRASEÑA -->
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
            <form action="index.php?ruta=recovery" method="POST">
                <h1 class="text-2xl font-bold mb-4 text-center">Recuperar Contraseña</h1>
                <p class="text-sm text-gray-600 mb-4 text-center">Ingresa tu correo electrónico y te enviaremos instrucciones para restablecer tu contraseña.</p>

                <!-- Alertas -->
                <?php if (!empty($mensaje)): ?>
                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded mb-4 text-sm text-center">
                        <?= htmlspecialchars($mensaje) ?>
                    </div>
                <?php endif; ?>

                <input type="email" name="correo" placeholder="Correo electrónico" required class="w-full mb-4 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" name="recuperar" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>


