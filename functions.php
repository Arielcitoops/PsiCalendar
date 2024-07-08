<?php
session_start();

function check_login() {
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}

function get_user_id() {
    return isset($_SESSION["id"]) ? $_SESSION["id"] : null;
}

function get_usuario_info($conn, $usuario_id) {
    $sql = "SELECT nombre, correo, usuario FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

function actualizar_perfil($conn, $nombre, $correo, $usuario_id) {
    $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $correo, $usuario_id);
    return $stmt->execute();
}

function redirigirSiNoLogueado() {
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}


?>
