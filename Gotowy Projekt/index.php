<?php

  ob_start();

  session_start();

?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>XYZ Sp. z o.o. - Panel Logowania</title>
  </head>
  <body>

    <header>
      <div id="time">
		    <span id="date">
          Czwartek, 01/01/1970
		    </span>
        <br>
        <h1>
        	<span id="hours">
            00
        	</span>
        	<sup>
        		<span id="minutes">
              01
        		</span>
        	</sup>
        </h1>
      </div>

      <div id="logo">
        <img src="../Resources/logo3.png" alt="Logo Firmy XYZ">
      </div>

      <div id="headerbutton">
        <a href="./register.php">
          <img src="../Resources/register.svg" alt="register">
          <p>Zarejestruj się</p>
        </a>
      </div>
    </header>

    <main>

      <div class="panel">
        <h3>Logowanie</h3>
        <?php

          if (isset($_GET["error"])) {
            echo <<< ERR
              <h3 class="error">
               $_GET[error]
              </h3>
            ERR;
          }

        ?>
        <form class="loginform" action="./login-script.php" method="post">
          <label for="login">
            <img src="../Resources/account.svg">
            <input type="text" name="login" placeholder="Wprowadź swój login!" <?php if(isset($_SESSION['name'])){echo "value='".$_SESSION['name']."'";unset($_SESSION['name']);}?> required>
          </label>
          <br>
          <label for="password">
            <img src="../Resources/password.svg">
            <input type="password" name="password" placeholder="Wprowadź swoje hasło!" required>
          </label>
          <br>
          <input type="submit" name="submit" value="Zaloguj się!">
        </form>
      </div>



    </main>

    <footer>
      <div class="copyright">
        |Copyright ©2022 XYZ Sp.  z  o. o.|
      </div>
    </footer>

    <script type="text/javascript" src="./clock.js"></script>

  </body>
</html>
