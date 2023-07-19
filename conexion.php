<?php
ob_start(); // Inicia el búfer de salida

$host = 'localhost';
$user = 'root';
$password = '';
$bd = 'webservicevm'; 

$conexion = @mysqli_connect($host, $user, $password, $bd);

if (!$conexion) {
    echo "Error en la conexión";
} else {
    echo "Conexión exitosa";
}

ob_end_clean(); // Limpia el búfer de salida sin enviarlo al navegador
?>
