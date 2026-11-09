<?php
declare(strict_types=1);

/** Controlador: recibe la petición, usa el modelo y elige la vista. */
class IncidenciaControlador
{
    public function __construct(private IncidenciaModelo $modelo)
    {
    }

    public function listado(): void
    {
        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        mostrarVista('listado', [
            'titulo'      => 'Incidencias registradas',
            'incidencias' => $this->modelo->listar(),
            'mensaje'     => $mensaje,
        ]);
    }
}
