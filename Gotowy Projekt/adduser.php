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
        header("location: ./admin.php?adduserinfo=Uzupełnij poprawnie wszystkie pola!");
        exit();
      }
    }
    require './connect.php';
    $sql = "SELECT `login` FROM `users`";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      if ($row['login']==$_POST["login"]) {
        $conn->close();
        header("location: ./admin.php?adduserinfo=Użytkownik o podanym loginie już istnieje!");
        exit();
      }
    }
    require './connect.php';
    $stmt = $conn->prepare("INSERT INTO `users` (`name`, `surname`, `login`, `password`, `role_id`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $surname, $login, $password, $role_id);
    $name = trim(strip_tags(trim(html_entity_decode($_POST["name"], ENT_QUOTES, 'UTF-8'))));
    $surname = trim(strip_tags(trim(html_entity_decode($_POST["surname"], ENT_QUOTES, 'UTF-8'))));
    $login = trim(strip_tags(trim(html_entity_decode($_POST["login"], ENT_QUOTES, 'UTF-8'))));
    $password = sha1(trim(strip_tags(trim(html_entity_decode($_POST["password"], ENT_QUOTES, 'UTF-8')))));
    $role_id = $_POST["role_id"];
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
      header("location: ./admin.php?adduserinfo=Pomyślnie dodano użytkownika!");
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
    header("location: ./admin.php?adduserinfo=Uzupełnij poprawnie wszystkie pola!");
    exit();
  }
?>
