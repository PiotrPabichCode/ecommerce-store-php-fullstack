<?php
    session_start();

    if((isset($_SESSION['LoggedIn'])) && ($_SESSION['LoggedIn'] == true)) {
        header('Location: ../index.php');
        exit();
    }

    if (isset($_POST['email'])) {
        $flagOK = true;

        // Login validation
        $login = $_POST['login'];
        if((strlen($login) < 3) || (strlen($login) > 20)) {
            $flagOK = false;
            $_SESSION['error'] = "Login needs to have 3-20 characters";
        }

        if(ctype_alnum($login) == false) {
            $flagOK = false;
            $_SESSION['error'] = "Login can only contain letters and numbers";
        }

        // E-mail validation
        $email = $_POST['email'];
        $emailA = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($email, FILTER_VALIDATE_EMAIL) == false) || ($emailA != $email)) {
            $flagOK = false;
            $_SESSION['error'] = "Enter valid e-mail";
        }
        
        // Password validaton
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];
        if((strlen($password) < 8) || (strlen($password) > 20)) {
            $flagOK = false;
            $_SESSION['error'] = "Password needs to have 8-20 characters";
        }
        if ($password != $passwordRepeat) {
            $flagOK = false;
            $_SESSION['error'] = "Passwords are not the same";
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Remember data
        $_SESSION['f_login'] = $login;
        $_SESSION['f_email'] = $email;
        $_SESSION['f_password'] = $password;
        $_SESSION['f_repeatPassword'] = $passwordRepeat;

        include_once("../utils/connect.php");
        // mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $connection = @new mysqli($host, $db_user, $db_password, $db_name);
            if($connection->connect_errno != 0) {
                // throw new Exception(mysqli_connect_errno());
            } else {

                // Email validation
                $res = $connection->query("SELECT UserID FROM users WHERE Email='$email'");
                if (!$res) {
                    // throw new Exception($connection->error);
                }
                $email_counter = $res->num_rows;
                if ($email_counter > 0) {
                    $flagOK = false;
                    $_SESSION['error'] = "Email already taken.";
                }

                // Login validation
                $res = $connection->query("SELECT UserID FROM users WHERE Login='$login'");
                if (!$res) {
                    throw new Exception($connection->error);
                }
                $login_counter = $res->num_rows;
                if ($login_counter > 0) {
                    $flagOK = false;
                    $_SESSION['error'] = "Login already taken.";
                }

                if ($flagOK == true) {
                    // All data is okey
                    if ($connection->query("INSERT INTO users(Login, Password, Email) VALUES ('$login', '$passwordHash', '$email')")) {
                        header('Location: index.php');
                    }
                } else {
                    throw new Exception($connection->error);    
                }

                $connection->close();
            }
        } catch(Exception $e)  {
            // echo '<span style="color:red;"> Server error! Try again later.</span>';
            // echo '<br/> Developer information: '.$e;
        }
    }


?>

<?php include('../includes/header.php'); ?>

  <style>
    @media (min-width: 1025px) {
        .h-custom {
        height: 100vh !important;
        }
    }
    .card-registration .select-input.form-control[readonly]:not([disabled]) {
        font-size: 1rem;
        line-height: 2.15;
        padding-left: .75em;
        padding-right: .75em;
        }
    .card-registration .select-arrow {
        top: 13px;
        }

    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #a1c4fd;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
        }

    .bg-indigo {
        background-color: #4835d4;
        }
    @media (min-width: 992px) {
    .card-registration-2 .bg-indigo {
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        }
    }
    @media (max-width: 991px) {
    .card-registration-2 .bg-indigo {
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        }
    }
.wrapper {
    max-width: 350px;
    min-height: 500px;
    margin: 80px auto;
    padding: 40px 30px 30px 30px;
    background-color: #ecf0f3;
    border-radius: 15px;
}

.logo {
    width: 80px;
    margin: auto;
}

.logo img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0px 0px 3px #5f5f5f,
        0px 0px 0px 5px #ecf0f3,
        8px 8px 15px #a7aaa7,
        -8px -8px 15px #fff;
}

.wrapper .name {
    font-weight: 600;
    font-size: 1.4rem;
    letter-spacing: 1.3px;
    padding-left: 10px;
    color: #555;
}

.wrapper .form-field input {
    width: 100%;
    display: block;
    border: none;
    outline: none;
    background: none;
    font-size: 1.2rem;
    color: #666;
    padding: 10px 15px 10px 10px;
    /* border: 1px solid red; */
}

.wrapper .form-field {
    padding-left: 10px;
    margin-bottom: 20px;
    border-radius: 20px;
    box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
}

.wrapper .form-field .fas {
    color: #555;
}

.wrapper .btn {
    box-shadow: none;
    width: 100%;
    height: 40px;
    background-color: #03A9F4;
    color: #fff;
    border-radius: 25px;
    box-shadow: 3px 3px 3px #b1b1b1,
        -3px -3px 3px #fff;
    letter-spacing: 1.3px;
}

.wrapper .btn:hover {
    background-color: #039BE5;
}

.wrapper a {
    text-decoration: none;
    font-size: 0.8rem;
    color: #03A9F4;
}

.wrapper a:hover {
    color: #039BE5;
}
img {
    background-size: cover;
}

@media(max-width: 380px) {
    .wrapper {
        margin: 30px 20px;
        padding: 40px 15px 15px 15px;
    }
}

/* Validation */
.error {
    color: red;
    margin-top: 10px;
    margin-bottom: 10px;
}

</style>
<?php include('../includes/navbar.php'); ?>

    <!-- Registration form -->
    <section class="registration">
        <div class="wrapper">
            <div class="logo">
                <img src="../img/book.svg" alt="">
            </div>
            <div class="text-center mt-4 name">Bibliopolium</div>
            <form method="post" class="p-3 mt-3">
                    <?php if(isset($_GET['error'])) {?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_GET['error']; ?>
                    </div>
                    <?php } ?>
                <div class="form-field d-flex align-items-center">
                    <span class="far fa-user"></span>
                    <input type="text" name="email" id="email" placeholder="E-mail">
                </div>
                <div class="form-field d-flex align-items-center">
                    <span class="far fa-user"></span>
                    <input type="text" name="login" id="login" placeholder="Login">
                </div>
                <div class="form-field d-flex align-items-center">
                    <span class="fas fa-key"></span>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="form-field d-flex align-items-center">
                    <span class="fas fa-key"></span>
                    <input type="password" name="passwordRepeat" id="passwordRepeat" placeholder="Repeat password">
                </div>
                <button class="btn mt-3">Sign up</button>
            </form>
            <div class="text-center fs-6">
                <a>Already have an account?</a> <a href="login.php">Sign in</a>
            </div>
        </div>
    </section>

    <?php include('../includes/footer.php'); ?>