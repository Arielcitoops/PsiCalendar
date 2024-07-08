<?php
require_once "config.php";
require_once "functions.php";
check_login();

$user_id = get_user_id();

// Obtener eventos desde la base de datos
$sql = "SELECT * FROM registros_diarios WHERE usuario_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$eventos = array();
while ($row = mysqli_fetch_assoc($result)) {
    $color = array(
        'alegre' => '#FFFF00',
        'triste' => '#0000FF',
        'cansado' => '#00FF00',
        'enojado' => '#FF0000'
    )[$row['emocion']] ?? '#FFFFFF';

    $eventos[] = array(
        'title' => ucfirst($row['emocion']),
        'start' => $row['fecha'],
        'color' => $color,
        'extendedProps' => array(
            'emocion' => $row['emocion'],
            'intensidad' => $row['intensidad'],
            'anecdota' => $row['anecdota']
        )
    );
}

$titulo_pagina = "Calendario - PsiCalendar";
include "templates/header.php";
?>

<div id="calendar"></div>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo json_encode($eventos); ?>,
        eventClick: function(info) {
            var clickedDate = info.event.start;
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);

            if (clickedDate <= currentDate) {
                var fecha = info.event.startStr;
                window.location.href = '/PsiCalendarvPHP/registro_diario.php?fecha=' + fecha;
            } else {
                alert('No puedes registrar emociones para fechas futuras.');
            }
        },
        dateClick: function(info) {
            var clickedDate = new Date(info.dateStr);
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);

            if (clickedDate <= currentDate) {
                window.location.href = '/PsiCalendarvPHP/registro_diario.php?fecha=' + info.dateStr;
            } else {
                alert('No puedes registrar emociones para fechas futuras.');
            }
        }
    });
    calendar.render();
});
</script>

<?php include "templates/footer.php"; ?>