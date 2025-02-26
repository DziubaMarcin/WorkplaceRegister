<?php

  ob_start();

  session_start();

?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>XYZ Sp. z o.o. - Panel Rejestracji</title>
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
        <a href="./index.php">
          <img src="../Resources/login.svg" alt="login">
          <p>Zaloguj się</p>
        </a>
      </div>
    </header>

    <main>

      <div class="panel">
        <h3>Rejestracja</h3>
        <?php

          if (isset($_GET['error'])) {
            echo <<< ERR
              <h3 class="error">
               $_GET[error]
              </h3>
            ERR;
          }

        ?>
        <form class="registerform" action="./register-script.php" method="post">
          <label for="name">
            <img src="../Resources/account-details.svg">
            <input type="text" name="name" placeholder="Imię" <?php if(isset($_SESSION['name'])){echo "value='".$_SESSION['name']."'";unset($_SESSION['name']);}?> required>
          </label>
          <br>
          <label for="surname">
            <img src="../Resources/account-details.svg">
            <input type="text" name="surname" placeholder="Nazwisko" <?php if(isset($_SESSION['surname'])){echo "value='".$_SESSION['surname']."'";unset($_SESSION['surname']);}?> required>
          </label>
          <br>
          <label for="login">
            <img src="../Resources/account.svg">
            <input type="text" name="login" placeholder="Wprowadź login!" <?php if(isset($_SESSION['login'])){echo "value='".$_SESSION['login']."'";unset($_SESSION['login']);}?> required>
          </label>
          <br>
          <label for="email">
            <img src="../Resources/email.svg">
            <input type="email" name="email" placeholder="Wprowadź E-mail!" required>
          </label>
          <br>
          <label for="password">
            <img src="../Resources/password.svg">
            <input type="password" name="password" placeholder="Wprowadź hasło!" required>
          </label>
          <br>
          <label for="password">
            <img src="../Resources/password.svg">
            <input type="password" name="password2" placeholder="Powtórz hasło!" required>
          </label>
          <br>
          <input type="submit" name="submit" value="Zarejestruj się!">
          <input type="reset" name="reset" value="Wyczyść dane!">
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
