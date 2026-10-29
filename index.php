<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>PsiCalendar - Inicio</title>
    <style>
        body {
            height: 100vh;
            background-image: url('img/fondo-index.jpg'); 
            background-size: cover;
            background-position: center;
            margin: 0;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.80); /* Color y opacidad */
            z-index: 0; /* Detrás del contenido */
        }
        header, .container {
            position: relative;
            z-index: 1; /* Delante de la superposición */
        }
        footer {
            margin-top: auto; /* Mantener el footer en la parte inferior */
            z-index: 1; /* Asegurarse de que el footer esté por encima de la superposición */
        }
    </style>
</head>
<body>
    <div class="overlay"></div> <!-- Superposición aquí -->
    <header>
        <br>
        <h1 class="titulopagina">Bienvenido a PsiCalendar</h1>
        <img id="logoindex" src="img/PsiCalendar.png" class="img-fluid mx-auto d-block" alt="PsiCalendar Logo">
        <br>
        <h2 class="parrafosinicio">El Diario que te ayudará a conocer a tu yo interior</h2> 
    </header>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col text-center">
                <h3 class="parrafoslogin">Ya tengo cuenta</h3>
                <br>
                <img src="img/login-icon.png" alt="Iniciar Sesión" class="img-fluid mb-2" style="width: 200px;">
                <br>
                <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
            </div>
            <div class="col text-center">
                <h3 class="parrafoslogin">Quiero unirme</h3>
                <br>
                <img src="img/register-icon.png" alt="Registrarse" class="img-fluid mb-2" style="width: 200px;">
                <br>
                <a href="registro.php" class="btn btn-secondary">Registrarse</a>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 PsykoHacks. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
