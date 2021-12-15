<!DOCTYPE html>
<html lang="es">
<style>
    *{
        font-family: Roboto;
    }
</style>

<head>
    <meta charset="UTF-8">
    <title>Manny Foods</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">
</head>

<?php
session_start();
if ($_SESSION) {
    if (isset($_SESSION['uiid'])) {
        $uiid = $_SESSION['uiid'];
    } else {
        header("location: login.php");
    }
} else {
    header("location: login.php");
}
?>
<header style="align-items:flex-end">
    <nav class="navbar navbar-expand-lg" style="background-color: #6A994E;">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><img src="./images/cropped-favicon-2.png" style="width:50px;"></a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard.php" style="color: white; font-weight: bolder;"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="inventario.php" style="color: white; font-weight: bolder;"><i class="fas fa-warehouse"></i> Mi inventario</a></li>
            <li class="nav-item"><a class="nav-link" href="compras.php" style="color: white; font-weight: bolder;"><i class="fas fa-shopping-cart"></i> Mis proximas compras</a></li>
            <li class="nav-item"><a class="nav-link" href="exit.php" style="color: white; font-weight: bolder;"><i class="fas fa-sign-out-alt"></i> Cerrar Sesion</a></li>
        </ul>
    </nav>
</header>

<body>
    <div class='container'>
        <p style="font-size: 2.5em; text-align: center; padding-top: 1em;">
            <?php
            echo sprintf("<em>Bienvenid@ <strong>%s</strong></em>", $_SESSION['name']);
            ?>
        </p>
    </div>
    <div class="container" style="background-color: #6A994E; border-radius: 1em; padding: 0.5em;">
        <p style="text-align: center; font-size: 2em; font-weight: bolder; color:white;">
            Productos con mayor existencia
        </p>
        <table class="table table-bordered top-5-products">
            <style>
                .thead-dark {
                    background-color: darkslategrey;
                    color: white;
                    text-align: center;
                }

                .top-5-products {
                    border-color: gray;
                    border-spacing: 5px;
                    background-color: white;
                }
            </style>
            <thead class="thead-dark">
                <tr>
                    <td>Nombre</td>
                    <td>Cantidad</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $con = include('database.php');
                    if($con){
                        $email = $_SESSION['email'];
                        $query = "SELECT NOMBRE, CANTIDAD FROM inventario WHERE USUARIO = '$email' ORDER BY CANTIDAD DESC LIMIT 5";
                        if(($rs = $con->query($query))){
                            if($rs->num_rows > 0){
                                while($row = $rs->fetch_assoc()){
                                    $nombre = $row['NOMBRE'];
                                    $cantidad = $row['CANTIDAD'];
                                    echo "<tr><td>$nombre</td><td>$cantidad</td></tr>";
                                }
                            }else{
                                echo '<tr><td colspan="2" style="text-align: center;">No hay productos en su inventario</tr>';
                            }
                        }

                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container" style="background-color: #6A994E; border-radius: 1em; padding: 0.5em; margin-top: 1em;">
        <p style="text-align: center; font-size: 2em; font-weight: bolder; color: white;">
            Productos con menor existencia
        </p>
        <table class="table table-bordered top-5-products">
            <style>
                .thead-dark {
                    background-color: darkslategrey;
                    color: white;
                    text-align: center;
                }

                .top-5-products {
                    border-color: gray;
                    border-spacing: 5px;
                    background-color: white;
                }
            </style>
            <thead class="thead-dark">
                <tr>
                    <td>Nombre</td>
                    <td>Cantidad</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $con = include("database.php");
                    if($con){
                        $query = sprintf("SELECT NOMBRE, CANTIDAD FROM INVENTARIO WHERE USUARIO = '%s' ORDER BY CANTIDAD ASC LIMIT 5;",$_SESSION['email']);
                        #echo $query;
                        if($rs = $con->query($query)){
                            if($rs->num_rows){
                                while($row = $rs->fetch_assoc()){
                                    $nombre = $row['NOMBRE'];
                                    $cantidad = $row['CANTIDAD'];
                                    echo "
                                        <tr>
                                            <td>
                                                $nombre
                                            </td>
                                            <td>
                                                $cantidad
                                            </td>
                                        </tr>
                                        ";
                                }
                            }else{
                                echo '<tr><td colspan="2" style="text-align: center;">No hay productos en su inventario</tr>';
                            }

                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>