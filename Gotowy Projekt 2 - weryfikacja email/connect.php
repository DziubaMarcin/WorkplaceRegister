<?php

  $conn = new mysqli("localhost", "root", "", "xyzrejestr3");

  if ($conn -> connect_errno) {
    header("location: ./unexpected-error.php");
    exit();
  }

?>
