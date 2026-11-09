<?php
declare(strict_types=1);

/** Valida en el servidor los datos del formulario de incidencias. */
class Validador
{
    private array $errores = [];
    private array $limpios = [];

    public function __construct(private array $areas)
    {
    }

    public function validar(array $post): bool
    {
        $this->errores = [];
        $texto = fn (string $campo): string => trim(preg_replace('/\s+/u', ' ', (string) ($post[$campo] ?? '')));

        $solicitante = $texto('solicitante');
        if (!preg_match("/^[\p{L} .'-]{3,80}$/u", $solicitante)) {
            $this->errores['solicitante'] = 'Escriba el nombre completo (de 3 a 80 letras).';
        }

        $correo = mb_strtolower($texto('correo'));
        if ($correo === '' || mb_strlen($correo) > 120 || filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
            $this->errores['correo'] = 'Escriba un correo válido, por ejemplo nombre@institucion.gob.ec.';
        }

        $idArea = filter_var($post['id_area'] ?? '', FILTER_VALIDATE_INT);
        if ($idArea === false || !isset($this->areas[$idArea])) {
            $this->errores['id_area'] = 'Seleccione el área desde donde se reporta.';
        }

        $tipo = (string) ($post['tipo'] ?? '');
        if (!in_array($tipo, IncidenciaModelo::TIPOS, true)) {
            $this->errores['tipo'] = 'Seleccione el tipo de incidencia.';
        }

        $prioridad = (string) ($post['prioridad'] ?? '');
        if (!in_array($prioridad, IncidenciaModelo::PRIORIDADES, true)) {
            $this->errores['prioridad'] = 'Seleccione la prioridad.';
        }

        // La descripción conserva sus saltos de línea; solo se recortan los extremos.
        $descripcion = trim((string) ($post['descripcion'] ?? ''));
        $largo = mb_strlen($descripcion);
        if ($largo < 10 || $largo > 500) {
            $this->errores['descripcion'] = 'Describa el problema con 10 a 500 caracteres.';
        }

        $this->limpios = [
            'solicitante' => $solicitante,
            'correo'      => $correo,
            'id_area'     => $idArea === false ? '' : $idArea,
            'tipo'        => $tipo,
            'prioridad'   => $prioridad,
            'descripcion' => $descripcion,
        ];
        return $this->errores === [];
    }

    public function errores(): array
    {
        return $this->errores;
    }

    public function datos(): array
    {
        return $this->limpios;
    }
}
