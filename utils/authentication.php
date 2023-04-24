<?php
session_start();
include('connect.php');

if(!isset($_SESSION['LoggedIn'])) {
    header('Location: /views/login.php');
    exit(0);
} else {
    if ($_SESSION['Admin'] != 1) {
        header('Location: /views/login.php');
        exit(0);
    }
}
?>