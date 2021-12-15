<?php
    session_start();
    if($_SESSION){
        if(isset($_SESSION['uiid'])){
            session_destroy();
        }
        header("location: login.php");
    }else{
        header("location: login.php");
    }

    
?>