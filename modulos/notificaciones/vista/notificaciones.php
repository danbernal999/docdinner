<div class="bg-neutral-50 min-h-screen p-6">
  <div class="max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold text-neutral-900 mb-8 text-center">Notificaciones de Metas de Ahorro</h2>
    
    <!-- Metas vencidas -->
    <?php if (count($vencidas) > 0): ?>
      <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4 rounded">
        <strong class="block text-red-700 font-bold mb-2">Metas vencidas pero no cumplidas:</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($vencidas as $meta): ?>
            <li class="text-red-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Metas próximas a vencer -->
    <?php if (count($proximas) > 0): ?>
      <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4 rounded">
        <strong class="block text-yellow-700 font-bold mb-2">Metas próximas a vencer (menos de 7 días):</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($proximas as $meta): ?>
            <li class="text-yellow-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Metas cumplidas -->
    <?php if (count($cumplidas) > 0): ?>
      <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4 rounded">
        <strong class="block text-green-700 font-bold mb-2">Metas cumplidas:</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($cumplidas as $meta): ?>
            <li class="text-green-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Metas sin progreso -->
    <?php if (count($sinProgreso) > 0): ?>
      <div class="bg-gray-100 border-l-4 border-gray-500 p-4 mb-4 rounded">
        <strong class="block text-gray-700 font-bold mb-2">Metas sin progreso (ahorrado = 0):</strong>
        <ul class="list-disc pl-5">
          <?php foreach ($sinProgreso as $meta): ?>
            <li class="text-gray-700"><?= htmlspecialchars($meta) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Mensaje en caso de no haber notificaciones -->
    <?php if (count($vencidas) === 0 && count($proximas) === 0 && count($cumplidas) === 0 && count($sinProgreso) === 0): ?>
      <div class="text-center text-neutral-600 p-6">
        No hay notificaciones por mostrar.
      </div>
    <?php endif; ?>
  </div>
</div>

