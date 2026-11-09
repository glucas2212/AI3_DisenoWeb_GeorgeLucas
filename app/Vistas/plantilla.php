<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($titulo) ?> | Mesa de ayuda</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/componentes.css">
</head>
<body>
    <header class="cabecera">
        <a class="cabecera__marca" href="index.php">Mesa de ayuda<span>Soporte técnico</span></a>
        <nav class="cabecera__menu" aria-label="Principal">
            <a href="index.php">Incidencias</a>
            <a class="cabecera__accion" href="index.php?accion=nueva">Reportar incidencia</a>
        </nav>
    </header>
    <main class="contenido">
        <?php require $contenido; ?>
    </main>
</body>
</html>
