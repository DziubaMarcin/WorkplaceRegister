<?php

  ob_start();

  session_start();

  if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
      if(empty($value)) {
        $_SESSION['login']=$_POST["login"];
        header("location: ./index.php?error=Uzupełnij poprawnie wszystkie pola!");
        exit();
      }
    }
    require './connect.php';
    $sql = "SELECT * FROM `users` WHERE `login`='".$_POST["login"]."';";
    $result = $conn->query($sql);
    if ($conn->affected_rows != 1) {
        $conn->close();
        header("Location: ./index.php?error=Uzupełnij poprawnie wszystkie pola!");
        exit();
      }
    while ($row = $result->fetch_assoc()) {
      if(hash_equals(sha1($_POST["password"]), $row["password"])) {
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['role_id'] = $row['role_id'];
          header("Location: ./redirect.php");
          exit();
        }
      else {
        header("Location: ./index.php?error=Uzupełnij poprawnie wszystkie pola!");
        exit();
      }
    }
  }
  else{
    $_SESSION['login'] = $_POST["login"];
    header("location: ./index.php?error=Uzupełnij poprawnie wszystkie pola!");
    exit();
  }

?>
