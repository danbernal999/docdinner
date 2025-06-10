<main class="bg-neutral-50 min-h-screen p-4 sm:p-6 lg:p-8">
  <div class="max-w-8xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 flex flex-col gap-8">
        <article class="bg-white p-6 rounded-2xl shadow-xl">
          <div class="flex flex-col sm:flex-row items-center gap-6">
            <div class="relative group flex-shrink-0">
              <img src="<?= htmlspecialchars($rutaFoto ?? 'default-avatar.png') ?>" alt="Foto de Perfil" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
              <label for="foto_perfil_input" class="absolute bottom-1 right-1 bg-cyan-500 text-white p-2 rounded-full cursor-pointer group-hover:bg-cyan-600 transition-transform transform group-hover:scale-110">
                <!-- Ícono flotante -->
                <i class="ri-bard-line absolute bottom-0 right-0 bg-custom-gradient text-white p-1 rounded-full cursor-pointer group-hover:scale-110 transition"></i>
              </label>
            </div>
            
            <div class="text-center sm:text-left">
              <h1 class="text-2xl font-bold text-gray-800">
                <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?>
              </h1>
              <p class="text-md text-gray-600">Bienvenido(a) de nuevo.</p>
            </div>
          </div>

          <form action="index.php?ruta=main&modulo=cuenta" method="POST" enctype="multipart/form-data">
            <input id="foto_perfil_input" type="file" name="foto_perfil" accept="image/*" onchange="this.form.submit()" class="hidden">
            <input type="hidden" name="changeFoto" value="1">
          </form>
        </article>

        <article class="bg-white p-6 rounded-2xl shadow-xl">
          <h2 class="text-xl font-bold text-neutral-900 border-b pb-4 mb-4">Ajustes de la Cuenta</h2>
          <div class="space-y-8">
            <section>
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Información del Perfil</h3>
              <div class="space-y-2 text-sm text-gray-700">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
                <p><strong>Correo actual:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
                <p><strong>Fecha de registro:</strong> <?= htmlspecialchars($usuario['fecha_registro']) ?></p>
              </div>
            </section>

            <hr>

            <section>
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Actualizar Correo Electrónico</h3>
              <form action="index.php?ruta=main&modulo=cuenta" method="POST" class="space-y-4">
                <input type="email" name="nuevo_correo" placeholder="Nuevo correo electrónico" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none transition">
                <button type="submit" name="changeCorreo" class="w-full sm:w-auto bg-neutral-900 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-cyan-600 transition-colors">
                  Actualizar Correo
                </button>
              </form>
            </section>

            <hr>
            
            <section>
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Cambiar Contraseña</h3>
              <form action="index.php?ruta=main&modulo=cuenta" method="POST" class="space-y-4">
                <input type="password" name="password_actual" placeholder="Contraseña actual" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none transition">
                <input type="password" name="nueva_password" placeholder="Nueva contraseña" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none transition">
                <input type="password" name="confirmar_password" placeholder="Confirmar nueva contraseña" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none transition">
                <button type="submit" name="changePass" class="w-full sm:w-auto bg-neutral-900 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-cyan-600 transition-colors">
                  Cambiar Contraseña
                </button>
              </form>
            </section>

          </div>
        </article>
      </div>

      <div class="lg:col-span-1 flex flex-col gap-8">
        <article class="bg-white p-6 rounded-2xl shadow-xl">
          <h2 class="text-xl font-bold text-neutral-900 border-b pb-4 mb-4">Seguridad y Privacidad</h2>
          <div class="space-y-6">

            <section>
              <h3 class="text-lg font-semibold text-gray-800">Seguridad de la Cuenta</h3>
              <p class="text-sm text-gray-600 mt-1">Protegemos tu cuenta con las mejores prácticas de seguridad, incluyendo la autenticación de dos factores (2FA) si está habilitada.</p>
            </section>

            <section>
              <h3 class="text-lg font-semibold text-gray-800">Privacidad de Datos</h3>
              <p class="text-sm text-gray-600 mt-1">Tus datos personales se manejan con estricto apego a nuestras políticas de privacidad. Nunca los compartiremos sin tu consentimiento.</p>
            </section>
            
            <section class="border-t border-red-200 pt-6 mt-6">
              <h3 class="text-lg font-semibold text-red-700">Eliminar Cuenta</h3>
              <p class="text-sm text-gray-600 mt-1 mb-4">
                Esta acción es irreversible. Perderás todos tus datos y el acceso a la plataforma de forma permanente.
              </p>
              <form action="index.php?ruta=main&modulo=cuenta" method="POST">
                <button type="submit" name="deleteAccount" class="w-full bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700 transition-colors" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta permanentemente?');">
                  Eliminar Mi Cuenta
                </button>
              </form>
            </section>
          </div>
        </article>
      </div>
    </div>
  </div>
</main>






