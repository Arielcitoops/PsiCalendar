<?php
require_once "config.php";
require_once "functions.php";
require_once "validaciones.php";

check_login();
$user_id = get_user_id();

$titulo_pagina = "Registro Diario - PsiCalendar";
include "templates/header.php";

// Obtener la fecha del parámetro GET o usar la fecha actual
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

// Verificar si la fecha es futura
$es_fecha_futura = strtotime($fecha) > strtotime(date('Y-m-d'));

// Obtener el registro existente para esta fecha, si existe
$registro_existente = null;
$sql = "SELECT * FROM registros_diarios WHERE usuario_id = ? AND fecha = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $user_id, $fecha);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $registro_existente = $row;
}

// Procesar el formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$es_fecha_futura) {
    $emocion = $_POST['emocion'];
    $intensidad = $_POST['intensidad'];
    $anecdota = $_POST['anecdota'];

    $errores = validarDatos($_POST, [
        'emocion' => 'required',
        'intensidad' => 'required|numeric|min:1|max:10',
        'anecdota' => 'required'
    ]);

    if (empty($errores)) {
        if ($registro_existente) {
            // Actualizar registro existente
            $sql = "UPDATE registros_diarios SET emocion = ?, intensidad = ?, anecdota = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sisi", $emocion, $intensidad, $anecdota, $registro_existente['id']);
        } else {
            // Insertar nuevo registro
            $sql = "INSERT INTO registros_diarios (usuario_id, fecha, emocion, intensidad, anecdota) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "issis", $user_id, $fecha, $emocion, $intensidad, $anecdota);
        }

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensaje'] = "Registro guardado con éxito.";
            header("Location: actividades.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al guardar el registro.</div>";
        }
    } else {
        foreach ($errores as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<h2>Registro Diario - <?php echo $fecha; ?></h2>

<?php if ($es_fecha_futura): ?>
    <div class="alert alert-warning">No puedes registrar emociones para fechas futuras.</div>
<?php elseif ($registro_existente): ?>
    <form method="post">
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
            <label for="intensidad">Intensidad (1-10):</label>
            <input type="number" class="form-control" id="intensidad" name="intensidad" min="1" max="10" value="<?php echo $registro_existente['intensidad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="anecdota">Anécdota del día:</label>
            <textarea class="form-control" id="anecdota" name="anecdota" rows="3" required><?php echo $registro_existente['anecdota']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Registro</button>
    </form>
<?php else: ?>
    <form method="post">
        <div class="form-group">
            <label for="emocion">Emoción:</label>
            <select class="form-control" id="emocion" name="emocion" required>
                <option value="alegre">Alegre</option>
                <option value="triste">Triste</option>
                <option value="enojado">Enojado</option>
                <option value="cansado">Cansado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="intensidad">Intensidad (1-10):</label>
            <input type="number" class="form-control" id="intensidad" name="intensidad" min="1" max="10" required>
        </div>
        <div class="form-group">
            <label for="anecdota">Anécdota del día:</label>
            <textarea class="form-control" id="anecdota" name="anecdota" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Registro</button>
    </form>
<?php endif; ?>

<div class="mt-3">
    <a href="calendario.php" class="btn btn-secondary">Volver al Calendario</a>
</div>

<?php include "templates/footer.php"; ?>