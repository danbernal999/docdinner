<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Análisis Financiero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .kpi-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-top: 15px;
        }
        .kpi-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            min-width: 150px;
        }
        .kpi-value {
            font-size: 1.5em;
            font-weight: bold;
            color: #007bff; /* Un color para los valores */
        }
        .kpi-label {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e0e0e0;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8em;
            color: #999;
        }
    </style>
</head>
<body>
    <h1>Reporte de Análisis Financiero</h1>
    <p style="text-align: center; color: #555;">Período: <?= htmlspecialchars($fechaInicio) ?> al <?= htmlspecialchars($fechaFin) ?></p>
    <p style="text-align: center; color: #555;">Tipo de Reporte: <?= htmlspecialchars(ucfirst($tipoReporte)) ?></p>

    <div class="section">
        <h2>KPIs Clave</h2>
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-value">$<?= number_format($kpis['totalGastos'], 2) ?></div>
                <div class="kpi-label">Total Gastos</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value">$<?= number_format($kpis['totalAhorros'], 2) ?></div>
                <div class="kpi-label">Total Ahorros</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value"><?= number_format($kpis['margenAhorro'], 2) ?>%</div>
                <div class="kpi-label">Margen de Ahorro</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value"><?= htmlspecialchars($kpis['ratioGastoAhorro']) ?></div>
                <div class="kpi-label">Ratio Gasto/Ahorro</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value"><?= number_format($kpis['porcentajeCrecimientoAhorro'], 2) ?>%</div>
                <div class="kpi-label">Crecimiento Ahorro</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Gastos por Período</h2>
        <?php if (!empty($gastosPorPeriodo)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gastosPorPeriodo as $periodo => $monto): ?>
                        <tr>
                            <td><?= htmlspecialchars($periodo) ?></td>
                            <td>$<?= number_format($monto, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay datos de gastos por período para el rango seleccionado.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Ahorros por Período</h2>
        <?php if (!empty($ahorrosPorPeriodo)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ahorrosPorPeriodo as $periodo => $monto): ?>
                        <tr>
                            <td><?= htmlspecialchars($periodo) ?></td>
                            <td>$<?= number_format($monto, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay datos de ahorros por período para el rango seleccionado.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Gastos por Categoría</h2>
        <?php if (!empty($gastosPorCategoria)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gastosPorCategoria as $gasto): ?>
                        <tr>
                            <td><?= htmlspecialchars($gasto['categoria']) ?></td>
                            <td>$<?= number_format($gasto['total_gastos'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay datos de gastos por categoría para el rango seleccionado.</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        Generado el: <?= date('Y-m-d H:i:s') ?>
    </div>
</body>
</html>