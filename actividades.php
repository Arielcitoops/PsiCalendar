<?php
require_once "config.php";
require_once "functions.php";

check_login();

$actividades = [
    "Meditar por 10 minutos",
    "Dar un paseo de 15 minutos",
    "Escribir 3 cosas por las que estás agradecido",
    "Llamar a un amigo o familiar",
    "Leer un capítulo de un libro"
];

$frases = [
    "La felicidad es un viaje, no un destino",
    "El éxito es la suma de pequeños esfuerzos repetidos día tras día",
    "La vida es 10% lo que te sucede y 90% cómo reaccionas a ello"
];

$actividades_seleccionadas = array_rand($actividades, 3);
$frase_del_dia = $frases[array_rand($frases)];

$titulo_pagina = "Actividades Sugeridas - PsiCalendar";
include "templates/header.php";
?>

<h2>Actividades Sugeridas para Hoy</h2>
<ul>
    <?php foreach ($actividades_seleccionadas as $index): ?>
        <li><?php echo $actividades[$index]; ?></li>
    <?php endforeach; ?>
</ul>

<h3>Frase del Día</h3>
<p><?php echo $frase_del_dia; ?></p>

<?php
if (isset($_SESSION['mensaje'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['mensaje'] . "</div>";
    unset($_SESSION['mensaje']);
}
?>

<div class="mt-4">
    <a href="calendario.php" class="btn btn-primary">Volver al Calendario</a>
    <a href="perfil.php" class="btn btn-info">Ver Perfil</a>
    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
</div>

<?php include "templates/footer.php"; ?>