<?php
require_once "config.php";
require_once "functions.php";
require_once "validaciones.php";

check_login();
$user_id = get_user_id();

$titulo_pagina = "Registro Diario - PsiCalendar";

$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$es_fecha_futura = strtotime($fecha) > strtotime(date('Y-m-d'));

$registro_existente = null;
$sql = "SELECT * FROM registros_diarios WHERE usuario_id = ? AND fecha = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $user_id, $fecha);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $registro_existente = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$es_fecha_futura) {
    $emocion = $_POST['emocion'];
    $intensidad = $_POST['intensidad'];
    $anecdota = $_POST['anecdota'];

    $errores = validarDatos($_POST, [
        'emocion' => 'required',
        'intensidad' => 'required|numeric|min:1|max:3',
        'anecdota' => 'required'
    ]);

    if (empty($errores)) {
        if ($registro_existente) {
            $sql = "UPDATE registros_diarios SET emocion = ?, intensidad = ?, anecdota = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sisi", $emocion, $intensidad, $anecdota, $registro_existente['id']);
        } else {
            $sql = "INSERT INTO registros_diarios (usuario_id, fecha, emocion, intensidad, anecdota) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "issis", $user_id, $fecha, $emocion, $intensidad, $anecdota);
        }

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje'] = "Registro guardado con éxito.";
            header("Location: actividades.php");
            exit();
        } else {
            $error_mensaje = "Error al guardar el registro.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <style>
        body {
            background-image: url('img/fondoregistrodiario.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            min-height: 100vh;
        }
        .navbar {
            padding: 15px 0;
            background-color: #343a40; /* Color de fondo oscuro */
        }
        .navbar-brand {
            font-size: 24px;
            font-family: 'Indie Flower';
            color: #ffffff; /* Color del texto blanco */
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 40px; /* Ajusta el tamaño del ícono */
            margin-right: 8px; /* Espacio entre el ícono y el texto */
        }
        .navbar-nav .nav-link {
            color: #ffffff !important; /* Color de los enlaces blancos */
        }
        .navbar-nav .nav-link:hover {
            color: #adb5bd !important; /* Color de los enlaces al pasar el ratón */
        }
        .container {
            text-align: center;
            margin-top: 20px;
        }
        h2 {
            font-family: 'Indie Flower', cursive;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 400px;
            margin: 0 auto;
        }
        .form-group {
            width: 100%;
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            font-size: 16px;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 20px;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Agregar ícono local -->
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Ícono"> PsiCalendar
            </a>
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

    <div class="container">
        <h2>Registro Diario - <?php echo $fecha; ?></h2>

        <?php if (isset($error_mensaje)): ?>
            <div class="alert alert-danger"><?php echo $error_mensaje; ?></div>
        <?php endif; ?>

        <?php if ($es_fecha_futura): ?>
            <div class="alert alert-warning">No puedes registrar emociones para fechas futuras.</div>
        <?php elseif ($registro_existente): ?>
            <form method="post" class="form-container">
                <div class="form-group">
                    <label for="emocion">Emoción:</label>
                    <select class="form-control" id="emocion" name="emocion" required>
                        <option value="alegre" <?php echo $registro_existente['emocion'] == 'alegre' ? 'selected' : ''; ?>>Alegre</option>
                        <option value="triste" <?php echo $registro_existente['emocion'] == 'triste' ? 'selected' : ''; ?>>Triste</option>
                        <option value="enojado" <?php echo $registro_existente['emocion'] == 'enojado' ? 'selected' : ''; ?>>Enojado</option>
                        <option value="cansado" <?php echo $registro_existente['emocion'] == 'cansado' ? 'selected' : ''; ?>>Cansado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="intensidad">Elije tu nivel de emoción (1-3) Alto-Medio-Bajo :</label>
                    <input type="number" class="form-control" id="intensidad" name="intensidad" min="1" max="3" value="<?php echo $registro_existente['intensidad']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="anecdota">Anécdota del día:</label>
                    <textarea class="form-control" id="anecdota" name="anecdota" rows="3" required><?php echo $registro_existente['anecdota']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Registro</button>
            </form>
        <?php else: ?>
            <form method="post" class="form-container">
                <div class="form-group">
                    <label for="emocion">Elije tu emoción:</label>
                    <select class="form-control" id="emocion" name="emocion" required>
                        <option value="alegre">Alegre</option>
                        <option value="triste">Triste</option>
                        <option value="enojado">Enojado</option>
                        <option value="cansado">Cansado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="intensidad">Elije tu nivel de emoción (1-3) Alto-Medio-Bajo :</label>
                    <input type="number" class="form-control" id="intensidad" name="intensidad" min="1" max="3" required>
                </div>
                <div class="form-group">
                    <label for="anecdota">Escribe tu Anécdota del día:</label>
                    <textarea class="form-control" id="anecdota" name="anecdota" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Registro</button>
            </form>
        <?php endif; ?>

        <br>
        <div class="mt-3">
            <a href="calendario.php" class="btn btn-secondary">Volver al Calendario</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 PsykoHacks. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
