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
        <?php if ($totalGastos < $saldoInicial): ?>
          <p class="text-sm text-neutral-950">
            Este mes estás dentro de tu saldo ✅, aún tienes disponible 
            <span class="text-green-600 font-bold">
              $<?= number_format($disponible) ?>
            </span>.
          </p>

        <?php elseif ($totalGastos == $saldoInicial): ?>
          <p class="text-sm text-neutral-950">
            Este mes gastaste exactamente lo que tenías 💸. Tu saldo está en 
            <span class="text-yellow-500 font-bold">$0</span>.
          </p>

        <?php else: ?>
          <p class="text-sm text-neutral-950">
            Este mes gastaste de más ❌. Tu deuda actual es 
            <span class="text-red-500 font-bold">
              $<?= number_format($deuda) ?>
            </span>.
          </p>
        <?php endif; ?>

      </div>

      <!-- Gráfico -->
      <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4 mb-6">
        
      </div>

      <!-- Tarjetas de Ingreso, Gasto, Ahorro y Deuda alineadas horizontalmente -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Ingreso (Saldo Inicial Total) -->
        <div class="bg-white p-5 rounded-xl shadow-2xl">
          <div class="flex items-center justify-between">
            <span class="font-medium text-neutral-800">Saldo Total</span>
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
<div class="grid grid-cols-2 md:grid-cols-5 gap-5 mt-4">
  <!-- Resumen de Gastos Fijos -->
  <div class="md:col-span-5 bg-white p-6 rounded-xl shadow-2xl h-full">
    <!-- Título -->
    <div class="mb-4">
      <h3 class="text-lg font-semibold text-neutral-950">Resumen Financiero</h3>
    </div>
    <!-- Estadísticas importantes -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
      
      <!-- Otros Ingresos -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Otros Ingresos</p>
        <p class="text-xl font-bold text-green-600">
          $<?= number_format($otrosIngresosTotal) ?>
        </p>
      </div>

      <!-- Total de Gastos Fijos -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Total Gastos Fijos</p>
        <p class="text-xl font-bold text-red-600">
          $<?= number_format($totalGastos) ?>
        </p>
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
          <p class="text-base font-semibold text-gray-400">No hay datos disponibles</p>
        </div>
      <?php endif; ?>

      <!-- Próximo vencimiento -->
      <div class="bg-gray-50 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Próximo gasto programado</p>

        <?php if (!empty($proximoGasto)): ?>
          <p class="text-base font-semibold text-gray-800">
            <?= htmlspecialchars($proximoGasto['nombre_gasto']) ?>
            <span class="text-blue-600">
              <?= date("d M Y", strtotime($proximoGasto['fecha'])) ?>
            </span>
          </p>
          <p class="text-sm text-gray-600">
            <?= htmlspecialchars($proximoGasto['categoria']) ?> - 
            $<?= number_format($proximoGasto['monto'], 0, ',', '.') ?>
          </p>
        <?php else: ?>
          <p class="text-gray-500 text-sm">No tienes gastos próximos</p>
        <?php endif; ?>
      </div>

      <div class="bg-gray-50 p-5 rounded-lg shadow">
        <div class="flex items-center justify-between">
          <span class="font-medium text-neutral-800">Cuotas pagadas</span>
          <span class="font-semibold text-blue-600">
            <?= (int)$cuotas_pagadas_total ?> / <?= (int)$total_cuotas_total ?>
          </span>
        </div>
        <p class="text-xs text-gray-500 mt-1">
          Pendiente aprox: $<?= number_format($pendiente_total, 0, ',', '.') ?>
        </p>
      </div>




    </div>

    <!-- Categorías De Iva Pagado -->
    <div class="my-4">
        <h3 class="text-lg font-semibold text-neutral-950">Resumen de IVA</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="rounded-lg text-sm text-neutral-700 mt-6">
        <p>💸 IVA pagado este mes: 
          <strong>$<?= number_format($ivaActual, 2, ',', '.') ?></strong>
        </p>

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
                    class="w-full h-50"
                    data-iva-actual="<?= $ivaActual ?>"
                    data-iva-anterior="<?= $ivaAnterior ?>">
            </canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="assets/js/dashboard/grafico.js"></script>
<script src="assets/js/dashboard/graficoIva.js"></script>
