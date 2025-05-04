<?php
require_once "../config/database.php"; // Incluir conexión a BD si la necesitas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../DocDinner - ACGD/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link rel="shortcut icon" href="../assets/icons/favicon.ico" type="image/x-icon">
    <title>DocDinner</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar__logo">
            <img src="../assets/images/LogoDocDinnerHD-removebg-preview.png" alt="Logo" width="100px">
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
            <img src="../assets/images/bard-fill.png" alt="Star" width="30px">
            <h2>Bienvenidos a DocDinner</h2>
        </div>
        <hr>
        <span>Simplifica tus finanzas, toma <br>el control de tu futuro.</span>
    </section>

    <!-- Botón Empezar -->
    <div class="boton__empezar">
        <button class="boton" onclick="window.location.href='login.php';">Empezar</button>
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
    <section id="contacto" class="seccion" style="margin-top: 80px; padding: 40px; color: white; display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div style="display: flex; width: 100%; max-width: 1200px;  color: white; padding: 20px; border-radius: 10px; gap: 20px; flex-wrap: wrap; justify-content: center;">
            <!-- Mapa -->
            <div style="flex: 1; min-width: 300px;">
                <div id="mapa" style="height: 500px; width: 100%; border-radius: 10px;"></div>
            </div>
            
            <!-- Formulario -->
            <div style="background-color: white; color: black; padding: 30px; width: 420px; min-height: 500px; border-radius: 10px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
                <h3 style="margin-top: 14px; font-weight: bold; margin-bottom: 15px; color: #666; text-transform: uppercase; text-align: center;">Contactanos</h3>
                <form style="display: flex; flex-direction: column;">
                    <input type="text" name="name" placeholder="Nombre" required style="margin-bottom: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; width: 100%; background-color: #f9f9f9;">
                    <input type="email" name="email" placeholder="E-mail" required style="margin-bottom: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; width: 100%; background-color: #f9f9f9;">
                    <input type="text" name="phone" placeholder="Teléfono" style="margin-bottom: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; width: 100%; background-color: #f9f9f9;">
                    <textarea name="message" placeholder="Mensaje" required style="margin-bottom: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; width: 100%; height: 80px; background-color: #f9f9f9;"></textarea>
                    <button type="submit" style="background-color: black; color: white; padding: 12px 15px; border: none; cursor: pointer; border-radius: 5px; font-size: 14px; font-weight: bold; text-transform: uppercase;">Enviar Mensaje →</button>
                </form><br><br>
                <a style="text-decoration: none; color: black;" href="https://mail.google.com/mail/u/3/#inbox?compose=CllgCJvpbJggxwJdRXdGjPrNlLhzSLPLWVdRVHGGpzvjgdHvcGSdFLrfXrNhbHFMrBQjnMSNHCL"><i class="ri-google-fill"></i></a>
            </div>
        </div>
    </section>

    <!-- CONTENIDO FAQs -->
    <section id="fqas" class="seccion" style="width:100%; min-height:100vh; display:flex; align-items:center; justify-content:center; background:radial-gradient(circle at 20% 20%, #000000 100%); padding:50px; box-sizing:border-box;">
        <div style="max-width:1200px; width:100%; display:flex; flex-wrap:wrap; gap:50px; color:#fff; font-family:sans-serif;">
            
            <!-- Lado Izquierdo: Título, descripción y botón -->
            <div style="flex:1 1 300px; display:flex; flex-direction:column; justify-content:center; gap:20px;">
            <span style="font-size:1rem; font-weight:500; color:#a0a0a0; letter-spacing:1px;"></span>
            <h2 style="font-size:2.5rem; font-weight:700; margin:0; line-height:1.2;">Get all your questions answered here</h2>
            <p style="font-size:1rem; line-height:1.6; color:#cccccc; margin:0;">It's extremely embarrassing adding the same contact in two different campaigns.</p>
            <a href="#" style="display:inline-block; padding:14px 30px; background:linear-gradient(to right, #31ff58, #38a3d8); border-radius:8px; color:#000; font-weight:600; text-decoration:none; transition:background 0.3s;">Start for Free Now</a>
            </div>
            
            <!-- Lado Derecho: Acordeón de preguntas -->
            <div style="flex:1 1 300px; display:flex; flex-direction:column; gap:15px;">
            <!-- Pregunta 1 -->
            <details style="background:#1c1c1c; border-radius:8px; padding:15px; cursor:pointer;">
                <summary style="font-size:1.2rem; margin:0;">What Is ManyReach Used For?</summary>
                <p style="margin-top:10px; font-size:1rem; color:#ccc;">
                ManyReach is used for automating outreach campaigns, saving time, and ensuring your messages are sent to the right contacts.
                </p>
            </details>
            
            <!-- Pregunta 2 -->
            <details style="background:#1c1c1c; border-radius:8px; padding:15px; cursor:pointer;">
                <summary style="font-size:1.2rem; margin:0;">Can I Upload As Many Contacts As I Want?</summary>
                <p style="margin-top:10px; font-size:1rem; color:#ccc;">
                Yes, you can upload as many contacts as your plan allows, making it flexible to scale your campaigns as needed.
                </p>
            </details>
            
            <!-- Pregunta 3 -->
            <details style="background:#1c1c1c; border-radius:8px; padding:15px; cursor:pointer;">
                <summary style="font-size:1.2rem; margin:0;">What Is a Credit?</summary>
                <p style="margin-top:10px; font-size:1rem; color:#ccc;">
                A credit typically represents a single outreach action, like sending one email or message to a contact.
                </p>
            </details>
            
            <!-- Pregunta 4 -->
            <details style="background:#1c1c1c; border-radius:8px; padding:15px; cursor:pointer;">
                <summary style="font-size:1.2rem; margin:0;">What Is ManyReach Used For?</summary>
                <p style="margin-top:10px; font-size:1rem; color:#ccc;">
                ManyReach is used for accelerating and streamlining business communication by automating your contact outreach process.
                </p>
            </details>
            
            <!-- Pregunta 5 -->
            <details style="background:#1c1c1c; border-radius:8px; padding:15px; cursor:pointer;">
                <summary style="font-size:1.2rem; margin:0;">What Is ManyReach Used For?</summary>
                <p style="margin-top:10px; font-size:1rem; color:#ccc;">
                You can also use ManyReach for segmenting your audience, personalizing messages, and tracking performance in real time.
                </p>
            </details>
            </div>
        </div>
    </section>

    <script>
        // Inicializa el mapa en Bogotá, Colombia
        var mapa = L.map('mapa').setView([4.7110, -74.0721], 13);

        // Agrega la capa de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        // Agrega un marcador en Bogotá
        L.marker([4.7110, -74.0721]).addTo(mapa)
            .bindPopup('Bogotá, Colombia')
            .openPopup();
    </script>
</body>
</html>
