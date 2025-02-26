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

?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>XYZ Sp. z o.o. - Panel Administratora</title>
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

      <?php
        require './connect.php';
        $sql = "SELECT `name` FROM `users` WHERE `id` LIKE '".$_SESSION['user_id']."';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo <<< HELLO
          <h1>Witaj, $row[name]!</h1>
        HELLO;
        $conn->close();
      ?>

      <div id="top">

        <div id="adduser" class="panel">
          <h3>Oczekujący Użytkownicy</h3>
          <?php
            if (isset($_GET["adduserinfo"])) {
              echo <<< INFO
                <h4>
                 $_GET[adduserinfo]
                </h4>
              INFO;
            }
          ?>
          <div class="tablescroll">
            <table>
              <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Login</th>
                <th>Zweryfikowano?</th>
                <th>Rola</th>
                <th>Zaakceptuj</th>
                <th>Usuń</th>
              </tr>
              <?php
                require './connect.php';
                $sql = "SELECT * FROM `registration`;";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                echo <<< ROW
                  <tr>
                    <form class="confirmuser" action="./acceptuser.php" method="post">
                      <td><input type="hidden" name="id" value="$row[id]">$row[id]</td>
                      <td><input type="hidden" name="name" value="$row[name]">$row[name]</td>
                      <td><input type="hidden" name="surname" value="$row[surname]">$row[surname]</td>
                      <td><input type="hidden" name="login" value="$row[login]">$row[login]</td>
                      <td data-is_activated="$row[is_activated]"><input type="hidden" name="login" value="$row[is_activated]">$row[is_activated]</td>
                      <td><select name="role_id" required>
                            <option value="" disabled selected>Wybierz Rolę</option>
                            <option value="1">Administrator</option>
                            <option value="2">Przełożony</option>
                            <option value="3">Pracownik</option>
                          </select></td>
                        <td><input type="image" src="../Resources/accept.svg" alt="accept"></td>
                        <td><a href="./denyuser.php?id=$row[id]"><img src="../Resources/delete.svg" alt="delete"></a></td>
                      </form>
                    </tr>
                ROW;
                }
                $conn->close();
              ?>
            </table>
          </div>
          <h3>Dodaj Użytkownika</h3>
          <form class="adduser" action="./adduser.php" method="post">
              <input type="text" name="name" placeholder="Imię" required>
              <input type="text" name="surname" placeholder="Nazwisko" required>
              <input type="text" name="login" placeholder="Login" required>
              <input type="password" name="password" placeholder="Hasło" required>
              <select name="role_id" required>
                <option value="" disabled selected>Wybierz Rolę</option>
                <option value="1">Administrator</option>
                <option value="2">Przełożony</option>
                <option value="3">Pracownik</option>
              </select>
            <input type="submit" name="adduser" value="Dodaj użytkownika!">
          </form>

        </div>

        <div id="usermanage" class="panel">
          <h3>Zarządzanie Użytkownikami</h3>
          <?php
            if (isset($_GET["manageusersinfo"])) {
              echo <<< INFO
                <h4>$_GET[manageusersinfo]</h4>
              INFO;
            }
          ?>
          <div class="tablescroll">
            <table>
              <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Login</th>
                <th>Rola</th>
                <th>Szczegóły</th>
                <th>Modyfikuj</th>
                <th>Usuń</th>
              </tr>
              <?php
              require './connect.php';
              $sql = "SELECT `users`.`id`, `users`.`name`, `users`.`surname`, `users`.`login`, `roles`.`role_name` FROM `users` INNER JOIN `roles` ON `users`.`role_id` = `roles`.`role_id`;";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                echo <<< ROW
                  <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[surname]</td>
                    <td>$row[login]</td>
                    <td>$row[role_name]</td>
                    <td><a href="./infouser.php?id=$row[id]"><img src="../Resources/info.svg" alt="info"></a></td>
                    <td><a href="./edituserform.php?id=$row[id]"><img src="../Resources/edit.svg" alt="edit"></a></td>
                    <td><a href="./confirmdeleteuser.php?id=$row[id]"><img src="../Resources/delete.svg" alt="delete"></a></td>
                  </tr>
                ROW;
              }
              $conn->close();
              ?>
            </table>
          </div>

        </div>

      </div>

      <div id="bottom">

        <div id="worktimemanage" class="panel">
          <h3>Modyfikacja Czasu Pracy</h3>
          <?php
            if (isset($_GET["worktimeinfo"])) {
              echo <<< INFO
                <h4>$_GET[worktimeinfo]</h4>
              INFO;
            }
          ?>
          <form class="worktimemodify" action="./admin.php" method="post">
            <label for="date">
              Wybierz Dzień:
              <br>
              <input type="date" name="date" required>
            </label>
            <input type="submit" name="modifyworktime" value="Zarządzaj!">
          </form>
          <?php
            if (isset($_POST["modifyworktime"])) {
              echo <<< WRKTIME
                <div class="tablescroll">
                  <table>
                    <tr>
                      <th>ID</th>
                      <th>Imię</th>
                      <th>Nazwisko</th>
                      <th>Data</th>
                      <th>Czas</th>
                      <th>Modyfikuj</th>
                      <th>Usuń</th>
                    </tr>
              WRKTIME;
              require './connect.php';
              $sql = "SELECT `worktime`.`id`, `worktime`.`user_id`, `worktime`.`date`, `worktime`.`time`, `users`.`name`, `users`.`surname` FROM `worktime` INNER JOIN `users` ON `worktime`.`user_id` = `users`.`id` WHERE `worktime`.`date` LIKE '".$_POST["date"]."';";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                echo <<< WRKTIME
                  <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[surname]</td>
                    <td>$row[date]</td>
                    <td>$row[time]</td>
                    <td><a href="./editworktimeform.php?id=$row[id]"><img src="../Resources/edit.svg" alt="edit"></a></td>
                    <td><a href="./deleteworktime.php?id=$row[id]"><img src="../Resources/delete.svg" alt="delete"></a></td>
                  </tr>
                WRKTIME;
              }
              echo <<< WRKTIME
                  </table>
                </div>
              WRKTIME;
            }
          ?>
        </div>

        <div id="comment" class="panel" style="width: 50%;">
          <h3>Komentuj</h3>
          <?php
            if (isset($_GET["commentinfo"])) {
              echo <<< INFO
                <h4>$_GET[commentinfo]</h4>
              INFO;
            }
          ?>
          <form class="commentform" id="commentform" action="./admin.php" method="post">
            <label for="commentdate">
              Wybierz Dzień:
              <br>
              <input type="date" name="commentdate" required>
            </label>
            <textarea name="commentcontent" rows="5" cols="50" placeholder="Napisz komentaż..." form="commentform"></textarea>
            <input type="submit" name="addcomment" value="Dodaj komentaż!">
            <input type="submit" name="showcomment" value="Pokaż komentaże!">
          </form>
          <?php
            if (isset($_POST["addcomment"]) && !empty($_POST['commentcontent'])) {
              require './connect.php';
              $stmt = $conn->prepare("INSERT INTO `comments` (`user_id`, `date`, `content`) VALUES (?, ?, ?)");
              $stmt->bind_param("iss", $user_id, $date, $content);
              $user_id = $_SESSION['user_id'];
              $date = $_POST["commentdate"];
              $content = $_POST["commentcontent"];
              $stmt->execute();
              if ($stmt->affected_rows == 1) {
                header("location: ./admin.php?commentinfo=Pomyślnie dodano komentaż");
                exit();
              }
              else {
                header("location: ./admin.php?commentinfo=Nie udało się dodać komentaża");
                exit();
              }
              $stmt->close();
              $conn->close();
            }
            elseif (isset($_POST["showcomment"])) {
              require './connect.php';
              $sql = "SELECT `comments`.`content`, `users`.`name`, `users`.`surname` FROM `comments` INNER JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `comments`.`date` LIKE '".$_POST["commentdate"]."'";
              $result = $conn->query($sql);
              echo <<< COMM
                <div class="tablescroll">
                  <table>
                    <tr>
                      <th>Autor</th>
                      <th>Treść Komentaża</th>
                    </tr>
              COMM;
              while ($row = $result->fetch_assoc()) {
                echo <<< COMM
                  <tr>
                    <td>$row[name] $row[surname]</td>
                    <td>$row[content]</td>
                  </tr>
                COMM;
              }
              echo <<< COMM
                  </table>
                </div>
              COMM;
              $conn->close();
            }
          ?>
        </div>

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
