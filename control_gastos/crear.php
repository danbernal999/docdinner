<?php
include 'db.php';

// Variable para manejar errores
$error = '';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_gasto = $_POST['nombre_gasto'];
    $monto = $_POST['monto'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];

    // Validación simple
    if (empty($nombre_gasto) || empty($monto) || empty($categoria) || empty($descripcion) || empty($fecha)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        // Insertar el nuevo gasto en la base de datos
        $sql = "INSERT INTO gastos_fijos (nombre_gasto, monto, categoria, descripcion, fecha) 
                VALUES (:nombre_gasto, :monto, :categoria, :descripcion, :fecha)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre_gasto' => $nombre_gasto,
            ':monto' => $monto,
            ':categoria' => $categoria,
            ':descripcion' => $descripcion,
            ':fecha' => $fecha
        ]);
        header('Location: index.php?agregado=true'); // Redirigir con parámetro de éxito
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Gasto - DocDinner</title>
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
                        "dark-light": "#252525"
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-dark text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-dark-light rounded-lg shadow-lg shadow-primary/10 p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="index.php" class="p-2 rounded-full hover:bg-black/20 transition-colors">
                <i class="ri-arrow-left-line text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Agregar Nuevo Gasto</h1>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-danger/20 border border-danger/30 text-white px-4 py-3 rounded mb-4 flex items-center">
                <i class="ri-error-warning-line mr-2 text-danger"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-5">
            <div class="space-y-2">
                <label for="nombre_gasto" class="block text-primary font-medium">Nombre del Gasto</label>
                <input 
                    type="text" 
                    id="nombre_gasto" 
                    name="nombre_gasto" 
                    required
                    class="w-full bg-dark border border-gray-700 rounded px-3 py-2 text-white focus:border-primary focus:outline-none transition-transform hover:scale-[1.01]"
                >
            </div>
            
            <div class="space-y-2">
                <label for="monto" class="block text-primary font-medium">Monto</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-400">$</span>
                    <input 
                        type="number" 
                        id="monto" 
                        name="monto" 
                        step="0.01" 
                        required
                        class="w-full bg-dark border border-gray-700 rounded px-3 py-2 pl-7 text-white focus:border-primary focus:outline-none transition-transform hover:scale-[1.01]"
                    >
                </div>
            </div>
            
            <div class="space-y-2">
                <label for="fecha" class="block text-primary font-medium">Fecha</label>
                <input 
                    type="date" 
                    id="fecha" 
                    name="fecha" 
                    required
                    class="w-full bg-dark border border-gray-700 rounded px-3 py-2 text-white focus:border-primary focus:outline-none transition-transform hover:scale-[1.01]"
                >
            </div>
            
            <div class="space-y-2">
                <label for="categoria" class="block text-primary font-medium">Categoría</label>
                <select 
                    id="categoria" 
                    name="categoria" 
                    required
                    class="w-full bg-dark border border-gray-700 rounded px-3 py-2 text-white focus:border-primary focus:outline-none transition-transform hover:scale-[1.01]"
                >
                    <option value="">Seleccione una categoría</option>
                    <option value="Alimentación">Alimentación</option>
                    <option value="Transporte">Transporte</option>
                    <option value="Vivienda">Vivienda</option>
                    <option value="Servicios">Servicios</option>
                    <option value="Entretenimiento">Entretenimiento</option>
                    <option value="Salud y belleza">Salud y belleza</option>
                    <option value="Educación">Educación</option>
                    <option value="Electrónica">Electrónica</option>
                    <option value="Ropa y accesorios">Ropa y accesorios</option>
                    <option value="Hogar y decoración">Hogar y decoración</option>
                    <option value="Deportes y aire libre">Deportes y aire libre</option>
                    <option value="Juguetes y juegos">Juguetes y juegos</option>
                    <option value="Automóviles y accesorios">Automóviles y accesorios</option>
                    <option value="Tecnología y software">Tecnología y software</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            
            <div class="space-y-2">
                <label for="descripcion" class="block text-primary font-medium">Descripción</label>
                <textarea 
                    id="descripcion" 
                    name="descripcion" 
                    required
                    rows="4"
                    class="w-full bg-dark border border-gray-700 rounded px-3 py-2 text-white focus:border-primary focus:outline-none transition-transform hover:scale-[1.01]"
                ></textarea>
            </div>
            
            <div class="flex gap-4 pt-2">
                <a 
                    href="index.php" 
                    class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded text-center font-medium transition-all hover:scale-[1.02]"
                >
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="flex-1 bg-primary hover:bg-primary/80 text-white py-2 rounded font-medium transition-all hover:scale-[1.02]"
                >
                    Agregar Gasto
                </button>
            </div>
        </form>
        
        <!-- Toast de éxito -->
        <div id="toast" class="fixed bottom-4 right-4 bg-primary text-white px-4 py-2 rounded shadow-lg transform translate-y-full opacity-0 transition-all duration-300">
            Gasto agregado correctamente
        </div>
    </div>

    <script>
        // Mostrar toast cuando se complete la operación
        function mostrarToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('translate-y-full', 'opacity-0');
            
            setTimeout(() => {
                toast.classList.add('translate-y-full', 'opacity-0');
            }, 3000);
        }
        
        // Verificar si hay un parámetro de éxito en la URL
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.get('agregado') === 'true') {
                mostrarToast();
            }
        });
    </script>
</body>
</html>