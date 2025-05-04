<?php
include_once('db_connect.php');

$id = $_GET['id'];

$database = new Connection();
$db = $database->open();

try {
    $sql = "SELECT * FROM metas_ahorro WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $meta = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$database->close();
?>

<!DOCTYPE html>
<html lang="es" class="h-full bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Meta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    backgroundImage: {
                        'custom-gradient': 'linear-gradient(to right, #31ff58, #38a3d8)',
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full bg-black text-white">
    <div class="min-h-full">
        <nav class="bg-gray-900 border-b border-gray-700">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Editar Meta</h1>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-gray-900 px-5 py-6 shadow sm:px-6">
                    <form method="POST" action="actualizar_meta.php" class="space-y-6">
                        <input type="hidden" name="id" value="<?php echo $meta['id']; ?>">
                        
                        <div>
                            <label for="nombre_meta" class="block text-sm font-medium text-white">
                                Nombre de la Meta
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       id="nombre_meta" 
                                       name="nombre_meta" 
                                       value="<?php echo htmlspecialchars($meta['nombre_meta']); ?>"
                                       required 
                                       class="block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-[#31ff58] focus:ring-[#38a3d8] sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="cantidad_meta" class="block text-sm font-medium text-white">
                                Cantidad
                            </label>
                            <div class="mt-1">
                                <input type="number" 
                                       id="cantidad_meta" 
                                       name="cantidad_meta" 
                                       step="0.01" 
                                       value="<?php echo htmlspecialchars($meta['cantidad_meta']); ?>"
                                       required 
                                       class="block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-[#31ff58] focus:ring-[#38a3d8] sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="fecha_limite" class="block text-sm font-medium text-white">
                                Fecha Límite
                            </label>
                            <div class="mt-1">
                                <input type="date" 
                                       id="fecha_limite" 
                                       name="fecha_limite" 
                                       value="<?php echo htmlspecialchars($meta['fecha_limite']); ?>"
                                       required 
                                       class="block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-[#31ff58] focus:ring-[#38a3d8] sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-white">
                                Descripción
                            </label>
                            <div class="mt-1">
                                <textarea id="descripcion" 
                                          name="descripcion" 
                                          rows="3" 
                                          class="block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-[#31ff58] focus:ring-[#38a3d8] sm:text-sm"><?php echo htmlspecialchars($meta['descripcion']); ?></textarea>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm bg-gray-800 hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-700">
                                Actualizar Meta
                            </button>
                            <a href="index.php" 
                               class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-700">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>