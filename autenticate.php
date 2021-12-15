<?php
    function autenticar($email, $password){
        $con = include("database.php");
        if($con){
            $email = stripcslashes($email);
            $password = stripslashes($password);
            $sql = "SELECT email FROM users WHERE email = '$email' AND pass = '$password';";
            $rs = $con->query($sql);
            if($rs){
                $size = mysqli_num_rows($rs);
                mysqli_free_result($rs);
                $con->close();
                if($size == 1){
                    return 200;
                }else{
                    return 400;
                }
            }else{
                return 400;
            }
        }else{
            return 404;
        }
    }
?>