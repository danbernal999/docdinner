<?php
session_start();
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : "Invitado";
$fechaInicio = isset($_GET['inicio']) ? $_GET['inicio'] : date('Y-m-d');
$fechaFin    = isset($_GET['fin']) ? $_GET['fin'] : date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analisis de Reportes</title>
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
</head>
<body class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950">
  <!-- Encabezado -->
  <header class="mb-6">
    <h1 class="text-2xl font-bold">Analisis de Reportes</h1>
  </header>

  <!-- Contenedor principal -->
  <div class="space-y-6">
    <!-- Filtros y Segmentación -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-semibold mb-4">Filtros y Segmentación</h2>
      <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
          <label for="fechaInicio" class="block text-sm font-medium text-neutral-700 mb-1">Desde</label>
          <input type="date" name="inicio" id="fechaInicio" value="<?= $fechaInicio ?>"
            class="bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2">
        </div>
        <div>
          <label for="fechaFin" class="block text-sm font-medium text-neutral-700 mb-1">Hasta</label>
          <input type="date" name="fin" id="fechaFin" value="<?= $fechaFin ?>"
            class="bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2">
        </div>
        <div>
          <label for="categoria" class="block text-sm font-medium text-neutral-700 mb-1">Categoría</label>
          <select name="categoria" id="categoria"
            class="bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2">
            <option value="">Todas</option>
            <option value="ventas">Ventas</option>
            <option value="compras">Compras</option>
            <option value="gastos">Gastos</option>
          </select>
        </div>
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
          Filtrar
        </button>
      </form>
    </div>

    <!-- Visualizaciones Avanzadas -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-semibold mb-4">Visualizaciones Avanzadas</h2>
      <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4">
        <canvas id="graficoAnalisis" class="w-full h-full"></canvas>
      </div>
    </div>

    <!-- Reportes Detallados y KPIs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Reportes Detallados -->
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">Reportes Detallados</h2>
        <p class="text-gray-600">
          Profundiza en datos con reportes diarios, semanales o mensuales para un análisis completo.
        </p>
        <button class="mt-4 bg-secondary text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
          Ver Reporte
        </button>
      </div>

      <!-- Indicadores Clave (KPIs) y Exportar/Importar -->
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">Indicadores Clave (KPIs)</h2>
        <ul class="space-y-2 text-gray-600">
          <li>Porcentaje de crecimiento: 15%</li>
          <li>Margen de ahorro: 10%</li>
          <li>Objetivo de ventas: $50,000</li>
          <!-- Agrega otros KPIs relevantes -->
        </ul>
        <div class="mt-4 flex gap-4">
          <button class="bg-accent text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
            Exportar PDF
          </button>
          <button class="bg-accent text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
            Exportar Excel
          </button>
          <button class="bg-accent text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
            Exportar CSV
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Cargar Chart.js y configurar el gráfico -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    new Chart(document.getElementById('graficoAnalisis').getContext('2d'), {
      type: 'line',
      data: {
        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        datasets: [{
          label: 'Datos de Ejemplo',
          data: [12, 19, 3, 5, 2, 3, 10, 15, 7, 9, 6, 11],
          borderColor: '#22C55E',
          backgroundColor: 'rgba(56, 163, 216, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: {
              color: 'black'
            }
          }
        },
        scales: {
          y: {
            ticks: {
              color: 'black'
            },
            grid: {
              color: 'rgba(0, 0, 0, 0.1)'
            }
          },
          x: {
            ticks: {
              color: 'black'
            },
            grid: {
              color: 'rgba(0, 0, 0, 0.1)'
            }
          }
        }
      }
    });
  </script>
</body>
</html>


