<?php
// validaciones.php

function validarDatos($datos, $reglas) {
    $errores = [];
    foreach ($reglas as $campo => $regla) {
        if (!isset($datos[$campo]) || empty($datos[$campo])) {
            $errores[$campo] = "El campo $campo es requerido.";
        } else {
            $valor = trim($datos[$campo]);
            switch ($regla) {
                case 'email':
                    if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                        $errores[$campo] = "El correo electrónico no es válido.";
                    }
                    break;
                case 'nombre':
                    if (!preg_match("/^[a-zA-Z ]*$/", $valor)) {
                        $errores[$campo] = "El nombre solo puede contener letras y espacios.";
                    }
                    break;
                case 'usuario':
                    if (!preg_match("/^[a-zA-Z0-9_]*$/", $valor)) {
                        $errores[$campo] = "El usuario solo puede contener letras, números y guiones bajos.";
                    }
                    break;
                case 'password':
                    if (strlen($valor) < 8) {
                        $errores[$campo] = "La contraseña debe tener al menos 8 caracteres.";
                    }
                    break;
                case 'fecha':
                    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $valor)) {
                        $errores[$campo] = "La fecha debe estar en formato YYYY-MM-DD.";
                    }
                    break;
                case 'emocion':
                    $emociones_validas = ['alegre', 'triste', 'enojado', 'cansado'];
                    if (!in_array($valor, $emociones_validas)) {
                        $errores[$campo] = "La emoción no es válida.";
                    }
                    break;
                case 'intensidad':
                    if (!is_numeric($valor) || $valor < 1 || $valor > 10) {
                        $errores[$campo] = "La intensidad debe ser un número entre 1 y 10.";
                    }
                    break;
            }
        }
    }
    return $errores;
}