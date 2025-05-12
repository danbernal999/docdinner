<?php
include 'db.php';

// Consulta para obtener el total de gastos
$sql = "SELECT SUM(monto) AS total_gastos FROM gastos_fijos";
$stmt = $conn->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$total_gastos = $result['total_gastos'] ?? 0; // Si no hay datos, se asigna 0
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control de Gastos</title>
  <!-- Cargar Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          backgroundImage: {
            'custom-gradient': 'linear-gradient(to right, #31ff58, #38a3d8)',
          },
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
<body class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950">
  <!-- Encabezado -->
  <header class="mb-8">
    <h1 class="text-3xl font-bold text-center">Control de Gastos</h1>
  </header>
  
  <!-- Tarjeta de Total de Gastos -->
  <main class="mx-auto max-w-md">
    <div class="rounded-xl bg-white shadow-lg p-6">
      <h2 class="text-xl font-semibold mb-4">Total</h2>
      <p class="text-2xl font-bold">
        $<?= number_format($total_gastos, 2, ',', '.') ?>
      </p>
    </div>
  </main>
</body>
</html>

