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
      require './connect.php';
      $sql = "DELETE FROM `worktime` WHERE `id` LIKE '".$_GET["id"]."';";
      $conn->query($sql);

      if ($conn -> affected_rows == 1) {
        $conn->close();
        header("location: ./admin.php?worktimeinfo=Pomyślnie usunięto rekord!");
        exit();
      }
      else {
        $conn->close();
        header("location: ./unexpected-error.php");
        exit();
      }
    }
    else {
      header("location: ./unexpected-error.php");
      exit();
    }

?>
