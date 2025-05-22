<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">    
    <link rel="shortcut icon" href="assets/icons/favicon.ico" type="image/x-icon">
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="assets/css/landing.css">
    <title>DocDinner</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar__logo">
            <img src="assets/images/LogoDocDinnerHD-removebg-preview.png" alt="Logo" width="100px">
            <a href="#docdinner" class="menu"><h1>DocDinner</h1></a>
        </div>

        <div class="navbar__menu">
            <li><a href="#acerca" class="menu">Acerca</a></li>
            <li><a href="#contacto" class="menu">Contacto</a></li>
            <li><a href="#faqs" class="menu">FAQs</a></li>
        </div>

        <div class="navbar__link">
            <i class="ri-links-line"></i>
            <a href="">Link</a>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <section id="docdinner" class="contenedor">
        <div class="bienvenida">
            <img src="assets/images/bard-fill.png" alt="Star" width="30px">
            <h2>Bienvenidos a DocDinner</h2>
        </div>
        <hr>
        <span>Simplifica tus finanzas, toma <br>el control de tu futuro.</span>
    </section>

    <!-- Botón Empezar -->
    <div class="boton__empezar">
    <a href="index.php?ruta=login">
        <button class="boton">Empezar</button>
    </a>
    </div>

    <!-- CONTENIDO ACERCA -->
    <section id="acerca" class="seccion">
        <div class="titulo__acerca">
            <h2>Acerca De</h2>
        </div>
        <div class="parrafos">
            <p class="uno">DocDinner es una solución inteligente para gestionar tus <br>
            finanzas personales de manera sencilla, eficiente y segura. <br>
            Nuestra misión es ayudarte a tomar el control de tus gastos y <br>
            deudas, permitiéndote alcanzar tus metas financieras sin <br>
            complicaciones.</p>
            
            <p class="dos">"El 69% de las personas no llevan un registro detallado de sus  gastos, <br> lo que
            puede llevar a deudas innecesarias y  dificultades financieras."</p>

            <p class="tres"><strong>National Foundation for Credit Counseling</strong></p>
        </div>
    </section>
    
   <!-- CONTENIDO CONTACTO -->
    <section id="contacto" class="seccion contacto-section">
        <div class="contacto-container">
            <!-- Mapa -->
            <div class="mapa-container">
                <div id="mapa" class="mapa"></div>
            </div>

            <!-- Formulario -->
            <div class="formulario-container">
                <h3 class="formulario-titulo">Contactanos</h3>
                <form class="formulario">
                    <input type="text" name="name" placeholder="Nombre" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="text" name="phone" placeholder="Teléfono">
                    <textarea name="message" placeholder="Mensaje" required></textarea>
                    <button type="submit">Enviar Mensaje →</button>
                </form>
                <br><br>
                <button id="googleLogin">
                    <i class="ri-google-fill"></i> Iniciar sesión con Google
                </button>
            </div>
        </div>
    </section>

    <!-- CONTENIDO FAQs -->
    <section id="faqs" class="seccion fqas-section">
        <div class="fqas-container">
            <!-- Lado Izquierdo -->
            <div class="fqas-info">
                <h2>Preguntas Frecuentes</h2>
                <p>Usa la aplicacion mas facil de control de gastos y deudas.</p>
                <a href="#" class="boton">Estas listo?</a>
            </div>

            <!-- Lado Derecho -->
            <div class="fqas-preguntas">
                <details>
                    <summary>¿Qué puedo hacer con DocDinner?</summary>
                    <p>Con DocDinner puedes llevar un control detallado de todos tus gastos, desde pequeñas compras hasta grandes inversiones.</p>
                </details>
                <details>
                    <summary>¿Qué beneficios ofrece DocDinner?</summary>
                    <p>DocDinner te ayuda a tener un mejor control financiero, recordándote en qué has gastado tu dinero para que no pierdas el rumbo de tus finanzas.</p>
                </details>
                <details>
                    <summary>¿DocDinner es gratis?</summary>
                    <p>Sí, DocDinner es completamente gratis y puedes usarla siempre que lo necesites.</p>
                </details>
                <details>
                    <summary>¿Necesito crear una cuenta para usar DocDinner?</summary>
                    <p>Sí, necesitas registrarte para que podamos guardar y proteger tus datos de forma segura, y así puedas acceder a ellos desde cualquier dispositivo.</p>
                </details>
                <details>
                    <summary>¿Cómo puedo registrar mis gastos en DocDinner?</summary>
                    <p>Una vez que inicies sesión, puedes ingresar tus gastos fácilmente desde el panel principal. Solo debes indicar el monto, la categoría y una breve descripción.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Seccion para los scripts -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="assets/js/landing/maps.js"></script>
</body>
</html>
