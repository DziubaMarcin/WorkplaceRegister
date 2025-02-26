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

  if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
      if(empty($value)) {
        header("location: ./worker.php?worktimeinfo=Uzupełnij poprawnie wszystkie pola!");
        exit();
      }
    }
    require './connect.php';
    $stmt = $conn->prepare("INSERT INTO `unapproved_worktime` (`user_id`, `date`, `time`) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $date, $time);
    $user_id = $_SESSION['user_id'];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
      header("location: ./worker.php?worktimeinfo=Pomyślnie dodano czas pracy");
      exit();
    }
    else {
      header("location: ./unexpected-error.php");
      exit();
    }
    $stmt->close();
    $conn->close();
  }
  else{
    header("location: ./worker.php?worktimeinfo=Uzupełnij poprawnie wszystkie pola!");
    exit();
  }

?>
