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
    <title>XYZ Sp. z o.o. - Edytuj Czas Pracy</title>
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
        <?php
          require './connect.php';
          $sql = "SELECT * FROM `worktime` WHERE `id` LIKE '".$_GET["id"]."';";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          if ($conn->affected_rows != 1) {
            header("location: ./unexpected-error.php");
          }
          $conn->close();
          echo <<< FORM
            <form class="editworktime" action="./editworktimescript.php" method="post">
              <input type="hidden" name="id" value="$row[id]" required>
              <input type="date" name="date" value="$row[date]" required>
              <input type="time" name="time" value="$row[time]" required>
              <input type="submit" name="updateworktime" value="Zaktualizuj!">
            </form>
          FORM;
        ?>
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
