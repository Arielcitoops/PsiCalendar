<?php
require_once "config.php";
require_once "functions.php";
require_once "validaciones.php";

check_login();
$user_id = get_user_id();

// Obtener nombre del usuario
$nombre_usuario = get_user_name($user_id); // Asumiendo que existe una función get_user_name()

$titulo_pagina = "Registro Diario - PsiCalendar";

// Obtener registros de emociones
$sql = "SELECT fecha, emocion FROM registros_diarios WHERE usuario_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$eventos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $color = '';
    switch ($row['emocion']) {
        case 'alegre':
            $color = '#FFD700'; // Amarillo
            break;
        case 'triste':
            $color = '#4169E1'; // Azul
            break;
        case 'enojado':
            $color = '#FF0000'; // Rojo
            break;
        case 'cansado':
            $color = '#808080'; // Gris
            break;
    }
    $eventos[] = [
        'start' => $row['fecha'],
        'display' => 'background',
        'backgroundColor' => $color
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PsiCalendar - Calendario</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <!-- Incluir CSS de FullCalendar -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <style>
        body {
            background-image: url('img/fondocalendario.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Indie Flower';
            color: white; 
        }
        .navbar-brand img {
            height: 30px; /* Ajusta el tamaño del ícono */
            margin-right: 8px; /* Espacio entre el ícono y el texto */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Agregar ícono local -->
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Ícono"> PsiCalendar
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Calendario</a>
                    </li>
                </ul>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <span class="navbar-text"> ---- Seas Bienvenid@ : <?php echo htmlspecialchars($nombre_usuario); ?></span>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="textocalendario">
        <br><br>
        <h3>Bienvenido a tu Calendario, siéntete libre de contar tus anécdotas</h3>
        <h3>Para ingresar da click en el dia de hoy y continúa tu travesia</h3>
    </div>
    <!-- Contenedor para el calendario -->
    <div class="container mt-5">
        <div id="calendar"></div>
    </div>

    <!-- Scripts al final del body para mejorar la carga -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <!-- Bootstrap Bundle JS (necesario para el Navbar de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script JS para inicialización del calendario -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var eventos = <?php echo json_encode($eventos); ?>;
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: eventos,
            eventClick: function(info) {
                var clickedDate = info.event.start;
                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0);

                if (clickedDate <= currentDate) {
                    var fecha = info.event.startStr;
                    window.location.href = 'registro_diario.php?fecha=' + fecha;
                } else {
                    alert('No puedes registrar emociones para fechas futuras.');
                }
            },
            dateClick: function(info) {
                var clickedDate = new Date(info.dateStr);
                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0);

                if (clickedDate <= currentDate) {
                    window.location.href = 'registro_diario.php?fecha=' + info.dateStr;
                } else {
                    alert('No puedes registrar emociones para fechas futuras.');
                }
            }
        });
        calendar.render();
    });
    </script>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 PsykoHacks. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
