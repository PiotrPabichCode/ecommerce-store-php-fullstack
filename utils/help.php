<?php

session_start();

$openAccount = $_POST('accountNavbar');
if(isset($openAccount)) {
    if((isset($_SESSION['LoggedIn'])) && ($_SESSION['LoggedIn'] == true)) {
        if ($_SESSION['Admin'] == 1) {
          header('Location: /views/admin.php');
        } else {
          header('Location: /views/account.php');
        }
        exit();
      }
}
?>