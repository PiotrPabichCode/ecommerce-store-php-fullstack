<?php
    session_start();

    if((isset($_SESSION['LoggedIn'])) && ($_SESSION['LoggedIn'] == true)) {
        header('Location: ../index.php');
        exit();
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

    .login-err {
        border-radius: 25px;
    }

    @media(max-width: 380px) {
        .wrapper {
            margin: 30px 20px;
            padding: 40px 15px 15px 15px;
        }
    }
  </style>
 <?php include('../includes/navbar.php'); ?>

    <!-- Login form -->
    <section class="registration">
        <div class="wrapper">
            <div class="logo">
                <img src="../img/book.svg" alt="">
            </div>
            <div class="text-center mt-4 name">Bibliopolium</div>
            <form class="p-3 mt-3 needs-validation" action="../controllers/sign-in.php" method="post" novalidate>
                <?php if(isset($_GET['error'])) {?>
                <div class="alert alert-danger mb-3 text-center login-err" role="alert">
                <?php
                    echo $_GET['error'];
                    unset($_POST['error']);
                ?>
                </div>
                <?php } ?>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="login" id="login" placeholder="Login" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="form-field d-flex align-items-center">
                    <span class="fas fa-key"></span>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <button class="btn mt-3">Login</button>
            </form>
            <div class="text-center fs-6">
                <a href="#">Forget password?</a> or <a href="registration.php">Sign up</a>
            </div>
        </div>
    </section>

    <?php include('../includes/footer.php'); ?>