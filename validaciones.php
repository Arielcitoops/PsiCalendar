<?php
// validaciones.php

/*Archivo mas importante sin esto no funciona nada*/

/*Funcion Validacion de data*/
function validarDatos($datos, $reglas) {
    $errores = [];
    /*Funcion para evitar campos vacios*/
    foreach ($reglas as $campo => $regla) {
        if (!isset($datos[$campo]) || empty($datos[$campo])) {
            $errores[$campo] = "El campo $campo es requerido.";
        } else {
            $valor = trim($datos[$campo]);
            /*Funcion el correo ya existe o no esta registrado*/
            switch ($regla) {
                case 'email':
                    if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                        $errores[$campo] = "El correo electrónico no es válido.";
                    }
                    break;
                    /*Funcion el nombre debe contener solo letras y espacios*/
                case 'nombre':
                    if (!preg_match("/^[a-zA-Z ]*$/", $valor)) {
                        $errores[$campo] = "El nombre solo puede contener letras y espacios.";
                    }
                    break;
                case 'usuario':
                    /*Funcion el usuario puede contener letras , numeros y guionesbajos para evitar errores en sql*/
                    if (!preg_match("/^[a-zA-Z0-9_]*$/", $valor)) {
                        $errores[$campo] = "El usuario solo puede contener letras, números y guiones bajos.";
                    }
                    break;
                case 'password':
                    /*Funcion contraseña debe tener al menos 8 caracteres*/
                    if (strlen($valor) < 8) {
                        $errores[$campo] = "La contraseña debe tener al menos 8 caracteres.";
                    }
                    break;
                case 'fecha':
                    /*Funcion fecha debe entregarse al sql en este formato*/
                    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $valor)) {
                        $errores[$campo] = "La fecha debe estar en formato YYYY-MM-DD.";
                    }
                    break;
                    /* Funcion emocion prevencion de exploit/bugs */
                case 'emocion':
                    $emociones_validas = ['alegre', 'triste', 'enojado', 'cansado'];
                    if (!in_array($valor, $emociones_validas)) {
                        $errores[$campo] = "La emoción no es válida.";
                    }
                    break;
                    /* Funcion intensidad prevencion de exploit/bugs */
                case 'intensidad':
                    if (!is_numeric($valor) || $valor < 1 || $valor > 3) {
                        $errores[$campo] = "La intensidad debe ser un número entre 1 y 3.";
                    }
                    break;
            }
        }
    }
    return $errores;
}