<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION["nombre"] ?? "Usuario";
$apellido = $_SESSION["apellido"] ?? "";
$usuario = $_SESSION["usuario"] ?? "";
$info = "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil - DocDinner</title>
  <!-- Cargar Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#22C55E",
            secondary: "#3B82F6",
            accent: "#F59E0B",
            danger: "#EF4444",
            dark: "#181818",
            "dark-light": "#252525",
            neutral: {
              900: "#171717",
              50: "#F9FAFB"
            }
          }
        }
      }
    }
  </script>
  <!-- Iconos Remix (opcional para íconos) -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-neutral-50 text-neutral-950 min-h-screen p-6">
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold text-start mb-8">Editar Perfil</h2>
    <div class="flex flex-col md:flex-row gap-8">
      <!-- Tarjeta de Usuario -->
      <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-2xl">
        <div class="flex flex-col items-center mb-6">
          <img src="../assets/icons/user-profile-icon-free-vector.jpg" alt="Perfil" class="rounded-full w-25 h-24">
          <button class="mt-4 bg-neutral-500 hover:bg-cyan-500 text-white py-2 px-4 rounded-full transition">
            Modificar
          </button>
        </div>
        <form class="space-y-4">
          <div>
            <label class="block text-gray-600 mb-1">Nombre</label>
            <input type="text" class="w-full bg-neutral-50 border border-gray-300 rounded px-3 py-2 text-neutral-900" value="<?= htmlspecialchars($nombre) ?>" readonly>
          </div>
          <div>
            <label class="block text-gray-600 mb-1">Apellidos</label>
            <input type="text" class="w-full bg-neutral-50 border border-gray-300 rounded px-3 py-2 text-neutral-900" value="<?= htmlspecialchars($apellido) ?>" readonly>
          </div>
          <div>
            <label class="block text-gray-600 mb-1">Nombre de usuario</label>
            <input type="text" class="w-full bg-neutral-50 border border-gray-300 rounded px-3 py-2 text-neutral-900" value="<?= htmlspecialchars($usuario) ?>" readonly>
            <small class="text-gray-500">www.docdinner.com/<?= htmlspecialchars($usuario) ?></small>
          </div>
          <div>
            <label class="block text-gray-600 mb-1">Info...</label>
            <textarea class="w-full bg-neutral-50 border border-gray-300 rounded px-3 py-2 text-neutral-900" rows="3" readonly><?= htmlspecialchars($info) ?></textarea>
          </div>
        </form>
      </div>
      
      <!-- Seguridad y Privacidad -->
      <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-2xl">
        <h4 class="text-2xl font-bold text-neutral-900 mb-4">Seguridad</h4>
        <p class="text-gray-600 mb-6">Protegemos tu cuenta con autenticación de dos factores.</p>
        <h4 class="text-2xl font-bold text-neutral-900 mb-4">Privacidad y Datos</h4>
        <p class="text-gray-600 mb-6">Protegemos tus datos personales con estrictas políticas de privacidad.</p>
        <div class="pt-10 space-y-4 h-full flex flex-col justify-center">
          <div class="py-3 border-t border-cyan-50"></div>
          <button class="w-full bg-neutral-950 hover:bg-cyan-500 text-white py-2 rounded transition">Restablecer</button>
          <button class="w-full bg-neutral-950 hover:bg-cyan-500 text-white py-2 rounded transition">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>


