<div class="bg-white w-full max-w-sm h-full shadow-2xl flex flex-col overflow-y-auto rounded-r-2xl border-l-4 border-indigo-500">

  <!-- Título principal -->
  <div class="px-6 py-4 border-b bg-indigo-50">
    <h2 class="text-xl font-bold text-indigo-700 flex items-center gap-2">
      <i class="ri-notification-3-line text-2xl"></i> Notificaciones
    </h2>
  </div>

  <!-- Metas de Ahorro -->
  <div class="px-6 py-3 border-b bg-neutral-50">
    <h3 class="text-xs font-semibold text-neutral-600 uppercase tracking-wide flex items-center gap-1">
      <i class="ri-pie-chart-2-line text-sm text-indigo-500"></i> Metas de Ahorro
    </h3>
  </div>

  <div class="divide-y">
    <?php
    $hayAhorro = false;

    foreach (['Vencidas' => $vencidas, 'Próximas' => $proximas, 'Cumplidas' => $cumplidas, 'Sin progreso' => $sinProgreso] as $estado => $lista) :
      if (count($lista) > 0) :
        $hayAhorro = true;
        foreach ($lista as $meta) :
          // Colores por estado
          $color = match ($estado) {
            'Vencidas' => 'text-red-500',
            'Próximas' => 'text-yellow-500',
            'Cumplidas' => 'text-green-500',
            'Sin progreso' => 'text-gray-500',
            default => 'text-neutral-500'
          };
    ?>
      <div class="flex items-start px-6 py-4 hover:bg-neutral-100 transition-all duration-200 cursor-pointer">
        <div class="flex-1">
          <p class="text-sm font-medium text-neutral-900"><?= htmlspecialchars($meta) ?></p>
          <p class="text-xs <?= $color ?>"><?= $estado ?></p>
        </div>
        <i class="ri-arrow-right-s-line text-lg text-neutral-400"></i>
      </div>
    <?php
        endforeach;
      endif;
    endforeach;

    if (!$hayAhorro) :
    ?>
      <div class="px-6 py-4 text-sm text-neutral-500 italic">
        🎉 No hay notificaciones de ahorro por mostrar.
      </div>
    <?php endif; ?>
  </div>

  <!-- Gastos de Productos -->
  <div class="px-6 py-3 border-b bg-neutral-50 mt-4">
    <h3 class="text-xs font-semibold text-neutral-600 uppercase tracking-wide flex items-center gap-1">
      <i class="ri-shopping-cart-line text-sm text-indigo-500"></i> Gastos de Productos
    </h3>
  </div>

  <div class="divide-y mb-4">
    <?php if (!empty($notificacionesProductos)) : ?>
      <?php foreach ($notificacionesProductos as $mensaje) : ?>
        <div class="flex items-start px-6 py-4 hover:bg-neutral-100 transition-all duration-200 cursor-pointer">
          <div class="flex-1">
            <p class="text-sm font-medium text-neutral-900"><?= htmlspecialchars($mensaje) ?></p>
            <p class="text-xs text-blue-500">Gasto de producto</p>
          </div>
          <i class="ri-arrow-right-s-line text-lg text-neutral-400"></i>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="px-6 py-4 text-sm text-neutral-500 italic">
        🧾 No hay notificaciones de productos por mostrar.
      </div>
    <?php endif; ?>
  </div>

</div>


