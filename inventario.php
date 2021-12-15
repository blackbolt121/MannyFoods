<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Manny Foods | Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">
</head>

<body>
    <?php
    function set($name){
        if(isset($_POST[$name])){
            return $_POST[$name];
        }
        return null;
    }
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
    
    if(($id = set("id-producto")) && ($accion = set("accion")) && ($cantidad = set("change"))){
        $email = $_SESSION['email'];
        $query = "CALL ELIMINAR_EXISTENCIA('$email',$id,$cantidad)";
        if(($con = include("database.php"))){
            if((!$rs = $con->query($query))){

            }
            $con->close();
        }
    }
    
    ?>
    <header>
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
    <div class="container">
        <br>
        <br>
        <?php
            $con = include("database.php");
            if($con){
                $email = $_SESSION['email'];
                $sql = "SELECT * FROM INVENTARIO WHERE USUARIO = '$email';";
                $rs = $con->query($sql);
                if(($rs->num_rows>0)){
                    echo "<table class='container'>
                            <h1> Productos en tu inventario </h1>
                            <br>
                            <thead style='font-weight:bold; background-color:#6A994E; text-align:center; color:white;'>
                                <tr>
                                    <td>
                                        Nombre Producto
                                    </td>
                                    <td>
                                        En inventario
                                    </td>
                                    <td>
                                        Cantidad Minima
                                    </td>
                                    <td colspan='3'>
                                        Cantidad a reducir
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                    ";
                    $n = 0;
                    while($row = $rs->fetch_assoc()){
                        $nombre = $row['NOMBRE'];
                        $existencias = $row['CANTIDAD'];
                        $min = $row['CANTIDAD_MINIMA'];
                        $id = $row['ID_PRODUCTO'];
                        echo "
                                <tr>
                                    <td style='text-align: center'>
                                        $nombre
                                    </td>
                                    <td style='text-align: center'>
                                        $existencias
                                    </td>
                                    <td style='text-align: center'>
                                        $min
                                    </td>
                                    <td style='text-align: center'>
                                        <button class='btn btn-danger' id='less$n'><i class=\"fas fa-minus\"></i></button> 
                                        <input type='number' value='1' id='cantidad-$n' min=1 max=$existencias>
                                        <input type='hidden' value=$existencias id='max-cant-$n'>
                                        <button class='btn btn-success' id='plus$n'><i class=\"fas fa-plus\"></i></button>
                                        <form action='inventario.php' method='POST'>
                                            <input type='hidden' value='$id' name='id-producto'>
                                            <input type='hidden' value='reducir' name='accion'>
                                            <input type='hidden' value='1' name='change' id='change-$n'>
                                            </td>
                                            <td style='text-align: center'>
                                                <button class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i> Eliminar</button>
                                            </td>
                                        </form>
                                <tr>";
                                $n++;
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "<input type='hidden' id='size' value='$n'>";
                }else{
                    echo '<h2 style="text-align:center">No hay nada que mostrar :(</h2>';
                    echo '<a class="btn btn-primary" style="background-color: #085F92; color: white;" href="compras.php"> Añadir productos para comprar </a>';
                }
                $con->close();
            }
        ?>
        
    </div>

</body>
    <script defer>
        let n = document.getElementById('size').value;
        let less = []
        let plus = []
        let cantidad = []
        let max_cant = []
        for(let i = 0; i<n; i++){
            less.push(document.getElementById('less'+i));
            plus.push(document.getElementById('plus'+i));
            cantidad.push(document.getElementById('cantidad-'+i))
            max_cant.push(document.getElementById('max-cant-'+i))
        }
        for(let i = 0; i<n; i++){
            less[i].onclick = () => {
                if(cantidad[i].value>1)
                    cantidad[i].value = cantidad[i].value - 1;
                document.getElementById("change-"+i).value = cantidad[i].value;
            }
            plus[i].onclick = () => {
                if(parseInt(max_cant[i].value) > cantidad[i].value)
                    cantidad[i].value = parseInt(cantidad[i].value) + 1;
                document.getElementById("change-"+i).value = cantidad[i].value;
            }
        }
    </script>

</html>