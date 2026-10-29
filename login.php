<?php
/* Solicita la configuracion determinada en config.php */
require_once "config.php";
/* Solicita la configuracion determinada en functions.php */
require_once "functions.php";

/* Solicita la informacion que ya esta almacenada en la BDD */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* Variable Usuario */
    $username = trim($_POST["usuario"]);
    /* Variable Contraseña */
    $password = trim($_POST["password"]);

    /* Sentencia SQL para validar datos en la BDD */
    $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = ?";

    /* Condiciones para inicio de sesión */
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        /* Condicionantes de validacion de datos */
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // Contraseña correcta, iniciar sesión
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("location: calendario.php");
                        exit;
                    } else {
                        /* Mensaje de alerta de usuario o contraseña incorrectos */
                        $login_err = "Usuario o contraseña incorrectos.";
                    }
                }
            } else {
                /* Mensaje de alerta de usuario o contraseña incorrectos */
                $login_err = "Usuario o contraseña incorrectos.";
            }
        } else {
            /* Mensaje de alerta de error con la conexion a la BDD */
            echo "Oops! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
        }

        mysqli_stmt_close($stmt);
    } else {
        /* Mensaje de alerta de error con la conexion a la BDD */
        echo "No se pudo preparar la consulta SQL.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <title>Iniciar Sesión - PsiCalendar</title>
</head>
<style>
    body{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    margin: 0px;
    padding: 0px;
    height: 700px;
    background-image: url('img/3746496.jpg');
    background-size: cover;
    font-family: 'Indie Flower';
    }

    .icono{
    width: 57px;
    height: 50px;
    background-image: url('img/ico.svg');
    background-size: cover;
    }

    h1{    
    font-size: 3rem;
    margin: 50px 0px;
    }

    label{
    margin: 11px;
    }

    .formulario-login{
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 45px;
    border: 2px solid;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    width: 300px;
    text-align: center;
    color: #000000;
    }

    .form-group {
    margin-bottom: 15px;
    }

    .form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: none;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: #000000;
    }

    .btn-login {
    background-color: #007bff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    width: 100%;
    }

    .btn-login:hover {
    background-color: #0056b3;
    }

    .btn-secondary {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: rgba(0, 81, 255, 0.2);
    border: none;
    border-radius: 5px;
    color: #000000;
    cursor: pointer;
    text-decoration: none;
    }

    .btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.4);
    }
</style>
<body>
    <div class="container_principal">
        <div class="encabez">
            <h1 class="titulo-login">Bienvenido a PsiCalendar</h1>
        </div>
    </div>

    <?php
    /* Evitar dialogos vacios */
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger alerta-login">' . $login_err . '</div>';
    }
    ?>
    <div class="credenciales">
        
        <form method="post" action="" class="formulario-login">
            <div class="icono">
                
            </div>
            <h4 class="titulo-login">Ingrese sus creedenciales</h4>
            <div class="form-group">
                <input type="text" class="form-control" id="input-usuario" placeholder="Usuario" name="usuario" required >
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="input-password" placeholder="Contraseña" name="password" required>
            </div>
            <button type="submit" class="btn-login">Iniciar Sesión</button>
            <label for="input-password">O Registrate Gratis Aqui Abajo </label>
            <a href="registro.php" class="btn btn-secondary">Registrarse</a>
        </form>
    </div>


    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 PsykoHacks. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
