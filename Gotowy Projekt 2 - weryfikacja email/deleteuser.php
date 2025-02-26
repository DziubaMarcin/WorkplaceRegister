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
      $sql = "DELETE FROM `users` WHERE `id` LIKE '".$_POST["id"]."';";
      $conn->query($sql);
      if ($conn->affected_rows == 1) {
        $conn->close();
        header("location: ./admin.php?manageusersinfo=Prawidłowo usunięto użytkownika!");
        exit();
      }
      else {
        $conn->close();
        header("location: ./unexpected-error.php");
        exit();
      }
  }
  else{
    header("location: ./unexpected-error.php");
    exit();
  }

?>
