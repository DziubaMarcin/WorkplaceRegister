<?php

  ob_start();

  if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
      if(empty($value)) {
        $_SESSION['name']=$_POST["name"];
        $_SESSION['surname']=$_POST["surname"];
        $_SESSION['login']=$_POST["login"];
        header("location: ./register.php?error=Uzupełnij poprawnie wszystkie pola!");
        exit();
      }
    }
    if ($_POST["password"] != $_POST['password2']) {
      $_SESSION['name']=$_POST["name"];
      $_SESSION['surname']=$_POST["surname"];
      $_SESSION['login']=$_POST["login"];
      header("location: ./register.php?error=Podane hasła nie zgadzają się!");
      exit();
    }
    else {
      require './connect.php';
      $sql = "SELECT `login` FROM `users`";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        if ($row['login']==$_POST["login"]) {
          $_SESSION['name']=$_POST["name"];
          $_SESSION['surname']=$_POST["surname"];
          $conn->close();
          header("location: ./register.php?error=Użytkownik o podanym loginie już istnieje!");
          exit();
        }
      }
      require './connect.php';
      $stmt = $conn->prepare("INSERT INTO `registration` (`name`, `surname`, `login`, `password`, `email`, `activation_code`) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $name, $surname, $login, $password, $email, $activation_code);
      $name = trim(strip_tags(trim(html_entity_decode($_POST["name"], ENT_QUOTES, 'UTF-8'))));
      $surname = trim(strip_tags(trim(html_entity_decode($_POST["surname"], ENT_QUOTES, 'UTF-8'))));
      $login = trim(strip_tags(trim(html_entity_decode($_POST["login"], ENT_QUOTES, 'UTF-8'))));
      $password = sha1(trim(strip_tags(trim(html_entity_decode($_POST["password"], ENT_QUOTES, 'UTF-8')))));
      $email = $_POST["email"];
      $activation_code = "".bin2hex(random_bytes(16))."";
      $stmt->execute();
      if ($stmt->affected_rows == 1) {
        //wysłanie maila
        require './sendmail.php';
        send_activation_mail($email, $activation_code);
        header("location: ./register-success.php");
        exit();
      }
      else {
        header("location: ./unexpected-error.php");
        exit();
      }
      $stmt->close();
      $conn->close();
    }
  }
  else{
    $_SESSION['name']=$_POST["name"];
    $_SESSION['surname']=$_POST["surname"];
    $_SESSION['login']=$_POST["login"];
    header("location: ./register.php?error=Uzupełnij poprawnie wszystkie pola!");
    exit();
  }
?>
