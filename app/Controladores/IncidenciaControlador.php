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

    public function nueva(): void
    {
        $this->mostrarFormulario([], []);
    }

    public function guardar(): void
    {
        if (!tokenEsValido($_POST['token'] ?? null)) {
            $this->mostrarFormulario($_POST, ['general' => 'La sesión del formulario expiró. Vuelva a enviarlo.'], 400);
            return;
        }

        $validador = new Validador($this->modelo->areas());
        if (!$validador->validar($_POST)) {
            $this->mostrarFormulario($validador->datos(), $validador->errores(), 422);
            return;
        }

        $id = $this->modelo->registrar($validador->datos());
        $_SESSION['mensaje'] = sprintf('Incidencia INC-%04d registrada.', $id);
        // Redirección después de POST: recargar el listado no reenvía el formulario.
        header('Location: index.php', true, 303);
    }

    private function mostrarFormulario(array $valores, array $errores, int $estado = 200): void
    {
        mostrarVista('formulario', [
            'titulo'      => 'Nueva incidencia',
            'valores'     => $valores,
            'errores'     => $errores,
            'areas'       => $this->modelo->areas(),
            'tipos'       => IncidenciaModelo::TIPOS,
            'prioridades' => IncidenciaModelo::PRIORIDADES,
        ], $estado);
    }
}
