<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Manny Foods</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">
</head>

<body>
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
    <header>
    <nav class="navbar navbar-expand-lg" style="background-color: #6A994E;">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="index.php"><img src="./images/cropped-favicon-2.png" style="width:50px;"></a></li>
            <li class="nav-item"><a class="nav-link" href="dashboard.php" style="color: white; font-weight: bolder;"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="inventario.php" style="color: white; font-weight: bolder;"><i class="fas fa-warehouse"></i> Mi inventario</a></li>
            <li class="nav-item"><a class="nav-link" href="compras.php" style="color: white; font-weight: bolder;"><i class="fas fa-shopping-cart"></i> Mis proximas compras</a></li>
            <li class="nav-item"><a class="nav-link" href="exit.php" style="color: white; font-weight: bolder;"><i class="fas fa-sign-out-alt"></i> Cerrar Sesion</a></li>
        </ul>
    </nav>
    </header>
    

</body>

</html>