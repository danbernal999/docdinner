<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DocDinner</title>
    <meta name="description" content="" />
    <link rel="shortcut icon" href="assets/images/LogoDocDinnerHD-removebg-preview.png" type="image/x-icon"/>
    <meta property="og:title" content="DocDinner" />
    <meta property="og:description" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <link rel="stylesheet" href="./css/tailwind-build.css" />
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body class="bm-flex bm-min-h-[100vh] bm-flex-col bm-bg-black bm-text-white">
    <!-- NavBar -->
    <header class="bm-max-w-lg:bm-px-4 bm-max-w-lg:bm-mr-auto bm-fixed bm-top-3 bm-z-20 bm-flex bm-h-[60px] bm-w-full bm-bg-opacity-0 bm-px-[5%] lg:bm-justify-around">
      <a class="bm-flex bm-items-center bm-gap-2 bm-h-[100px] bm-p-[5px]" href="">
        <img src="assets/images/LogoDocDinnerHD-removebg-preview.png" alt="logo" class="bm-h-full bm-w-auto"/>
        <h1 class="bm-text-xl bm-font-bold bm-text-white">DocDinner</h1>
      </a>

      <div class="collapsible-header animated-collapse max-lg:bm-shadow-md" id="collapsed-header-items">
        <div class="bm-flex bm-h-full bm-w-max bm-gap-5 bm-text-base max-lg:bm-mt-[30px] max-lg:bm-flex-col max-lg:bm-place-items-end max-lg:bm-gap-5 lg:bm-mx-auto lg:bm-place-items-center">
          <a class="header-links" href="#hero-section"> Acerca </a>
          <a class="header-links" href="#funciones"> Funciones </a>
          <a class="header-links" href="#caracteristicas"> Caracteristicas </a>
          <a class="header-links" href="#equipo">Equipo</a>
          <a class="header-links" href="#fqa"> FQA </a>
        </div>
        <div class="bm-mx-4 bm-flex bm-place-items-center bm-gap-[20px] bm-text-base max-md:bm-w-full max-md:bm-flex-col max-md:bm-place-content-center">
          <a href="index.php?ruta=login" aria-label="signup" class="bm-rounded-full bm-bg-white bm-px-3 bm-py-2 bm-text-black bm-transition-transform bm-duration-[0.3s] hover:bm-translate-x-2">
            <span>Empezar</span>
            <i class="bi bi-stars"></i>
          </a>
        </div>
      </div>
      <button class="bi bi-list bm-absolute bm-right-3 bm-top-3 bm-z-50 bm-text-3xl bm-text-white lg:bm-hidden" onclick="toggleHeader()" aria-label="menu" id="collapse-btn"></button>
    </header>

    <!-- Inicio -->
    <section class="hero-section bm-relative bm-flex bm-min-h-[100vh] bm-w-full bm-max-w-[100vw] bm-flex-col bm-overflow-hidden max-md:bm-mt-[50px]" id="hero-section">
      <div class="bm-flex bm-h-full bm-min-h-[100vh] bm-w-full bm-flex-col bm-place-content-center bm-gap-6 bm-p-[5%] max-xl:bm-place-items-center max-lg:bm-p-4">
        <div class="bm-flex bm-flex-col bm-place-content-center bm-items-center">

          <!-- Bienvenidos -->
          <div class="reveal-up bm-mt-10 bm-max-w-[450px] bm-p-2 bm-text-center bm-text-gray-300 max-lg:bm-max-w-full bm-flex bm-flex-col bm-place-items-center">
          </div>

          <!-- Frase -->
          <div class="reveal-up gradient-text bm-text-center bm-text-6xl bm-font-semibold bm-uppercase bm-leading-[80px] max-lg:bm-text-4xl max-md:bm-leading-snug">
            <span class=""> Simplifica tus finanzas </span>
            <br />
            <span class=""> toma el control de tu futuro. </span>
          </div>

          <!-- Empezar & Documentacion -->
          <div class="reveal-up bm-mt-10 bm-flex bm-place-items-center bm-gap-4">
            <a class="btn bm-flex bm-gap-2 !bm-bg-black !bm-text-white bm-transition-colors bm-duration-[0.3s] hover:!bm-bg-white hover:!bm-text-black" href="index.php?ruta=documentacion">
              <i class="bi bi-play-circle-fill"></i>
              <span>Documentacion</span>
            </a>
          </div>
        </div>

        <!-- Imagen Dashboard -->
        <div class="reveal-up bm-relative bm-mt-8 bm-flex bm-w-full bm-place-content-center bm-place-items-center" id="dashboard-container">
          <div class="bm-relative bm-max-w-[80%] bm-overflow-hidden bm-rounded-xl bm-bg-transparent max-md:bm-max-w-full" id="dashboard">
            <img src="./assets/images/home/dashboard.png" alt="dashboard" class="bm-h-full bm-w-full bm-object-cover bm-opacity-90 max-lg:bm-object-contain"/>
          </div>

        </div>
      </div>
    </section>

    <!-- Acerca  -->
    <section id="" class="bm-relative bm-flex bm-w-full bm-max-w-[100vw] bm-flex-col bm-place-content-center bm-place-items-center bm-overflow-hidden bm-p-8">
      <h2 class="reveal-up bm-text-3xl max-md:bm-text-xl">Tecnologias Usadas</h2>

      <!-- Iconos De Cada Tecnologia -->
      <div class="reveal-up carousel-container">
        <div class="carousel lg:w-place-content-center bm-mt-6 bm-flex bm-w-full bm-gap-5 max-md:bm-gap-2">
          <!-- Agregar las tecnologias Usadas  -->
          <div class="carousel-img bm-h-[60px] bm-w-[150px]">
            <img src="./assets/images/brand-logos/google-color-svgrepo-com.svg" alt="Google" class="bm-h-full bm-w-full" srcset="" />
          </div>
          <div class="carousel-img bm-h-[60px] bm-w-[150px]">
            <img src="./assets/images/brand-logos/html-5-svgrepo-com.svg" alt="Microsoft" class="bm-h-full bm-w-full" srcset="" />
          </div>
          <div class="carousel-img bm-h-[60px] bm-w-[150px]">
            <img src="./assets/images/brand-logos/tailwind-svgrepo-com.svg" alt="Adobe" class="bm-h-full bm-w-full" srcset="" />
          </div>
          <div class="carousel-img bm-h-[60px] bm-w-[150px]">
            <img src="./assets/images/brand-logos/javascript-svgrepo-com.svg" alt="Adobe" class="bm-h-full bm-w-full" srcset="" />
          </div>
          <div class="carousel-img bm-h-[60px] bm-w-[150px]">
            <img src="./assets/images/brand-logos/php2-svgrepo-com.svg" alt="Adobe" class="bm-h-full bm-w-full" srcset="" />
          </div>
          <div class="carousel-img bm-h-[60px] bm-w-[150px]">
            <img src="./assets/images/brand-logos/github-color-svgrepo-com.svg" alt="Adobe" class="bm-h-full bm-w-full" srcset="" />
          </div>
        </div>
      </div>
    </section>

    <!-- Funciones -->
    <section id="funciones" class="bm-relative bm-flex bm-w-full bm-max-w-[100vw] bm-flex-col bm-place-content-center bm-place-items-center bm-overflow-hidden bm-p-6">
        <div class="bm-mt-8 bm-flex bm-flex-col bm-place-items-center bm-gap-5">
            <div class="reveal-up bm-mt-5 bm-flex bm-flex-col bm-gap-3 bm-text-center">
                <h2 class="bm-text-4xl bm-font-medium bm-text-gray-200 max-md:bm-text-3xl">Beneficios Importantes</h2>
            </div>

            <div class="bm-mt-6 bm-flex bm-max-w-[100%] bm-flex-wrap bm-place-content-center bm-gap-8 max-lg:bm-flex-col">
                <!-- Beneficio 1 -->
                <div class="reveal-up bm-flex bm-h-[400px] bm-w-[450px] bm-flex-col bm-gap-3 bm-text-center max-md:bm-w-[320px]">
                    <div class="border-gradient bm-h-[200px] bm-w-full bm-overflow-hidden max-md:bm-h-[150px]">
                        <div class="bm-flex bm-h-full bm-w-full bm-place-content-center bm-place-items-end bm-p-2">
                        <i class="bi-check2-circle bm-text-7xl bm-text-gray-200 max-md:bm-text-5xl"></i>
                        </div>
                    </div>
                    <div class="bm-flex bm-flex-col bm-gap-4 bm-p-2">
                        <h3 class="bm-mt-8 bm-text-2xl bm-font-normal max-md:bm-text-xl">Ahorra horas de gestión</h3>
                        <div class="bm-text-gray-300">
                        Registra gastos, ingresos y deudas en segundos, sin hojas de cálculo complicadas.
                        </div>
                    </div>
                </div>

                <!-- Beneficio 2 -->
                <div class="reveal-up bm-flex bm-h-[400px] bm-w-[450px] bm-flex-col bm-gap-3 bm-text-center max-md:bm-w-[320px]">
                    <div class="border-gradient bm-h-[200px] bm-w-full bm-overflow-hidden max-md:bm-h-[150px]">
                        <div class="bm-flex bm-h-full bm-w-full bm-place-content-center bm-place-items-end bm-p-2">
                        <i class="bi-phone-fill bm-text-7xl bm-text-gray-200 max-md:bm-text-5xl"></i>
                        </div>
                    </div>
                    <div class="bm-flex bm-flex-col bm-gap-4 bm-p-2">
                        <h3 class="bm-mt-8 bm-text-2xl bm-font-normal max-md:bm-text-xl">Interfaz intuitiva</h3>
                        <div class="bm-text-gray-300">
                        Navega fácilmente por tu información con un diseño claro y agradable.
                        </div>
                    </div>
                </div>

                <!-- Beneficio 3 -->
                <div class="reveal-up bm-flex bm-h-[400px] bm-w-[450px] bm-flex-col bm-gap-3 bm-text-center max-md:bm-w-[320px]">
                    <div class="border-gradient bm-h-[200px] bm-w-full bm-overflow-hidden max-md:bm-h-[150px]">
                        <div class="bm-flex bm-h-full bm-w-full bm-place-content-center bm-place-items-end bm-p-2">
                        <i class="bi-bar-chart-fill bm-text-7xl bm-text-gray-200 max-md:bm-text-5xl"></i>
                        </div>
                    </div>
                    <div class="bm-flex bm-flex-col bm-gap-4 bm-p-2">
                        <h3 class="bm-mt-8 bm-text-2xl bm-font-normal max-md:bm-text-xl">Toma decisiones rápidas</h3>
                        <div class="bm-text-gray-300">
                        Obtén estadísticas y gráficos en tiempo real para controlar tu dinero al instante.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Funciones -->
    <section class="bm-relative bm-flex bm-min-h-[80vh] bm-w-full bm-max-w-[100vw] bm-flex-col bm-place-content-center bm-place-items-center bm-overflow-hidden bm-p-6">
        <div class="bm-mt-8 bm-flex bm-flex-col bm-place-items-center bm-gap-5">
            <div class="reveal-up bm-mt-5 bm-flex bm-flex-col bm-gap-3 bm-text-center">
            <h2 class="bm-text-4xl bm-font-medium bm-text-gray-200 max-md:bm-text-2xl">Funciones Importantes</h2>
            </div>
            <div class="bm-mt-6 bm-flex bm-max-w-[80%] bm-flex-wrap bm-place-content-center bm-gap-8 max-lg:bm-flex-col">

            <div class="reveal-up bm-flex bm-h-[200px] bm-w-[450px] bm-gap-8 bm-rounded-xl bm-border bm-border-outlineColor bm-bg-secondary bm-p-8 max-md:bm-w-[320px]">
                <div class="bm-text-4xl max-md:bm-text-2xl">
                <i class="bi bi-wallet2"></i>
                </div>
                <div class="bm-flex bm-flex-col bm-gap-4">
                <h3 class="bm-text-2xl max-md:bm-text-xl">Control de gastos</h3>
                <p class="bm-text-gray-300 max-md:bm-text-sm">
                    Registra y organiza tus gastos de manera sencilla para tener un panorama claro de tus finanzas.
                </p>
                </div>
            </div>

            <div class="reveal-up bm-flex bm-h-[200px] bm-w-[450px] bm-gap-8 bm-rounded-xl bm-border bm-border-outlineColor bm-bg-secondary bm-p-8 max-md:bm-w-[320px]">
                <div class="bm-text-4xl max-md:bm-text-2xl">
                <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="bm-flex bm-flex-col bm-gap-4">
                <h3 class="bm-text-2xl max-md:bm-text-xl">Reportes claros</h3>
                <p class="bm-text-gray-300 max-md:bm-text-sm">
                    Visualiza gráficos y estadísticas que te ayudarán a tomar mejores decisiones financieras.
                </p>
                </div>
            </div>

            <div class="reveal-up bm-flex bm-h-[200px] bm-w-[450px] bm-gap-8 bm-rounded-xl bm-border bm-border-outlineColor bm-bg-secondary bm-p-8 max-md:bm-w-[320px]">
                <div class="bm-text-4xl max-md:bm-text-2xl">
                <i class="bi bi-cloud-fill"></i>
                </div>
                <div class="bm-flex bm-flex-col bm-gap-4">
                <h3 class="bm-text-2xl max-md:bm-text-xl">Respaldo en la nube</h3>
                <p class="bm-text-gray-300 max-md:bm-text-sm">
                    Guarda de forma segura toda tu información para acceder a ella desde cualquier dispositivo.
                </p>
                </div>
            </div>

            <div class="reveal-up bm-flex bm-h-[200px] bm-w-[450px] bm-gap-8 bm-rounded-xl bm-border bm-border-outlineColor bm-bg-secondary bm-p-8 max-md:bm-w-[320px]">
                <div class="bm-text-4xl max-md:bm-text-2xl">
                <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div class="bm-flex bm-flex-col bm-gap-4">
                <h3 class="bm-text-2xl max-md:bm-text-xl">Seguridad avanzada</h3>
                <p class="bm-text-gray-300 max-md:bm-text-sm">
                    Protege tus datos con cifrado y autenticación en dos pasos para mayor tranquilidad.
                </p>
                </div>
            </div>

            <div class="reveal-up bm-flex bm-h-[200px] bm-w-[450px] bm-gap-8 bm-rounded-xl bm-border bm-border-outlineColor bm-bg-secondary bm-p-8 max-md:bm-w-[320px]">
                <div class="bm-text-4xl max-md:bm-text-2xl">
                <i class="bi bi-bell-fill"></i>
                </div>
                <div class="bm-flex bm-flex-col bm-gap-4">
                <h3 class="bm-text-2xl max-md:bm-text-xl">Recordatorios</h3>
                <p class="bm-text-gray-300 max-md:bm-text-sm">
                    Recibe notificaciones para no olvidar pagos y mantenerte siempre al día.
                </p>
                </div>
            </div>

            <div class="reveal-up bm-flex bm-h-[200px] bm-w-[450px] bm-gap-8 bm-rounded-xl bm-border bm-border-outlineColor bm-bg-secondary bm-p-8 max-md:bm-w-[320px]">
                <div class="bm-text-4xl max-md:bm-text-2xl">
                <i class="bi bi-phone-fill"></i>
                </div>
                <div class="bm-flex bm-flex-col bm-gap-4">
                <h3 class="bm-text-2xl max-md:bm-text-xl">Acceso desde cualquier lugar</h3>
                <p class="bm-text-gray-300 max-md:bm-text-sm">
                    Gestiona tus finanzas desde tu móvil, tablet o computadora sin complicaciones.
                </p>
                </div>
            </div>

            </div>
        </div>
    </section>

    <!-- Caracteristicas -->
    <section id="caracteristicas" class="bm-relative bm-flex bm-min-h-[80vh] bm-w-full bm-max-w-[100vw] bm-flex-col bm-place-content-center bm-place-items-center bm-overflow-hidden bm-p-6">
      <div class="reveal-up bm-flex bm-min-h-[60vh] bm-place-content-center bm-place-items-center bm-gap-[10%] max-lg:bm-flex-col max-lg:bm-gap-10">
        
        <!-- Imagen del dashboard de DocDinner -->
        <div class="bm-flex">
          <div class="bm-max-h-[650px] bm-max-w-[850px] bm-overflow-hidden bm-rounded-lg bm-shadow-lg bm-shadow-[rgba(24,223,230,0.44)]">
            <img src="./assets/images/home/dash.png" alt="Panel de control DocDinner" class="bm-h-full bm-w-full bm-object-cover"/>
          </div>
        </div>

        <!-- Texto y beneficios -->
        <div class="bm-mt-6 bm-flex bm-max-w-[450px] bm-flex-col bm-gap-4">
          <h3 class="bm-text-4xl bm-font-medium max-md:bm-text-2xl">
            Simplifica tus finanzas con DocDinner
          </h3>

          <div class="bm-mt-4 bm-flex bm-flex-col bm-gap-3">
            <h4 class="bm-text-xl bm-font-medium">
              <i class="bi bi-check2-circle !bm-text-2xl"></i>
              Control de ingresos y gastos
            </h4>
            <span class="bm-text-lg bm-text-gray-300 max-md:bm-text-base">
              Registra, organiza y analiza tus movimientos financieros en un solo lugar.
            </span>
          </div>

          <div class="bm-mt-4 bm-flex bm-flex-col bm-gap-3">
            <h4 class="bm-text-xl bm-font-medium">
              <i class="bi bi-check2-circle !bm-text-2xl"></i>
              Alertas y notificaciones inteligentes
            </h4>
            <span class="bm-text-lg bm-text-gray-300 max-md:bm-text-base">
              Recibe avisos cuando tus gastos superen lo planificado o detectemos cambios importantes.
            </span>
          </div>

          <div class="bm-mt-4 bm-flex bm-flex-col bm-gap-3">
            <h4 class="bm-text-xl bm-font-medium">
              <i class="bi bi-check2-circle !bm-text-2xl"></i>
              Reportes claros y visuales
            </h4>
            <span class="bm-text-lg bm-text-gray-300 max-md:bm-text-base">
              Visualiza gráficos y estadísticas para tomar mejores decisiones financieras.
            </span>
          </div>
        </div>
      </div>
    </section>

    <section class="bm-relative bm-flex bm-min-h-[80vh] bm-w-full bm-max-w-[100vw] bm-flex-col bm-place-content-center bm-place-items-center bm-overflow-hidden bm-p-6">
      <div class="reveal-up bm-flex bm-min-h-[60vh] bm-place-content-center bm-place-items-center bm-gap-[10%] max-lg:bm-flex-col max-lg:bm-gap-10">
        <!-- Texto -->
        <div class="bm-mt-6 bm-flex bm-max-w-[450px] bm-flex-col bm-gap-4">
          <h3 class="bm-text-4xl bm-font-medium max-md:bm-text-2xl">Análisis financiero claro y potente</h3>

          <div class="bm-mt-4 bm-flex bm-flex-col bm-gap-3">
            <h4 class="bm-text-xl bm-font-medium">
              <i class="bi bi-check2-circle !bm-text-2xl"></i>
              Fácil de interpretar
            </h4>
            <span class="bm-text-lg bm-text-gray-300 max-md:bm-text-base">Obtén gráficos y reportes que muestran de forma clara tus ingresos, gastos y tendencias.</span>
          </div>

          <div class="bm-mt-4 bm-flex bm-flex-col bm-gap-3">
            <h4 class="bm-text-xl bm-font-medium">
              <i class="bi bi-check2-circle !bm-text-2xl"></i>
              Todo en un solo panel
            </h4>
            <span class="bm-text-lg bm-text-gray-300 max-md:bm-text-base">Visualiza en un dashboard único toda tu información financiera en tiempo real.</span>
          </div>

          <div class="bm-mt-4 bm-flex bm-flex-col bm-gap-3">
            <h4 class="bm-text-xl bm-font-medium"><i class="bi bi-check2-circle !bm-text-2xl">
              </i>Predicciones inteligentes
            </h4>
            <span class="bm-text-lg bm-text-gray-300 max-md:bm-text-base">Anticipa gastos futuros y planifica mejor gracias a nuestro sistema de proyecciones.</span>
          </div>
        </div>

        <!-- Imagen -->
        <div class="bm-flex">
          <div class="bm-max-h-[650px] bm-max-w-[850px] bm-overflow-hidden bm-rounded-lg bm-shadow-lg bm-shadow-[rgba(49,212,233,0.44)]">
            <img src="./assets/images/home/insights.png" alt="Panel de análisis DocDinner" class="bm-h-full bm-w-full bm-object-cover"/>
          </div>
        </div>
      </div>
    </section>

    <!-- Equipo -->
    <section id="equipo" class="bm-relative bm-mt-5 bm-flex bm-min-h-[80vh] bm-w-full bm-max-w-[100vw] bm-flex-col bm-place-content-center bm-place-items-center bm-justify-center bm-overflow-hidden bm-p-6">
      <h3 class="bm-text-4xl bm-font-medium bm-text-gray-200 max-md:bm-text-2xl">Desarrolladores</h3>

      <div class="bm-mt-8 bm-flex bm-flex-wrap bm-gap-10 bm-justify-center">
        
        <!-- Daniel Bernal -->
        <div class="reveal-up bm-flex bm-h-fit bm-w-[320px] bm-flex-col bm-gap-4 bm-rounded-lg bm-border bm-border-outlineColor bm-bg-secondary bm-p-4">
          <div class="bm-flex bm-items-center bm-gap-3">
            <div class="bm-h-[60px] bm-w-[60px] bm-overflow-hidden bm-rounded-full">
              <img src="./assets/images/people/danelbernal.jpg" 
                  class="bm-h-full bm-w-full bm-object-cover" 
                  alt="Daniel Bernal" />
            </div>
            <div class="bm-flex bm-flex-col">
              <span class="bm-font-semibold bm-text-gray-100">Daniel Bernal</span>
              <span class="bm-text-gray-400">Bogotá, Colombia</span>

              <a href="https://co.linkedin.com/in/danielbernallopez" target="_blank" class="bm-text-sky-400 hover:bm-underline bm-flex bm-items-center bm-gap-1">
                <i class="bi bi-linkedin"></i> LinkedIn
              </a>
            </div>
          </div>
          <p class="bm-text-gray-300 bm-text-sm">
            Co-fundador & Desarrollador Full Stack de DocDinner. <br><br>
            Especializado en el diseño e implementación de interfaces modernas y atractivas <br> con un enfoque en la optimización de la experiencia de usuario. <br><br> Desarrollador de software con sólidos conocimientos en frontend y backend, capaz de <br> transformar ideas en soluciones digitales eficientes, escalables y visualmente impactantes.
          </p>
        </div>

        <!-- Michael Quintero -->
        <div class="reveal-up bm-flex bm-h-fit bm-w-[320px] bm-flex-col bm-gap-4 bm-rounded-lg bm-border bm-border-outlineColor bm-bg-secondary bm-p-4">
          <div class="bm-flex bm-items-center bm-gap-3">
            <div class="bm-h-[60px] bm-w-[60px] bm-overflow-hidden bm-rounded-full">
              <img src="" 
                  class="bm-h-full bm-w-full bm-object-cover" 
                  alt="Nombre Compañero" />
            </div>
            <div class="bm-flex bm-flex-col">
              <span class="bm-font-semibold bm-text-gray-100">Michael Quintero</span>
              <span class="bm-text-gray-400">Bogota, Colombia</span>
            </div>
          </div>
          <p class="bm-text-gray-300 bm-text-sm">
            Co-fundador & Desarrollador Backend de DocDinner. <br>
            Especialista en bases de datos y arquitectura de sistemas, con experiencia en el diseño <br> optimización y mantenimiento de infraestructuras tecnológicas eficientes y seguras.
          </p>
          <a href="https://linkedin.com/in/usuario-compañero" 
            target="_blank" 
            class="bm-text-sky-400 hover:bm-underline">
            Ver perfil en LinkedIn
          </a>
        </div>
      </div>
    </section>

    <!-- FQA -->
    <section id="fqa" class="bm-flex bm-w-full bm-flex-col bm-place-content-center bm-place-items-center bm-gap-[10%] bm-p-[5%] bm-px-[10%]">
      <h3 class="bm-text-4xl bm-font-medium bm-text-gray-300 max-md:bm-text-2xl">Preguntas Frecuentes</h3>

      <div class="bm-mt-5 bm-flex bm-min-h-[300px] bm-w-full bm-max-w-[850px] bm-flex-col bm-gap-4">
        <div class="faq bm-w-full bm-rounded-md bm-border-[1px] bm-border-solid bm-border-[#1F2123] bm-bg-[#080808]">
        <div class="faq-accordion bm-flex bm-w-full bm-select-none bm-text-xl max-md:bm-text-lg">
            <span>¿DocDinner es gratis?</span>
            <i class="bi bi-plus bm-ml-auto bm-font-semibold"></i>
        </div>
        <div class="content">Sí, puedes usar DocDinner de forma gratuita. Algunas funciones premium estarán disponibles en futuras versiones.</div>
        </div>

        <div class="faq bm-w-full bm-rounded-md bm-border-[1px] bm-border-solid bm-border-[#1F2123] bm-bg-[#080808]">
        <div class="faq-accordion bm-flex bm-w-full bm-select-none bm-text-xl max-md:bm-text-lg">
            <span>¿Puedo sugerir nuevas funciones?</span>
            <i class="bi bi-plus bm-ml-auto bm-font-semibold"></i>
        </div>
        <div class="content">
            ¡Claro! Nos encanta recibir ideas. Puedes enviarnos tus sugerencias a través de nuestro
            <a href="mailto:docdinnerbg@gmail.com" class="bm-underline">correo de soporte</a>.
        </div>
        </div>

        <div class="faq bm-w-full bm-rounded-md bm-border-[1px] bm-border-solid bm-border-[#1F2123] bm-bg-[#080808]">
        <div class="faq-accordion bm-flex bm-w-full bm-select-none bm-text-xl max-md:bm-text-lg">
            <span>¿DocDinner funciona en todos los dispositivos?</span>
            <i class="bi bi-plus bm-ml-auto bm-font-semibold"></i>
        </div>
        <div class="content">
            Sí, está optimizado para funcionar en móviles, tabletas y computadoras de escritorio.
        </div>
        </div>

        <div class="faq bm-w-full bm-rounded-md bm-border-[1px] bm-border-solid bm-border-[#1F2123] bm-bg-[#080808]">
        <div class="faq-accordion bm-flex bm-w-full bm-select-none bm-text-xl max-md:bm-text-lg">
            <span>¿Cada cuánto se actualiza la aplicación?</span>
            <i class="bi bi-plus bm-ml-auto bm-font-semibold"></i>
        </div>
        <div class="content">
            Publicamos mejoras y nuevas funciones de forma periódica, aproximadamente cada mes.
        </div>
        </div>
      </div>

      <div class="bm-mt-20 bm-flex bm-flex-col bm-place-items-center bm-gap-4">
        <div class="bm-text-3xl max-md:bm-text-2xl">¿Todavía tienes dudas?</div>
        <a href="mailto:docdinnerbg@gmail.com" class="btn !bm-rounded-full !bm-border-[1px] !bm-border-solid !bm-border-gray-300 !bm-bg-transparent bm-transition-colors bm-duration-[0.3s]">Contáctanos</a>
      </div>
    </section>

    <footer class="bm-mt-auto bm-flex bm-w-full bm-place-content-around bm-gap-3 bm-p-[5%] bm-px-[10%] bm-text-white max-md:bm-flex-col">
      <div class="bm-flex bm-h-full bm-w-[250px] bm-flex-col bm-place-items-center bm-gap-6 max-md:bm-w-full">
        <img src="./assets/logo/colombia-colombia-svgrepo-com.svg" alt="logo" srcset="" class="bm-flex bm-w-[150px]"/>
        <div>Bogota, Colombia</div>
      </div>

      <div class="bm-flex bm-h-full bm-w-[250px] bm-flex-col bm-gap-4">
        <h2 class="bm-text-3xl max-md:bm-text-xl">General</h2>
        <div class="bm-flex bm-flex-col bm-gap-3 max-md:bm-text-sm">
          <a href="empezar" class="footer-link">Empezar</a>
          <a href="tecnologias" class="footer-link">Tecnologias</a>
          <a href="beneficios" class="footer-link">Beneficios</a>
          <a href="contacto" class="footer-link">Contacto</a>
        </div>
      </div>

      <div class="bm-flex bm-h-full bm-w-[250px] bm-flex-col bm-gap-4">
        <h2 class="bm-text-3xl max-md:bm-text-xl">Recursos</h2>
        <div class="bm-flex bm-flex-col bm-gap-3 max-md:bm-text-sm">
          <a href="acerca" class="footer-link">Acerca</a>
          <a href="fqa" class="footer-link">FAQ</a>
          <a href="contacto" class="footer-link">Contacto</a>
          <a href="documentacion" class="footer-link">Privacy policy</a>
        </div>
      </div>
    </footer>
  </body>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js" integrity="sha512-B1lby8cGcAUU3GR+Fd809/ZxgHbfwJMp0jLTVfHiArTuUt++VqSlJpaJvhNtRf3NERaxDNmmxkdx2o+aHd4bvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/ScrollTrigger.min.js" integrity="sha512-AY2+JxnBETJ0wcXnLPCcZJIJx0eimyhz3OJ55k2Jx4RtYC+XdIi2VtJQ+tP3BaTst4otlGG1TtPJ9fKrAUnRdQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="./index.js"></script>
  <script src="https://platform.linkedin.com/badges/js/profile.js" async defer type="text/javascript"></script>
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
  <script src="assets/js/landing/maps.js"></script>
</html>

