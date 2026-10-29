<?php
/*Obtener informacion para prevenir cruce de datos */
require_once "config.php";
require_once "functions.php";
require_once "validaciones.php"; 

/*Llamada a la funcion del nombre del titulo */
$titulo_pagina = "Registro - PsiCalendar";

/*Funcionalidad de registro a la bdd*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    /*Funcionalidad de hash a la contraseña para que no se vea reflejada en la bdd*/
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    /*Llamada a la sentencia sql que crea al usuario*/
    $sql = "INSERT INTO usuarios (nombre, correo, usuario, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $usuario, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        /*En caso de error de conexion a la bdd*/
        $error = "Error al registrar el usuario.";
    }
}
?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
<style>
    body{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 0px;
        padding: 0px;
        height: 700px;
        background-image: url('img/5273.jpg');
        background-size: cover;
        font-family: 'Indie Flower';
    }

    .form{
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 45px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        width: 300px;
        text-align: center;
        margin-bottom: 75px;
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

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }
    </style>
</div>
<div id="calendar"></div>
<!-- Inicio del codigo HTML -->
<h2>Bienvenido al Registro de PsiCalendar</h1>
<h2>Nos alegra que te quieras unir a esta familia</h1>
<form method="post" action="" class="form">
    <h2>Registro de Usuario</h2>
    <!-- Inicio del Formulario Front -->
    <div class="form-group">
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
    </div>
    <div class="form-group">
        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electronico" required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
    </div>
    <div class="form-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
    </div>
    <br><br>
    <button type="submit" class="btn-primary">Registrarse</button>
</form>
