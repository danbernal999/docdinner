<div class="bg-dark text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-dark-light rounded-lg shadow-lg shadow-primary/10 p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="index.php?ruta=main&modulo=productos" class="p-2 rounded-full hover:bg-black/20 transition-colors">
                <i class="ri-arrow-left-line text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Agregar Nuevo Gasto</h1>
        </div>
        
        <form action="index.php?ruta=main&modulo=productos" method="POST" class="space-y-5">
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
                    href="index.php?ruta=main&modulo=productos" 
                    class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 rounded text-center font-medium transition-all hover:scale-[1.02]"
                >
                    Cancelar
                </a>
                <button 
                    type="submit"
                    name="crearGasto"
                    class="flex-1 bg-primary hover:bg-primary/80 text-white py-2 rounded font-medium transition-all hover:scale-[1.02]"
                >
                    Agregar Gasto
                </button>
            </div>
        </form>
    </div>
</div>
