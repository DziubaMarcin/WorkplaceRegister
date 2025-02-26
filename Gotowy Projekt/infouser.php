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
    <title>XYZ Sp. z o.o. - Szegółowe Informacje o Użytkowniku</title>
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
        <a href="./logout.php">
          <img src="../Resources/logout.svg" alt="logout">
          <p>Wyloguj się</p>
        </a>
      </div>
    </header>

    <main>

      <div class="panel" style="width: 90%;">
        <?php
          require './connect.php';
          $sql = "SELECT * FROM `users` WHERE `id` LIKE '".$_GET["id"]."';";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          echo <<< ROW
            <h2>Szczegółowe informacje o użytkowniku $row[name] $row[surname]</h2>
            <h4>Informacje te są wysoce poufne i do wglądu tylko dla Administratora</h4>
            <div class="tablescroll">
              <h3>Ogólne Informacje</h3>
              <table>
                <tr>
                  <th>ID</th>
                  <th>Imię</th>
                  <th>Nazwisko</th>
                  <th>Login</th>
                  <th>Hasło</th>
                  <th>ID Roli</th>
                  <th>Data Dodania</th>
                </tr>
                <tr>
                  <td>$row[id]</td>
                  <td>$row[name]</td>
                  <td>$row[surname]</td>
                  <td>$row[login]</td>
                  <td>$row[password]</td>
                  <td>$row[role_id]</td>
                  <td>$row[addition_date]</td>
                </tr>
              </table>
            </div>
          ROW;
          $sql = "SELECT `users`.`role_id`, `roles`.`role_name` FROM `users` INNER JOIN `roles` ON `users`.`role_id` = `roles`.`role_id` WHERE `users`.`id` LIKE '".$_GET["id"]."';";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          echo <<< ROW
            <div class="tablescroll">
            <h3>Pełniona Rola</h3>
              <table>
                <tr>
                  <th>ID Roli</th>
                  <th>Rola</th>
                </tr>
                <tr>
                  <td>$row[role_id]</td>
                  <td>$row[role_name]</td>
                </tr>
              </table>
            </div>
          ROW;
          $sql = "SELECT * FROM `worktime` WHERE `user_id` LIKE '".$_GET["id"]."';";
          $result = $conn->query($sql);
          echo "<div>";
          while ($row = $result->fetch_assoc()) {
            echo <<< ROW
              <h3>Zatwierdzone Działania</h3>
                <table>
                  <tr>
                    <th>ID Wpisu</th>
                    <th>Data</th>
                    <th>Czas Pracy</th>
                  </tr>
                  <tr>
                    <td>$row[id]</td>
                    <td>$row[date]</td>
                    <td>$row[time]</td>
                  </tr>
                </table>
            ROW;
          }
          echo "</div>";
          $sql = "SELECT * FROM `unapproved_worktime` WHERE `user_id` LIKE '".$_GET["id"]."';";
          $result = $conn->query($sql);
          echo "<div>";
          while ($row = $result->fetch_assoc()) {
            echo <<< ROW
              <h3>Niezatwierdzone Działania</h3>
                <table>
                  <tr>
                    <th>ID Wpisu</th>
                    <th>Data</th>
                    <th>Czas Pracy</th>
                  </tr>
                  <tr>
                    <td>$row[id]</td>
                    <td>$row[date]</td>
                    <td>$row[time]</td>
                  </tr>
                </table>
            ROW;
          }
          echo "</div>";
          $conn->close();
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
