<div class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950">
  <!-- Encabezado -->
  <header class="mb-6">
    <h1 class="text-2xl font-bold">Analisis de Reportes</h1>
  </header>

  <!-- Contenedor principal -->
  <div class="space-y-6">
    <!-- Filtros y Segmentación -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <h2 class="text-xl font-semibold mb-4">Filtros y Segmentación</h2>
      <form method="GET" class="flex flex-wrap gap-4 items-end">
        <input type="hidden" name="ruta" value="main">
        <input type="hidden" name="modulo" value="analisis">
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
  <!-- Script del grafico en assets -->
  <script src="assets/js/analisis/grafico.js"></script>
  
</div>