<div class="bg-neutral-50 min-h-screen p-4 md:p-8">
  <!-- 🔔 Notificaciones de Metas de Ahorro -->
  <div class="mb-8">
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <h2 class="text-2xl font-bold text-neutral-950">🎯 Notificaciones de Metas de Ahorro</h2>
      <p class="text-sm text-neutral-500">Resumen de tu progreso financiero</p>
    </div>
  </div>

  <?php if (
    count($vencidas) > 0 ||
    count($proximas) > 0 ||
    count($cumplidas) > 0 ||
    count($sinProgreso) > 0
  ): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6">
      <!-- Repite aquí cada card como ya las tienes -->
      <?php if (count($vencidas) > 0): ?>
        <div class="bg-white rounded-xl shadow-2xl p-6 border-t-4 border-red-500">
          <h3 class="text-lg font-semibold text-red-600 mb-3">🚫 Metas vencidas</h3>
          <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
            <?php foreach ($vencidas as $meta): ?>
              <li><?= htmlspecialchars($meta) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (count($proximas) > 0): ?>
        <div class="bg-white rounded-xl shadow-2xl p-6 border-t-4 border-yellow-500">
          <h3 class="text-lg font-semibold text-yellow-600 mb-3">⏳ Metas próximas a vencer</h3>
          <ul class="list-disc pl-5 text-sm text-yellow-700 space-y-1">
            <?php foreach ($proximas as $meta): ?>
              <li><?= htmlspecialchars($meta) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (count($cumplidas) > 0): ?>
        <div class="bg-white rounded-xl shadow-2xl p-6 border-t-4 border-green-500">
          <h3 class="text-lg font-semibold text-green-600 mb-3">✅ Metas cumplidas</h3>
          <ul class="list-disc pl-5 text-sm text-green-700 space-y-1">
            <?php foreach ($cumplidas as $meta): ?>
              <li><?= htmlspecialchars($meta) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (count($sinProgreso) > 0): ?>
        <div class="bg-white rounded-xl shadow-2xl p-6 border-t-4 border-gray-500">
          <h3 class="text-lg font-semibold text-gray-600 mb-3">📭 Metas sin progreso</h3>
          <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
            <?php foreach ($sinProgreso as $meta): ?>
              <li><?= htmlspecialchars($meta) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="bg-white rounded-xl shadow-2xl p-6 text-center text-neutral-600">
      <p class="text-lg font-medium">🎉 No hay notificaciones de ahorro por mostrar</p>
    </div>
  <?php endif; ?>


  <!-- 📦 Notificaciones de Gastos de Productos -->
  <div class="mt-12 mb-6">
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <h2 class="text-2xl font-bold text-neutral-950">📦 Notificaciones de Gastos de Productos</h2>
      <p class="text-sm text-neutral-500">Alertas relacionadas con tus gastos por categoría o producto</p>
    </div>
  </div>

  <?php if (!empty($notificacionesProductos)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow-2xl p-6 border-t-4 border-blue-500 col-span-1 md:col-span-2 xl:col-span-3">
        <ul class="list-disc pl-5 text-sm text-blue-700 space-y-2">
          <?php foreach ($notificacionesProductos as $mensaje): ?>
            <li><?= htmlspecialchars($mensaje) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php else: ?>
    <div class="bg-white rounded-xl shadow-2xl p-6 text-center text-neutral-600">
      <p class="text-lg font-medium">🧾 No hay notificaciones de productos por mostrar</p>
    </div>
  <?php endif; ?>
</div>

