const apiKey = "d1hg98pr01qsvr2a0dngd1hg98pr01qsvr2a0do0";

const activos = [
  { simbolo: "AAPL", id: "aapl", nombre: "Apple Inc (AAPL)" },
  { simbolo: "MSFT", id: "msft", nombre: "Microsoft (MSFT)" },
  { simbolo: "TSLA", id: "tsla", nombre: "Tesla (TSLA)" },
  { simbolo: "GOOGL", id: "googl", nombre: "Alphabet (GOOGL)" },
  { simbolo: "AMZN", id: "amzn", nombre: "Amazon (AMZN)" }
];

// Crear HTML
function crearTarjetaHTML(activo) {
  return `
    <div class="flex items-center justify-between p-3 border rounded-lg shadow-sm bg-white">
      <div class="flex flex-col justify-center w-1/3">
        <p class="font-semibold text-gray-800">${activo.nombre}</p>
        <p id="${activo.id}-price" class="text-sm text-gray-500">$...</p>
      </div>
      <div class="flex justify-center w-1/3">
        <canvas id="${activo.id}-chart" width="100" height="30" class="mt-1"></canvas>
      </div>
      <div id="${activo.id}-change" class="text-sm font-medium w-1/3 text-right">...</div>
    </div>
  `;
}

// Cargar datos desde Finnhub
async function cargarDatosFinancieros() {
  for (const activo of activos) {
    try {
      // Precio actual
      const quoteRes = await fetch(`https://finnhub.io/api/v1/quote?symbol=${activo.simbolo}&token=${apiKey}`);
      const quote = await quoteRes.json();

      const price = quote.c;
      const prev = quote.pc;

      document.getElementById(`${activo.id}-price`).textContent = `$${price.toFixed(2)}`;
      const cambio = ((price - prev) / prev) * 100;

      const cambioElem = document.getElementById(`${activo.id}-change`);
      cambioElem.textContent = `${cambio.toFixed(2)}%`;
      cambioElem.className = `text-sm font-medium ${cambio >= 0 ? 'text-green-600' : 'text-red-600'}`;

      // Historial para la gráfica
      const now = Math.floor(Date.now() / 1000);
      const weekAgo = now - 7 * 24 * 60 * 60;

      const histRes = await fetch(`https://finnhub.io/api/v1/stock/candle?symbol=${activo.simbolo}&resolution=D&from=${weekAgo}&to=${now}&token=${apiKey}`);
      const hist = await histRes.json();

      if (!hist.c || !Array.isArray(hist.c)) continue;

      const ctx = document.getElementById(`${activo.id}-chart`).getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: hist.t.map(t => new Date(t * 1000).toLocaleDateString()),
          datasets: [{
            data: hist.c,
            borderColor: cambio >= 0 ? "green" : "red",
            borderWidth: 1.5,
            fill: false,
            pointRadius: 0,
            tension: 0.3
          }]
        },
        options: {
          plugins: { legend: { display: false } },
          scales: { x: { display: false }, y: { display: false } },
          responsive: false,
          maintainAspectRatio: false
        }
      });

    } catch (error) {
      console.error(`Error con ${activo.simbolo}:`, error);
    }
  }
}

// Ejecutar
function init() {
  const contenedor = document.getElementById("datos-financieros");
  contenedor.innerHTML = activos.map(crearTarjetaHTML).join("");
  cargarDatosFinancieros();
}

init();

