<?php

  ob_start();

  session_start();

    switch ($_SESSION['role_id']) {
      case 1:
        header("Location: ./admin.php");
        exit();
        break;

      case 2:
        header("Location: ./superior.php");
        exit();
        break;

      case 3:
        header("Location: ./worker.php");
        exit();
        break;

      default:
      case 1:
        header("Location: ./index.php");
        exit();
        break;
    }

?>
