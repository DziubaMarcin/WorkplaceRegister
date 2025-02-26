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

    if (!empty($_POST)) {
      foreach ($_POST as $key => $value) {
        if(empty($value)) {
          header("location: ./unexpected-error.php");
          exit();
        }
      }
      require './connect.php';
      $sql = "SELECT `password` FROM `registration` WHERE `id` LIKE '".$_POST['id']."';";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $conn->autocommit(FALSE);
      $stmt = $conn->prepare("INSERT INTO `users` (`name`, `surname`, `login`, `password`, `role_id`) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssi", $name, $surname, $login, $password, $role_id);
      $name = $_POST["name"];
      $surname = $_POST["surname"];
      $login = $_POST["login"];
      $password = $row['password'];
      $role_id = $_POST["role_id"];
      $stmt->execute();
      $id = $_POST["id"];
      $conn->query("DELETE FROM `registration` WHERE `id` = $id");

      if (!$conn -> commit()) {
        $conn->rollback();
        $stmt->close();
        $conn->close();
        header("location: ./unexpected-error.php");
        exit();
      }

      $stmt->close();
      $conn->close();
      header("location: ./admin.php?adduserinfo=Pomyślnie zatwierdzono użytkownika!");
      exit();

    }
    else {
      header("location: ./unexpected-error.php");
      exit();
    }

?>
