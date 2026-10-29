<?php
session_start();

/*Funcion Revision de Login , agarrando informacion de login.php*/
function check_login() {
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}
/*Funcion obtener id de la base de datos para ingreso/salida de datos*/
function get_user_id() {
    return isset($_SESSION["id"]) ? $_SESSION["id"] : null;
}

/*Funcion obtencion de los datos de la base de datos para ingreso/salida de datos*/
function get_usuario_info($conn, $usuario_id) {
    $sql = "SELECT nombre, correo, usuario FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

/*Funcion de logout*/
function redirigirSiNoLogueado() {
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}

function get_user_name($user_id) {
    global $conn; // Asumiendo que $conn es tu conexión a la base de datos

    $sql = "SELECT nombre FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombre);
    
    if (mysqli_stmt_fetch($stmt)) {
        return $nombre;
    } else {
        return false; // Si no se encuentra el usuario
    }

    mysqli_stmt_close($stmt);
}

?>
