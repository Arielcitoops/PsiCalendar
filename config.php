<?php

/* Establecimiento de Conexion a la Base de Datos*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'bdd_psicalendar');

/* Variable de conexion */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

/* Variante si encuentra un error en la conexion */
if($conn === false){
    print_r("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
