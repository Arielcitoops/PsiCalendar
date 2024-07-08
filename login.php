<?php
/* Solicita la configuracion determinada en config.php */
require_once "config.php";
/* Solicita la configuracion determinada en functions.php */
require_once "functions.php";

/* Solicita la informacion que ya esta almacenada en la BDD  */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    /* Variable Usuario  */
    $username = trim($_POST["usuario"]);
    /* Variable Contraseña */
    $password = trim($_POST["password"]);
    
    /* Sentencia SQL para validar datos en la BDD */
    $sql = "SELECT id, usuario, password FROM usuarios WHERE usuario = ?";
    
    /* Condiciones para inicio de sesión */
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        
        /*Condicionantes de validacion de datos */
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        // Contraseña correcta, iniciar sesión
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;                            
                        
                        header("location: calendario.php");
                        exit;
                    } else{
                        /* Mensaje de alerta de usuario o contraseña incorrectos */
                        $login_err = "Usuario o contraseña incorrectos.";
                    }
                }
            } else{
                /* Mensaje de alerta de usuario o contraseña incorrectos */
                $login_err = "Usuario o contraseña incorrectos.";
            }
        } else{
            /* Mensaje de alerta de error con la conexion a la BDD */
            echo "Oops! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
        }

        mysqli_stmt_close($stmt);
    } else {
        /* Mensaje de alerta de error con la conexion a la BDD */
        echo "No se pudo preparar la consulta SQL.";
    }
}

include "templates/header.php";
/* Inicio del Codigo de HTML */
?>

<h2>Iniciar Sesión</h2>
<?php
/* Evitar dialogos vacios */
if(!empty($login_err)){
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
}

/* Inicio de los Formularios de Usuario y Contraseña */
?>
<form method="post" action="">
    <div class="form-group">
        <label for="usuario">Usuario:</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required>
    </div>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
</form>

<?php include "templates/footer.php"; ?>
