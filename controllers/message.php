<?php
if (isset($_SESSION['message'])) {
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION['message']);
}
if (isset($_SESSION['error_message'])) {
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?= $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION['error_message']);
}
?>