<?php
    $url = 'localhost:3300';
    $user = 'root';
    $database_password = "";
    $db = "manyfoods";
    $conexion = mysqli_connect($url,$user,$database_password,$db);
    if($conexion->connect_error){
        return null;
    }
    return $conexion;
?>