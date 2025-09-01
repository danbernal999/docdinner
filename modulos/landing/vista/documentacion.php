<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Documentación - DocDinner</title>
  <link rel="shortcut icon" href="assets/images/LogoDocDinnerHD-removebg-preview.png" type="image/x-icon"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Sidebar -->
  <aside class="fixed top-0 left-0 w-64 h-full bg-black text-white p-6 flex flex-col justify-between">
    <div>
      <h1 class="text-2xl font-bold mb-6">📄 DocDinner</h1>
      <nav class="space-y-4">
        <a href="#guia" class="block hover:text-cyan-500 transition">1. Guía de Uso</a>
        <a href="#docs" class="block hover:text-cyan-500 transition">2. Documentación Técnica</a>
        <a href="#privacidad" class="block hover:text-cyan-500 transition">3. Políticas de Privacidad</a>
      </nav>
    </div>

    <!-- Botón Volver -->
    <div class="mt-6">
      <a href="index.php?ruta=home" class="w-full block text-center px-4 py-2 bg-neutral-50 text-black rounded-lg shadow hover:bg-cyan-500 transition">Volver
      </a>
    </div>
  </aside>

  <!-- Contenido principal -->
  <main class="ml-72 p-10 space-y-12">

    <!-- Guía de Uso -->
    <section id="guia">
      <h2 class="text-3xl font-semibold mb-4">1. Guía de Uso</h2>
      <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-xl font-bold mb-2">Registro e inicio de sesión</h3>
          <p>Aprende a crear tu cuenta y proteger tu acceso con autenticación segura.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-xl font-bold mb-2">Gestión de gastos e ingresos</h3>
          <p>Registra tus transacciones y clasifícalas por categorías.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-xl font-bold mb-2">Visualización de balances y gráficos</h3>
          <p>Consulta reportes claros con gráficas dinámicas.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
          <h3 class="text-xl font-bold mb-2">Alertas y notificaciones</h3>
          <p>Recibe recordatorios de pagos, metas y control de deudas.</p>
        </div>
      </div>
    </section>

    <!-- Documentación Técnica -->
    <section id="docs" class="bg-white p-10 rounded-lg shadow-lg">
      <h2 class="text-4xl font-bold text-gray-900 mb-6 border-b pb-3">📘 Documentación Técnica</h2>
      <p class="text-gray-600 mb-8">📌 En esta sección encontrarás toda la información técnica y estructural sobre <strong>DocDinner</strong>, incluyendo arquitectura, objetivos y el marco tecnológico utilizado.
      </p>

      <!-- Índice -->
      <nav class="mb-10">
        <h3 class="text-xl font-semibold mb-3 text-gray-800">📑 Índice</h3>
        <ul class="list-decimal pl-6 space-y-2 text-blue-600">
          <li><a href="#resumen">Resumen Ejecutivo</a></li>
          <li><a href="#problema">Planteamiento del Problema</a></li>
          <li><a href="#objetivo">Objetivo del Proyecto</a></li>
          <li><a href="#alcance">Alcance del Proyecto</a></li>
          <li><a href="#marco">Marco Teórico / Tecnológico</a></li>
          <li><a href="#arquitectura">Arquitectura del Sistema</a></li>
        </ul>
      </nav>

      <!-- Resumen Ejecutivo -->
      <article id="resumen" class="mb-10">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">1. Resumen Ejecutivo</h3>
        <p class="text-gray-700 leading-relaxed mb-4">
          En la era digital actual, gestionar las finanzas personales de manera eficiente es crucial para personas de todas las edades y profesiones. 
          La complejidad de la información financiera y la necesidad de controlar gastos y deudas han generado una demanda de herramientas digitales 
          que faciliten esta tarea. Para responder a esta necesidad, presentamos la propuesta técnica para desarrollar e implementar <strong>DocDinner</strong>, 
          una aplicación para el control de gastos y deudas personales.
        </p>
        <p class="text-gray-700 leading-relaxed">
          <strong>DocDinner</strong> está diseñada para ofrecer una solución innovadora y eficaz que permita a los usuarios gestionar sus finanzas de manera efectiva y segura. 
          Se enfoca en resolver problemas comunes como la falta de organización financiera y la complejidad en la gestión de deudas, proporcionando una experiencia intuitiva 
          para la planificación y el análisis financiero.
        </p>
      </article>

      <!-- Planteamiento del Problema -->
      <article id="problema" class="mb-10 border-t pt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">2. Planteamiento del Problema</h3>
        <p class="text-gray-700 mb-4">
           📌 Actualmente, existe una creciente necesidad de herramientas accesibles que permitan a los usuarios gestionar sus finanzas personales de manera eficiente. 
          Sin embargo, muchas aplicaciones presentan problemas:
        </p>
        <ul class="list-disc pl-6 text-gray-700 space-y-2">
          <li>Falta de una herramienta integral que combine la gestión financiera con información relevante del mercado.</li>
          <li>Interfaces complicadas o poco intuitivas.</li>
          <li>Escasa integración con datos financieros en tiempo real.</li>
          <li>Dificultad en el seguimiento de gastos y deudas con análisis predictivo.</li>
        </ul>
      </article>

      <!-- Objetivo del Proyecto -->
      <article id="objetivo" class="mb-10 border-t pt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">3. Objetivo del Proyecto</h3>
        <p class="text-gray-700 mb-4">
          📌 Desarrollar <strong>DocDinner</strong>, una aplicación web que permita a los usuarios gestionar sus finanzas personales de manera eficiente, 
          con una interfaz intuitiva y acceso a información de inversiones y mercados en tiempo real.
        </p>
        <ul class="list-disc pl-6 text-gray-700 space-y-2">
          <li>Registro y categorización de ingresos y gastos.</li>
          <li>Visualización de gráficos por mes y categoría.</li>
          <li>Control de deudas y metas de ahorro.</li>
          <li>Configuración de presupuestos personalizados.</li>
          <li>Autenticación de usuarios segura.</li>
        </ul>
      </article>

      <!-- Alcance -->
      <article id="alcance" class="mb-10 border-t pt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">4. Alcance del Proyecto</h3>
        <p class="text-gray-700 font-medium">📌 Incluye:</p>
        <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
          <li>Registro, inicio de sesión y recuperación de contraseña.</li>
          <li>CRUD de ingresos, gastos, deudas y metas.</li>
          <li>Filtros por fecha y categoría.</li>
          <li>Gráficas interactivas con <strong>Chart.js</strong>.</li>
          <li>Presupuesto mensual configurable.</li>
          <li>Conexión con API financiera para datos en tiempo real.</li>
          <li>Interfaz responsive con <strong>TailwindCSS</strong>.</li>
        </ul>
        <p class="text-gray-700 font-medium">📌 No incluye (por ahora):</p>
        <ul class="list-disc pl-6 text-gray-700 space-y-2">
          <li>App móvil nativa.</li>
          <li>Notificaciones push.</li>
          <li>Soporte multimoneda.</li>
        </ul>
      </article>

      <!-- Marco Teórico / Tecnológico -->
      <article id="marco" class="mb-10 border-t pt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">5. Marco Teórico</h3>
        <p class="text-lg font-semibold">📌 Tecnológico</p><br>
        <ul class="list-disc pl-6 text-gray-700 space-y-2">
          <li><strong>PHP:</strong> Backend de la aplicación.</li>
          <li><strong>MySQL:</strong> Base de datos relacional.</li>
          <li><strong>TailwindCSS:</strong> Framework CSS moderno y responsivo.</li>
          <li><strong>Chart.js:</strong> Gráficas estadísticas.</li>
          <li><strong>JavaScript:</strong> Dinamismo del frontend.</li>
          <li><strong>PHPMailer:</strong> Recuperación de contraseñas por correo.</li>
          <li><strong>APIs externas (Finnhub / TwelveData):</strong> Datos financieros en tiempo real.</li>
        </ul>
      </article>

      <!-- Arquitectura -->
      <article id="arquitectura" class="border-t pt-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">6. Arquitectura del Sistema</h3>
        <p class="text-gray-700 mb-4">
          📌 El sistema sigue la arquitectura <strong>MVC (Modelo-Vista-Controlador)</strong>, lo que garantiza una estructura modular, escalable y mantenible.
        </p>
        <ul class="list-disc pl-6 text-gray-700 mb-4 space-y-2">
          <li><strong>Modelos:</strong> Acceso y manipulación de datos en MySQL.</li>
          <li><strong>Vistas:</strong> Interfaz de usuario (HTML + TailwindCSS).</li>
          <li><strong>Controladores:</strong> Lógica de negocio en PHP.</li>
        </ul>
        <p class="text-gray-700 font-medium">📌 Módulos principales:</p>
        <ul class="list-disc pl-6 text-gray-700 space-y-2">
          <li>Autenticación (login/registro/recuperar clave).</li>
          <li>Dashboard general.</li>
          <li>Gestión de ingresos y gastos.</li>
          <li>Módulo de ahorros.</li>
          <li>Notificaciones y recordatorios.</li>
          <li>Configuración del usuario.</li>
        </ul>
      </article>
    </section>

    <!-- Políticas de Privacidad -->
    <section id="privacidad" class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-3xl font-semibold mb-4">3. Políticas de Privacidad</h2>

      <p class="text-gray-700 mb-4">
        En <strong>DocDinner</strong> valoramos y respetamos tu privacidad. Nuestro compromiso es
        proteger la información personal y financiera que compartes con nosotros,
        asegurando transparencia en el tratamiento de tus datos.
      </p>

      <h3 class="text-xl font-semibold mt-6 mb-2">📌 Datos que recolectamos</h3>
      <ul class="list-disc pl-6 text-gray-700 space-y-2">
        <li>Información de registro: nombre, correo electrónico y contraseña.</li>
        <li>Datos financieros que ingresas voluntariamente: gastos, ingresos, deudas y ahorros.</li>
        <li>Datos técnicos básicos: dirección IP, navegador y dispositivo (solo para mejorar el servicio).</li>
      </ul>

      <h3 class="text-xl font-semibold mt-6 mb-2">📌 Uso de la información</h3>
      <p class="text-gray-700 mb-4">
        La información recopilada se utiliza para:
      </p>
      <ul class="list-disc pl-6 text-gray-700 space-y-2">
        <li>Proporcionar acceso a tu cuenta y mantener la seguridad de tus datos.</li>
        <li>Generar reportes personalizados de gastos, ingresos y proyecciones.</li>
        <li>Enviar notificaciones y recordatorios financieros (puedes desactivarlos en cualquier momento).</li>
        <li>Mejorar la experiencia de usuario mediante análisis internos.</li>
      </ul>

      <h3 class="text-xl font-semibold mt-6 mb-2">📌 Seguridad de la información</h3>
      <p class="text-gray-700 mb-4">
        Implementamos medidas de seguridad técnicas y organizativas para proteger tu información contra accesos no autorizados, pérdida o alteración. Sin embargo, recuerda que ningún sistema es 100% infalible en Internet.
      </p>

      <h3 class="text-xl font-semibold mt-6 mb-2">📌 Derechos del usuario</h3>
      <p class="text-gray-700 mb-4">
        Como usuario de <strong>DocDinner</strong>, tienes derecho a:
      </p>
      <ul class="list-disc pl-6 text-gray-700 space-y-2">
        <li>Acceder a la información que has registrado.</li>
        <li>Rectificar o actualizar tus datos personales.</li>
        <li>Solicitar la eliminación de tu cuenta y datos almacenados.</li>
        <li>Revocar el consentimiento para el uso de tus datos en cualquier momento.</li>
      </ul>

      <h3 class="text-xl font-semibold mt-6 mb-2">📌 Contacto</h3>
      <p class="text-gray-700">
        Si tienes dudas o deseas conocer algo más específico, puedes comunicarte con nosotros en cualquier momento a través del correo:  
        <a href="mailto:docdinnerbg@gmail.com" class="text-blue-600 underline">docdinnerbg@gmail.com</a>.
      </p>
    </section>

  </main>

  <!-- Footer -->
  <footer class="ml-72 mt-12 p-6 text-center text-gray-500 border-t">
    &copy; 2025 DocDinner - Todos los derechos reservados.
  </footer>

</body>
</html>
