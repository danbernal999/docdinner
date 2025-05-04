<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "control_gastos");
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Consulta metas de ahorro
$sql = "SELECT * FROM metas_ahorro";
$result = $conn->query($sql);

// Consulta historial de ahorros
$historial_sql = "SELECT * FROM historial_ahorros WHERE meta_id = ?";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metas de Ahorro</title>
  <!-- Cargar Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#22C55E",
            secondary: "#3B82F6",
            accent: "#F59E0B",
            danger: "#EF4444",
            dark: "#181818",
            "dark-light": "#252525",
            neutral: {
              900: "#171717",
              50: "#F9FAFB"
            }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-neutral-50 min-h-screen text-neutral-950 m-10">

  <!-- Encabezado con mayor anchura -->
  <header class="w-full mb-6">
    <div class="max-w-screen-2xl mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Título de la sección -->
      <div>
        <h1 class="text-2xl font-bold">Metas de Ahorro</h1>
      </div>
      <!-- Botón para Agregar Nueva Meta -->
      <div>
        <a href="agregar_meta.php" class="bg-neutral-950 text-sm hover:bg-cyan-500 text-white px-4 py-2 rounded-full transition-all shadow-xl">
          Agregar Nueva Meta
        </a>
      </div>
    </div>
  </header>

  <!-- Contenedor principal, ahora con max-w-screen-2xl -->
  <main class="max-w-screen-2xl mx-auto px-4 pb-8">

    <!-- Tabla de Metas de Ahorro -->
    <div class="overflow-x-auto bg-white shadow-xl rounded-xl">
      <table class="min-w-full table-auto text-md">
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
          <?php while ($row = $result->fetch_assoc()):
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
            <td class="px-4 py-3 text-center font-medium">
              <?= $row['id'] ?>
            </td>
            <td class="px-4 py-3 text-center">
              <?= htmlspecialchars($row['nombre_meta']) ?>
            </td>
            <td class="px-4 py-3 text-center">
              $<?= number_format($cantidad_meta, 2) ?> COP
            </td>
            <td class="px-4 py-3 text-center">
              $<?= number_format($ahorrado, 2) ?> COP
            </td>
            <td class="px-4 py-3">
              <div class="w-full bg-gray-200 rounded-full h-5">
                <div
                  class="h-5 text-xs font-semibold text-white text-center rounded-full <?= $colorBarra ?>"
                  style="width: <?= $progreso ?>%;">
                  <?= round($progreso) ?>%
                </div>
              </div>
            </td>
            <td class="px-4 py-3 text-center">
              <?= htmlspecialchars($row['fecha_limite']) ?>
            </td>
            <td class="px-4 py-3 text-center">
              <?php if ($metaCumplida): ?>
                <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                  🎉 ¡Meta alcanzada!
                </span>
              <?php else: ?>
                <?= htmlspecialchars($estado) ?>
              <?php endif; ?>
            </td>
            <td class="px-4 py-3 text-center space-y-2">
              <!-- Botón Editar -->
              <a
                href="editar_meta.php?id=<?= $row['id'] ?>"
                class="block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm transition-opacity">
                Editar
              </a>
              <!-- Botón Eliminar -->
              <button
                onclick="confirmarEliminacion(<?= $row['id'] ?>)"
                class="block w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition-opacity">
                Eliminar
              </button>
              <!-- Botón Historial -->
              <button
                onclick="toggleModal('historialModal<?= $row['id'] ?>')"
                class="block w-full bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-md text-sm transition-opacity">
                Historial
              </button>
              <!-- Botón Añadir Ahorro (solo si no está cumplida) -->
              <?php if (!$metaCumplida): ?>
                <button
                  onclick="toggleModal('modalAhorro<?= $row['id'] ?>')"
                  class="block w-full bg-primary hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm transition-opacity">
                  Añadir Ahorro
                </button>
              <?php endif; ?>
            </td>
          </tr>

          <!-- Modal para Añadir Ahorro -->
          <div id="modalAhorro<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
              <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                  <h5 class="text-xl font-bold">
                    Añadir Ahorro a "<?= htmlspecialchars($row['nombre_meta']) ?>"
                  </h5>
                  <button
                    onclick="toggleModal('modalAhorro<?= $row['id'] ?>')"
                    class="text-gray-500 text-2xl leading-none">
                    &times;
                  </button>
                </div>
                <form action="añadir_ahorro.php" method="POST">
                  <input type="hidden" name="meta_id" value="<?= $row['id'] ?>">
                  <label class="block text-sm font-medium text-neutral-700" for="cantidad_ahorrada">
                    Cantidad:
                  </label>
                  <input
                    type="number"
                    name="cantidad_ahorrada"
                    required
                    class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2 mt-1">
                  <div class="mt-3">
                    <label class="inline-flex items-center">
                      <input
                        type="checkbox"
                        name="agregar_descripcion"
                        id="descripcionCheck<?= $row['id'] ?>"
                        class="form-checkbox">
                      <span class="ml-2 text-sm text-neutral-700">Agregar descripción</span>
                    </label>
                  </div>
                  <div id="descripcionDiv<?= $row['id'] ?>" class="mt-3 hidden">
                    <label class="block text-sm font-medium text-neutral-700" for="descripcion">
                      Descripción:
                    </label>
                    <textarea
                      name="descripcion"
                      rows="3"
                      class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 focus:border-primary focus:ring-primary p-2 mt-1"
                    ></textarea>
                  </div>
                  <button
                    type="submit"
                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-opacity">
                    Guardar
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal para Ver Historial de Ahorros -->
          <div id="historialModal<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
              <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                  <h5 class="text-xl font-bold">
                    Historial de Ahorros<br>
                    <span class="text-base font-normal">
                      "<?= htmlspecialchars($row['nombre_meta']) ?>"
                    </span>
                  </h5>
                  <button
                    onclick="toggleModal('historialModal<?= $row['id'] ?>')"
                    class="text-gray-500 text-2xl leading-none">
                    &times;
                  </button>
                </div>
                <div class="max-h-72 overflow-y-auto space-y-3">
                  <?php
                    // Consulta para historial
                    $stmt = $conn->prepare($historial_sql);
                    $stmt->bind_param("i", $row['id']);
                    $stmt->execute();
                    $historial_result = $stmt->get_result();
                    while ($historial = $historial_result->fetch_assoc()):
                  ?>
                    <div class="border-b border-gray-200 pb-2">
                      <p class="text-sm">
                        <strong>Cantidad:</strong>
                        $<?= number_format($historial['cantidad'], 2) ?> COP
                      </p>
                      <p class="text-sm">
                        <strong>Fecha:</strong>
                        <?= $historial['fecha'] ?>
                      </p>
                      <?php if (!empty($historial['descripcion1'])): ?>
                        <p class="text-sm">
                          <strong>Descripción:</strong>
                          <?= htmlspecialchars($historial['descripcion1']) ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
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
        window.location.href = "eliminar_meta.php?id=" + metaId;
      }
    }
  </script>
</body>
</html>


