<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
$nombreUsuario = $_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - DocDinner</title>
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
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-dark text-white h-screen w-screen flex">
  <!-- Sidebar (altura completa) -->
  <div class="flex flex-col items-start w-60 h-full text-neutral-50 bg-neutral-950 p-3">
    <a class="flex items-center w-full mb-3" href="#inicio" onclick="mostrarSeccion('inicio')">
      <img src="../assets/images/LogoDocDinnerHD-removebg-preview.png" alt="Logo DocDinner" width="60" height="50">
      <span class="ml-2 text-xl font-bold">DocDinner</span>
    </a>
    <!-- Menú Principal -->
    <div class="w-full">
      <div class="flex flex-col w-full mb-4 border-t border-gray-700 pt-4">
        <a class="flex items-center w-full h-12 px-3 rounded hover:bg-cyan-500 hover:text-cyan-50" href="#inicio" onclick="mostrarSeccion('inicio');">
          <i class="ri-home-line text-2xl"></i>
          <span class="ml-2 text-sm font-medium">Inicio</span>
        </a>
        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-500 hover:text-cyan-50" href="#gastos" onclick="mostrarSeccion('gastos')">
          <i class="ri-bar-chart-line text-2xl"></i>
          <span class="ml-2 text-sm font-medium">Análisis</span>
        </a>
        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-500 hover:text-cyan-50" href="#metas" onclick="mostrarSeccion('metas')">
          <i class="ri-bank-line text-2xl"></i>
          <span class="ml-2 text-sm font-medium">Ahorro</span>
        </a>
      </div>
      <div class="flex flex-col w-full mb-4 border-t border-gray-700 pt-4">
        <a class="flex items-center w-full h-12 px-3 rounded hover:bg-cyan-500 hover:text-cyan-50" href="#productos" onclick="mostrarSeccion('productos')">
          <i class="ri-price-tag-3-line text-2xl"></i>
          <span class="ml-2 text-sm font-medium">Productos</span>
        </a>
        <a class="relative flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-500 hover:text-cyan-50" href="#notificaciones" onclick="mostrarSeccion('notificaciones')">
          <i class="ri-chat-1-line text-2xl"></i>
          <span class="ml-2 text-sm font-medium">Notificaciones</span>
        </a>
        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-500 hover:text-cyan-50" href="#ajustes" onclick="mostrarSeccion('ajustes')">
          <i class="ri-settings-line text-2xl"></i>
          <span class="ml-2 text-sm font-medium">Configuración</span>
        </a>
      </div>
    </div>
    <!-- Enlace de Cuenta -->
    <a class="flex items-center w-full mb-4 h-12 px-3 mt-auto rounded hover:bg-cyan-500 hover:text-cyan-50" href="#perfil" onclick="mostrarSeccion('perfil')">
      <i class="ri-user-line text-2xl"></i>
      <span class="ml-2 text-sm font-medium">Cuenta</span>
    </a>
  </div>

  <!-- Main Content (ocupa el resto de la pantalla) -->
  <main class="flex-1">
    <!-- Contenido de secciones -->
    <div class="">
      <!-- Sección Dashboard (Inicio) -->
      <div id="inicio" class="seccion activa space-y-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
              <iframe src="./inicio.php" class="w-full h-[925px] border"></iframe>
            </div>
        </div>
      </div>

      <!-- Sección Análisis (Gastos) -->
      <div id="gastos" class="seccion hidden">
        <div class="">
          <div class="flex flex-col lg:flex-row gap-6">
            <!-- Gráfica (Iframe) -->
            <div class="flex-1">
              <iframe src="../control_gastos/filtrar.php" class="w-full h-[925px] border-none"></iframe>
            </div>
          </div>
        </div>
      </div>

      <!-- Ahorro Pantalla -->
      <div id="metas" class="seccion hidden">
        <div class="">
          <div class="flex flex-col lg:flex-row gap-6">
            <!-- Gráfica (Iframe) -->
            <div class="flex-1">
              <iframe src="../metas_ahorro/index.php" class="w-full h-[925px] border-none"></iframe>
            </div>
          </div>
        </div>
      </div>

      <!-- Productos -->
      <div id="productos" class="seccion hidden">
        <div class="">
          <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
              <iframe src="../control_gastos/index.php" class="w-full h-[925px] border-none"></iframe>
            </div>
          </div>
        </div>
      </div>

      <div id="notificaciones" class="seccion hidden">
        <div class="">
          <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
              <iframe src="./notificaciones_metas.php" class="w-full h-[925px] border-none"></iframe>
            </div>
          </div>
        </div>
      </div>

      <div id="ajustes" class="seccion hidden">
        <div class="">
          <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
              <iframe src="./perfil.php" class="w-full h-[925px] border-none"></iframe>
            </div>
          </div>
        </div>
      </div>
  

      <!-- Otras secciones (metas, notificaciones, perfil, ajustes) -->
    </div>
  </main>
  <script>
    function mostrarSeccion(seccionId) {
      document.querySelectorAll('.seccion').forEach(seccion => {
        seccion.classList.add('hidden');
        seccion.classList.remove('activa');
      });
      const seccionActual = document.getElementById(seccionId);
      if (seccionActual) {
        seccionActual.classList.remove('hidden');
        seccionActual.classList.add('activa');
      }
    }
  </script>
</body>
</html>
