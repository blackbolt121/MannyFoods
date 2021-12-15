<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php
      session_start();
      if($_SESSION){
        if(isset($_SESSION['uiid'])){
          header("location: dashboard.php");
        }else{
          echo "No session started";
        }
      }
      $db = include("database.php");
      $nombre = "";
      $method = $_SERVER['REQUEST_METHOD'];
      $password = "";
      $email = "";
      $alert = true;
      $login = false;
      if($method === 'POST'){
        $boolean = true;
        if(isset($_POST['email']))
          if( strlen($_POST['email']) > 0 ){
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
              $email = "";
              $boolean  = false;
            }
          }else{
            $boolean = false;
          }
        else{
          $boolean = false;
        }
        if(isset($_POST['password'])){
          if ( strlen($_POST['password']) > 0){
            $password = $_POST['password'];
            if($boolean){
              #Si el correo ingresado es uno valido
              $sql = 'SELECT COUNT(email) AS "size" FROM users  WHERE pass = "%s" AND email = "%s"';
              $encrypted = md5($password);
              $sql = sprintf($sql,$encrypted,$email);
              $res = $db->query($sql);
              if($res){
                while($row = $res->fetch_assoc()){
                  if($row['size'] == 1){
                    $login = true;
                    $alert = false;
                    include('createSession.php');
                    $user_data = getSession($email);
                    $_SESSION['email'] = $email;
                    $_SESSION['uiid'] = $user_data['uiid'];
                    $_SESSION['name'] = $user_data['name'];
                    $_SESSION['day'] = $user_data['day'];
                    $_SESSION['month'] = $user_data['month'];
                    $_SESSION['year'] = $user_data['year'];
                    header("location: dashboard.php");
                    break;
                  }else{
                    $login = false;
                  }
                }
              }else{
                $login = false;
              }
            }
          }
        }
      }else{
        $alert = false;
      }
      if($login){
        echo "<script> alert('Login exitoso'); </script>";
      }
    ?>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/loginform.css">
    <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MannyFoods | Login</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg justify-content-between">
      <div class="">
      <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <img src="./images/cropped-favicon-2.png" style="width:50px;">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Acerca de nosotros</a>
          </li>
        </ul>
      </div>
      <div class="">
        <a href="signin.php" id="signin">Sign In</a>
      </div>
      </nav>
    </header>
    <div class = "container center">
        <form action="login.php" method="POST">
            <input type="hidden" name="action" value="login">
            <input type="text" name="email" id="email" placeholder="E-Mail"
              <?php
                if(isset($_POST['email'])){
                  echo 'value = ' . $email; 
                }
              ?>
            >
            <br>
            <input type="password" name="password" id = "password" placeholder="password" 
                <?php
                  if(isset($_POST['password'])){
                    echo 'value = ' . $password;
                  }
                ?>
            >
            <br>
            <?php
              if($alert)
                echo '<div class = "container red"> <br>' . 
                  (( strlen($email) == 0 )? "<p> No ingreso su email </p> " : "") . 
                  (( strlen($password) == 0)? '<p> No ingreso un password </p>' : 
                     ((!$login)? '<p> password o correo invalido </p>' : '') ).
                  '</div> <br>';
            ?>
            <button class="btn btn-primary" type="submit">Ingresar</button>
        </form>
    </div>



  </body>
</html>