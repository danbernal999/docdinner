<?php
function linkActivo($modulo, $moduloActual) {
    return $modulo === $moduloActual ? 'bg-cyan-500 text-white border-l-4 border-cyan-400' : '';
}
?>
<div class="fixed bg-black top-0 left-0 flex flex-col items-start w-20 md:w-60 h-full text-neutral-50 p-3 transition-all duration-300">
    <a class="flex items-center w-full mb-3" href="index.php?ruta=main">
        <img src="assets/images/LogoDocDinnerHD-removebg-preview.png" alt="Logo DocDinner" width="50" height="50" class="mx-auto md:mx-0">
        <span class="ml-2 text-xl font-bold hidden md:inline">DocDinner</span>
    </a>

    <div class="w-full">
        <div class="flex flex-col w-full mb-4 border-t border-gray-700 pt-4">
            <a class="flex items-center w-full h-12 px-3 rounded hover:bg-cyan-700 hover:text-cyan-50 <?= linkActivo('', $moduloActivo) ?>" href="index.php?ruta=main">
                <i class="ri-home-line text-2xl"></i>
                <span class="ml-2 text-sm font-medium hidden md:inline">Inicio</span>
            </a>
            <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-700 hover:text-cyan-50 <?= linkActivo('analisis', $moduloActivo) ?>" 
                href="index.php?ruta=main&modulo=analisis">
                <i class="ri-bar-chart-line text-2xl"></i>
                <span class="ml-2 text-sm font-medium hidden md:inline">Análisis</span>
            </a>
            <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-700 hover:text-cyan-50 <?= linkActivo('productos', $moduloActivo) ?>" 
                href="index.php?ruta=main&modulo=productos">
                <i class="ri-price-tag-3-line text-2xl"></i>
                <span class="ml-2 text-sm font-medium hidden md:inline">Gastos</span>
            </a>
            <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-700 hover:text-cyan-50 <?= linkActivo('ahorro', $moduloActivo) ?>" 
                href="index.php?ruta=main&modulo=ahorro">
                <i class="ri-bank-line text-2xl"></i>
                <span class="ml-2 text-sm font-medium hidden md:inline">Ahorro</span>
            </a>
        </div>

        <div class="flex flex-col w-full mb-4 border-t border-gray-700 pt-4">
            <button id="openNotifications" class="relative flex items-center w-full h-12 px-3 rounded hover:bg-cyan-700 hover:text-cyan-50">
                <i class="ri-chat-1-line text-2xl"></i>
                <span class="ml-2 text-sm font-medium hidden md:inline">Notificaciones</span>
            </button>

            <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-cyan-700 hover:text-cyan-50 <?= linkActivo('cuenta', $moduloActivo) ?>" 
                href="index.php?ruta=main&modulo=cuenta">
                <i class="ri-user-line text-2xl"></i>
                <span class="ml-2 text-sm font-medium hidden md:inline">Cuenta</span>
            </a>
        </div>
    </div>

    <a class="flex items-center w-full mb-4 h-12 px-3 mt-auto rounded hover:bg-cyan-700 hover:text-cyan-50 <?= linkActivo('configuracion', $moduloActivo) ?>" 
        href="index.php?ruta=main&modulo=configuracion">
        <i class="ri-settings-line text-2xl"></i>
        <span class="ml-2 text-sm font-medium hidden md:inline">Configuracion</span>
    </a>
</div>


