
<div class="flex flex-col gap-6">
    <!-- Tarjeta de Perfil -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
    <!-- Ejemplo de contenido -->
    <div class="flex items-center justify-between my-4 text-black">
        <h2>Configuración de cuenta</h2>

        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
        <p><strong>Correo actual:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
        <p><strong>Fecha de registro:</strong> <?=  $usuario['fecha_registro'] ?></p>
        <p><strong>Último inicio de sesión:</strong> <?= $usuario['ultimo_login'] ?? 'Nunca' ?></p>
    </div>
    </div>
    
        <!-- Tarjeta de Configuración -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
        <!-- Ejemplo de contenido -->
    <div class="flex items-center justify-between my-4 text-black">
        <h3>Cambiar correo electrónico</h3>
        <form action="index.php?ruta=main&modulo=cuenta" method="POST">
            <input type="email" name="nuevo_correo" placeholder="Nuevo correo" required>
            <button class="bg-neutral-950 text-white text-sm px-4 py-2 rounded-xl hover:bg-cyan-500 transition" type="submit" name="changeCorreo">Actualizar correo</button>
        </form>
    </div>
    </div>
    
        <!-- Tarjeta de Seguridad -->
    <div class="bg-white p-6 rounded-xl shadow-2xl">
        <!-- Ejemplo de contenido -->
    <div class="flex items-center justify-between my-4 text-black">
        <h3>Cambiar contraseña</h3>
        <form action="index.php?ruta=main&modulo=cuenta" method="POST">
            <input type="password" name="password_actual" placeholder="Contraseña actual" required>
            <input type="password" name="nueva_password" placeholder="Nueva contraseña" required>
            <input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required>
            <button class="bg-neutral-950 text-white text-sm px-4 py-2 rounded-xl hover:bg-cyan-500 transition" type="submit" name="changePass">Cambiar contraseña</button>
        </form>
    </div>
    </div>
</div>




