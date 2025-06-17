<div class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950 max-w-svw">
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

    <!-- Reportes + KPIs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Grafico de Ahorros -->
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <h4 class="text-lg font-semibold mb-4">Visualización de Gastos</h4>
        <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4">
          <canvas id="graficoAnalisisAhorro" class="w-full h-full"></canvas>
        </div>
      </div>

      <!-- Gráfico comparativo -->
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <h4 class="text-lg font-semibold mb-4">Visualizacion de Ahorro</h4>
        <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4">
          <canvas id="graficoComparativo" class="w-full h-full"></canvas>
        </div>
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

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="assets/js/analisis/graficoAhorro.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    let graficoAnalisisAhorro;
    let graficoComparativo;

    const ctx = document.getElementById('graficoAnalisisAhorro').getContext('2d');
    const ctxComparativo = document.getElementById('graficoComparativo').getContext('2d');

    // Datos de ejemplo
    const datos = {
      labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
      datasets: [{
        label: 'Ventas',
        data: [1200, 1900, 3000, 2500, 3200],
        backgroundColor: 'rgba(6, 182, 212, 0.3)',
        borderColor: 'rgba(6, 182, 212, 1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
      }]
    };

    const opciones = {
      responsive: true,
      plugins: {
        legend: { display: true },
        tooltip: { enabled: true }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    };

    function crearGrafico(tipo = 'line') {
      if (graficoAnalisisAhorro) graficoAnalisisAhorro.destroy();

      graficoAnalisisAhorro = new Chart(ctx, {
        type: tipo,
        data: datos,
        options: opciones
      });
    }

    function crearGraficoComparativo() {
      if (graficoComparativo) graficoComparativo.destroy();

      graficoComparativo = new Chart(ctxComparativo, {
        type: 'line',
        data: {
          labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
          datasets: [
            {
              label: 'Este Año',
              data: [1200, 1900, 3000, 2500, 3200],
              borderColor: 'rgba(6, 182, 212, 1)',
              backgroundColor: 'rgba(6, 182, 212, 0.2)',
              fill: true,
              tension: 0.4
            },
            {
              label: 'Año Pasado',
              data: [1000, 1500, 2800, 2200, 2900],
              borderColor: 'rgba(234, 179, 8, 1)',
              backgroundColor: 'rgba(234, 179, 8, 0.2)',
              fill: true,
              tension: 0.4
            }
          ]
        },
        options: opciones
      });
    }

    // Inicialización al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
      crearGrafico('line');
      crearGraficoComparativo();

      // Cambiar tipo de gráfico con el selector
      const tipoGraficoSelect = document.getElementById('tipoGrafico');
      tipoGraficoSelect.addEventListener('change', (e) => {
        crearGrafico(e.target.value);
      });
    });
  </script>

</div>
