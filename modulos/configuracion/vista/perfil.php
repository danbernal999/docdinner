<div class="p-6 max-w-xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-200">
    <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-2">
        <i class="ri-settings-3-line text-blue-500 text-2xl"></i>
        Configuración de Saldo
    </h2>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'actualizado'): ?>
        <div class="flex items-center gap-2 mb-4 p-3 bg-green-100 border border-green-300 rounded-lg text-green-700">
            <i class="ri-checkbox-circle-line text-xl"></i>
            <span>Saldo actualizado correctamente.</span>
        </div>
    <?php endif; ?>

    <form action="index.php?ruta=main&modulo=configuracion" method="POST" class="space-y-4">
        <div>
            <label for="saldo_inicial" class="block text-gray-700 font-medium mb-1">
                Saldo Inicial
            </label>
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

        <button 
            type="submit" 
            name="guardarSaldo" 
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition"
        >
            Guardar
        </button>
    </form>
</div>




