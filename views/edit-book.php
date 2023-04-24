<?php
session_start();
if (!isset($_SESSION['LoggedIn'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['Admin'] != 1) {
    header('Location: account.php');
    exit();
}

include("../utils/connect.php");
?>

<?php include('../includes/header.php'); ?>

<style>
    .panel {
        height: 800px;
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
<?php include('../includes/navbar.php'); ?>

<div class="py-3 bg-primary linker">
    <div class="container">
        <h6 class="text-white">
            <a href="../index.php" class="text-white">
                Home /
            </a>
            <a href="admin.php" class="text-white">
                Panel /
            </a>
            <a href="" class="text-white">
                Edit panel
            </a>
        </h6>
    </div>
</div>

<!-- Admin panel -->
<div class="container px-4 py-3">
    <div class="row">
        <div class="card py-3">
            <div class="card-header">
                <span class="fs-3">Edit book</span>
                <a href="books.php" class="btn btn-primary float-end"><i class="bi bi-reply"></i> Back</a>
            </div>
            <div class="card-body">

                <?php
                if (isset($_GET['id'])) {
                    $bookID = $_GET['id'];
                    $myBook = "SELECT * from books where BookID = '$bookID'";
                    $bookRun = mysqli_query($connection, $myBook);
                    if (mysqli_num_rows($bookRun) > 0) {

                        foreach ($bookRun as $book) {
                            $authorID = $book['AuthorID'];
                            $categoryID = $book['CategoryID'];
                            $publisherID = $book['PublisherID'];
                            $discountID = $book['DiscountID'];

                            $myauthor = "SELECT * from authors where AuthorID = '$authorID'";
                            $authorRun = mysqli_query($connection, $myauthor);
                            $author = mysqli_fetch_assoc($authorRun);

                            $mycategory = "SELECT * from category where CategoryID = '$categoryID'";
                            $categoryRun = mysqli_query($connection, $mycategory);
                            $category = mysqli_fetch_assoc($categoryRun);

                            $mypublisher = "SELECT * from publishers where PublisherID = '$publisherID'";
                            $publisherRun = mysqli_query($connection, $mypublisher);
                            $publisher = mysqli_fetch_assoc($publisherRun);

                            $mydiscount = "SELECT * from discount where DiscountID = '$discountID'";
                            $discountRun = mysqli_query($connection, $mydiscount);
                            $discount = mysqli_fetch_assoc($discountRun);
                            ?>
                            <?php include('../controllers/message.php'); ?>
                            <form action="../controllers/update_book.php" method="POST">
                                <input type="hidden" name="book_id" value="<?= $book['BookID']; ?>">
                                <div class="col-md-12 mb-3">
                                    <label for="">Book title</label>
                                    <input type="text" name="booktitle" value="<?= $book['Booktitle']; ?>" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Author</label>
                                    <input type="text" name="authorname" value="<?= $author['AuthorName']; ?>" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Category</label>
                                    <select class="form-select" name="category" id="category-select">
                                        <option selected id="0" value="<?= $category['CategoryName']; ?>">
                                            <?= $category['CategoryName']; ?>
                                        </option>
                                        <?php
                                        $res = mysqli_query($connection, "SELECT * from category");
                                        $i = 1;
                                        while ($rows = mysqli_fetch_assoc($res)) {
                                            if ($rows['CategoryName'] != $category['CategoryName']) { ?>
                                                <option id="<?= $i ?>" value="<?= $rows['CategoryName']; ?>">
                                                    <?= $rows['CategoryName'] ?>
                                                </option>
                                                <?php } ?>

                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Year</label>
                                    <input type="text" name="year" value="<?= $book['Year']; ?>" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Quantity</label>
                                    <input type="text" name="quantity" value="<?= $book['Quantity']; ?>" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Publisher</label>
                                    <input type="text" name="publishername" value="<?= $publisher['PublisherName']; ?>"
                                        class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Price [$]</label>
                                    <input type="text" name="price" value="<?= $book['Price']; ?>" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Discount [%]</label>
                                    <select class="form-select" name="discount" id="discount-select">
                                        <option selected>
                                            <?= $discount['Precent'] . ' %'; ?>
                                        </option>
                                        <?php
                                        $res = mysqli_query($connection, "SELECT * from discount ORDER BY Precent ASC");
                                        $i = 1;
                                        while ($rows = mysqli_fetch_assoc($res)) {
                                            if ($rows['Precent'] != $discount['Precent']) { ?>
                                                <option value="<?$i?>">
                                                    <?= $rows['Precent'] . ' %' ?>
                                                </option>
                                                <?php }
                                            ?>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Image</label>
                                    <input type="text" name="image" value="<?= $book['imageL']; ?>" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" name="update_book" class="btn btn-primary">Update book</button>
                                </div>
                            </form>
                            <?php
                        }
                    } else { ?>
                        <h4>No record found</h4>
                        <?php

                    }
                } ?>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer.php'); ?>