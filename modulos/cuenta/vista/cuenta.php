<div class="max-w-100 h-screen mx-auto p-6 flex flex-col gap-5 bg-neutral-50">
    <div class="relative bg-white p-6 rounded-2xl shadow-xl space-y-6">
      <div class="flex items-center gap-4">
          <!-- Contenedor del avatar con overlay del icono -->
          <div class="relative group">
              <!-- Imagen de perfil -->
              <img
                  src="<?= htmlspecialchars($rutaFoto) ?>"
                  alt="Foto Perfil"
                  class="w-32 h-32 rounded-full object-cover border-2 border-gray-300 shadow"
              />
              <!-- Ícono flotante -->
              <label for="foto_perfil" class="absolute bottom-0 right-0 bg-custom-gradient text-white p-1 rounded-full cursor-pointer group-hover:scale-110 transition">
                  <i class="ri-bard-line text-lg"></i>
              </label>
          </div>

          <!-- Nombre del usuario -->
          <div>
              <h2 class="text-gray-800 text-lg font-semibold leading-tight">
                  <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>
              </h2>
          </div>
      </div>

      <!-- Formulario oculto -->
      <form action="index.php?ruta=main&modulo=cuenta" method="POST" enctype="multipart/form-data">
          <input 
              id="foto_perfil" 
              type="file" 
              name="foto_perfil" 
              accept="image/*" 
              onchange="this.form.submit()" 
              class="hidden"
          >
          <input type="hidden" name="changeFoto" value="1">
      </form>
    </div>

  <!-- Sección: Información de perfil -->
  <div class="relative bg-white p-6 rounded-2xl shadow-xl space-y-8">
    <!-- Información del usuario -->
    <h2 class="text-xl font-semibold text-neutral-950">Información del Perfil</h2>
    <div class="space-y-2 text-gray-700 text-sm">
      <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
      <p><strong>Correo actual:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
      <p><strong>Fecha de registro:</strong> <?=  $usuario['fecha_registro'] ?></p>
      <p><strong>Último inicio de sesión:</strong> <?= $usuario['ultimo_login'] ?? 'Nunca' ?></p>
    </div>

    <!-- Actualizar correo -->
    <h2 class="text-xl font-semibold text-gray-900 pt-5">Actualizar Correo Electrónico</h2>
    <form action="index.php?ruta=main&modulo=cuenta" method="POST" class="space-y-5">
      <input 
        type="email" 
        name="nuevo_correo" 
        placeholder="Nuevo correo" 
        required
        class="w-100 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
      >
      <button 
        type="submit" 
        name="changeCorreo" 
        class="w-100 bg-neutral-950 text-white text-sm px-4 py-2 rounded-lg hover:bg-cyan-500 transition"
      >
        Actualizar correo
      </button>
    </form>

    <!-- Cambiar contraseña -->
    <h2 class="text-xl font-semibold text-gray-900 border-b pt-5">Cambiar Contraseña</h2>
    <form action="index.php?ruta=main&modulo=cuenta" method="POST" class="space-y-4">
      <input 
        type="password" 
        name="password_actual" 
        placeholder="Contraseña actual" 
        required
        class="w-100 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
      >
      <input 
        type="password" 
        name="nueva_password" 
        placeholder="Nueva contraseña" 
        required
        class="w-100 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
      >
      <input 
        type="password" 
        name="confirmar_password" 
        placeholder="Confirmar contraseña" 
        required
        class="w-100 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
      >
      <button 
        type="submit" 
        name="changePass" 
        class="w-100 bg-neutral-950 text-white text-sm px-4 py-2 rounded-lg hover:bg-cyan-500 transition"
      >
        Cambiar contraseña
      </button>
    </form>
  </div>
</div>







