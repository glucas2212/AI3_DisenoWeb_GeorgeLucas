<?php
declare(strict_types=1);

/** Modelo: único lugar del sistema que ejecuta SQL sobre las incidencias. */
class IncidenciaModelo
{
    public const TIPOS = ['Hardware', 'Software', 'Red', 'Impresora', 'Accesos'];
    public const PRIORIDADES = ['Baja', 'Media', 'Alta', 'Crítica'];

    public function __construct(private PDO $bd)
    {
    }

    /** @return array<int, string> id_area => nombre */
    public function areas(): array
    {
        $consulta = $this->bd->prepare('SELECT id_area, nombre FROM areas ORDER BY nombre');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function listar(): array
    {
        $consulta = $this->bd->prepare(
            'SELECT i.id_incidencia, i.solicitante, i.correo, a.nombre AS area, i.tipo,
                    i.prioridad, i.descripcion, i.estado, i.fecha_creacion
               FROM incidencias AS i
               JOIN areas AS a ON a.id_area = i.id_area
              ORDER BY i.id_incidencia DESC'
        );
        $consulta->execute();
        return $consulta->fetchAll();
    }
}
