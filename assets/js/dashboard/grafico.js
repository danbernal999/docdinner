async function cargarDatosGrafico() {
  const response = await fetch('index.php?ruta=apiGastos&accion=gastosMensuales');
  const json = await response.json();

  const Utils = {
    CHART_COLORS: {
      red: 'rgb(239, 68, 68)',
      green: 'rgb(34, 197, 94)',
      blue: 'rgb(27, 185, 224)'
    }
  };

  const data = {
    labels: json.labels,
    datasets: [
      {
        label: 'Deuda',
        data: json.data,
        borderColor: Utils.CHART_COLORS.red,
        backgroundColor: 'rgba(239, 68, 68, 0.2)',
        fill: true,
        tension: 0.4,
        pointRadius: 5
      },
      {
        label: 'Disponible',
        data: json.data,
        borderColor: Utils.CHART_COLORS.green,
        backgroundColor: 'rgba(34, 197, 94, 0.2)',
        fill: true,
        tension: 0.4,
        pointRadius: 5
      },
      {
        label: 'Gasto',
        data: json.data,
        borderColor: Utils.CHART_COLORS.blue,
        backgroundColor: 'rgba(27, 185, 224, 0.2)',
        fill: true,
        tension: 0.4,
        pointRadius: 5
      }
    ]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top'
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      interaction: {
        mode: 'nearest',
        axis: 'x',
        intersect: false
      },
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Monto ($)'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Meses del Año'
          }
        }
      }
    }
  };

  // ⚠️ Aquí se crea el gráfico *DESPUÉS* de recibir los datos
  const ctx = document.getElementById('graficoAnalisis').getContext('2d');
  new Chart(ctx, config);
}

// Ejecutar cargarDatosGrafico CUANDO el DOM esté listo
window.addEventListener('DOMContentLoaded', () => {
  cargarDatosGrafico();
});

  

  


