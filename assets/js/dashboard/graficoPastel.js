  async function cargarGraficoPastel() {
    try {
      const response = await fetch('index.php?ruta=apiGastos&accion=gastosPorCategoria');
      const datos = await response.json();

      const ctx = document.getElementById('gastosPastel').getContext('2d');

      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: datos.labels,
          datasets: [{
            label: 'Gastos por categoría',
            data: datos.data,
            backgroundColor: [
              'rgb(239, 68, 68)',   // rojo
              'rgb(34, 197, 94)',   // verde
              'rgb(27, 185, 224)',  // azul
              'rgb(249, 115, 22)',  // naranja
              'rgb(139, 92, 246)',  // morado
              'rgb(234, 179, 8)',   // amarillo
              'rgb(16, 185, 129)',  // verde azulado
              'rgb(251, 191, 36)',  // amarillo suave
              'rgb(244, 114, 182)', // rosa
              'rgb(203, 213, 225)'  // gris claro
            ]
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: '#374151', // gris oscuro para buena visibilidad
                font: {
                  size: 12
                }
              }
            },
            title: {
              display: true,
              text: 'Gastos del Mes por Categoría',
              font: {
                size: 16
              }
            }
          }
        }
      });
    } catch (error) {
      console.error('Error al cargar el gráfico de pastel:', error);
    }
  }

  window.addEventListener('DOMContentLoaded', cargarGraficoPastel);