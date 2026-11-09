<div class="encabezado-pagina">
    <h1>Incidencias registradas</h1>
    <p><?= count($incidencias) ?> reportes, del más reciente al más antiguo.</p>
</div>

<?php if ($mensaje): ?>
    <p class="aviso aviso--ok" role="status"><?= h($mensaje) ?></p>
<?php endif; ?>

<?php if (!$incidencias): ?>
    <p class="vacio">No hay incidencias registradas. <a href="index.php?accion=nueva">Reporte la primera</a>.</p>
<?php else: ?>
    <div class="tabla-desplazable">
        <table class="tabla">
            <thead>
                <tr>
                    <th scope="col">N.º</th>
                    <th scope="col">Solicitante</th>
                    <th scope="col">Área</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Prioridad</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($incidencias as $fila): ?>
                <?php /* Todo dato que viene de la base pasa por h() antes de imprimirse. */ ?>
                <tr>
                    <td data-col="N.º" class="folio">INC-<?= sprintf('%04d', (int) $fila['id_incidencia']) ?></td>
                    <td data-col="Solicitante"><?= h($fila['solicitante']) ?><small><?= h($fila['correo']) ?></small></td>
                    <td data-col="Área"><?= h($fila['area']) ?></td>
                    <td data-col="Tipo"><?= h($fila['tipo']) ?></td>
                    <td data-col="Prioridad"><span class="prioridad prioridad--<?= h(strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $fila['prioridad']))) ?>"><?= h($fila['prioridad']) ?></span></td>
                    <td data-col="Descripción" class="descripcion"><?= nl2br(h($fila['descripcion'])) ?></td>
                    <td data-col="Estado"><?= h($fila['estado']) ?></td>
                    <td data-col="Fecha"><?= h(date('d/m/Y H:i', strtotime($fila['fecha_creacion']))) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
