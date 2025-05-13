new Chart(document.getElementById('graficoAnalisis').getContext('2d'), {
    type: 'line',
    data: {
        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        datasets: [{
        label: 'Datos de Ejemplo',
        data: [12, 19, 3, 5, 2, 3, 10, 15, 7, 9, 6, 11],
        borderColor: '#22C55E',
        backgroundColor: 'rgba(56, 163, 216, 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
        legend: {
            labels: {
            color: 'black'
            }
        }
        },
        scales: {
        y: {
            ticks: {
            color: 'black'
            },
            grid: {
            color: 'rgba(0, 0, 0, 0.1)'
            }
        },
        x: {
            ticks: {
            color: 'black'
            },
            grid: {
            color: 'rgba(0, 0, 0, 0.1)'
            }
        }
        }
    }
});