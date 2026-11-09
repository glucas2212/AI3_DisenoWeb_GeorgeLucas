<?php
declare(strict_types=1);

/**
 * Devuelve la conexión PDO a db_sistema_web (se crea una sola vez por petición).
 *
 * @throws RuntimeException con un mensaje apto para mostrar al usuario.
 */
function obtenerConexion(): PDO
{
    static $conexion = null;
    if ($conexion instanceof PDO) {
        return $conexion;
    }

    $rutaCredenciales = __DIR__ . '/credenciales.php';
    if (!file_exists($rutaCredenciales)) {
        error_log('[mesa-ayuda] No existe config/credenciales.php');
        throw new RuntimeException('La aplicación no tiene configurada la base de datos.');
    }
    $cfg = require $rutaCredenciales;

    $dsn = "mysql:host={$cfg['servidor']};port={$cfg['puerto']};dbname={$cfg['base_datos']};charset=utf8mb4";
    $opciones = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // los errores lanzan PDOException
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,                  // preparación real en el servidor MySQL
    ];

    try {
        $conexion = new PDO($dsn, $cfg['usuario'], $cfg['contrasena'], $opciones);
        $conexion->exec("SET time_zone = '-05:00'");            // hora de Ecuador en fecha_creacion
    } catch (PDOException $error) {
        // El mensaje real (usuario, servidor, código SQLSTATE) solo va al log del servidor.
        error_log('[mesa-ayuda] Fallo de conexión: ' . $error->getMessage());
        throw new RuntimeException('El servicio de base de datos no está disponible en este momento.');
    }

    return $conexion;
}
