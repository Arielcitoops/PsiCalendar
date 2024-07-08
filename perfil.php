<?php
require_once "config.php";
require_once "functions.php";

redirigirSiNoLogueado();

$usuario_id = get_user_id();
$mensaje = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    if (actualizar_perfil($conn, $nombre, $correo, $usuario_id)) {
        $mensaje = "Perfil actualizado con éxito.";
    } else {
        $error = "Error al actualizar el perfil.";
    }
}

$usuario = get_usuario_info($conn, $usuario_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil - PsiCalendar</title>
</head>
<body>
    <h2>Perfil de Usuario</h2>
    <?php if (!empty($mensaje)): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>
        <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br>
        <p>Usuario: <?php echo htmlspecialchars($usuario['usuario']); ?></p>
        <input type="submit" value="Actualizar Perfil">
    </form>
</body>
</html>
