<!-- Inicio del Codigo en HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PsiCalendar - Logout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <style>
    body{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0px;
    padding: 0px;
    height: 700px;
    background-image: url('img/3746498.jpg');
    background-size: cover;
    font-family: 'Indie Flower';
    
    }

    h1{    
    font-size: 3rem;
    margin: 50px 0px;
    }

    .btn-secondary {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    text-decoration: none;
    }

    .btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.4);
    }
    </style>
</head>
<body>
   
    <?php
    /* Tomar Header de la carpeta templates */
    $titulo_pagina = "Inicio - PsiCalendar";
    ?>
<!-- Pagina Index  -->
    <h1>Gracias por usarnos</h1>
    <br>
    <p>Recuerda que puedes enviarnos tus sugerencias a este correo:</p>
    <br>
    <p>arielare2004@gmail.com</p>
    <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
    <br><br><br><br><br><br><br><br><br><br>
    <!-- Tomar Footer de la carpeta templates -->
</body>
</html>