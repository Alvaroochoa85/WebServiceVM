<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $bd = 'webservicevm'; 

    $conexion = @mysqli_connect($host, $user, $password, $bd);
    
    if(!$conexion){
        echo "Error en la conexion";
    }else{
        echo"conexion exitosa";
    }


?>