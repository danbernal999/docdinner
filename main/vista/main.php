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
  <?php
  include 'main/vista/sidebar.php';
  ?>

  <!-- Main Content (ocupa el resto de la pantalla) -->
  <main class="ml-20 md:ml-60 flex-1">
      <?php

        $modulo = $_GET['modulo'] ?? 'dashboard';

        //Para seccionar modulos en el main
        switch ($modulo) {
            case 'dashboard':
              include 'modulos/dashboard/controlador.php';
              require_once 'config/database.php';
              $conn = getDB();
              $controller = new DashboardController($conn);
              $controller->dashboard();
              break;

            case 'analisis':
              include 'modulos/analisis/controlador.php';
              $controller = new AnalisisController();
              $controller->analisis();
              break;

            case 'ahorro':
              include 'modulos/ahorro/controlador.php';
              require_once 'config/database.php';
              $conn = getDB();
              $controller = new AhorroController($conn);
              $controller->ahorro();
              break;

            case 'productos':
              include 'modulos/productos/controlador.php';
              require_once 'config/database.php';
              $conn = getDB();
              $controller = new ProductosController($conn);
              $controller->productos();
              break;

            case 'notificaciones':
              include 'modulos/notificaciones/controlador.php';
              require_once 'config/database.php';
              $conn = getDB();
              $controller = new NotificacionesController($conn);
              $controller->notificaciones();
              break;

            case 'configuracion':
              include 'modulos/configuracion/controlador.php';
              $controller = new ConfiguracionController();
              $controller->configuracion();
              break;

            case 'cuenta':
              include 'modulos/cuenta/controlador.php';
              require_once 'config/database.php';
              $conn = getDB();
              $controller = new CuentaController($conn);
              $controller->cuenta();
              break;



        }
      ?>
  </main>
</body>
</html>