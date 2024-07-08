<!-- Inicio del Codigo en HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PsiCalendar - Home</title>
</head>
<body>
   
    <?php
    /* Tomar Header de la carpeta templates */
    $titulo_pagina = "Inicio - PsiCalendar";
    include "templates/header.php";
    ?>
<!-- Pagina Index  -->
    <h1>Bienvenido a PsiCalendar</h1>
    <p>Aquí puedes llevar un registro de tus emociones y recibir sugerencias de actividades para mejorar tu bienestar.</p>

    <?php if (!isset($_SESSION['usuario_id'])): ?>
        <!-- Entrar al Login -->
        <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
        <!-- Entrar al Registro -->
        <a href="registro.php" class="btn btn-secondary">Registrarse</a>
    <?php endif; ?>
    <!-- Tomar Footer de la carpeta templates -->
    <?php include "templates/footer.php"; ?>
</body>
</html>