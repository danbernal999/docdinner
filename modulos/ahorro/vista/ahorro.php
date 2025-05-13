<div class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950">
  
  <!-- Encabezado con mayor anchura -->
  <header class="mb-6">
    <div class="flex items-center justify-between">
      <!-- Título de la sección -->
      <div>
        <h1 class="text-2xl font-bold">Metas de Ahorro</h1>
      </div>
      <!-- Botón para Agregar Nueva Meta -->
      <div>
        <a href="index.php?ruta=main&modulo=ahorro&accion=crear" class="bg-neutral-950 text-sm hover:bg-cyan-500 text-white px-4 py-2 rounded-full transition-all shadow-xl">
          Agregar Nueva Meta
        </a>
      </div>
    </div>
  </header>

  <!-- Contenedor principal, ahora con max-w-screen-2xl -->
  <main class="bg-white p-1 rounded-xl shadow-2xl">

    <!-- Tabla de Metas de Ahorro -->
    <div class="overflow-x-auto">
      <table class="w-full text-md table-fixed">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-3 font-semibold text-center">ID</th>
            <th class="px-4 py-3 font-semibold text-center">Nombre</th>
            <th class="px-4 py-3 font-semibold text-center">Cantidad</th>
            <th class="px-4 py-3 font-semibold text-center">Ahorrado</th>
            <th class="px-4 py-3 font-semibold text-center">Progreso</th>
            <th class="px-4 py-3 font-semibold text-center">Fecha Límite</th>
            <th class="px-4 py-3 font-semibold text-center">Estado</th>
            <th class="px-4 py-3 font-semibold text-center">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
        <?php foreach ($result as $row): ?>
          <?php
            // Lógica de progreso y estado
            $ahorrado = $row['ahorrado'] ?? 0;
            $cantidad_meta = $row['cantidad_meta'];
            $progreso = ($cantidad_meta > 0) ? ($ahorrado / $cantidad_meta) * 100 : 0;
            $estado = (strtotime($row['fecha_limite']) < time()) ? "¡Meta vencida!" : "En curso";
            $claseFila = (strtotime($row['fecha_limite']) < time() && $ahorrado < $cantidad_meta) ? "bg-red-50" : "";
            $colorBarra = ($progreso < 30) ? "bg-danger" : (($progreso < 70) ? "bg-yellow-500" : "bg-primary");
            $metaCumplida = $ahorrado >= $cantidad_meta;
          ?>
          <tr class="<?= $claseFila ?>">
            <td class="text-center text-sm font-medium"><?= $row['id'] ?></td>
            <td class="text-center text-sm"><?= htmlspecialchars($row['nombre_meta']) ?></td>
            <td class="text-center text-sm whitespace-nowrap">$<?= number_format($cantidad_meta, 2) ?> COP</td>
            <td class="text-center text-sm whitespace-nowrap">$<?= number_format($ahorrado, 2) ?> COP</td>
            <td>
              <div class="bg-gray-200 rounded-full h-4 overflow-hidden">
                <div
                  class="h-4 text-[10px] font-semibold text-white text-center rounded-full <?= $colorBarra ?>"
                  style="width: <?= $progreso ?>%;">
                  <?= round($progreso) ?>%
                </div>
              </div>
            </td>
            <td class="text-center text-sm whitespace-nowrap"><?= htmlspecialchars($row['fecha_limite']) ?></td>
            <td class="text-center text-sm">
              <?php if ($metaCumplida): ?>
                <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                  🎉 ¡Meta alcanzada!
                </span>
              <?php else: ?>
                <?= htmlspecialchars($estado) ?>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <div class="flex flex-col space-y-1">
              <!-- botones aquí -->
                <a href="index.php?ruta=main&modulo=ahorro&accion=editar&id=<?= $row['id'] ?>" class="block bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-md">Editar</a>
                <button onclick="confirmarEliminacion(<?= $row['id'] ?>)" class="block w-full bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md">Eliminar</button>
                <button onclick="toggleModal('historialModal<?= $row['id'] ?>')" class="block w-full bg-gray-500 hover:bg-gray-600 text-white text-xs px-2 py-1 rounded-md">Historial</button>
                <?php if (!$metaCumplida): ?>
                  <button onclick="toggleModal('modalAhorro<?= $row['id'] ?>')" class="block w-full bg-green-500 hover:bg-green-600 text-white text-xs px-2 py-1 rounded-md">Añadir Ahorro</button>
                <?php endif; ?>
              </div>
            </td>
          </tr>

          <!-- Modal Añadir Ahorro -->
          <div id="modalAhorro<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
              <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                  <h5 class="text-xl font-bold">Añadir Ahorro a "<?= htmlspecialchars($row['nombre_meta']) ?>"</h5>
                  <button onclick="toggleModal('modalAhorro<?= $row['id'] ?>')" class="text-gray-500 text-2xl leading-none">&times;</button>
                </div>
                <form action="index.php?ruta=main&modulo=ahorro&accion=ahorroGuardar" method="POST">
                  <input type="hidden" name="meta_id" value="<?= $row['id'] ?>">
                  <label class="block text-sm font-medium text-neutral-700">Cantidad:</label>
                  <input type="number" name="cantidad_ahorrada" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2 mt-1">
                  <div class="mt-3">
                    <label class="inline-flex items-center">
                      <input type="checkbox" name="agregar_descripcion" id="descripcionCheck<?= $row['id'] ?>" class="form-checkbox">
                      <span class="ml-2 text-sm text-neutral-700">Agregar descripción</span>
                    </label>
                  </div>
                  <div id="descripcionDiv<?= $row['id'] ?>" class="mt-3 hidden">
                    <label class="block text-sm font-medium text-neutral-700">Descripción:</label>
                    <textarea name="descripcion" rows="3" class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2 mt-1"></textarea>
                  </div>
                  <button type="submit" name="guardarAhorro" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-opacity">Guardar</button>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Historial -->
          <div id="historialModal<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
              <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                  <h5 class="text-xl font-bold">Historial de Ahorros<br><span class="text-base font-normal">"<?= htmlspecialchars($row['nombre_meta']) ?>"</span></h5>
                  <button onclick="toggleModal('historialModal<?= $row['id'] ?>')" class="text-gray-500 text-2xl leading-none">&times;</button>
                </div>
                <div class="max-h-72 overflow-y-auto space-y-3">
                  <?php
                    $historial_result = $this->metaAhorroModel->obtenerHistorialPorMeta($row['id']);
                    foreach ($historial_result as $historial):
                  ?>
                    <div class="border-b border-gray-200 pb-2">
                      <p class="text-sm"><strong>Cantidad:</strong> $<?= number_format($historial['cantidad'], 2) ?> COP</p>
                      <p class="text-sm"><strong>Fecha:</strong> <?= $historial['fecha'] ?></p>
                      <?php if (!empty($historial['descripcion1'])): ?>
                        <p class="text-sm"><strong>Descripción:</strong> <?= htmlspecialchars($historial['descripcion1']) ?></p>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Scripts para modales y comportamiento -->
  <script>
    // Función para mostrar/ocultar modales
    function toggleModal(id) {
      const modal = document.getElementById(id);
      modal.classList.toggle('hidden');
    }

    // Mostrar/ocultar campo de descripción
    document.querySelectorAll('[id^="descripcionCheck"]').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const id = this.id.replace('descripcionCheck', '');
        const descDiv = document.getElementById('descripcionDiv' + id);
        descDiv.classList.toggle('hidden', !this.checked);
      });
    });

    // Confirmar eliminación
    function confirmarEliminacion(metaId) {
      if (confirm("¿Estás seguro de que deseas eliminar esta meta?")) {
        window.location.href = "index.php?ruta=main&modulo=ahorro&accion=eliminar&id=" + metaId;
      }
    }
  </script>
</div>



