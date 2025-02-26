<?php

  if (isset($_GET["email"]) && isset($_GET["activation_code"])) {
    require './connect.php';
    $sql = "UPDATE `registration` SET `is_activated` = '1' WHERE `registration`.`email` LIKE '".$_GET["email"]."' AND `registration`.`activation_code` LIKE '".$_GET["activation_code"]."';";
    $conn->query($sql);
    if ($conn->affected_rows == 1) {
      $conn->close();
      header("location: ./verifysuccess.php");
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
