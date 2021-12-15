<?php
    function register($nombre, $dia, $mes, $año, $correo, $pass){
        $con = include("database.php");
        if($con){
            if(strlen($pass) > 0){
                $query = 
                'INSERT INTO users 
                    VALUES ("%s","%s",%d,"%s",%d,"%s");
                ';
                $query = sprintf($query,$correo,md5($pass),$dia,$mes,$año,$nombre);
                $res = $con->query($query);
                if(!$res){
                    echo '<script> alert("Fallo al registrate o ya te has registrado previamente");</script>';
                }else{
                    header('location: login.php?status_login="success"');
                }
                
            }
            
            $con->close();
        }
    }
    
    
?>