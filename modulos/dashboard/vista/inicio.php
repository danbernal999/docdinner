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
        <p class="text-sm text-neutral-50">
          Este mes gastaste un <span class="text-red-500 font-bold">+15%</span> más que el anterior.
        </p>
      </div>

      <!-- Gráfico -->
      <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4 mb-6">
        <canvas id="graficoAnalisis" class="w-full h-full"></canvas>
      </div>

      <!-- Tarjetas de Ingreso, Gasto, Ahorro y Deuda alineadas horizontalmente -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Ingreso (Saldo Inicial) -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Saldo Inicial</span>
            <span class="font-semibold text-yellow-500">$<?= number_format($saldoInicial) ?></span>
          </div>
        </div>

        <!-- Gasto -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Gasto</span>
            <span class="font-semibold text-cyan-500">$<?= number_format($totalGastos) ?></span>
          </div>
        </div>

        <!-- Disponible -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Disponible</span>
            <span class="font-semibold text-green-500">$<?= number_format($disponible) ?></span>
          </div>
        </div>

        <!-- Deuda (si existe) -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Deuda</span>
            <span class="font-semibold text-red-500"><?= $deuda > 0 ? "-$" . number_format($deuda) : "$0" ?></span>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Visualizacion de Ahorro -->
   <!-- class="rounded-2xl overflow-hidden text-white shadow-lg relative" style="background: radial-gradient(ellipse at right top, #107667ed 0%, #ffffff 47%, #ffffff 100%)" -->
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
  <div class="md:col-span-3 bg-white p-6 rounded-xl shadow-2xl h-full" >
    <!-- Título -->
    <div class="mb-4">
      <h3 class="text-lg font-semibold text-neutral-950">Resumen de Gastos Fijos</h3>
    </div>

    <!-- Estadísticas importantes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
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

        <div class="bg-gray-50 p-4 rounded-lg shadow">
          <p class="text-sm text-gray-600">Beta</p>
          <p class="text-xl font-bold text-red-600">$<?= number_format($total_gastos) ?></p>
        </div>

    </div>

    <!-- Categorías De Iva Pagado -->
    <div class="bg-gray-50 rounded-lg shadow p-4 text-sm text-gray-700 mt-6">
      <h2 class="text-lg font-semibold text-neutral-900 mb-2">Resumen de IVA</h2>

      <p>💸 IVA pagado este mes: <strong>$<?= number_format($ivaActual, 2, ',', '.') ?></strong></p>

      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-2">
        <p class="whitespace-nowrap">
          📊 Variación mensual:
          <strong class="<?= $variacion >= 0 ? 'text-green-600' : 'text-red-600' ?>">
            <?= $variacion >= 0 ? '+' : '' ?><?= number_format($variacion, 1) ?>%
          </strong>
          <?= $ivaAnterior == 0 ? '(sin datos del mes anterior)' : '' ?>
        </p>

        <div class="max-w-[160px] md:max-w-[200px]">
          <canvas id="ivaSparkline"
                  height="50"
                  width="160"
                  class="w-full h-auto"
                  data-iva-actual="<?= $ivaActual ?>"
                  data-iva-anterior="<?= $ivaAnterior ?>"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Resumen del Api Financiera -->
  <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-2xl h-full">
    <!-- Componente: Finanzas en tiempo real -->
    <h3 class="text-lg font-semibold text-neutral-950">Finanzas en Tiempo Real</h3>
    <div id="datos-financieros" class="space-y-3 mt-6  overflow-y-auto max-h-[250px]">
      <!-- Aquí se generarán las tarjetas de activos financieros -->
      <!-- Las tarjetas se generarán dinámicamente con JavaScript --> 
    </div>
  </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="assets/js/dashboard/grafico.js"></script>
<script src="assets/js/dashboard/graficoPastel.js"></script>
<script src="assets/js/dashboard/apiFinanciera.js"></script>
<script src="assets/js/dashboard/graficoIva.js"></script>




