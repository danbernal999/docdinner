<?php
// Incluimos la conexión a la base de datos usando la clase Database definida en el archivo database.php
require_once('../config/database.php');
$conn = Database::conectar();

$hoy = date('Y-m-d');
$proximos_7_dias = date('Y-m-d', strtotime('+7 days'));

// Metas vencidas pero no cumplidas
$sql1 = "SELECT nombre_meta FROM metas_ahorro WHERE fecha_limite < '$hoy' AND cumplida = 0";
$vencidas = $conn->query($sql1)->fetchAll(PDO::FETCH_COLUMN);

// Metas próximas a vencer (menos de 7 días)
$sql2 = "SELECT nombre_meta FROM metas_ahorro 
         WHERE fecha_limite BETWEEN '$hoy' AND '$proximos_7_dias' 
         AND cumplida = 0";
$proximas = $conn->query($sql2)->fetchAll(PDO::FETCH_COLUMN);

// Metas cumplidas
$sql3 = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado >= cantidad_meta";
$cumplidas = $conn->query($sql3)->fetchAll(PDO::FETCH_COLUMN);

// Metas sin progreso
$sql4 = "SELECT nombre_meta FROM metas_ahorro WHERE ahorrado = 0";
$sinProgreso = $conn->query($sql4)->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Notificaciones de Metas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            neutral: {
              900: "#171717",
              50: "#F9FAFB"
            }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-neutral-50 min-h-screen p-6">
  <div class="max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold text-neutral-900 mb-8 text-center">Notificaciones de Metas de Ahorro</h2>
    
    <!-- Metas vencidas -->
    <?php if (count($vencidas) > 0): ?>
      <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4 rounded">
        <strong class="block text-red-700 font-bold mb-2">Metas vencidas pero no cumplidas:</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($vencidas as $meta): ?>
            <li class="text-red-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Metas próximas a vencer -->
    <?php if (count($proximas) > 0): ?>
      <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4 rounded">
        <strong class="block text-yellow-700 font-bold mb-2">Metas próximas a vencer (menos de 7 días):</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($proximas as $meta): ?>
            <li class="text-yellow-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Metas cumplidas -->
    <?php if (count($cumplidas) > 0): ?>
      <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4 rounded">
        <strong class="block text-green-700 font-bold mb-2">Metas cumplidas:</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($cumplidas as $meta): ?>
            <li class="text-green-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Metas sin progreso -->
    <?php if (count($sinProgreso) > 0): ?>
      <div class="bg-gray-100 border-l-4 border-gray-500 p-4 mb-4 rounded">
        <strong class="block text-gray-700 font-bold mb-2">Metas sin progreso (ahorrado = 0):</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($sinProgreso as $meta): ?>
            <li class="text-gray-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Mensaje en caso de no haber notificaciones -->
    <?php if (count($vencidas) === 0 && count($proximas) === 0 && count($cumplidas) === 0 && count($sinProgreso) === 0): ?>
      <div class="text-center text-neutral-600 p-6">
        No hay notificaciones por mostrar.
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
