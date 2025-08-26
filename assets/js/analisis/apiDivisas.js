const API_KEY = "26704da72c7140d89d64b3efb3dcdea0";
const currencies = ["USD", "EUR", "GBP", "BRL", "MXN"];
const charts = {}; // guardar instancias de gráficos

async function cargarDivisas() {
    try {
        const contenedor = document.getElementById("cardsDivisas");
        contenedor.innerHTML = "";

        const url = `https://api.currencyfreaks.com/v2.0/rates/latest?apikey=${API_KEY}`;
        const response = await fetch(url);
        const data = await response.json();

        const copRate = parseFloat(data.rates["COP"]);

        currencies.forEach((base) => {
            let rate;

            if (base === "USD") {
                rate = copRate;
            } else {
                const baseRate = parseFloat(data.rates[base]);
                rate = copRate / baseRate;
            }

            // Crear card
            const card = document.createElement("div");
            card.className =
                "p-4 mb-3 bg-white shadow rounded-xl flex justify-between items-center";

            // ID único para el canvas
            const chartId = `chart-${base}`;

            card.innerHTML = `
                <div>
                    <h3 class="font-bold text-gray-800">${base} → COP</h3>
                    <p class="text-sm text-emerald-500">
                        ${rate ? `$${rate.toLocaleString("es-CO", {minimumFractionDigits: 2, maximumFractionDigits: 2})}` : "Error"}
                    </p>
                </div>
                <span class="text-gray-400 w-16 h-8">
                    <canvas id="${chartId}" width="60" height="30"></canvas>
                </span>
            `;

            contenedor.appendChild(card);

            // Generar datos falsos de tendencia
            const trend = Array.from({ length: 10 }, () =>
                rate * (1 + (Math.random() - 0.5) / 100) // ±0.5%
            );

            // Si ya existe un gráfico, destruirlo antes de crear otro
            if (charts[chartId]) {
                charts[chartId].destroy();
            }

            const ctx = document.getElementById(chartId).getContext("2d");
            charts[chartId] = new Chart(ctx, {
                type: "line",
                data: {
                    labels: Array(trend.length).fill(""),
                    datasets: [
                        {
                            data: trend,
                            borderColor: "#38a3d8",
                            borderWidth: 2,
                            fill: false,
                            pointRadius: 0,
                            tension: 0.3,
                        },
                    ],
                },
                options: {
                    responsive: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false },
                    },
                },
            });
        });
    } catch (error) {
        console.error("Error cargando divisas:", error);
    }
}

setInterval(cargarDivisas, 30000);
cargarDivisas();
