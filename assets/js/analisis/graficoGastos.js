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