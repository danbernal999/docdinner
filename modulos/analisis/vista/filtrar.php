<div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-4 md:p-8 text-neutral-950 max-w-svw font-sans">
    <div class="space-y-8">
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Análisis Avanzado de Finanzas</h2>
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 items-end">
                <input type="hidden" name="ruta" value="main">
                <input type="hidden" name="modulo" value="analisis">

                <?php
                // Helper para campos de entrada
                function inputField($label, $name, $type, $value) {
                    echo "<div>
                            <label for=\"$name\" class=\"block text-sm font-medium text-neutral-700 mb-1\">$label</label>
                            <input type=\"$type\" name=\"$name\" id=\"$name\" value=\"" . htmlspecialchars($value) . "\"
                                class=\"w-full bg-gray-50 border border-gray-300 text-neutral-950 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 transition-all duration-200\">
                        </div>";
                }

                // Helper para selects
                function selectField($label, $name, $selectedValue, $options) {
                    echo "<div>
                            <label for=\"$name\" class=\"block text-sm font-medium text-neutral-700 mb-1\">$label</label>
                            <select name=\"$name\" id=\"$name\"
                                class=\"w-full bg-gray-50 border border-gray-300 text-neutral-950 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 transition-all duration-200\">";
                    foreach ($options as $value => $text) {
                        echo "<option value=\"$value\" " . (($selectedValue == $value) ? 'selected' : '') . ">$text</option>";
                    }
                    echo "</select>
                        </div>";
                }

                inputField('Desde', 'inicio', 'date', $fechaInicio);
                inputField('Hasta', 'fin', 'date', $fechaFin);

                selectField('Tipo de Transacción', 'categoria', $categoria, [
                    'todas' => 'Todas',
                    'gastos' => 'Gastos',
                    'ahorros' => 'Ahorros'
                ]);

                selectField('Granularidad', 'granularidad', $granularidad, [
                    'diaria' => 'Diaria',
                    'mensual' => 'Mensual',
                    'anual' => 'Anual'
                ]);
                ?>

                <div class="sm:col-span-2 md:col-span-1 lg:col-span-1 flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-4 py-2.5 rounded-lg shadow-md hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg font-bold text-gray-800">Tendencia de Gastos</h4>
                    <select id="tipoGraficoGastos" class="bg-gray-50 border border-gray-300 text-neutral-950 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 transition-all duration-200">
                        <option value="line">Línea</option>
                        <option value="bar">Barra</option>
                    </select>
                </div>
                <div class="flex-grow bg-gray-50 h-80 rounded-lg flex items-center justify-center p-4">
                    <canvas id="graficoAnalisisGastos"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 flex flex-col">
                <h4 class="text-lg font-bold mb-4 text-gray-800">Desglose de Gastos por Categoría</h4>
                <div class="flex-grow bg-gray-50 h-80 rounded-lg flex items-center justify-center p-4">
                    <canvas id="graficoDesgloseCategorias"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h4 class="text-lg font-bold mb-4 text-gray-800">Visualización de Ahorro (Periodo Actual vs. Anterior)</h4>
            <div class="bg-gray-50 h-80 rounded-lg flex items-center justify-center p-4">
                <canvas id="graficoComparativo"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Indicadores Clave (KPIs)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php
                // Helper para tarjetas KPI
                function kpiCard($iconClass, $iconColor, $bgColor, $borderColor, $title, $value, $description) {
                    echo "<div class=\"{$bgColor} p-4 rounded-lg flex flex-col items-center justify-center text-center shadow-sm {$borderColor}\">
                            <i class=\"{$iconClass} {$iconColor} text-3xl mb-2\"></i>
                            <h3 class=\"text-lg font-semibold text-gray-700\">{$title}</h3>
                            <p class=\"text-3xl font-bold {$iconColor} mt-1\">{$value}</p>
                            <span class=\"text-sm text-gray-500\">{$description}</span>
                        </div>";
                }

                kpiCard('fas fa-chart-line', 'text-blue-600', 'bg-blue-50', 'border border-blue-100', 'Crecimiento Ahorro', $kpis['porcentajeCrecimiento'], 'vs. año anterior');
                kpiCard('fas fa-piggy-bank', 'text-emerald-600', 'bg-emerald-50', 'border border-emerald-100', 'Margen de Ahorro', $kpis['margenAhorro'], 'Ahorro / (Ahorro + Gasto)');
                kpiCard('fas fa-bullseye', 'text-amber-600', 'bg-amber-50', 'border border-amber-100', 'Progreso Metas', $kpis['objetivoVentas'], 'de metas de ahorro');
                ?>
            </div>

            <div class="mt-8 flex flex-wrap gap-4 justify-center">
                <?php
                // Helper para botones de exportación
                function exportButton($iconClass, $gradientClass, $text) {
                    echo "<button class=\"{$gradientClass} text-white px-6 py-3 rounded-lg shadow-md hover:opacity-90 transition-all duration-300 transform hover:scale-105 flex items-center\">
                            <i class=\"{$iconClass} mr-2\"></i>{$text}
                        </button>";
                }

                exportButton('fas fa-file-pdf', 'bg-gradient-to-r from-purple-500 to-pink-500', 'Exportar PDF');
                exportButton('fas fa-file-excel', 'bg-gradient-to-r from-green-500 to-teal-500', 'Exportar Excel');
                exportButton('fas fa-file-csv', 'bg-gradient-to-r from-orange-500 to-red-500', 'Exportar CSV');
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script> 
    <script>
        let graficoAnalisisGastos, graficoComparativo, graficoDesgloseCategorias;

        // Datos pasados desde PHP
        const datosPHP = {
            gastos: {
                datasets: <?= $datosGastos['datasets'] ?>,
                labels: <?= $datosGastos['labels'] ?>
            },
            ahorroComparativo: {
                datasets: <?= $datosAhorroComparativo['datasets'] ?>,
                labels: <?= $datosAhorroComparativo['labels'] ?>
            },
            desgloseCategorias: {
                data: <?= $datosDesgloseCategorias['data'] ?>,
                labels: <?= $datosDesgloseCategorias['labels'] ?>,
                backgroundColor: <?= $datosDesgloseCategorias['backgroundColor'] ?>
            }
        };

        const ctxGastos = document.getElementById('graficoAnalisisGastos').getContext('2d');
        const ctxComparativo = document.getElementById('graficoComparativo').getContext('2d');
        const ctxDesgloseCategorias = document.getElementById('graficoDesgloseCategorias').getContext('2d');

        // Opciones comunes para gráficos de línea/barra
        const opcionesComunesLineBar = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { font: { size: 14 } }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0,0,0,0.7)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 5,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            return label + new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(200, 200, 200, 0.2)' },
                    ticks: {
                        font: { size: 12 },
                        callback: function(value) {
                            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 }).format(value);
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 12 } }
                }
            }
        };

        // Opciones comunes para gráficos de pastel/doughnut (diferentes scales)
        const opcionesComunesDoughnut = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { font: { size: 12 } }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0,0,0,0.7)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 5,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) label += ': ';
                            const total = context.dataset.data.reduce((sum, current) => sum + current, 0);
                            const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(2) : 0;
                            return label + new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(context.parsed) + ` (${percentage}%)`;
                        }
                    }
                }
            }
        };


        function crearGraficoGastos(type = 'line') {
            if (graficoAnalisisGastos) graficoAnalisisGastos.destroy();
            graficoAnalisisGastos = new Chart(ctxGastos, {
                type: type,
                data: {
                    labels: datosPHP.gastos.labels,
                    datasets: datosPHP.gastos.datasets.map(dataset => ({
                        ...dataset,
                        // Ajusta backgroundColor para barras y fill/tension para líneas
                        backgroundColor: (type === 'bar') ? dataset.borderColor.replace('1)', '0.7)') : dataset.backgroundColor,
                        fill: (type === 'line') ? dataset.fill : false,
                        tension: (type === 'line') ? dataset.tension : 0
                    }))
                },
                options: {
                    ...opcionesComunesLineBar,
                    plugins: {
                        ...opcionesComunesLineBar.plugins,
                        title: { display: true, text: 'Tendencia de Gastos por Periodo', font: { size: 16, weight: 'bold' }, padding: { top: 10, bottom: 20 } }
                    }
                }
            });
        }

        function crearGraficoComparativo() {
            if (graficoComparativo) graficoComparativo.destroy();
            graficoComparativo = new Chart(ctxComparativo, {
                type: 'line',
                data: {
                    labels: datosPHP.ahorroComparativo.labels,
                    datasets: datosPHP.ahorroComparativo.datasets
                },
                options: {
                    ...opcionesComunesLineBar,
                    plugins: {
                        ...opcionesComunesLineBar.plugins,
                        title: { display: true, text: 'Comparación de Ahorro', font: { size: 16, weight: 'bold' }, padding: { top: 10, bottom: 20 } }
                    }
                }
            });
        }

        function crearGraficoDesgloseCategorias() {
            if (graficoDesgloseCategorias) graficoDesgloseCategorias.destroy();
            graficoDesgloseCategorias = new Chart(ctxDesgloseCategorias, {
                type: 'doughnut',
                data: {
                    labels: datosPHP.desgloseCategorias.labels,
                    datasets: [{
                        data: datosPHP.desgloseCategorias.data,
                        backgroundColor: datosPHP.desgloseCategorias.backgroundColor,
                        hoverOffset: 10,
                        borderColor: 'white',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...opcionesComunesDoughnut,
                    plugins: {
                        ...opcionesComunesDoughnut.plugins,
                        title: { display: true, text: 'Distribución de Gastos por Categoría', font: { size: 16, weight: 'bold' }, padding: { top: 10, bottom: 20 } }
                    }
                }
            });
        }

        // Inicialización al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            crearGraficoGastos('line'); // Tipo por defecto al cargar
            crearGraficoComparativo();
            crearGraficoDesgloseCategorias();

            // Event listener para cambiar el tipo de gráfico de gastos
            const tipoGraficoGastosSelect = document.getElementById('tipoGraficoGastos');
            if (tipoGraficoGastosSelect) {
                tipoGraficoGastosSelect.addEventListener('change', (e) => {
                    crearGraficoGastos(e.target.value);
                });
            }
        });
    </script>
</div>