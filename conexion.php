<?php

$server = "localhost";
$dbuser = "jassoft_politic";
$dbpwd = "rG7WXtEewQMXYD9W";
$db = "politic";


$conexion = new mysqli($server, $dbuser, $dbpwd, $db) or die("No se pudo realizar la conexion con el servidor.");

if ($conexion->connect_errno) {

    echo "Lo sentimos, este sitio web está experimentando problemas.";

    // Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
    // de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
    echo "Error: Fallo al conectarse a MySQL debido a: </br>";
    echo "Err no: " . $conexion->connect_errno . "</br>";
    echo "Error: " . $conexion->connect_error . "</br>";

    // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
    exit;
}
?>
