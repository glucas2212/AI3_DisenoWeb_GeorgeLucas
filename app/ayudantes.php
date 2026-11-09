<?php
declare(strict_types=1);

/**
 * Escapa texto para insertarlo en HTML. Es la defensa contra XSS:
 * convierte < > & " ' en entidades para que el navegador los muestre y no los ejecute.
 */
function h(?string $texto): string
{
    return htmlspecialchars($texto ?? '', ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/** Token anti-CSRF guardado en la sesión. */
function tokenFormulario(): string
{
    $_SESSION['token'] ??= bin2hex(random_bytes(32));
    return $_SESSION['token'];
}

function tokenEsValido(mixed $recibido): bool
{
    return is_string($recibido) && hash_equals($_SESSION['token'] ?? '', $recibido);
}

/** Muestra una vista dentro de la plantilla general. */
function mostrarVista(string $vista, array $datos = [], int $estadoHttp = 200): void
{
    http_response_code($estadoHttp);
    extract($datos, EXTR_SKIP);
    $contenido = __DIR__ . "/Vistas/{$vista}.php";
    require __DIR__ . '/Vistas/plantilla.php';
}
