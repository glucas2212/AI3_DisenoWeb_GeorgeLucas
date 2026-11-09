<?php
declare(strict_types=1);

/*
 * Controlador frontal: todas las peticiones entran por aquí.
 *   index.php                      -> listado de incidencias (Read)
 *   index.php?accion=nueva         -> formulario
 *   index.php?accion=guardar (POST) -> inserción (Create)
 */
require __DIR__ . '/app/arranque.php';

try {
    $controlador = new IncidenciaControlador(new IncidenciaModelo(obtenerConexion()));
    $accion = $_GET['accion'] ?? 'listado';

    match (true) {
        $accion === 'nueva'                                             => $controlador->nueva(),
        $accion === 'guardar' && $_SERVER['REQUEST_METHOD'] === 'POST'  => $controlador->guardar(),
        default                                                         => $controlador->listado(),
    };
} catch (RuntimeException $error) {
    mostrarVista('error', ['titulo' => 'Servicio no disponible', 'detalle' => $error->getMessage()], 503);
} catch (Throwable $error) {
    error_log('[mesa-ayuda] ' . $error);
    mostrarVista('error', ['titulo' => 'Error inesperado', 'detalle' => 'No se pudo completar la operación.'], 500);
}
