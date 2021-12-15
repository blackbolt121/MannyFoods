<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php 
    session_start();
    if($_SESSION){
      if(isset($_SESSION['uiid'])){
        header("location: dashboard.php");
      }
    }
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "POST"){
      $campos = ['name','day','month','year','email','password','confirm-password'];
      $values = [];
      $band = true;
      foreach ($campos as $key => $value) {
        # code...
        if(!isset($_POST[$value])){
          $band = false;
        }
        array_push($values,$_POST[$value]);
      }
      if($band){
        if(strcmp($values[5],$value[6])){
          include("register.php");
          $name = stripslashes($values[0]); 
          $day = stripslashes($values[1]);
          $month = stripslashes($values[2]);
          $year = stripslashes($values[3]);
          $email = stripslashes($values[4]);
          $pass = stripslashes($values[5]);
          $var = register($name, $day, $month, $year,$email,$pass);

        }else{
          echo "<script> alert('password mismatch') </script>";
        }
        
      }

    }
    
  
  ?>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/loginform.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./scripts/signin.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">


    <title>ManyFoods | Sign In</title>
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
        <a href="login.php" id="login">Log In</a>
      </div>
      </nav>
    </header>

    <div class = "container center">
        <form action="signin.php" method="POST" id="register">
            <input type="text" name="name" placeholder="Your name" id="name">
            <input class="inline-number" id = "day" placeholder="Day" type="number" name="day" min="1" max="31">
            <select name="month" id="month" id="month">
              <option value="napply">Select a month</option>
              <option value="Enero">Enero</option>
              <option value="Febrero">Febrero</option>
              <option value="Marzo">Marzo</option>
              <option value="Abril">Abril</option>
              <option value="Mayo">Mayo</option>
              <option value="Junio">Junio</option>
              <option value="Julio">Julio</option>
              <option value="Agosto">Agosto</option>
              <option value="Septiembre">Septiembre</option>
              <option value="Octubre">Octubre</option>
              <option value="Noviembre">Noviembre</option>
              <option value="Deciembre">Diciembre</option>
            </select>
            <input class="inline-number" placeholder="Year" id = "year" type="number" name="year" min="1900" max="2021" value = "2000">
            <input type="text" name="email" id="email" placeholder="E-Mail">
            <br>
            <input type="password" name="password" id = "password" placeholder="password">
            <br>
            <input type="password" name="confirm-password" id = "confirm-password" placeholder="confirm-password">
            <br>
            <button id="submit" type="submit">Ingresar</button>
        </form>
    </div>

  </body>
</html>