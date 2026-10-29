<?php
require_once "config.php";
require_once "functions.php";

check_login();

$actividades = [
    "Medita con un video de youtube por 10 minutos - https://www.youtube.com/watch?v=-L0A-bU-Kio",
    "Da un paseo de 15 minutos",
    "Escribir 10 cosas por las que estás agradecido",
    "Llamar a tu mejor amigo y dile lo mucho que lo aprecias",
    "Leer un capítulo del título (Cumbres Borrascosas) de Emily Bronte - https://biblioteca.org.ar/libros/656163.pdf",
    "Haz un origami de perrito! - https://www.youtube.com/watch?v=td0dhHx1hbs",
    "Sal a ver el panorama de tu casa por 10 mins y respira",
    "Busca en Spotify (El miedo al cambio) de Farid Dieck - 17 mins - https://open.spotify.com/episode/3rAWiP2nACcX1NSsYvz6id",
    "Dibuja un paisaje de algún lugar que hayas visitado",
    "Prueba a escuchar One More Time - de Daft Punk - https://www.youtube.com/watch?v=A2VpR8HahKc",
    "Escribe qué es lo que sientes al escuchar el Himno a la Alegría de Beethoven - https://www.youtube.com/watch?v=KFzXUqzvAFI",
    "Has escuchado Highway to Hell - de AC/DC, es interesante, búscalo - https://www.youtube.com/watch?v=l482T0yNkeo",
    "¿Sabías las curiosidades de la canción Another Brick in the Wall Pt2? Te deja mucho en qué pensar - https://www.letras.com/blog/another-brick-in-the-wall-significado/",
    "Si tienes un incienso a disposición, préndelo y pon música china",
    "Haz una lista de gratitud a las personas que más aprecias",
    "Prepárate un jugo de limón e invita a tus amigos a tomar de él",
    "Busca en Youtube Luisito Comunica - Ecuador, puedes aprender algo que no sabías - https://www.youtube.com/results?search_query=luisito+comunica+ecuador",
    "¿Sabes de dónde proviene la palabra (Ñaño)? Te apuesto a que no, hora de la búsqueda",
    "¿Quieres conocer música folclórica alegre? Busca Los Herederos de Tabacundo en Youtube - https://www.youtube.com/results?search_query=los+herederos+de+tabacundo",
    "Revive los 90s Busca Tren al Sur - Los Prisioneros - https://www.youtube.com/watch?v=eDipH-myZWE",
    "Prueba a buscar Big in Japan - Alphaville, es antiguo pero bueno - https://www.youtube.com/watch?v=E2HeDHkL9kg",
    "Échate una salsa, mi rey/reina, ¡vámoooos! - https://www.youtube.com/results?search_query=salsa",
    "Busca (Darle valor a las pequeñas metas) - Entiende Tu Mente en Spotify - https://open.spotify.com/episode/4MEKkX4IS1oQ53iXxWtZs6",
    "Escucha Pobre Secretaria - Daniela Romo, pa' que te rías y bailes - https://www.youtube.com/watch?v=AGJrr9QnwVI",
    "Busca - De Música Ligera - Soda Stereo, un clasicazo - https://www.youtube.com/watch?v=T_FkEw27XJ0",
    "Busca Every Breath You Take - The Police, subtitulado en español en Youtube - https://www.youtube.com/watch?v=6afav_M2w7w",
    "Escribe sobre las cosas que te gustan hacer",
    "A bailar, busca Chantaje - Just Dance en Youtube y sigue los pasos! - https://www.youtube.com/watch?v=rddettN2RMU",
    "Otro clásico, busca Torero de Chayanne y a bailar!! - https://www.youtube.com/watch?v=GuZzuQvv7uc",
    "Da click en este link y aplica lo que aprendiste - https://www.youtube.com/watch?v=4CVxvJMstpg",
    "Haz un origami de un sapito que salte! - https://es.wikihow.com/hacer-una-rana-saltarina-de-origami",
    "Busca I'm Still Standing - Elton John en español y fíjate en su letra - https://www.youtube.com/watch?v=1V-QmQ5mjmg",
    "Toma un baño caliente",
    "Busca alguna receta sencilla para hacer en tu cocina",
    "¿Tienes plantas? Hora de apreciarlas, dales agua y mueve su tierra",
    "Toma una taza de café",
    "Hazte un masaje en los pies!",
    "Busca el artículo del día en Wikipedia - https://es.wikipedia.org/wiki/Wikipedia:Portada",
    "Isla del Tesoro - Robert Louis Stevenson, lee el primer capítulo: https://biblioteca.org.ar/libros/130864.pdf",
    "Hora de ver tus fotos y recordar viejos tiempos!",
    "Hora del té, prepárate una agüita aromática",
    "Da click para realizar Ejercicios de Yoga para principiantes - https://www.youtube.com/watch?v=1J8CRcoFekE",
    "Sal a la terraza o fuera de casa y estírate",
    "Lee sobre las poesías de Paulo Coelho",
    "Practica tu escritura por 10 mins",
    "¿Tu cuarto está limpio? Vamos a reacomodar!!",
    "Abre tu teléfono y toma fotos de tu entorno, como un profesional",
    "Revive el 2010 Busca Carito - Carlos Vives - https://www.youtube.com/watch?v=zsmO6xDiO04",
    "A bailar Busca Calypso - Luis Fonsi Just Dance y a mover el bote - https://www.youtube.com/watch?v=ayODReK0Gek",
    "¿De dónde salió lo de los ecuatorianos decir (Seco de Pollo)? Vamos a buscar!"
];

$frases = [
    "La vida es lo que hacemos de ella. Los viajes son los viajeros. Lo que vemos no es lo que vemos, sino lo que somos. - Fernando Pessoa",
    "La felicidad no es algo que pospones para el futuro; es algo que diseñas para el presente. - Jim Rohn",
    "La única manera de hacer un gran trabajo es amar lo que haces. - Steve Jobs",
    "No te preocupes por los fracasos, preocúpate por las oportunidades que pierdes cuando ni siquiera lo intentas. - Jack Canfield",
    "La vida es un regalo, y quiero aprovecharlo al máximo. - Kate Winslet",
    "No cuentes los días, haz que los días cuenten. - Muhammad Ali",
    "La vida es corta, y es hasta cierto punto un desperdicio de tiempo ocuparse de asuntos serios. - Oscar Wilde",
    "No hay manera de ser una persona perfecta, pero hay un millón de maneras de ser una persona increíble. - Anónimo",
    "La verdadera felicidad consiste en hacer el bien. - Aristóteles",
    "El éxito no es la clave de la felicidad. La felicidad es la clave del éxito. Si amas lo que haces, tendrás éxito. - Albert Schweitzer",
    "Cree en ti mismo y todo será posible. - Friedrich Nietzsche",
    "La vida no se trata de esperar a que pase la tormenta, se trata de aprender a bailar bajo la lluvia. - Vivian Greene",
    "Nunca pierdas la esperanza, los milagros ocurren todos los días. - H. Jackson Brown Jr.",
    "La mayor gloria en la vida no es nunca caer, sino levantarse cada vez que caemos. - Nelson Mandela",
    "No importa lo lento que vayas siempre y cuando no te detengas. - Confucio",
    "La vida es un viaje que debe ser viajado, sin importar lo malas que sean las carreteras y lo cansado que uno se sienta. - Oliver Goldsmith",
    "La vida es realmente simple, pero insistimos en hacerlo complicado. - Confucio",
    "El éxito es la suma de pequeños esfuerzos repetidos día tras día. - Robert Collier",
    "La felicidad no es algo que pospones para el futuro; es algo que diseñas para el presente. - Jim Rohn",
    "Nada puede resistir al trabajo perseverante. - Alejandro Magno"
];

// Selección aleatoria de 3 actividades
$actividades_seleccionadas = array_rand($actividades, 3);

// Selección aleatoria de una frase
$frase_del_dia = $frases[array_rand($frases)];

// Título de la página
$titulo_pagina = "Actividades Sugeridas - PsiCalendar";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo_pagina); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 70px; /* Ajusta el espacio para el navbar fijo */
            font-family: 'Indie Flower', cursive; /* Reemplaza con la fuente utilizada en calendario.php */
            text-align: center; /* Centra el texto */
            background: url('img/fondoactividades.jpg') no-repeat center center fixed; /* Cambia la ruta a la imagen de fondo */
            background-size: cover; /* Ajusta el tamaño de la imagen para cubrir toda la página */
            color: white;
        }
        
        .navbar-brand img {
            height: 30px; /* Ajusta el tamaño del ícono */
            margin-right: 8px; /* Espacio entre el ícono y el texto */
        }
        .container {
            max-width: 800px; /* Limita el ancho del contenedor */
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
        }

        .btn {
            margin: 5px; /* Espaciado para los botones */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Ícono"> PsiCalendar </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="calendario.php">Calendario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <h2>Actividades Sugeridas para Hoy</h2>
        <br>
        <h5>Copia el link y disfruta de tu actividad</h5>
        <br>
        <ul class="list-group mb-4">
            <?php foreach ($actividades_seleccionadas as $index): ?>
                <li class="list-group-item"><?php echo htmlspecialchars($actividades[$index]); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Frase del Día</h3>
        <br><br>
        <p><?php echo htmlspecialchars($frase_del_dia); ?></p>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['mensaje']); ?></div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <br><br>
        <div class="mt-4">
            <a href="calendario.php" class="btn btn-primary">Volver al Calendario</a>
            <br>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 PsykoHacks. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
