<?php

  ob_start();

  session_start();

  if(!isset($_SESSION['role_id']))  {
    header("location: ./accessdenied.php");
    exit();
    }
    elseif ($_SESSION['role_id'] != 2) {
      header("location: ./accessdenied.php");
      exit();
    }

    if (isset($_GET["id"]) && isset($_GET["user_id"]) && isset($_GET["date"]) && isset($_GET["time"])) {
      require './connect.php';
      $conn->autocommit(FALSE);
      $stmt = $conn->prepare("INSERT INTO `worktime` (`user_id`, `date`, `time`) VALUES (?, ?, ?)");
      $stmt->bind_param("iss", $user_id, $date, $time);
      $user_id = $_GET["user_id"];
      $date = $_GET["date"];
      $time = $_GET["time"];
      $stmt->execute();
      $id = $_GET["id"];
      $conn->query("DELETE FROM `unapproved_worktime` WHERE `id` = $id");

      if (!$conn -> commit()) {
        $conn->rollback();
        $stmt->close();
        $conn->close();
        header("location: ./unexpected-error.php");
        exit();
      }

      $stmt->close();
      $conn->close();
      header("location: ./superior.php?confirmationinfo=Pomyślnie zatwierdzono czas pracy!");
      exit();

    }
    else {
      header("location: ./unexpected-error.php");
      exit();
    }

?>
