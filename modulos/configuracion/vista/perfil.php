<?php
// Inicia la sesión si aún no ha sido iniciada.
// Esto es crucial para acceder a las variables de sesión como 'saldo_inicial', 'moneda', etc.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener el saldo inicial y otros ingresos de la sesión para mostrarlos en el formulario.
// Si no están definidos, se inicializan a 0 o a una cadena vacía para evitar errores.
$saldo_inicial_display = $_SESSION['saldo_inicial'] ?? '';
$moneda_display = $_SESSION['moneda'] ?? 'COP'; // Valor por defecto si no hay moneda en sesión
$otros_ingresos_display = $_SESSION['otros_ingresos'] ?? ''; // Nuevo campo

// Calcular el saldo total disponible para mostrarlo al usuario.
// Se suma el saldo inicial base con los otros ingresos.
$saldo_total_disponible = ($_SESSION['saldo_inicial'] ?? 0) + ($_SESSION['otros_ingresos'] ?? 0);
?>

<div class="min-h-screen flex items-center justify-center bg-neutral-50 px-4 py-10 font-inter">
  <div class="w-full max-w-6xl bg-white rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
    
    <!-- Panel Izquierdo: Formulario de Configuración -->
    <div class="p-8">
      <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-2">
        <i class="ri-settings-3-line text-blue-500 text-2xl"></i>
        Configuración de Saldo
      </h2>

      <!-- Mensaje de Saldo Actual -->
      <?php if (isset($_SESSION['saldo_inicial'])): ?>
        <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4 text-blue-800 rounded-md">
          <!-- Se muestra el saldo total sumando el saldo inicial y otros ingresos -->
          <p>Tu saldo total disponible es: <strong>$<?= number_format($saldo_total_disponible, 2) ?></strong></p>
          <p class="text-sm text-blue-700 mt-1">
            (Saldo inicial: $<?= number_format($_SESSION['saldo_inicial'] ?? 0, 2) ?> 
            + Otros ingresos: $<?= number_format($_SESSION['otros_ingresos'] ?? 0, 2) ?>)
          </p>
        </div>
      <?php endif; ?>

      <!-- Mensaje de Actualización Exitosa -->
      <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'actualizado'): ?>
        <div class="flex items-center gap-2 mb-4 p-3 bg-green-100 border border-green-300 rounded-lg text-green-700">
          <i class="ri-checkbox-circle-line text-xl"></i>
          <span>Configuración actualizada correctamente.</span>
        </div>
      <?php endif; ?>

      <!-- Formulario de Configuración Principal -->
      <form action="index.php?ruta=main&modulo=configuracion" method="POST" class="space-y-4">
        <!-- Saldo Inicial -->
        <div>
          <label for="saldo_inicial" class="block text-gray-700 font-medium mb-1">Saldo Inicial</label>
          <input 
            type="number" 
            name="saldo_inicial" 
            id="saldo_inicial"
            step="0.01" 
            value="<?= htmlspecialchars($saldo_inicial_display) ?>" 
            class="w-full px-4 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            required
            <!-- Se elimina el atributo 'disabled' condicional -->
          />
        </div>

        <!-- Moneda -->
        <div>
          <label for="moneda" class="block text-gray-700 font-medium mb-1">Moneda</label>
          <select 
            name="moneda" 
            id="moneda" 
            class="w-full px-4 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            required
          >
            <option value="COP" <?= ($moneda_display === 'COP' ? 'selected' : '') ?>>COP - Peso Colombiano</option>
            <!-- Puedes añadir más opciones de moneda aquí si es necesario -->
          </select>
        </div>
        
        <!-- Botón Guardar Saldo Inicial y Moneda -->
        <button 
          type="submit" 
          name="guardarConfiguracionPrincipal" 
          class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition mt-4"
        >
          Guardar Saldo y Moneda
        </button>

        <!-- Botón para mostrar/ocultar Otros Ingresos -->
        <button type="button" id="toggleOtrosIngresosBtn" class="w-full bg-gray-200 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-300 transition mt-4">
          Agregar/Editar Otros Ingresos
        </button>

        <!-- Campo opcional: Otros Ingresos (inicialmente oculto o visible si tiene valor) -->
        <div id="otrosIngresosContainer" class="mt-4 p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50"
             style="display: <?= ($otros_ingresos_display !== '' && floatval($otros_ingresos_display) > 0) ? 'block' : 'none' ?>;">
          <label for="otros_ingresos" class="block text-gray-700 font-medium mb-1">Monto de Otros Ingresos</label>
          <input 
            type="number" 
            name="otros_ingresos" 
            id="otros_ingresos"
            step="0.01"
            placeholder="Ej: 500000" 
            value="<?= htmlspecialchars($otros_ingresos_display) ?>"             
            class="w-full px-4 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          />
          <p class="text-xs text-gray-500 mt-1">Este monto se sumará a tu saldo inicial.</p>

          <!-- Botón Guardar Otros Ingresos -->
          <button 
            type="submit" 
            name="guardarOtrosIngresos" 
            class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition mt-4"
          >
            Guardar Otros Ingresos
          </button>
        </div>
        
      </form>

      <!-- Botón para Reiniciar Configuración -->
      <form action="index.php?ruta=main&modulo=configuracion&reset=1" method="POST" class="mt-4">
        <button type="submit" class="text-sm text-red-500 hover:underline">Reiniciar configuración</button>
      </form>

      <!-- Tip Financiero -->
      <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">💡 Tip financiero del día</h3>
        <p class="text-sm text-gray-600 italic">"Establece un límite mensual y síguelo. El control comienza por un objetivo claro."</p>
      </div>
    </div>

    <!-- Panel Derecho: Beneficios y Objetivos -->
    <div class="bg-gray-950 text-white p-8 flex flex-col justify-between space-y-6">
      <div>
        <h3 class="text-xl font-semibold mb-2">Ventajas de configurar tu saldo</h3>
        <div class="space-y-4">
          <div class="flex items-start gap-3">
            <i class="ri-error-warning-line text-blue-400 text-xl"></i>
            <p>Recibe alertas si te pasas de tu presupuesto.</p>
          </div>
          <div class="flex items-start gap-3">
            <i class="ri-wallet-3-line text-blue-400 text-xl"></i>
            <p>Adapta tu análisis financiero a tu moneda local.</p>
          </div>
          <div class="flex items-start gap-3">
            <i class="ri-bar-chart-line text-blue-400 text-xl"></i>
            <p>Comparación mensual entre saldo y gastos reales.</p>
          </div>
          <div class="flex items-start gap-3">
            <i class="ri-lock-line text-blue-400 text-xl"></i>
            <p>Tus datos están protegidos y solo tú los ves.</p>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2">🎯 Objetivos financieros sugeridos</h3>
        <ul class="list-disc list-inside text-sm text-gray-300 space-y-1">
          <li>Establece un presupuesto mensual fijo.</li>
          <li>Evalúa tus gastos reales frente al deseado.</li>
          <li>Adapta tu saldo si tus ingresos cambian.</li>
          <li>Automatiza tus ahorros si es posible.</li>
        </ul>
      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleOtrosIngresosBtn');
    const otrosIngresosContainer = document.getElementById('otrosIngresosContainer');
    // Ya no necesitamos la referencia a saldoInicialInput para deshabilitar/habilitar
    // const saldoInicialInput = document.getElementById('saldo_inicial'); 
    // const otrosIngresosInput = document.getElementById('otros_ingresos'); // Se mantiene si se usa para el estado inicial del contenedor

    // La función updateFieldStates ya no es necesaria para el bloqueo, solo para la visibilidad inicial
    // function updateFieldStates() { ... }

    if (toggleBtn && otrosIngresosContainer) {
        // Estado inicial al cargar la página (solo visibilidad del contenedor)
        // La visibilidad inicial ya está controlada por PHP en el atributo style del div.

        toggleBtn.addEventListener('click', function() {
            // Alterna la visibilidad del contenedor de otros ingresos
            if (otrosIngresosContainer.style.display === 'none' || otrosIngresosContainer.style.display === '') {
                otrosIngresosContainer.style.display = 'block';
                // Ya no deshabilitamos saldoInicialInput aquí
            } else {
                otrosIngresosContainer.style.display = 'none';
                // Ya no habilitamos saldoInicialInput aquí
            }
        });

        // Se eliminan los event listeners 'input' para saldoInicialInput y otrosIngresosInput
        // ya que la lógica de bloqueo se ha removido.
    }
});
</script>
