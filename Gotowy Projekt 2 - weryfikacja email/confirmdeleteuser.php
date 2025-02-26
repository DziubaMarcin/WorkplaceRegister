<?php

  ob_start();

  session_start();

  if(!isset($_SESSION['role_id']))  {
    header("location: ./accessdenied.php");
    exit();
    }
    elseif ($_SESSION['role_id'] != 1) {
      header("location: ./accessdenied.php");
      exit();
    }

  if (!isset($_GET["id"])) {
    header("location: ./unexpected-error.php");
    exit();
  }

?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>XYZ Sp. z o.o. - Usuwanie Użytkownika</title>
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
        <img src="../Resources/error.svg" alt="warning" class="filter-red" style="height: 100%; width: 100%;">
        <h3>Uwaga!</h3>
        <h4>Czy na pewno chcesz usunąć tego użytkownika?</h4>
        <h4>Ta operacja będzie nieodwracalna!</h4>
        <form class="confirmdeleteuser" action="./deleteuser.php" method="post">
          <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
          <input type="submit" name="delete" value="Usuń bezpowrotnie!">
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
