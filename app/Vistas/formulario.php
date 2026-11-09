<?php
/** Devuelve el mensaje de error de un campo y los atributos ARIA correspondientes. */
$error = fn (string $campo): string => $errores[$campo] ?? '';
$aria = fn (string $campo): string => isset($errores[$campo]) ? "aria-invalid=\"true\" aria-describedby=\"err-{$campo}\"" : '';
$valor = fn (string $campo): string => h((string) ($valores[$campo] ?? ''));
?>
<div class="encabezado-pagina">
    <h1>Reportar una incidencia</h1>
    <p>Todos los campos son obligatorios.</p>
</div>

<?php if ($errores): ?>
    <p class="aviso aviso--error" role="alert"><?= h($errores['general'] ?? 'Corrija los campos señalados para registrar la incidencia.') ?></p>
<?php endif; ?>

<form class="formulario" id="form-incidencia" method="post" action="index.php?accion=guardar">
    <input type="hidden" name="token" value="<?= h(tokenFormulario()) ?>">

    <fieldset>
        <legend>Datos de quien reporta</legend>
        <div class="campo">
            <label for="solicitante">Nombre completo</label>
            <input id="solicitante" name="solicitante" required minlength="3" maxlength="80"
                   pattern="[A-Za-zÁÉÍÓÚÜÑáéíóúüñ .'\-]{3,80}" autocomplete="name"
                   data-mensaje="Escriba el nombre completo (de 3 a 80 letras)."
                   value="<?= $valor('solicitante') ?>" <?= $aria('solicitante') ?>>
            <p class="campo__error" id="err-solicitante"><?= h($error('solicitante')) ?></p>
        </div>
        <div class="campo">
            <label for="correo">Correo institucional</label>
            <input id="correo" name="correo" type="email" required maxlength="120" autocomplete="email"
                   data-mensaje="Escriba un correo válido, por ejemplo nombre@institucion.gob.ec."
                   value="<?= $valor('correo') ?>" <?= $aria('correo') ?>>
            <p class="campo__error" id="err-correo"><?= h($error('correo')) ?></p>
        </div>
        <div class="campo">
            <label for="id_area">Área</label>
            <select id="id_area" name="id_area" required data-mensaje="Seleccione el área desde donde se reporta." <?= $aria('id_area') ?>>
                <option value="">Seleccione</option>
                <?php foreach ($areas as $id => $nombre): ?>
                    <option value="<?= (int) $id ?>" <?= (string) ($valores['id_area'] ?? '') === (string) $id ? 'selected' : '' ?>><?= h($nombre) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="campo__error" id="err-id_area"><?= h($error('id_area')) ?></p>
        </div>
    </fieldset>

    <fieldset>
        <legend>Detalle del problema</legend>
        <div class="campo">
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required data-mensaje="Seleccione el tipo de incidencia." <?= $aria('tipo') ?>>
                <option value="">Seleccione</option>
                <?php foreach ($tipos as $tipo): ?>
                    <option <?= ($valores['tipo'] ?? '') === $tipo ? 'selected' : '' ?>><?= h($tipo) ?></option>
                <?php endforeach; ?>
            </select>
            <p class="campo__error" id="err-tipo"><?= h($error('tipo')) ?></p>
        </div>
        <div class="campo">
            <span class="campo__etiqueta" id="lbl-prioridad">Prioridad</span>
            <div class="opciones" role="radiogroup" aria-labelledby="lbl-prioridad" <?= $aria('prioridad') ?>>
                <?php foreach ($prioridades as $prioridad): ?>
                    <label class="opcion">
                        <input type="radio" name="prioridad" value="<?= h($prioridad) ?>" required
                               data-mensaje="Seleccione la prioridad."
                               <?= ($valores['prioridad'] ?? 'Media') === $prioridad ? 'checked' : '' ?>>
                        <span><?= h($prioridad) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <p class="campo__error" id="err-prioridad"><?= h($error('prioridad')) ?></p>
        </div>
        <div class="campo campo--ancho">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="5" required minlength="10" maxlength="500"
                      data-mensaje="Describa el problema con 10 a 500 caracteres."
                      aria-describedby="contador" <?= $aria('descripcion') ?>><?= $valor('descripcion') ?></textarea>
            <p class="campo__ayuda" id="contador">Máximo 500 caracteres.</p>
            <p class="campo__error" id="err-descripcion"><?= h($error('descripcion')) ?></p>
        </div>
    </fieldset>

    <div class="formulario__acciones">
        <button type="submit" class="boton">Registrar incidencia</button>
        <a href="index.php">Volver al listado</a>
    </div>
</form>
<script src="assets/js/formulario.js"></script>
