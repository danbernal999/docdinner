<?php
// router.php

// Si la ruta pedida existe como archivo (ej: CSS, JS, imagen), la devuelve normal
if (php_sapi_name() === 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

// En cualquier otro caso, manda todo al index.php
require_once __DIR__ . '/index.php';
