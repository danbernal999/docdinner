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
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="sparkle2"
                >
                    <path
                    class="path2"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke="black"
                    fill="black"
                    d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z"
                    ></path>
                    <path
                    class="path2"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke="black"
                    fill="black"
                    d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z"
                    ></path>
                    <path
                    class="path2"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke="black"
                    fill="black"
                    d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z"
                    ></path>
                </svg>
            <h2 href="#" class="btn-shine">Bienvenido a DocDinner</h2>
        </div>
        <hr>
        <span>Simplifica tus finanzas, toma <br>el control de tu futuro.</span>
    </section>

    <!-- Botón Empezar -->
    <div class="boton__empezar">
        <a href="index.php?ruta=login"> 
            <button class="button">
            <div class="dots_border"></div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="sparkle"
                >
                    <path
                    class="path"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke="black"
                    fill="black"
                    d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z"
                    ></path>
                    <path
                    class="path"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke="black"
                    fill="black"
                    d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z"
                    ></path>
                    <path
                    class="path"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke="black"
                    fill="black"
                    d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z"
                    ></path>
                </svg>
                <span class="text_button">Empezar</span>
            </button>
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
            
            <p class="tres"><strong>National Foundation for Credit Counseling</strong></p><br>
            <p class="dos">"El 69% de las personas no llevan un registro detallado de sus  gastos, <br> lo que
            puede llevar a deudas innecesarias y  dificultades financieras."</p><br>


            <div class="cards">
                <div class="outer">
                    <div class="dot"></div>
                    <div class="card">
                        <div class="ray"></div>
                        <div class="text">+90%</div>
                        <div>Satisfaccion de <br> Usuarios</div>
                        <div class="line topl"></div>
                        <div class="line leftl"></div>
                        <div class="line bottoml"></div>
                        <div class="line rightl"></div>
                    </div>
                </div>
                <div class="outer">
                    <div class="dot"></div>
                    <div class="card">
                        <div class="ray"></div>
                        <div class="text">+60</div>
                        <div>Metas <br> Financieras</div>
                        <div class="line topl"></div>
                        <div class="line leftl"></div>
                        <div class="line bottoml"></div>
                        <div class="line rightl"></div>
                    </div>
                </div>
                <div class="outer">
                    <div class="dot"></div>
                    <div class="card">
                        <div class="ray"></div>
                        <div class="text">+50k</div>
                        <div>Gasto <br> Organizados</div>
                        <div class="line topl"></div>
                        <div class="line leftl"></div>
                        <div class="line bottoml"></div>
                        <div class="line rightl"></div>
                    </div>
                </div>
            </div>
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
