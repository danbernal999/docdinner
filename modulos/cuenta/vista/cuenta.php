<div class="max-w-100 h-screen mx-auto p-6 flex flex-col gap-5 bg-neutral-50">
    <div class="relative bg-white p-6 rounded-2xl shadow-xl space-y-6">
      <div class="flex items-center gap-4">
          <!-- Contenedor del avatar con overlay del icono -->
          <div class="relative group">
              <!-- Imagen de perfil -->
              <img
                  src="<?= htmlspecialchars($_SESSION['foto'] ?? 'assets/icons/user-profile-icon-free-vector.jpg') ?>"
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
<div class="relative font-inter antialiased">

    <main class="relative min-h-screen flex flex-col justify-center bg-slate-900 overflow-hidden">
        <div class="w-full max-w-5xl mx-auto px-4 md:px-6 py-24">
            <div class="text-center">

                <!-- Logo Carousel animation  -->
                <div
                    x-data="{}"
                    x-init="$nextTick(() => {
                        let ul = $refs.logos;
                        ul.insertAdjacentHTML('afterend', ul.outerHTML);
                        ul.nextSibling.setAttribute('aria-hidden', 'true');
                    })"
                    class="w-full inline-flex flex-nowrap overflow-hidden [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]"
                >
                    <ul x-ref="logos" class="flex items-center justify-center md:justify-start [&_li]:mx-8 [&_img]:max-w-none animate-infinite-scroll">
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/facebook.svg" alt="Facebook" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/disney.svg" alt="Disney" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/airbnb.svg" alt="Airbnb" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/apple.svg" alt="Apple" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/spark.svg" alt="Spark" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/samsung.svg" alt="Samsung" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/quora.svg" alt="Quora" />
                        </li>
                        <li>
                            <img src="https://cruip-tutorials.vercel.app/logo-carousel/sass.svg" alt="Sass" />
                        </li>
                    </ul>                
                </div>
                <!-- End: Logo Carousel animation  -->
                
            </div>

        </div>
    </main>
    
    <!-- Page footer -->
    <footer class="absolute left-6 right-6 md:left-12 md:right-auto bottom-4 md:bottom-8 text-center md:text-left">
        <a class="text-xs text-slate-500 hover:underline" href="https://cruip.com">&copy;Cruip - Tailwind CSS templates</a>
    </footer>
    
    <!-- Banner with links -->
    <div class="fixed bottom-0 right-0 w-full md:bottom-6 md:right-12 md:w-auto z-50" :class="bannerOpen ? '' : 'hidden'" x-data="{ bannerOpen: true }">
        <div class="bg-slate-800 text-sm p-3 md:rounded shadow flex justify-between">
            <div class="text-slate-500 inline-flex">
                <a class="font-medium hover:underline text-slate-300" href="https://cruip.com/create-an-infinite-horizontal-scroll-animation-with-tailwind-css/" target="_blank">
                    Read Tutorial
                </a>
                <span class="italic px-1.5">or</span>
                <a class="font-medium hover:underline text-indigo-500 flex items-center" href="https://github.com/cruip/cruip-tutorials/blob/main/logo-carousel/index.html" target="_blank" rel="noreferrer">
                    <span>Download</span>
                    <svg class="fill-indigo-400 ml-1" xmlns="http://www.w3.org/2000/svg" width="9" height="9">
                        <path d="m1.649 8.514-.91-.915 5.514-5.523H2.027l.01-1.258h6.388v6.394H7.158l.01-4.226z" />
                    </svg>
                </a>
            </div>
            <button class="text-slate-500 hover:text-slate-400 pl-2 ml-3 border-l border-slate-700" @click="bannerOpen = false">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4 shrink-0 fill-current" viewBox="0 0 16 16">
                    <path d="M12.72 3.293a1 1 0 00-1.415 0L8.012 6.586 4.72 3.293a1 1 0 00-1.414 1.414L6.598 8l-3.293 3.293a1 1 0 101.414 1.414l3.293-3.293 3.293 3.293a1 1 0 001.414-1.414L9.426 8l3.293-3.293a1 1 0 000-1.414z" />
                </svg>
            </button>
        </div>
    </div>

</div>






