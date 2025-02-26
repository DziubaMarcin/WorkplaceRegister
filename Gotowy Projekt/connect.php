<?php

  $conn = new mysqli("localhost", "root", "", "xyzrejestr");

  if ($conn -> connect_errno) {
    header("location: ./unexpected-error.php");
    exit();
  }

?>
