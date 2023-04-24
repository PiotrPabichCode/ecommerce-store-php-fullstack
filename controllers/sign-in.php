<?php
    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))) {
        header('Location: ../index.php');
        exit();
    }

    require_once "../utils/connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connection->connect_errno != 0) {
        echo "Error: ".$connection->connect_errno;
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if($res = $connection->query(sprintf("SELECT * FROM users WHERE Login = '%s'", 
            mysqli_real_escape_string($connection, $login)))) {
            $users_counter = $res->num_rows;
            
            if($users_counter > 0) {
                $data = $res->fetch_assoc();
                if (password_verify($password, $data['Password'])) {
                    $_SESSION['LoggedIn'] = true;
                    $_SESSION['UserID'] = $data['UserID'];
                    $_SESSION['FirstName'] = $data['FirstName'];
                    $_SESSION['LastName'] = $data['LastName'];
                    $_SESSION['Email'] = $data['Email'];
                    $_SESSION['Admin'] = $data['Admin'];
                    unset($_SESSION['error']);
                    $res->free_result();
                    header('Location: ../index.php');
                } else {
                    // $_SESSION['error'] = 'Incorrect login or password';
                    header('Location: ../views/login.php?error=Incorrect login or password');
                }
            } else {
                // $_SESSION['error'] = 'Incorrect login or password';
                header('Location: ../views/login.php?error=Incorrect login or password');
            }
        }

        $connection->close();
    }
    

?>