
  
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
