<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Manny Foods | Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/compras.css">
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
if(isset($_POST['action']) && isset($_POST['artn'])){
    $action = $_POST['action'];
    $articulo = $_POST['artn'];
    $con = include("database.php");
    if($con){
        $sql = "CALL ";
        switch($action){
        case "eliminar-compra":
            $sql = $sql . sprintf("ELIMINARCOMPRA('%s',%d)",$_SESSION['email'],$articulo);
            break;
        case "agregar-compra":
            $sql = $sql . sprintf("AGREGARINVENTARIO('%s',%d)",$_SESSION['email'],$articulo);
            break;
        default:
            
            break;
        }
        if(!$con->query($sql)){
            echo $sql;
        }
        
        $con->close();
    }else{
        echo 'Bad coneection';
    }
}
#Agregando productos
if (isset($_POST['departamento']) && isset($_POST['subdepartamento']) && isset($_POST['producto']) && isset($_POST['cantidad']) && isset($_POST['cantidad-minima'])) {
    $con = include("database.php");
    if ($con) {
        $sql = sprintf("CALL INSERT_COMPRA('%s',%d,%d,%d,%d,%d);", $_SESSION['email'], $_POST['departamento'], $_POST['subdepartamento'], $_POST['producto'], $_POST['cantidad'], $_POST['cantidad-minima']);
        if (!$con->query($sql)) {
            echo "<script> alert('Error al registrar producto');</script>";
        }

        $con->close();
        header("location: compras.php");
    }
}
function printProximasCompras(){
    $con = include("database.php");
    if($con){
        $sql = sprintf("CALL GETCOMPRAS('%s');",$_SESSION['email']);
        $rs = $con->query($sql);
        if($rs){
            echo '<div class="container">';
            if($rs->num_rows>0){
                echo '<table id="proximo">';
                echo '  <thead class="compras" style="background-color: #6A994E; font-weight: bold; text-align: center; color: white; border-spacing: 3em;">';
                echo '      <tr>
                                <td>
                                    Nombre
                                </td>
                                <td>
                                    Cantidad Minima
                                </td>
                                <td>
                                    Cantidad a comprar
                                </td>
                                <td>
                                    Precio por unidad
                                </td>
                                <td>
                                    Costo de compra
                                </td>
                                <td>Agregar</td>
                                <td></td>
                                <td>Eliminar</td>
                            </tr>';
                echo '  </thead>';
                echo'<tbody>';
                $count = 0;
                $total = 0.00;
                while($row = $rs->fetch_assoc()){
                    $pname = $row['nombre'];
                    $cminima = $row['cminima'];
                    $id = $row['ID'];
                    $ccomprar = $row['ccomprar'];
                    $precio = $row['precio'];
                    $pagar = round($ccomprar*$precio,2);
                    $total = round($total+$pagar,2);
                    echo "
                        <tr class='compras-row' id='prod$count'>
                            <td class='cname'>
                                $pname
                            </td>
                            <td class='cmin'>
                                $cminima unidades
                            </td>
                            <td class='ccompras'>
                                $ccomprar unidades
                            </td>
                            <td class='precio'>
                                $$precio MXN
                            </td>
                            <td class='precio'>
                                $$pagar MXN
                            </td>
                            <td>
                                <form action='compras.php' method='POST'>
                                    <input type='hidden' name='artn' value='$id'></input>
                                    <input type='hidden' name='action' value='agregar-compra'>
                                    <button type='submit' id='agregar-$count'class='btn secondary-btn' style='background-color: green; color:white;;'>Agregar al inventario</button>
                                </form>
                            </td>
                            <td>
                            </td>
                            <td>
                                <form action='compras.php' method='POST'>
                                    <input type='hidden' name='artn' value='$id'>
                                    <input type='hidden' name='action' value='eliminar-compra'>
                                    <button type='submit' id='eliminar-$count'class='btn secondary-btn' style='background-color: red; color:white;'>Eliminar de compras</button>
                                </form>
                            </td>
                        </tr>";
                        $count++;   
                }
                echo "<tfooter><tr class='compras-row'>
                    <td></td><td></td><td></td><td>Total</td><td class='precio'>$$total MXN</td>
                </tr></tfooter>";
                echo '</tbody>';
                echo '</table>';
                echo "<input id='count' type='hidden' value='$count'></input>";
            }else{
                echo '<div class="container">Sin productos en tu lista de compras</div>';
            }
            echo "</div>";
        }
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

<body>
    <br>
    <br>
    <div class="container">
        <h2>
            Agregar producto
        </h2>
        <form id="add-p" action="compras.php" method="POST">
            <div>
                <style>
                    * {
                        font-family: Roboto;

                    }

                    table {
                        overflow-x: auto;
                    }
                </style>
                <table style="text-align: center; width:100%">
                    <tr>
                        <td>
                            Departamento
                        </td>
                        <td>
                            <select name="departamento" id="dept" style="text-align:center;">
                                <option value="-1">Sin seleccionar</option>
                                <?php
                                function getDepartamento()
                                {
                                    $con = include("database.php");
                                    if ($con) {
                                        $res = $con->query("CALL GETAVAILABLEDEPARTMENTS();");
                                        if ($res) {
                                            if ($res->num_rows > 0) {
                                                while ($row = $res->fetch_assoc()) {
                                                    echo sprintf("<option value='%d'>%s</option>", $row["ID"], ($row["NOMBRE"]));
                                                }
                                            } else {
                                                echo "<option value='-3'>No hay departamentos disponibles</option>";
                                            }
                                        }
                                        $con->close();
                                    } else {
                                        echo "<option value='-2'>Bad resulset </option>";
                                    }
                                }
                                getDepartamento();
                                ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Subdepartamento
                        </td>
                        <td>
                            <select name="subdepartamento" id="sdept" style="text-align:center;">
                                <option value="-1">Sin seleccionar</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Producto
                        </td>
                        <td>
                            <select name="producto" id="producto" style="text-align: center;">
                                <option value="1">Sin seleccionar</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Cantidad a Comprar</td>
                        <td><input type="number" name="cantidad" id="cantidad-compra" min="1" max="999" value="1" style="padding: 0 28%;"></td>
                    </tr>
                    <tr>
                        <td>Cantidad Minima en Inventario</td>
                        <td><input type="number" name="cantidad-minima" id="cantidad-minima" min="1" max="999" value="1" style="padding: 0 28%;"></td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <button class="btn btn-primary" id="agregar_producto" type="submit">Agregar</button>
                        </td>
                    </tr>
                </table>

            </div>
        </form>
    </div>
    <br>
    <div class="container">
        <h2>Proximo a comprar</h2>
        <?php
           printProximasCompras(); 
        ?>
        <br>
    </div>


</body>
<script defer>
    var select_dept = document.getElementById("dept");
    var select_sub = document.getElementById("sdept");
    var select_prod = document.getElementById("producto")
    async function getSubdepartments() {
        var dept = select_dept.options[select_dept.selectedIndex].text;
        URL = "http://192.168.100.28/curso/ManyFoods/api.php?action=getsubdepartments" + "&department=" + dept;
        const respuesta = await fetch(URL)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return "FAILURE";
                }
            })
            .catch(error => alert(error))
        var size = select_sub.childNodes.length
        for (var i = 0; i < size; i++) {
            select_sub.removeChild(select_sub.lastChild)
        }
        var size = select_prod.childNodes.length
        for (var i = 0; i < size; i++) {
            select_prod.removeChild(select_prod.lastChild)
        }
        var new_option = document.createElement('option');
        new_option.value = "-1";
        new_option.text = "Selecciona una opcion";
        var new_option2 = document.createElement('option');
        new_option2.value = "-1";
        new_option2.text = "Selecciona una opcion";
        if (respuesta.sub != undefined) {
            select_sub.appendChild(new_option)
            select_prod.appendChild(new_option2)
            let array = respuesta.sub;
            for (var key in array) {
                var new_option = document.createElement('option');
                new_option.value = key;
                new_option.text = array[key];
                select_sub.appendChild(new_option)
            }
        }
    }
    async function getProducts() {
        var dept = select_dept.options[select_dept.selectedIndex].text;
        var sdept = select_sub.options[select_sub.selectedIndex].text;
        URL = "http://192.168.100.28/curso/ManyFoods/api.php?action=getProducts" + "&department=" + dept + "&subdepartment=" + sdept;
        const respuesta = await fetch(URL)
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    alert("Error en la llamada de productos")
                }
            })
            .catch(error => {
                alert(error);
                return "No se obtuvieron resultados";
            });
        if (respuesta != "No se obtuvieron resultados") {
            let array = respuesta.products
            var size = select_prod.childNodes.length
            for (var i = 0; i < size; i++) {
                select_prod.removeChild(select_prod.lastChild)
            }
            var new_option = document.createElement('option');
            new_option.value = "-1";
            new_option.text = "Selecciona una opcion";
            select_prod.appendChild(new_option)
            if (respuesta.products != undefined) {
                select_prod.appendChild(new_option)
                let array = respuesta.products;
                for (var key in array) {
                    console.log(key);
                }
                for (var key in array) {
                    var new_option = document.createElement('option');
                    new_option.value = array[key][0];
                    new_option.text = array[key][1];
                    select_prod.appendChild(new_option)
                }
            }
        } else {
            alert(respuesta)
        }


    }
    document.getElementById("dept").onchange = () => {
        getSubdepartments()
    }
    document.getElementById("sdept").onchange = () => {
        getProducts()
    }
</script>
<script defer>
    document.getElementById("add-p").onsubmit = () => {
        if (document.getElementById("dept").value > -1 && document.getElementById("sdept").value > -1 && document.getElementById("producto").value > -1) {
            return true;
        } else {
            if (document.getElementById("dept").value == -1) {
                alert("Agregue un departamento")
            } else {
                if (document.getElementById("sdept").value == -1) {
                    alert("Agregue un subdepartamento")
                } else {
                    if (document.getElementById("producto").value == -1) {
                        alert("Seleccione un producto")
                    }
                }
            }

            return false;
        }
    }
</script>
</html>