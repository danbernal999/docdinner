<div class="bg-neutral-50 min-h-screen p-4 md:p-8 text-neutral-950">
    <main class="bg-white p-1 max-w-svw rounded-xl shadow-2xl">

        <div class="flex flex-col m-2">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold m-4">Metas de Ahorro</h2>
                </div>
                <div>
                    <button onclick="toggleModal('modalCrearMeta')" class="bg-neutral-950 text-sm hover:bg-cyan-500 text-white mx-2 px-6 py-2 rounded-xl transition-all shadow-2xl">Agregar Nueva Meta</button>
                </div>
            </div>

            <div class="">
                <table class="w-full text-md table-auto md:table-fixed">
                    <thead class="bg-gray-100">
                        <tr>
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
                                $colorBarra = ($progreso < 30) ? "bg-danger" : (($progreso < 70) ? "bg-cyan-500" : "bg-green-400");
                                $progreso = min($progreso, 100); // Limitar el progreso al 100%
                                $metaCumplida = $ahorrado >= $cantidad_meta;
                            ?>
                            <tr class="<?= $claseFila ?>">
                                <td class="text-center text-sm"><?= htmlspecialchars($row['nombre_meta']) ?></td>
                                <td class="text-center text-sm whitespace-nowrap">$<?= number_format($cantidad_meta, 2) ?> COP</td>
                                <td class="text-center text-sm whitespace-nowrap">$<?= number_format($ahorrado, 2) ?> COP</td>
                                <td>
                                    <div class="bg-gray-200 rounded-full h-4 overflow-hidden">
                                        <div
                                            class="h-4 text-[10px] font-semibold text-black text-center rounded-full <?= $colorBarra ?>"
                                            style="width: <?= $progreso ?>%;">
                                            <?= round($progreso) ?>%
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-sm whitespace-nowrap"><?= htmlspecialchars($row['fecha_limite']) ?></td>
                                <td class="text-center text-sm">
                                    <?php if ($metaCumplida): ?>
                                        <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                                            🎉 ¡Meta Alcanzada!
                                        </span>
                                    <?php else: ?>
                                        <?= htmlspecialchars($estado) ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="flex flex-col space-y-4">
                                        <div class="relative inline-block text-center">
                                            <button onclick="toggleDropdown('acciones<?= $row['id'] ?>')" 
                                                class="bg-cyan-500 hover:bg-cyan-600 text-white text-xs px-2 py-1 rounded-md">
                                                Acciones +
                                            </button>

                                            <div id="acciones<?= $row['id'] ?>" class="hidden absolute z-10 mt-1 w-36 bg-white rounded-md shadow-md border border-gray-200">
                                                <button onclick="toggleModal('modalEditar<?= $row['id'] ?>')" 
                                                    class="w-full text-center text-[11px] px-2 py-1 hover:bg-gray-100">
                                                    ✏️ Editar
                                                </button>
                                                <button onclick="confirmarEliminacion(<?= $row['id'] ?>)" 
                                                    class="w-full text-center text-[11px] px-2 py-1 hover:bg-red-100 text-red-600">
                                                    🗑️ Eliminar
                                                </button>
                                                <button onclick="toggleModal('historialModal<?= $row['id'] ?>')" 
                                                    class="w-full text-center text-[11px] px-2 py-1 hover:bg-gray-100">
                                                    📜 Historial
                                                </button>
                                                <?php if (!$metaCumplida): ?>
                                                <button onclick="toggleModal('modalAhorro<?= $row['id'] ?>')" 
                                                    class="w-full text-center text-[11px] px-2 py-1 hover:bg-green-100 text-green-700">
                                                    💰 Añadir Ahorro
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <div id="modalEditar<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
                                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                                        <div class="flex justify-between items-center mb-4">
                                            <h5 class="text-xl font-bold">Editar Meta<br></h5>
                                            <button onclick="toggleModal('modalEditar<?= $row['id'] ?>')" class="text-gray-500 text-2xl leading-none">&times;</button>
                                        </div>
                                        <form action="index.php?ruta=main&modulo=ahorro" method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                            <label class="block text-sm font-medium text-neutral-700 mt-2">Nombre de la Meta</label>
                                            <input type="text" name="nombre_meta" value="<?= htmlspecialchars($row['nombre_meta']) ?>" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1">

                                            <label class="block text-sm font-medium text-neutral-700 mt-3">Cantidad</label>
                                            <input type="number" name="cantidad_meta" step="0.01" value="<?= htmlspecialchars($row['cantidad_meta']) ?>" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1">

                                            <label class="block text-sm font-medium text-neutral-700 mt-3">Fecha Límite</label>
                                            <input type="date" name="fecha_limite" value="<?= htmlspecialchars($row['fecha_limite']) ?>" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1">

                                            <label class="block text-sm font-medium text-neutral-700 mt-3">Descripción</label>
                                            <textarea name="descripcion" rows="3" class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1"><?= htmlspecialchars($row['descripcion']) ?></textarea>

                                            <div class="mt-4 flex justify-end space-x-2">
                                                <button type="button" onclick="toggleModal('modalEditar<?= $row['id'] ?>')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</button>
                                                <button type="submit" name="actualizarMeta" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="modalAhorro<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
                                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                                        <div class="flex justify-between items-center mb-4">
                                            <h5 class="text-xl font-bold">Añadir Ahorro a <?= htmlspecialchars($row['nombre_meta']) ?></h5>
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

                            <div id="historialModal<?= $row['id'] ?>" class="hidden fixed inset-0 z-50 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
                                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                                        <div class="flex justify-between items-center mb-4">
                                            <h5 class="text-xl font-bold">Historial de Ahorros de <?= htmlspecialchars($row['nombre_meta']) ?></h5>
                                            <button onclick="toggleModal('historialModal<?= $row['id'] ?>')" class="text-gray-500 text-2xl leading-none">&times;</button>
                                        </div>
                                        <div class="max-h-72 overflow-y-auto space-y-3">
                                            <?php
                                                $historial_result = $this->metaAhorroModel->obtenerHistorialPorMeta($row['id']);
                                                if (empty($historial_result)) {
                                                    echo '<p class="text-center text-gray-500">No hay historial de ahorros para esta meta.</p>';
                                                } else {
                                                    foreach ($historial_result as $historial):
                                            ?>
                                                    <div class="border-b border-gray-200 pb-2 flex justify-between items-center">
                                                        <div>
                                                            <p class="text-sm"><strong>Cantidad:</strong> $<?= number_format($historial['cantidad'], 2) ?> COP</p>
                                                            <p class="text-sm"><strong>Fecha:</strong> <?= $historial['fecha'] ?></p>
                                                            <?php if (!empty($historial['descripcion1'])): ?>
                                                                <p class="text-sm"><strong>Descripción:</strong> <?= htmlspecialchars($historial['descripcion1']) ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <button onclick="confirmarDeshacerAhorro(<?= $historial['id'] ?>, <?= $row['id'] ?>, <?= $historial['cantidad'] ?>)" class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md">
                                                            Deshacer
                                                        </button>
                                                    </div>
                                            <?php
                                                    endforeach;
                                                }
                                            ?>
                                        </div>
                                        <div class="mt-4 flex justify-end items-end space-x-2">
                                            <a href="modulos/ahorro/vista/generar_pdf.php?meta_id=<?= $row['id'] ?>" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-opacity">
                                                Imprimir Historial
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="modalCrearMeta" class="hidden fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50 px-4">
                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
                        <div class="flex justify-between items-center mb-4">
                            <h5 class="text-xl font-bold">Agregar Nueva Meta de Ahorro</h5>
                            <button onclick="toggleModal('modalCrearMeta')" class="text-gray-500 text-2xl leading-none">&times;</button>
                        </div>
                        <form action="index.php?ruta=main&modulo=ahorro" method="POST">
                            <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario_id'] ?>">

                            <label class="block text-sm font-medium text-neutral-700 mt-2">Nombre de la Meta</label>
                            <input type="text" name="nombre_meta" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1">

                            <label class="block text-sm font-medium text-neutral-700 mt-3">Cantidad Objetivo</label>
                            <input type="number" name="cantidad_meta" step="0.01" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1">

                            <label class="block text-sm font-medium text-neutral-700 mt-3">Fecha Límite</label>
                            <input type="date" name="fecha_limite" required class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1">

                            <label class="block text-sm font-medium text-neutral-700 mt-3">Descripción (opcional)</label>
                            <textarea name="descripcion" rows="3" class="w-full bg-gray-100 text-neutral-950 rounded-md border border-gray-300 p-2 mt-1"></textarea>

                            <div class="mt-4 flex justify-end space-x-2">
                                <button type="button" onclick="toggleModal('modalCrearMeta')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Cancelar</button>
                                <button type="submit" name="crearMeta" class="px-4 py-2 bg-neutral-950 text-white rounded-md hover:bg-cyan-600">Guardar Meta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/ahorro/modals.js"></script>

    <script>
        // Función para mostrar/ocultar el campo de descripción en el modal de añadir ahorro
        document.querySelectorAll('[id^="descripcionCheck"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const metaId = this.id.replace('descripcionCheck', '');
                const descripcionDiv = document.getElementById('descripcionDiv' + metaId);
                if (this.checked) {
                    descripcionDiv.classList.remove('hidden');
                } else {
                    descripcionDiv.classList.add('hidden');
                }
            });
        });

        // Función para confirmar la eliminación de una meta
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta meta de ahorro? Se eliminarán también todos los ahorros asociados a ella.")) {
                window.location.href = `index.php?ruta=main&modulo=ahorro&accion=eliminar&id=${id}`;
            }
        }

        // Función para confirmar y deshacer un ahorro específico
        function confirmarDeshacerAhorro(historialId, metaId, cantidad) {
            if (confirm(`¿Estás seguro de que deseas deshacer este ahorro de $${cantidad} COP?`)) {
                window.location.href = `index.php?ruta=main&modulo=ahorro&accion=deshacerAhorro&historial_id=${historialId}&meta_id=${metaId}&cantidad=${cantidad}`;
            }
        }
    </script>
</div>