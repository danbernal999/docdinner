<!DOCTYPE html>
<html lang="es" class="h-full bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Meta</title>
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
        <div class="bg-custom-gradient pb-32">
            <header class="py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-white">Agregar Nueva Meta</h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-gray-900 px-5 py-6 shadow sm:px-6">
                    <form method="POST" action="guardar_meta.php" class="space-y-6">
                        <div>
                            <label for="nombre_meta" class="block text-sm font-medium text-white">
                                Nombre de la Meta
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       id="nombre_meta" 
                                       name="nombre_meta" 
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
                                          class="block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-[#31ff58] focus:ring-[#38a3d8] sm:text-sm"></textarea>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="inline-flex justify-center rounded-md bg-custom-gradient px-4 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#31ff58]">
                                Guardar Meta
                            </button>
                            <a href="index.php" 
                               class="inline-flex justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-700">
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
