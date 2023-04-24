<?php
session_start();

?>

<?php include('../includes/header.php');

function unsetVariables()
{
    unset($_SESSION['booktitle-create']);
    unset($_SESSION['category-create']);
    unset($_SESSION['author-create']);
    unset($_SESSION['year-create']);
    unset($_SESSION['quantity-create']);
    unset($_SESSION['publisher-create']);
    unset($_SESSION['price-create']);
    unset($_SESSION['discount-create']);
    unset($_SESSION['image-create']);
}

?>

<style>
  img {
    background-size: cover;
  }
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
      <a href="create-book.php" class="text-white">
        Add book
      </a>
    </h6>
  </div>
</div>

<!-- Products -->

<section class="py-2 admin-panel">
    <div class="container rounded bg-white py-3">
        <h4 class="display-4 text-center">Admin panel</h4>
        <hr><br>
        <a href="users.php"><button class="btn btn-outline-primary">Users</button></span></a><span>
        <a href="books.php"><button class="btn btn-outline-primary">Books</button></span></a><span>
        <a href="create-book.php"><button class="btn btn-primary">Add book</button></span></a><span>
    </div>
    <div class="container bg-white py-3">
        <h4 class="display-4 text-center">Create</h4>
        <hr><br>
        <?php include('../controllers/message.php'); ?>
        <form class="justify-content-center align-items-center" action="../controllers/create.php" method="POST">
            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger create-input-width mb-3 text-center" role="alert">
                <?php
                echo $_GET['error'];
                unset($_POST['error']);
                ?>
            </div>
            <?php } ?>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Book title</span>
                <input type="text" class="form-control" name="booktitle" 
                placeholder="Enter book title" 
                    <?php
                    if (isset($_SESSION['booktitle-create'])) {
                        echo 'value="' . $_SESSION['booktitle-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Category</span>
                <select class="form-select" name="category" id="category" >
                    <option value="0" id="0" selected>Choose category...</option>
                    <?php
                    $res = mysqli_query($connection, "SELECT * from category");
                    $i = 1;
                    while ($rows = mysqli_fetch_assoc($res)) { ?>
                    <option value="<?= $i ?>" id="<?= $i?>"
                    <?php
                    if (isset($_SESSION['category-create'])) {
                        if ($_SESSION['category-create'] == $i) {
                            echo "selected";
                        }
                    };
                    ?>><?= $rows['CategoryName'] ?></option>
                    <?php
                    $i++;
                } ?>
                </select>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Author name</span>
                <input type="text" class="form-control" id="author"
                    name="author" placeholder="Enter author name" 
                    <?php
                    if (isset($_SESSION['author-create'])) {
                        echo 'value="' . $_SESSION['author-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Year</span>
                <input type="text" class="form-control" id="year" name="year"
                 placeholder="Enter year" 
                 <?php
                    if (isset($_SESSION['year-create'])) {
                        echo 'value="' . $_SESSION['year-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Quantity</span>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    placeholder="Enter quantity" 
                    <?php
                    if (isset($_SESSION['quantity-create'])) {
                        echo 'value="' . $_SESSION['quantity-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Publisher</span>
                <input type="text" class="form-control" id="publisher" name="publisher"
                    placeholder="Enter publisher name" 
                    <?php
                    if (isset($_SESSION['publisher-create'])) {
                        echo 'value="' . $_SESSION['publisher-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Price</span>
                <input type="text" class="form-control" id="price" name="price"
                    placeholder="Enter price" 
                    <?php
                    if (isset($_SESSION['price-create'])) {
                        echo 'value="' . $_SESSION['price-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Discount</span>
                <select class="form-select" id="discount" name="discount" >
                    <option value="0" id="0" selected>Choose discount...</option>
                    <?php
                    $res = mysqli_query($connection, "SELECT * from discount ORDER BY Precent ASC");
                    $i = 1;
                    while ($rows = mysqli_fetch_assoc($res)) { ?>
                    <option value="<?= $i ?>" id="<?= $i?>"
                    <?php
                    if (isset($_SESSION['discount-create'])) {
                        if ($_SESSION['discount-create'] == $i) {
                            echo "selected";
                        }
                    };
                    ?>><?= $rows['Precent'] . ' %' ?></option>
                    <?php
                    $i++;
                } ?>
                </select>
            </div>
            <div class="input-group mb-3 create-input-width">
                <span class="input-group-text create-width justify-content-center">Image URL</span>
                <input type="text" class="form-control" id="image"
                    name="image" placeholder="Enter image URL" 
                    <?php
                    if (isset($_SESSION['image-create'])) {
                        echo 'value="' . $_SESSION['image-create'] . '"';
                    }
                    ?>>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mb-3 create-input-width"
                    name="create">Create</button>
            </div>
        </form>
    </div>
</section>

<?php include('../includes/footer.php'); ?>