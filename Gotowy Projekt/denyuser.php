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

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    require './connect.php';
    $sql = "DELETE FROM `registration` WHERE `id` = $id";
    $result = $conn->query($sql);
    if ($conn->affected_rows == 1) {
      header("location: ./admin.php?adduserinfo=Pomyślnie usunięto rekord!");
      exit();
    }
    else {
      header("location: ./unexpected-error.php");
      exit();
    }
  }
  else {
    header("location: ./unexpected-error.php");
    exit();
  }

?>
