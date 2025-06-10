<div class="bg-neutral-50 min-h-screen p-4 md:p-8">
<header class="bg-white rounded-xl shadow-2xl w-full mb-4">
  <div class="max-w-8xl px-3 flex items-center justify-between">
    <!-- Sección de usuario -->
    <div class="flex items-center gap-4">
      <!-- Imagen de perfil -->
      <img
        src="<?= htmlspecialchars($rutaFoto) ?>"
        alt="Foto Perfil"
        class="w-12 h-12 rounded-full object-cover"
      />
      <!-- Nombre y estado del usuario -->
      <div>
        <h2 class="text-neutral-950 text-base font-bold leading-tight">
          Bienvenido! <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>
        </h2>
        <p class="text-gray-500 text-sm">Controla & organiza tus gastos con la seguridad & facilidad que mereces.</p>
      </div>

    </div>
    <!-- Botón de acción (visible siempre o desde md hacia arriba, según necesidad) -->
    <div class="flex items-center gap-4">
      <a href="index.php?ruta=logout">
        <button class="bg-neutral-950 text-white text-sm px-4 py-2 rounded-xl hover:bg-cyan-500 transition">Cerrar Sesión</button>
      </a>
    </div>
  </div>
</header>
<!-- Contenedor principal: grid para el Balance y Visualzacion ahorro -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
  <!-- Columna principal: Gráfico + tarjetas -->
  <div class="md:col-span-2">
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <!-- Título y balance -->
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-neutral-950">Balance General</h2>
        <p class="text-sm text-gray-700">
          Este mes gastaste un <span class="text-red-500 font-bold">+15%</span> más que el anterior.
        </p>
      </div>

      <!-- Gráfico (placeholder) -->
      <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4 mb-6">
        <canvas id="graficoDashboard" class="w-full h-full">Grafica Aqui</canvas>
      </div>

      <!-- Tarjetas de Saldo, Gasto y Deuda alineadas horizontalmente -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Saldo -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Ingreso</span>
            <span class="font-semibold text-yellow-500">$2.500.000</span>
          </div>
        </div>

        <!-- Gasto -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Gasto</span>
            <span class="font-semibold text-cyan-500">$2.500.000</span>
          </div>
        </div>

        <!-- Ahorro -->
         <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Ahorro</span>
            <span class="font-semibold text-green-500">$2.500.000</span>
          </div>
        </div>

        <!-- Deuda -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Deuda</span>
            <span class="font-semibold text-red-500">$-1.300.000</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Visualizacion de Ahorro -->
  <div class="bg-white p-6 rounded-xl shadow-2xl">
    <h2 class="text-xl font-semibold text-neutral-950 mb-4">Visualización Ahorro</h2>
    <!-- Contenedor con scroll -->
    <div class="flex flex-col space-y-4 max-h-80 overflow-y-auto pr-2">
      <!-- Div de cada meta de ahorro -->
      <?php foreach ($result as $row): ?> 

        <?php
          $nombreMeta = $row['nombre_meta'];
          $ahorrado = $row['ahorrado'] ?? 0;
          $cantidad_meta = $row['cantidad_meta'] ?? 0;
          $progreso = ($cantidad_meta > 0) ? round(($ahorrado / $cantidad_meta) * 100) : 0;
        ?>
        
        <div>
          <p class="text-sm font-semibold text-neutral-900 mb-1"><?= htmlspecialchars($nombreMeta) ?></p>
          <div class="w-full h-4 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full" style="width: <?= $progreso ?>%;"></div>
          </div>
          <p class="text-xs mt-1 text-gray-500">Llevas $<?= number_format($ahorrado) ?> de $<?= number_format($cantidad_meta) ?></p>
        </div>

      <?php endforeach; ?>

    </div>
  </div>
</div>

<!-- Contenedor secundario: Productos y resumen del mes -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-5 mt-5">
  <!-- Resumen de Gastos Fijos -->
  <div class="md:col-span-3 bg-white p-6 rounded-xl shadow-2xl h-full">
    <!-- Título -->
    <div class="mb-4">
      <h3 class="text-lg font-semibold text-neutral-950">Resumen de Gastos Fijos</h3>
      <p class="text-sm text-gray-600">Estadísticas rápidas de tus productos financieros mensuales.</p>
    </div>

    <!-- Estadísticas importantes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
      <!-- Total de Gastos Fijos -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Total Gastos Fijos</p>
        <p class="text-xl font-bold text-red-600">$<?= number_format($total_gastos) ?></p>
      </div>

      <!-- Gasto más alto -->
      <?php if ($gastoMasAlto): ?>
        <div class="bg-gray-50 p-4 rounded-lg shadow">
          <p class="text-sm text-gray-600">Gasto más alto</p>
          <p class="text-base font-semibold text-gray-800">
            <?= htmlspecialchars($gastoMasAlto['nombre_gasto']) ?>:
            <span class="text-red-600">$<?= number_format($gastoMasAlto['monto']) ?></span>
          </p>
        </div>
      <?php else: ?>
        <div class="bg-gray-50 p-4 rounded-lg shadow">
          <p class="text-sm text-gray-600">Gasto más alto</p>
          <p class="text-base font-semibold text-gray-800 text-gray-400">No hay datos disponibles</p>
        </div>
      <?php endif; ?>

      <!-- Próximo vencimiento -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Próximo gasto programado</p>
        <p class="text-base font-semibold text-gray-800">Internet: <span class="text-blue-600">05 Jun 2025</span></p>
      </div>

      <!-- Porcentaje de cumplimiento -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Porcentaje de cumplimiento</p>
        <p class="text-xl font-bold text-green-600">85%</p>
      </div>
    </div>

    <!-- Categorías principales -->
    <div class="mt-6">
      <h4 class="text-sm font-semibold text-gray-800 mb-2">Distribución por Categoría</h4>
      <ul class="text-sm text-gray-700 space-y-1">
        <li class="flex justify-between">
          <span>Vivienda</span>
          <span>$100.000.000</span>
        </li>
        <li class="flex justify-between">
          <span>Transporte</span>
          <span>$100.000</span>
        </li>
        <li class="flex justify-between">
          <span>Hogar y Decoración</span>
          <span>$50.000</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Resumen del Mes (a la derecha) -->
  <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-2xl h-full">
    <div class="flex flex-col md:flex-row items-start justify-between gap-5">
      <!-- Columna de texto -->
      <div class="flex-1">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Resumen del Mes</h3>
        <p class="text-sm text-gray-600">Gasto total: <strong>$1.500.000</strong></p>
        <p class="text-sm text-gray-600">Categoría más activa: <strong>Comida</strong></p>
        <p class="text-sm text-gray-600">Ahorro mensual: <strong>$500.000</strong></p>
        <p class="text-sm text-gray-600">Objetivo de ahorro: <strong>$1.000.000</strong></p>
        <p class="text-sm text-gray-600">Progreso: <strong>50%</strong></p>
        <p class="text-sm text-gray-600">Próximo vencimiento: <strong>05 Jun 2025</strong></p>
        <p class="text-sm text-gray-600">Gasto más alto: <strong>Vivienda - $1.000.000</strong></p> 
        
        <br><br><br><br>
        <p class="text-sm text-gray-600 text-red-500">¡Cuidado! Superaste tu límite diario.</p>
      </div>

      <!-- Columna de gráfica -->
      <div class="w-full md:w-2/5 lg:w-1/2">
        <div class="relative w-full aspect-square">
          <canvas id="gastosChart" class="absolute inset-0 w-full h-full"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('gastosChart').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Comida', 'Transporte', 'Hogar', 'Entretenimiento'],
      datasets: [{
        label: 'Gastos Mensuales',
        data: [600000, 300000, 400000, 200000],
        backgroundColor: [
          '#f87171', // rojo
          '#60a5fa', // azul
          '#34d399', // verde
          '#fbbf24'  // amarillo
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#374151', // texto gris oscuro
            font: {
              size: 14
            }
          }
        }
      }
    }
  });
</script>


