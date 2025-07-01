<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - DocDinner</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="assets/js/main/tailwind-config.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="shortcut icon" href="assets/icons/favicon.ico" type="image/x-icon">
</head>
<body class="bg-dark text-white flex">

  <!-- Sidebar -->
  <?php include 'main/vista/sidebar.php'; ?>

  <!-- Conexión a la base de datos -->
  <?php
    require_once 'config/database.php';
    $conn = getDB(); // Conexión disponible para todos los módulos
  ?>

  <!-- Main Content -->
  <main class="ml-20 md:ml-60 flex-1">
    <?php
      $modulo = $_GET['modulo'] ?? 'dashboard';

      switch ($modulo) {
        case 'dashboard':
          include 'modulos/dashboard/controlador.php';
          $controller = new DashboardController($conn);
          $controller->dashboard();
          break;

        case 'analisis':
          include 'modulos/analisis/controlador.php';
          $controller = new AnalisisController(); // sin conexión
          $controller->analisis();
          break;

        case 'ahorro':
          include 'modulos/ahorro/controlador.php';
          $controller = new AhorroController($conn);
          $controller->ahorro();
          break;

        case 'productos':
          include 'modulos/productos/controlador.php';
          $controller = new ProductosController($conn);
          $controller->productos();
          break;

        case 'notificaciones':
          include 'modulos/notificaciones/controlador.php';
          $controller = new NotificacionesController($conn);
          $controller->notificaciones();
          break;

        case 'configuracion':
          include 'modulos/configuracion/controlador.php';
          $controller = new ConfiguracionController($conn);
          $controller->configuracion();
          break;

        case 'cuenta':
          include 'modulos/cuenta/controlador.php';
          $controller = new CuentaController($conn);
          $controller->cuenta();
          break;
      }
    ?>
  </main>

  <div id="notificationsModal" class="fixed inset-0 z-50 flex items-center justify-start bg-black bg-opacity-50 hidden">
    <div class="bg-neutral-50 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] h-full overflow-y-auto p-6 relative">

      <!-- Botón cerrar -->
      <button id="closeNotifications" class="absolute top-4 right-4 text-neutral-500 hover:text-neutral-800">
        <i class="ri-close-line text-3xl"></i>
      </button>

      <!-- Contenido dinámico -->
      <div id="notificationsContent"></div>
    </div>
  </div>

  <!-- ✅ Script para abrir/cerrar -->
  <script>
    const openBtn = document.getElementById('openNotifications');
    const closeBtn = document.getElementById('closeNotifications');
    const modal = document.getElementById('notificationsModal');
    const content = document.getElementById('notificationsContent');

    openBtn?.addEventListener('click', () => {
      fetch('index.php?ruta=main&modulo=notificaciones')
        .then(response => response.text())
        .then(html => {
          content.innerHTML = html;
          modal.classList.remove('hidden');
        });
    });

    closeBtn?.addEventListener('click', () => {
      modal.classList.add('hidden');
      content.innerHTML = '';
    });

    modal?.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.add('hidden');
        content.innerHTML = '';
      }
    });

    // Cerrar modal al presionar ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
        modal.classList.add('hidden');
        content.innerHTML = '';
      }
    });
  </script>

</body>
</html>
