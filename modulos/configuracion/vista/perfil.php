<div class="min-h-screen flex items-center justify-center bg-neutral-50 px-4 py-10">
  <div class="w-full max-w-6xl bg-white rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
    
    <!-- Panel Izquierdo -->
    <div class="p-8">
      <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-2">
        <i class="ri-settings-3-line text-blue-500 text-2xl"></i>
        Configuración de Saldo
      </h2>

      <!-- Saldo actual -->
      <?php if (isset($_SESSION['saldo_inicial'])): ?>
        <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4 text-blue-800 rounded-md">
          <p>Tu saldo actual registrado es: <strong>$<?= number_format($_SESSION['saldo_inicial'], 2) ?></strong></p>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'actualizado'): ?>
        <div class="flex items-center gap-2 mb-4 p-3 bg-green-100 border border-green-300 rounded-lg text-green-700">
          <i class="ri-checkbox-circle-line text-xl"></i>
          <span>Saldo actualizado correctamente.</span>
        </div>
      <?php endif; ?>

      <!-- Formulario de configuración -->
      <form action="index.php?ruta=main&modulo=configuracion" method="POST" class="space-y-4">
        <!-- Saldo inicial -->
        <div>
          <label for="saldo_inicial" class="block text-gray-700 font-medium mb-1">Saldo Inicial</label>
          <input 
            type="number" 
            name="saldo_inicial" 
            id="saldo_inicial"
            step="0.01" 
            value="<?= htmlspecialchars($_SESSION['saldo_inicial'] ?? '') ?>" 
            class="w-full px-4 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            required
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
            <option value="COP" <?= ($_SESSION['moneda'] ?? '') === 'COP' ? 'selected' : '' ?>>COP - Peso Colombiano</option>
            <option value="USD" <?= ($_SESSION['moneda'] ?? '') === 'USD' ? 'selected' : '' ?>>USD - Dólar Estadounidense</option>
            <option value="EUR" <?= ($_SESSION['moneda'] ?? '') === 'EUR' ? 'selected' : '' ?>>EUR - Euro</option>
            <option value="MXN" <?= ($_SESSION['moneda'] ?? '') === 'MXN' ? 'selected' : '' ?>>MXN - Peso Mexicano</option>
          </select>
        </div>

        <!-- Campo opcional: Otros Ingresos -->
        <div>
          <label for="otros_ingresos" class="block text-gray-700 font-medium mb-1">Otros Ingresos (opcional)</label>
          <input 
            type="number" 
            name="otros_ingresos" 
            id="otros_ingresos"
            step="0.01"
            placeholder="Ej: 500000" 
            value="<?= htmlspecialchars($_POST['otros_ingresos'] ?? '') ?>"            
            class="w-full px-4 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
          />
        </div>

        <!-- Botón -->
        <button 
          type="submit" 
          name="guardarSaldo" 
          class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Guardar configuración
        </button>
      </form>

      <!-- Botón para reiniciar -->
      <form action="index.php?ruta=main&modulo=configuracion&reset=1" method="POST" class="mt-4">
        <button type="submit" class="text-sm text-red-500 hover:underline">Reiniciar configuración</button>
      </form>

      <!-- Tip financiero -->
      <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">💡 Tip financiero del día</h3>
        <p class="text-sm text-gray-600 italic">"Establece un límite mensual y síguelo. El control comienza por un objetivo claro."</p>
      </div>
    </div>

    <!-- Panel Derecho - Beneficios y objetivos -->
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







