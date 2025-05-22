<div class="bg-neutral-50 min-h-screen p-4 md:p-8">
<header class="bg-white rounded-xl shadow-xl w-full mb-5">
  <div class="max-w-8xl px-3 py-2 flex items-center justify-between">
    <!-- Sección de usuario -->
    <div class="flex items-center gap-4">
      <!-- Imagen de perfil -->
      <img
        src="assets/icons/user-profile-icon-free-vector.jpg"
        alt="Foto Perfil"
        class="w-12 h-12 rounded-full object-cover"
      />
      <!-- Nombre y estado del usuario -->
      <div>
        <h2 class="text-gray-800 text-lg font-semibold leading-tight">
          Bienvenido! <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>
        </h2>
        <p class="text-gray-500 text-sm">Controla & organiza tus gastos con la seguridad & facilidad que mereces.</p>
      </div>

    </div>
    <!-- Botón de acción (visible siempre o desde md hacia arriba, según necesidad) -->
    <div class="flex items-center gap-4">
      <a href="index.php?ruta=logout">
        <button class="bg-neutral-950 text-white text-sm px-4 py-2 rounded-xl hover:bg-cyan-500 transition">Cerrar Sesión</button>
      </a>
    </div>
  </div>
</header>
  <!-- Contenedor principal: grid para el Balance y los Assets -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Sección de Portfolio (ocupa 2 columnas en pantallas medianas o grandes) -->
    <div class="md:col-span-2">
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <!-- Título y balance -->
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-xl font-semibold text-neutral-950">Balance General</h2>
          </div>
          <div>
            <span class="text-2xl font-bold text-gray-800">$17,643.41</span>
          </div>
        </div>

        <!-- Gráfico (placeholder) -->
        <div class="bg-gray-100 h-64 rounded-lg flex items-center justify-center p-4">
          <canvas id="" class="w-full h-full">Grafica Aqui</canvas>
        </div>

        <!-- Valor adicional o cambio -->
        <div class="text-right mt-2">
          <span class="text-sm text-neutral-950"></span>
        </div>
      </div>
    </div>

    <!-- Sección de Assets (ocupa 1 columna) -->
    <div class="flex flex-col gap-6">
    <!-- Tarjeta de Saldo -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <!-- Ejemplo de contenido -->
      <div class="flex items-center justify-between my-4">
        <span class="font-medium text-neutral-800">Saldo</span>
        <span class="text-gray-500">$2.500.000</span>
      </div>
    </div>
    
    <!-- Tarjeta de Gasto -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <!-- Ejemplo de contenido -->
      <div class="flex items-center justify-between my-4">
        <span class="font-medium text-neutral-800">Gasto</span>
        <span class="text-gray-500">$2.500.000</span>
      </div>
    </div>
    
    <!-- Tarjeta de Deuda -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <!-- Ejemplo de contenido -->
      <div class="flex items-center justify-between my-4">
        <span class="font-medium text-neutral-800">Deuda</span>
        <span class="text-gray-500">$2.500.000</span>
      </div>
    </div>
  </div>
</div>

  <!-- Sección de Market e información adicional -->
  <div class="mt-5">
    <!-- Contenedor de dos columnas para Market y el banner de Earn -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Tabla de Market -->
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-800"></h3>
          <!-- Botones de 24h / 7d, etc. -->
          <div>
            <button class="px-2 py-1 text-sm text-gray-700 border border-gray-300 rounded-md mr-2">
              24h
            </button>
            <button class="px-2 py-1 text-sm text-gray-700 border border-gray-300 rounded-md">
              7d
            </button>
          </div>
        </div>

        <table class="w-full text-left">
          <thead>
            <tr class="text-gray-500">
              <th class="pb-2">Nombre</th>
              <th class="pb-2">Precio</th>
              <th class="pb-2"></th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <tr>
              <td class="py-2">Pan</td>
              <td class="py-2">$3.500</td>
              <td class="py-2"></td>
            </tr>
            <tr>
              <td class="py-2">Leche</td>
              <td class="py-2">$7.500</td>
              <td class="py-2"></td>
            </tr>
            <tr>
              <td class="py-2">Gaseosa</td>
              <td class="py-2">$8.000</td>
              <td class="py-2"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Sección de banner o "Earn" -->
      <div class="bg-white p-6 rounded-xl shadow-2xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
           <span class="font-bold">Datos</span> 
        </h3>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Boton</button>
      </div>
    </div>

    <div class="flex flex-col gap-6 mt-5">
    <!-- Tarjeta de Metas de Ahorro -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
      <!-- Encabezado -->
        <div class="flex items-center justify-between">
          <div class="h-20 w-20 relative">
            <!-- Reemplaza este canvas por la implementación de tu gráfica -->
            <canvas id="savingsGraph" class="w-full h-full"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

