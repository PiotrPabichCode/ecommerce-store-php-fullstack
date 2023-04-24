<?php
session_start();
include('../includes/header.php');
checkUserLogin($connection);
include('../includes/navbar.php');
?>

<style>
    img {
        background-size: cover;
    }

    .img-cart {
        height: 130px;
        width: 130px;
    }

    .linker-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 500px;
  }
</style>


<div class="py-3 bg-primary linker">
    <div class="container">
        <h6 class="text-white">
            <a href="../index.php" class="text-white">
                Home /
            </a>
            <a href="favorites.php" class="text-white">
                Favorites
            </a>
        </h6>
    </div>
</div>

<!-- Favorites -->

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow">

            <div class="row">
                <div class="col-md-12">
                    <div class="p-3">
                        <div id="mywishlist">

                            <table class="table table-bordered table-striped text-center">
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['UserID'])) {
                                        $curr_user = $_SESSION['UserID'];
                                        $query = "SELECT * FROM books b, favorites f WHERE f.user_id = '$curr_user' AND b.BookID = f.prod_id";
                                        $items = mysqli_query($connection, $query);
                                        $counter = 1;
                                        if (mysqli_num_rows($items) > 0) { ?>
                                            <h1 class="display-4 fs-1">Books</h1>
                                            <hr>
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Book name</th>
                                                    <th scope="col">Author</th>
                                                    <th scope="col">Publisher</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Year</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Remove</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            foreach ($items as $fitem) {
                                                $author_id = $fitem['AuthorID'];
                                                $publisher_id = $fitem['PublisherID'];
                                                $category_id = $fitem['CategoryID'];
                                                $query_author = "SELECT * FROM authors WHERE AuthorID = '$author_id'";
                                                $query_publisher = "SELECT * FROM publishers WHERE PublisherID = '$publisher_id'";
                                                $query_category = "SELECT * FROM category WHERE CategoryID = '$category_id'";

                                                $author = mysqli_query($connection, $query_author);
                                                $authorRow = mysqli_fetch_array($author);
                                                $publisher = mysqli_query($connection, $query_publisher);
                                                $publisherRow = mysqli_fetch_array($publisher);
                                                $category = mysqli_query($connection, $query_category);
                                                $categoryRow = mysqli_fetch_array($category);
                                                ?>

                                                <tr>
                                                    <td class="align-middle">
                                                        <?= $counter ?>
                                                    </td>
                                                    <td class="align-middle linker-title"> <a href="item.php?product=<?= $fitem['BookID'] ?>"><img src="<?= $fitem['imageL'] ?>" width="50px" height="50px" alt="<?= $fitem['imageL'] ?>"></a> </td>
                                                    <td class="align-middle linker-title"><?= $fitem['Booktitle'] ?></td>
                                                    <td class="align-middle">
                                                        <?= $authorRow['AuthorName'] ?>
                                                    </td>
                                                    <td class="align-middle"><?= $publisherRow['PublisherName'] ?></td>
                                                    <td class="align-middle">
                                                        <?= $categoryRow['CategoryName'] ?>
                                                    </td>
                                                    <td class="align-middle"><?= $fitem['Year'] ?></td>
                                                    <td class="align-middle">$<?= $fitem['PriceAfterDiscount'] ?></td>
                                                    <td class="align-middle"><button class="btn btn-danger delete-favorite-item"
                                                            value="<?= $fitem['id'] ?>">
                                                            <i class="bi bi-trash me-2"></i>Remove</button></td>
                                                <tr>
                                                    <?php
                                                    $counter++;
                                            }
                                        } else { ?>
                                            <td colspan="5">Your wishlist is empty</td>
                                       <?php  }
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer.php'); ?>