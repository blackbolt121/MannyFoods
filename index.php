<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/index.css">
  <script src="./scripts/signin.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./images/cropped-favicon-2.ico" type="image/x-icon">
  <title>ManyFoods</title>
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
      <?php
      session_start();
      if ($_SESSION) {
        if (isset($_SESSION['uiid'])) {
          echo '

            <div class="">
              <a href="dashboard.php" id="login">Ir a dashboard</a>
            </div>
            
          ';
        } else {
          echo
          '
                <div class="">
                  <a href="login.php" id="login">Log In</a>
                  <a href="signin.php" id="signin">Sign In</a>
                </div>
                
                ';
        }
      } else {
        echo
        '
                <div class="">
                  <a href="login.php" id="login">Log In</a>
                  <a href="signin.php" id="signin">Sign In</a>
                </div>
                
                ';
      }
      ?>

    </nav>
  </header>
  <div class="parallax" id="cover1" style="width:100%; position: relative;">
    <div class="info">Manten un eficiente control del inventario de tus alimentos</div>
  </div>
  <script>
    document.getElementById("cover1").style.backgroundImage = "url(https://dam.cocinafacil.com.mx/wp-content/uploads/2020/04/comida-china-tipica.jpg)"
  </script>
  <div class="parallax" id="cover2" style="width:100%; position: relative;">
    <div class="info">Miles de productos registrados en nuestras bases de datos!!!</div>
  </div>
  <script>
    document.getElementById("cover2").style.backgroundImage = "url(https://sevilla.abc.es/gurme/wp-content/uploads/sites/24/2012/01/comida-rapida-casera.jpg)"
  </script>
  <div class="parallax" id="cover3" style="width:100%; position: relative;">
    <div class="info">Haz compras más inteligentes</div>
  </div>
  <script>
    document.getElementById("cover3").style.backgroundImage = "url(https://www.paulinacocina.net/wp-content/uploads/2020/01/untitled-copy.jpg)"
  </script>
</body>

</html>