// DocDinner - Control de gastos personales
// Copyright (c) 2025 Brayan Bernal, Michael Quintero
// Licensed under the MIT License


# 📦 Instalación de DocDinner

Sigue estos pasos para instalar y ejecutar correctamente el proyecto **DocDinner** en tu entorno local:

## ✅ Requisitos

- PHP >= 7.4
- Composer
- Servidor web (XAMPP, LAMPP, etc.)
- MySQL

## 🔧 Pasos para instalar

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/danbernal999/docdinner.git
   cd docdinner
   ```

2. **Instala las dependencias con Composer:**

   ```bash
   composer update
   ```

3. **Configura la base de datos:**

   - Importa el archivo `control_gastos.sql` en tu gestor de base de datos (ej. phpMyAdmin).
   - Asegúrate de que los datos de conexión estén correctamente configurados en el archivo `config/database.php`.

4. **Configura el servidor web:**

   - Usa Apache u otro servidor que soporte PHP.
   - Asegúrate de que el directorio raíz apunte a la carpeta del proyecto.

5. **Inicia la aplicación:**

   - Abre tu navegador y accede a la URL local correspondiente, por ejemplo:  
     `http://localhost/docdinner/`

---

> 💡 **Recuerda:** No necesitas subir la carpeta `vendor/` al repositorio. Asegúrate de que esté en el archivo `.gitignore` y que cada desarrollador ejecute `composer install` después de clonar el proyecto.
