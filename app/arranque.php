<?php
declare(strict_types=1);

// Nunca se imprimen errores de PHP en la página; quedan en el log del servidor.
ini_set('display_errors', '0');
ini_set('log_errors', '1');
date_default_timezone_set('America/Guayaquil');

// Cabeceras de seguridad.
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; font-src 'self'; img-src 'self'; form-action 'self'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/ayudantes.php';
require_once __DIR__ . '/Modelos/IncidenciaModelo.php';
require_once __DIR__ . '/Validador.php';
require_once __DIR__ . '/Controladores/IncidenciaControlador.php';
