<?php

  ob_start();

  session_start();

  if(!isset($_SESSION['role_id']))  {
    header("location: ./accessdenied.php");
    exit();
    }
    elseif ($_SESSION['role_id'] != 3) {
      header("location: ./accessdenied.php");
      exit();
    }

?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>XYZ Sp. z o.o. - Panel Pracownika</title>
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
        $sql = "SELECT `name` FROM `users` WHERE `id` LIKE '".$_SESSION['user_id']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo <<< HELLO
          <h1>Witaj, $row[name]!</h1>
        HELLO;
        $conn->close();
      ?>

      <div id="top">

        <div id="worktime" class="panel">
          <h3>Dodaj Przepracowane Godziny</h3>
          <?php
            if (isset($_GET["worktimeinfo"])) {
              echo <<< INFO
                <h4>
                 $_GET[worktimeinfo]
                </h4>
              INFO;
            }
          ?>
          <form class="worktime" action="./workeraddworktime.php" method="post">
            <label for="date">
              Wybierz Dzień:
              <br>
              <input type="date" name="date" required>
            </label>
            <br>
            <label for="time">
              Wprowadź Czas:
              <br>
              <input type="time" name="time" required>
            </label>
            <input type="submit" name="addtime" value="Dodaj czas!">
          </form>
          <h4>Czas pracy musi zostać zatwierdzony przez przełożonego!!!</h4>

        </div>

        <div id="summary" class="panel">
          <h3>Miesięczne Podsumowanie</h3>
          <form class="summary" action="./worker.php" method="post">
            <label for="month">
              Wybierz Miesiąc:
              <br>
              <input type="month" name="month" required>
            </label>
            <input type="submit" name="showsummary" value="Pokaż podsumowanie!">
          </form>
          <?php
            if (isset($_POST["month"])) {
              require './connect.php';
              $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`time`))) AS `totaltime`, COUNT(`time`) AS `totalpresence` FROM `worktime` WHERE `user_id` LIKE '".$_SESSION['user_id']."' AND `date` LIKE '".$_POST["month"]."%"."';";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                echo <<< SUMM
                  <h4>Wybrano Miesiąc: $_POST[month]</h4>
                  <h4>Przepracowane Dni: $row[totalpresence]</h4>
                  <h4>Przepracowane Godziny: $row[totaltime]</h4>
                SUMM;
            }
            $conn->close();
          }
          ?>
        </div>

      </div>

      <div id="bottom">

        <div id="comment" class="panel" style="width: 100%;">
          <h3>Komentuj</h3>
          <?php
            if (isset($_GET["commentinfo"])) {
              echo <<< INFO
                <h4>$_GET[commentinfo]</h4>
              INFO;
            }
          ?>
          <form class="commentform" id="commentform" action="./worker.php" method="post">
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
                header("location: ./worker.php?commentinfo=Pomyślnie dodano komentaż");
                exit();
              }
              else {
                header("location: ./worker.php?commentinfo=Nie udało się dodać komentaża");
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
