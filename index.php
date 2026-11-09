<?php
declare(strict_types=1);

/*
 * Controlador frontal: todas las peticiones entran por aquí.
 *   index.php                      -> listado de incidencias (Read)
 */
require __DIR__ . '/app/arranque.php';

try {
    $controlador = new IncidenciaControlador(new IncidenciaModelo(obtenerConexion()));
    $accion = $_GET['accion'] ?? 'listado';

    match (true) {
        default                                                         => $controlador->listado(),
    };
} catch (RuntimeException $error) {
    mostrarVista('error', ['titulo' => 'Servicio no disponible', 'detalle' => $error->getMessage()], 503);
} catch (Throwable $error) {
    error_log('[mesa-ayuda] ' . $error);
    mostrarVista('error', ['titulo' => 'Error inesperado', 'detalle' => 'No se pudo completar la operación.'], 500);
}
