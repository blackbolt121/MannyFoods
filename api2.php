<?php
#$_POST = apache_request_headers();
$method = $_SERVER["REQUEST_METHOD"];
$info = [];
function post($id)
{
    return isset($_POST[$id]);
}
function new_product($departamento, $subdepartamento, $nombre, $precio)
{
    $sql = "CALL INSERT_PRODUCT('$nombre','$departamento','$subdepartamento',$precio);";
    $con = include('database.php');
    if ($con) {
        $query = $con->query($sql);
        if (!$query) {
            return 408;
        }
        $con->close();
        return 210;
    }
}
function getsubbydept($dept)
{
    $sql = "CALL GETSUBBYDEPT('$dept');";
    $con = include('database.php');
    if ($con) {
        $info['sql'] = $sql;
        $resultset = $con->query($sql);
        $subdepts = [];
        if ($resultset->num_rows > 0) {

            while ($row = $resultset->fetch_assoc()) {
                $subdepts[intval($row['ID'])] = $row['NOMBRE'];
            }
        }
        $con->close();
        return $subdepts;
    }
    return [];
}
function getProducts($dept, $sdept)
{
    $con = include("database.php");
    $productos = [];
    $sql = "CALL GETPRODUCTOS('$dept','$sdept')";
    if ($con) {
        $rs = $con->query($sql);
        if ($rs) {
            if ($rs->num_rows > 0) {
                $count = 1;
                while ($row = $rs->fetch_assoc()) {
                    $productos[$count] = [$row['ID_PRODUCTO'], $row['NOMBRE'], $row['PRECIO']];
                    $count = $count + 1;
                }
            }
        }
    }
    return $productos;
}
function value($id)
{
    return $_POST[$id];
}
function register($nombre, $dia, $mes, $año, $correo, $pass)
{
    $con = include("database.php");
    $st = 400;
    $nombre = stripslashes($nombre);
    $dia = stripslashes($dia);
    $mes = stripslashes($mes);
    $año = stripslashes($año);
    $correo = stripslashes($pass);
    if ($con) {
        if (strlen($pass) > 0) {
            $query =
                'INSERT INTO users 
                    VALUES ("%s","%s",%d,"%s",%d,"%s");
                ';
            $query = sprintf($query, $correo, $pass, $dia, $mes, $año, $nombre);
            $res = $con->query($query);
            if (!$res) {
                $st = 400;
            } else {
                $st = 200;
            }
        }
        $con->close();
    }
    return $st;
}
switch ($method) {
    case 'POST':
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            switch ($action) {
                case 'login':
                    if (isset($_POST['email']) && isset($_POST['password'])) {
                        $email = stripslashes($_POST['email']);
                        $pass = stripslashes($_POST['password']);
                        include("autenticate.php");
                        $status = autenticar($email, $pass);
                        $info['status'] = $status;
                        include("createSession.php");
                        $data = getSession($email);
                        if ($status == 200) {
                            $info['login'] = true;
                            $info['email'] = $email;
                            $info['uuid'] = $data['uiid'];
                            $info['name'] = $data['name'];
                            $info['day'] = $data['day'];
                            $info['month'] = $data['month'];
                            $info['year'] = $data['year'];
                        } elseif ($status == 400) {
                            # code...
                            $info['login'] = false;
                        }
                    } else {
                        $info['status'] = 404;
                    }
                    break;
                case 'register':
                    if (post('email') && post('name') && post('password') && post('cpassword') && post('day') && post('month') && post('year')) {
                        if (value('password') == value('cpassword')) {
                            $aemail = value('email');
                            $aname = value('name');
                            $apass = value('password');
                            $aday = value('day');
                            $amonth = value('month');
                            $ayear = value('year');
                            $info['status'] = register($aname, $aday, $amonth, $ayear, $aemail, $apass);
                        }else{
                            $info['status'] = 401;
                        }
                    }else{
                        $info['status'] = 404;
                    }
                    break;
                case 'producto-nuevo':
                    if (post('nombre') && post('departamento') && post('subdepartamento') && post('precio')) {
                        $info['status'] = new_product($_POST['departamento'], $_POST['subdepartamento'], $_POST['nombre'], $_POST['precio']);
                    }
                    break;
                case 'deletecompra':
                    if (isset($_POST['id'])) {
                        $info['status'] = 200;
                    } else {
                        $info['status'] = 404;
                    }
                    break;
                case 'getCompras':
                    if (isset($_POST['email'])){
                        $con = include('database.php');
                        if($con){
                            $sql = sprintf("CALL GETCOMPRAS('%s');",$_POST['email']);
                            $rs = $con->query($sql);
                            if($rs){
                                $columnas = $rs->num_rows;
                                $info['status'] = 200;
                                $info['cantidad'] = $columnas;
                                if($columnas>0){
                                    $i = 0;
                                    while($row = $rs->fetch_assoc()){
                                        $arr['id'] = intval($row['ID']);
                                        $arr['nombre'] = $row['nombre'];
                                        $arr['minimo'] = intval($row['cminima']);
                                        $arr['comprar'] = intval($row['ccomprar']);
                                        $arr['precio'] = doubleval($row['precio']);
                                        $arr['departamento'] = intval($row['Departamento']);
                                        $arr['subdepartamento'] = intval($row['Subdepartamento']);
                                        $info[intval($i)] = $arr;
                                        $i++;
                                    }
                                }
                            }else{
                                $info['status'] = 404;
                            }
                            $con->close();
                        }else{
                            $info['status'] = 404;
                        }
                    }
                    break;
                    case 'getInventario':
                        if(isset($_POST['email'])){
                            $sql = sprintf("CALL GETINVENTARIO('%s')",$_POST['email']);
                            $con = include('database.php');
                            if($con){
                                $rs = $con->query($sql);
                                if($rs){
                                    $info['status'] = 200;
                                    if(($info['cantidad productos'] = $rs->num_rows) > 0){
                                        $i = 0;
                                        while(($row = $rs->fetch_assoc())){
                                            $arr['id'] = intval($row['ID']);
                                            $arr['nombre'] = $row['NOMBRE'];
                                            $arr['departamento'] = $row['DEPARTAMENTO'];
                                            $arr['subdepartamento'] = $row['SUBDEPARTAMENTO'];
                                            $arr['precio'] = doubleval($row['PRECIO']);
                                            $arr['cantidad'] = intval($row['CANTIDAD']);
                                            $arr['minimo'] = intval($row['MINIMO']);
                                            $info[$i] = $arr;
                                            $i++;
                                        }
                                    }
                                }else{
                                    $info['status'] = 404;
                                }
                            }else{
                                $info['status'] = 404;
                            }
                        }else{
                            $info['status'] = 404;
                        }
                        break;
                case 'eliminarExistencia':
                        if(isset($_POST['email']) && isset($_POST['id']) && isset($_POST['cantidad'])){
                            if($con = include("database.php")){
                                $sql = sprintf("CALL ELIMINAR_EXISTENCIA('%s',%d,%d)",$_POST['email'],$_POST['id'],$_POST['cantidad']);
                                if($rs = $con->query($sql)){
                                   $info['status'] = 200; 
                                }else{
                                    $info['status'] = 400;
                                }
                            }else{
                                $info['status'] = 400;
                            }
                        }else{
                            $info['status'] = 400;
                        }
                    break;
                case 'AGREGARINVENTARIO':
                    if((isset($_POST['email'])) && (isset($_POST['id']))){
                        $sql = sprintf("CALL AGREGARINVENTARIO('%s',%d)",$_POST['email'],$_POST['id']);
                        if(($con = include("database.php"))){
                            if(($rs = $con->query($sql))){
                                $info['status'] = 200;
                            }else{
                                $info['status'] = 403;
                                $info['sql'] = $sql;
                            }
                            $con->close();
                        }else{
                            $info['status'] = 401;
                        }
                    }else{
                        $info['status'] = 402;
                    }
                    break;
                case 'ELIMINARCOMPRA':
                    if((isset($_POST['email'])) && (isset($_POST['id']))){
                        $sql = sprintf("CALL ELIMINARCOMPRA('%s',%d)",$_POST['email'],$_POST['id']);
                        if(($con = include("database.php"))){
                            if(($rs = $con->query($sql))){
                                $info['status'] = 200;
                            }else{
                                $info['status'] = 400;
                            }
                            $con->close();
                        }else{
                            $info['status'] = 400;
                        }
                    }
                    break;
                    case 'GETAVAILABLEDEPARTMENTS':
                        $sql = "CALL GETAVAILABLEDEPARTMENTS();";
                        if($con = include("database.php")){
                            if($rs = $con->query($sql)){
                                $info['status'] = 200;
                                $array = [];
                                while($row = $rs->fetch_assoc()){
                                    array_push($array,$row);
                                }
                                $size = count($array);
                                $info['size'] = $size;
                                $info['departments'] = $array;
                            }else{
                                $info['status'] = 400;
                            }
                        }else{
                            $info['status'] = 400;
                        }
                        break;
                case 'GETSUBDEPARTMENTS':
                    $info['status'] = 200;
                    if (isset($_POST["department"])) {
                        $dep = $_POST["department"];
                        $info['sub'] = getsubbydept($dep);
                    } else {
                        $info['status'] = 402;
                    }
                    break;
                case "GETPRODUCTS":
                    if (isset($_POST['department']) && isset($_POST['subdepartment'])) {
                        $dep = $_POST['department'];
                        $sdep = $_POST['subdepartment'];
                        $info['status'] = 200;
                        $info['products'] = getProducts($dep, $sdep);
                    }
                    break;
                default:
                    $info['status'] = 404;
                    $info['action'] = "Action not accepted";
                    break;
            }
        } else {
            $info['status'] = 404;
            $info['debug'] = 'No action policy set';
        }
        break;
    case 'GET':
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case 'getsubdepartments':
                    $info['status'] = 200;
                    if (isset($_GET["department"])) {
                        $dep = $_GET["department"];
                        $info['sub'] = getsubbydept($dep);
                    } else {
                        $info['status'] = 402;
                    }
                    break;
                case "getProducts":
                    if (isset($_GET['department']) && isset($_GET['subdepartment'])) {
                        $dep = $_GET['department'];
                        $sdep = $_GET['subdepartment'];
                        $info['status'] = 200;
                        $info['products'] = getProducts($dep, $sdep);
                    }
                    break;
                case 'deletecompra':
                    if (isset($_POST['id'])) {
                        $info['status'] = 200;
                    } else {
                        $info['status'] = 404;
                    }
                    break;
                default:
                    $info['status'] = 404;
                    $info['error'] = $_GET['action'];
                    break;
            }
        } else {
            $info['status'] = 401;
        }
        break;
    default:
        $info['status'] = 404;
        $info['method'] = $method;
        break;
}
$str = json_encode($info);
echo $str;
