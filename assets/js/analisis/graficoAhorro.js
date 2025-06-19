const data = {
  labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
  datasets: [{
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    borderWidth: 1,
    backgroundColor: ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0', '#D35400'],
  }]
};

// Función: resaltar color al pasar el mouse
function handleHover(evt, item, legend) {
  legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
    colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
  });
  legend.chart.update();
}

// Función: quitar transparencia
function handleLeave(evt, item, legend) {
  legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
    colors[index] = color.length === 9 ? color.slice(0, -2) : color;
  });
  legend.chart.update();
}

// Luego creamos la config (cuando data ya existe)
const config = {
  type: 'pie',
  data: data,
  options: {
    plugins: {
      legend: {
        onHover: handleHover,
        onLeave: handleLeave
      }
    }
  }
};

// Esperar al DOM para montar el gráfico
window.addEventListener('DOMContentLoaded', () => {
  const canvas = document.getElementById('graficoAhorro');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    new Chart(ctx, config);
  } else {
    console.error("No se encontró el canvas con id 'graficoAhorro'");
  }
});
