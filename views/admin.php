<?php
include('../includes/header.php');
session_start();
checkUserLogin($connection);
checkIfAdmin($connection);
include('../includes/navbar.php');
?>

<style>
    .panel {
        min-height: 800px;
    }

    .create-width {
        width: 110px;
    }

    .create-input-width {
        width: 600px;
        /* text-align: center;  */
        margin: 0 auto;
        float: none;
    }
</style>
<?php
if (isset($_GET['panel_card'])) {
    $panelID = $_GET['panel_card'];
} else {
    $panelID = 1;
}
?>

<div class="py-3 bg-primary linker">
    <div class="container">
        <h6 class="text-white">
            <a href="../index.php" class="text-white">
                Home /
            </a>
            <a href="admin.php" class="text-white">
                Panel
            </a>
        </h6>
    </div>
</div>

<!-- Admin panel -->
<section class="py-2 admin-panel">
    <div class="container rounded bg-white py-3" id="pills-newItem" role="tabpanel" aria-labelledby="pills-newItem-tab">
        <h4 class="display-4 text-center">Admin panel</h4>
        <hr><br>
        <a href="users.php"><button class="btn btn-outline-primary">Users</button></span></a><span>
        <a href="books.php"><button class="btn btn-outline-primary">Books</button></span></a><span>
        <a href="create-book.php"><button class="btn btn-outline-primary">Add book</button></span></a><span>
    </div>
</section>



<?php include('../includes/footer.php'); ?>