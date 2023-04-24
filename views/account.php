<?php
session_start();
if (!isset($_SESSION['LoggedIn'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['Admin'] == 1) {
    header('Location: admin.php');
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="py-3 bg-primary linker">
    <div class="container">
        <h6 class="text-white">
            <a href="../index.php" class="text-white">
                Home /
            </a>
            <a href="account.php" class="text-white">
                Account
            </a>
        </h6>
    </div>
</div>

<!-- Profile -->

<!-- Admin panel -->
<section class="py-2 admin-panel">
    <div class="container rounded bg-white py-3" id="pills-newItem" role="tabpanel" aria-labelledby="pills-newItem-tab">
        <h4 class="display-4 text-center">User panel</h4>
        <h4 class="font-weight-bold">
        <?= $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] ?>
        </h4><span class="text-black-50"><?= $_SESSION['Email'] ?></span><span> </span>
        <hr><br>
        <a href="your-addresses.php"><button class="btn btn-outline-primary">Your addresses</button></span></a><span>
        <a href="my-orders.php?id=<?= $_SESSION['UserID']?>"><button class="btn btn-outline-primary">Your orders</button></span></a><span>
        <a href="your-account-settings.php"></a><button class="btn btn-outline-primary">Change account settings</button></span><span>
        <div class="row">
            <div class="col-md-3 border-right">
            </div>
        </div>
    </div>
</section>

<?php include('../includes/footer.php'); ?>