<div class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950">
  <!-- Contenedor principal -->
  <div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <h2 class="text-xl font-semibold mb-4">Analisis Avanzado</h2>
      <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <input type="hidden" name="ruta" value="main">
        <input type="hidden" name="modulo" value="analisis">

        <!-- Fecha inicio -->
        <div>
          <label for="fechaInicio" class="block text-sm font-medium text-neutral-700 mb-1">Desde</label>
          <input type="date" name="inicio" id="fechaInicio" value="<?= $fechaInicio ?>"
            class="w-full bg-gray-100 text-neutral-950 rounded-md focus:border-primary focus:ring-primary p-2">
        </div>

        <!-- Fecha fin -->
        <div>
          <label for="fechaFin" class="block text-sm font-medium text-neutral-700 mb-1">Hasta</label>
          <input type="date" name="fin" id="fechaFin" value="<?= $fechaFin ?>"
            class="w-full bg-gray-100 text-neutral-950 rounded-md focus:border-primary focus:ring-primary p-2">
        </div>

        <!-- Categoría -->
        <div>
          <label for="categoria" class="block text-sm font-medium text-neutral-700 mb-1">Categoría</label>
          <select name="categoria" id="categoria"
            class="w-full bg-gray-100 text-neutral-950 rounded-md focus:border-primary focus:ring-primary p-2">
            <option value="">Todas</option>
            <option value="ventas">Ventas</option>
            <option value="compras">Compras</option>
            <option value="gastos">Gastos</option>
          </select>
        </div>

        <!-- Botón -->
        <div class="sm:col-span-2 md:col-span-1 lg:col-span-1 flex items-end">
          <button type="submit" class="w-full bg-cyan-500 text-white px-4 py-2 mb-1 rounded-md hover:opacity-90 transition-opacity">
            Filtrar
          </button>
        </div>
      </form>
    </div>

    <!-- Visualización -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <h4 class="text-lg font-semibold mb-4">Visualizaciones Avanzadas</h4>
      <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4">
        <canvas id="graficoAnalisis" class="w-full h-full"></canvas>
      </div>
    </div>

    <!-- Reportes + KPIs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Grafico de Ahorros -->
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4">
          <canvas id="graficoAhorro" class="w-full h-full">Grafico de Ahorros</canvas>
        </div>
      </div>

      <!-- KPIs -->
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <h2 class="text-xl font-semibold mb-4">Indicadores Clave (KPIs)</h2>
        <ul class="space-y-2 text-gray-600">
          <li>Porcentaje de crecimiento: 15%</li>
          <li>Margen de ahorro: 10%</li>
          <li>Objetivo de ventas: $50,000</li>
        </ul>

        <div class="mt-4 flex flex-wrap gap-4">
          <button class="bg-cyan-500 text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
            Exportar PDF
          </button>
          <button class="bg-cyan-500 text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
            Exportar Excel
          </button>
          <button class="bg-cyan-500 text-white px-4 py-2 rounded-md hover:opacity-90 transition-opacity">
            Exportar CSV
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="assets/js/analisis/grafico.js"></script>
  <script src="assets/js/analisis/graficoAhorro.js"></script>
</div>
