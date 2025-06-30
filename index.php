// DocDinner - Control de gastos personales
// Copyright (c) 2025 Brayan Bernal, Michael Quintero
// Licensed under the MIT License

<?php

$ruta = $_GET['ruta'] ?? 'home';

//Para manejar rutas en php 
switch ($ruta) {
    case 'home':
        include 'modulos/landing/controlador.php';
        $controller = new LandingController();
        $controller->index(); //Funcion del index. no tiene mucha ciencia 
        break;

    case 'login':
        include 'auth/controlador.php';
        require_once 'config/database.php';
        $conn = getDB();
        $controller = new AuthController($conn); //Este maneja el login y crea la sesion si inician claro
        $controller->login(); //Piloso por que las session solo se ejecuta en el main
        break;

    case 'main':
        include 'main/controlador.php'; //Modificacion en los mudulos entrar aqui
        $controller = new MainController(); //Este maneja Toda las Rutas de los modulos
        $controller->main(); //Funcion que si la ven, tiene el auth para validar si hay usuario
        break;
        
    case 'logout':
        include 'auth/logout.php'; //Este maneja el logout y destruye la session
        $controller = new LogoutController();
        $controller->logout(); //Funcion que destruye la session
        break;

    case 'recovery':
        include 'auth/recuperar/controlador.php';
        require_once 'config/database.php';
        $conn = getDB(); 
        $controller = new RecuperarController($conn);
        $controller->recuperar(); //Funcion del index. no tiene mucha ciencia 
        break;

    case 'apiGastos':
        if (isset($_GET['accion'])){
            $accion = $_GET['accion'];

            include 'modulos/productos/controlador.php';
            require_once 'config/database.php';
            $conn = getDB(); 
            $controller = new ProductosController($conn);
            $controller->apiGastos($accion);

        }
        break;
}

?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


