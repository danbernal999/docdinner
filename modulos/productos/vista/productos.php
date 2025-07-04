<div class="bg-neutral-50 min-h-screen text-neutral-950 p-4 md:p-8">
  <main class="mx-auto space-y-8">
    <!-- Tarjeta de Formularios: Búsqueda por Categoría -->
    <div class="rounded-xl bg-white p-6 shadow-2xl">
      <h2 class="text-xl font-bold mb-4">Gastos Adquiridos</h2>

      <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
        <div>
          <label for="categoria" class="block text-sm font-medium">Buscar por Categoría:</label>
          <div class="flex items-center gap-2 mt-1">
          <select id="categoria" name="categoria" required class="w-full rounded-md bg-gray-100 border border-gray-300 py-2 pl-3 pr-10 focus:border-cyan-500 focus:outline-none focus:ring-primary sm:text-sm">
            <option value="">Seleccione una categoría</option>
            <option value="Alimentación" <?= $categoriaSeleccionada == 'Alimentación' ? 'selected' : '' ?>>Alimentación</option>
            <option value="Transporte" <?= $categoriaSeleccionada == 'Transporte' ? 'selected' : '' ?>>Transporte</option>
            <option value="Vivienda" <?= $categoriaSeleccionada == 'Vivienda' ? 'selected' : '' ?>>Vivienda</option>
            <option value="Servicios" <?= $categoriaSeleccionada == 'Servicios' ? 'selected' : '' ?>>Servicios</option>
            <option value="Entretenimiento" <?= $categoriaSeleccionada == 'Entretenimiento' ? 'selected' : '' ?>>Entretenimiento</option>
            <option value="Salud y belleza" <?= $categoriaSeleccionada == 'Salud y belleza' ? 'selected' : '' ?>>Salud y belleza</option>
            <option value="Educación" <?= $categoriaSeleccionada == 'Educación' ? 'selected' : '' ?>>Educación</option>
            <option value="Electrónica" <?= $categoriaSeleccionada == 'Electrónica' ? 'selected' : '' ?>>Electrónica</option>
            <option value="Ropa y accesorios" <?= $categoriaSeleccionada == 'Ropa y accesorios' ? 'selected' : '' ?>>Ropa y accesorios</option>
            <option value="Hogar y decoración" <?= $categoriaSeleccionada == 'Hogar y decoración' ? 'selected' : '' ?>>Hogar y decoración</option>
            <option value="Deportes y aire libre" <?= $categoriaSeleccionada == 'Deportes y aire libre' ? 'selected' : '' ?>>Deportes y aire libre</option>
            <option value="Juguetes y juegos" <?= $categoriaSeleccionada == 'Juguetes y juegos' ? 'selected' : '' ?>>Juguetes y juegos</option>
            <option value="Automóviles y accesorios" <?= $categoriaSeleccionada == 'Automóviles y accesorios' ? 'selected' : '' ?>>Automóviles y accesorios</option>
            <option value="Tecnología y software" <?= $categoriaSeleccionada == 'Tecnología y software' ? 'selected' : '' ?>>Tecnología y software</option>
            <option value="Otro" <?= $categoriaSeleccionada == 'Otro' ? 'selected' : '' ?>>Otro</option>
          </select>

          <button type="button" onclick="window.location.href = 'index.php?ruta=main&modulo=productos';" class="ml-1 rounded-md px-4 py-2 text-lg font-bold shadow-2xl"><i class="ri-refresh-line"></i></button>
        </div>

        </div>
        <div class="flex justify-end gap-2">
          <button type="submit" name="buscar_categoria" class="rounded-md bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-lg">Buscar</button>
          <button type="submit" name="ver_total_categoria" class="rounded-md bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg">Ver Total de la Categoría</button>
        </div>
      </form>
      <?php if ($total_categoria !== null): ?>
        <div class="mt-4 rounded-md bg-gray-100 p-4">
          <h2 class="text-lg font-semibold">Total de la categoría "<?= htmlspecialchars($categoriaSeleccionada); ?>": $<?= number_format($total_categoria, 2, ',', '.'); ?></h2>
        </div>
      <?php endif; ?>
    </div>

    <!-- Tarjeta de Tabla de Gastos Fijos y Botones de Acción -->
    <div class="rounded-xl bg-white p-6 shadow-2xl">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-semibold">Lista de Gastos Fijos</h2>
        <div class="flex items-center gap-2">
          <button data-modal-target="modal-crear-gasto" data-modal-toggle="modal-crear-gasto" class="rounded-md bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg">
            Añadir Gasto
          </button>

          <form method="POST">
            <button type="submit" name="ver_total" class="rounded-md bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg">Ver Total de Gastos</button>
          </form>
        </div>
      </div>
      <?php if ($total_gastos !== null): ?>
        <div class="mt-4 rounded-md bg-gray-100 p-4">
          <h2 class="text-lg font-semibold">Total de Gastos: $<?= number_format($total_gastos, 2, ',', '.'); ?></h2>
        </div>
      <?php endif; ?>
      <div class="mt-8 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-semibold">Nombre</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Monto</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">IVA</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Valor sin IVA</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Fecha</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Categoría</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Descripción</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">

          <!-- foreach = Por cada | as = Como -->
            <?php foreach ($gastos as $gasto): ?>
              <tr>
                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-neutral-950"><?= htmlspecialchars($gasto['nombre_gasto']) ?></td>
                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">$<?= number_format($gasto['monto'], 2, ',', '.') ?></td>
                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">$<?= number_format($gasto['valor_iva'] ?? 0, 2, ',', '.') ?></td>
                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">$<?= number_format($gasto['valor_sin_iva'] ?? 0, 2, ',', '.') ?></td>
                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($gasto['fecha']) ?></td>
                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($gasto['categoria']) ?></td>
                <td class="px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($gasto['descripcion']) ?></td>
                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                  <div class="flex flex-col gap-2">
                    <!-- Botón Editar: activa el modal correspondiente -->
                    <button data-modal-toggle="editar-modal-<?= $gasto['id'] ?>" class="rounded-md bg-cyan-500 px-2 py-1 text-xs font-semibold text-white shadow-lg hover:opacity-90 transition">
                      Editar
                    </button>
                    <a href="index.php?ruta=main&modulo=productos&accion=eliminar&id=<?= $gasto['id'] ?>" class="rounded-md bg-red-600 px-2 py-1 text-xs font-semibold text-white shadow-lg hover:bg-red-500 transition text-center" onclick="return confirm('¿Está seguro de eliminar este gasto?')">
                      Eliminar
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  
  <!-- Modals para editar cada producto -->
  <?php foreach ($gastos as $gasto): ?>
    <div id="editar-modal-<?= $gasto['id'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-[calc(100%)] max-h-full bg-black/70 backdrop-blur-md">
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">Editar Gasto</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-toggle="editar-modal-<?= $gasto['id'] ?>">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Cerrar modal</span>
            </button>
          </div>
          <!-- Modal body: Formulario de edición -->
          <form action="index.php?ruta=main&modulo=productos" method="POST" class="p-4">
            <input type="hidden" name="id" value="<?= $gasto['id'] ?>">
            <div class="mb-4">
              <label for="nombre_gasto_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Gasto</label>
              <input type="text" name="nombre_gasto" id="nombre_gasto_<?= $gasto['id'] ?>" value="<?= htmlspecialchars($gasto['nombre_gasto']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
              <label for="monto_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Monto</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                <input type="number" name="monto" id="monto_<?= $gasto['id'] ?>" step="0.01" value="<?= htmlspecialchars($gasto['monto']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5" />
              </div>
            </div>

            <div class="mb-4">
              <label for="fecha_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
              <input type="date" name="fecha" id="fecha_<?= $gasto['id'] ?>" value="<?= htmlspecialchars($gasto['fecha']) ?>" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
            </div>
            <div class="mb-4">
              <label for="categoria_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
              <select name="categoria" id="categoria_<?= $gasto['id'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                <?php
                $categorias = ['Alimentación', 'Transporte', 'Vivienda', 'Servicios', 'Entretenimiento', 'Salud y Belleza', 'Educación', 'Electronica', 'Ropa y Accesorios', 'Hogar y Decoración', 'Deportes y Aire Libre', 'Juguetes y Accesorios', 'Automóviles y Accesorios', 'Tecnología y Software', 'Otro'];
                foreach ($categorias as $cat) {
                    $selected = ($gasto['categoria'] == $cat) ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($cat) . "\" $selected>" . htmlspecialchars($cat) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-4">
              <label for="descripcion_<?= $gasto['id'] ?>" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
              <textarea name="descripcion" id="descripcion_<?= $gasto['id'] ?>" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?= htmlspecialchars($gasto['descripcion']) ?></textarea>
            </div>

            <button type="submit" name="actualizarGasto" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Actualizar</button>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  
  <!-- Modal para añadir gasto -->
  <div id="modal-crear-gasto" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-[calc(100%)] max-h-full bg-black/70 backdrop-blur-md">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b rounded-t">
          <h3 class="text-lg font-semibold text-gray-900">Añadir Gasto</h3>
          <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center" data-modal-toggle="modal-crear-gasto">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Cerrar modal</span>
          </button>
        </div>

        <!-- Modal Body: Formulario -->
        <form action="index.php?ruta=main&modulo=productos" method="POST" class="p-4">
          <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario_id'] ?>">

          <div class="mb-4">
            <label for="nombre_gasto" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Gasto</label>
            <input type="text" name="nombre_gasto" id="nombre_gasto" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
          </div>

          <div class="mb-4">
            <label for="monto" class="block mb-2 text-sm font-medium text-gray-900">Monto</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
              <input type="number" name="monto" id="monto" step="0.01" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5" />
            </div>
          </div>

          <div class="mb-4">
            <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
            <input type="date" name="fecha" id="fecha" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
          </div>

          <div class="mb-4">
            <label for="categoria" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
            <select name="categoria" id="categoria" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
              <option value="">Seleccione una categoría</option>
              <?php
              $categorias = ['Alimentación', 'Transporte', 'Vivienda', 'Servicios', 'Entretenimiento', 'Salud y Belleza', 'Educación', 'Electrónica', 'Ropa y Accesorios', 'Hogar y Decoración', 'Deportes y Aire Libre', 'Juguetes y Juegos', 'Automóviles y Accesorios', 'Tecnología y Software', 'Otro'];
              foreach ($categorias as $cat) {
                echo "<option value=\"" . htmlspecialchars($cat) . "\">" . htmlspecialchars($cat) . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required></textarea>
          </div>

          <!-- Sección IVA -->
          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-900">¿Este gasto incluye IVA?</label>
            <div class="flex items-center gap-3">
              <input type="checkbox" id="incluir_iva" name="incluir_iva" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
              <label for="incluir_iva" class="text-sm text-gray-700">Incluir IVA</label>
            </div>
          </div>

          <div id="iva-section" class="mb-4 hidden">
            <label for="tasa_iva" class="block mb-2 text-sm font-medium text-gray-900">Tasa de IVA</label>
            <select id="tasa_iva" name="tasa_iva" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
              <option value="19">19%</option>
              <option value="5">5%</option>
              <option value="0">0% (Exento)</option>
            </select>

            <div class="mt-3 text-sm text-gray-700">
              <p><strong>IVA estimado:</strong> <span id="iva_estimado">$0.00</span></p>
              <p><strong>Valor sin IVA:</strong> <span id="valor_sin_iva">$0.00</span></p>
            </div>
          </div>

          <button type="submit" name="crearGasto" class="text-white bg-blue-700 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Guardar Gasto</button>
        </form>
      </div>
    </div>
  </div>
  
  
  <!-- Script para toggle de modales -->
  <script src="assets/js/productos/modals.js"></script>
  <script src="assets/js/productos/iva.js"></script>

</div>


