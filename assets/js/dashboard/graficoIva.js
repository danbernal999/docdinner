document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('ivaSparkline')?.getContext('2d');
  if (!ctx) return;

  const ivaAnterior = parseFloat(ctx.canvas.dataset.ivaAnterior || 0);
  const ivaActual = parseFloat(ctx.canvas.dataset.ivaActual || 0);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Mes anterior', 'Mes actual'],
      datasets: [{
        data: [ivaAnterior, ivaActual],
        fill: false,
        tension: 0.4,
        borderColor: '#3b82f6',
        pointRadius: 3,
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => '$' + parseFloat(ctx.raw).toLocaleString('es-CO')
          }
        },
        datalabels: {
          color: '#3b82f6',
          align: 'top',
          anchor: 'end',
          formatter: (value) => '$' + value.toLocaleString('es-CO'),
          font: {
            size: 11,
            weight: 'bold'
          }
        }
      },
      scales: {
        x: { display: false },
        y: { display: false }
      }
    },
    plugins: [ChartDataLabels]
  });
});

