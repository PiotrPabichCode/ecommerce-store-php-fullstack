<?php
session_start();
include("../utils/connect.php");

if (!isset($_GET['product'])) {
  header('Location: products.php');
  exit();
}
$productItem = $_GET['product'];
$productData = $connection->query("SELECT * FROM books WHERE BookID = '$productItem'");
if (mysqli_num_rows($productData) == 0) {
  header('Location: products.php');
  exit();
}
$product = mysqli_fetch_array($productData);

$resAuthor = $connection->query("SELECT * from authors where AuthorID = $product[AuthorID]");
$author = mysqli_fetch_array($resAuthor);

$resCategory = $connection->query("SELECT * from category where CategoryID = $product[CategoryID]");
$category = mysqli_fetch_array($resCategory);

$resPublisher = $connection->query("SELECT * from publishers where PublisherID = $product[PublisherID]");
$publisher = mysqli_fetch_array($resPublisher);

?>

<?php include('../includes/header.php'); ?>
<style>
  img {
    background-size: cover;
    border-radius: 5%;
  }

  .img-size {
    width: 370px;
    height: 530px;
    margin-top: 10px;
    margin-left: 240px;
    padding-top: 20px;
    padding-bottom: 20px;
    border-radius: 10%;
  }

  .unavailable-img {
    width: 350px;
    height: 500px;
    /* margin-top: 40px; */
    margin-left: 240px;
    padding-top: 20px;
    padding-bottom: 20px;
    border-radius: 10%;
  }

  .newarrival {
    background: green;
    max-width: 80px;
    color: white;
    font-size: 12px;
    font-weight: bold;
  }

  .col-md-7 h2 {
    color: white;
    font-size: 36px;
  }

  .col-md-7 p,
  label {
    color: white;
  }

  .price {
    color: #FE980F;
    font-size: 26px;
    font-weight: bold;
    padding-top: 20px;
  }

  .cart {
    background: #FE980F;
    color: #FFFFFF;
    font-size: 15px;
  }

  .linker-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 700px;
  }
</style>

<?php include('../includes/navbar.php'); ?>

<div class="py-3 bg-primary linker">
  <div class="container">
    <h6 class="text-white linker-title">
      <a href="../index.php" class="text-white">
        Home /
      </a>
      <a href="products.php" class="text-white">
        Products /
      </a>
      <a href="" class="text-white">
        <?= $product['Booktitle'] ?>
      </a>
    </h6>
  </div>
</div>

<!-- Product -->

<section classs="container product">
  <div class="row product_data">
    <input type="hidden" class="prodID1" value="<?= $product['Quantity'] ?>" disabled>
    <div class="col-md-5">
      <img class="<?php if ($product['Quantity'] == 0) {
      echo 'unavailable-img';
    } else {
      echo 'img-size';
    } ?>" src="<?= $product['imageL'] ?>" alt="">
    </div>
    <div class="col-md-7 pt-5">
      <?php
      $choice = rand(0, 2);
      if ($choice == 0) { ?>
        <p class="newarrival text-center">NEW</p>
        <?php } else if ($choice == 1) { ?>
        <p class="newarrival text-center">BEST SELLER</p>
        <?php } else if ($choice == 2) { ?>
        <p class="newarrival text-center">TRENDING</p>
        <?php } ?>
      <h2>
        <?= $product['Booktitle'] ?> <a class="lock addToFavorite" id="<?= $product['BookID']?>" style='cursor: pointer'>
        <?php
          $curr_fav_user = $_SESSION['UserID'];
          $bID = $product['BookID'];
          $fav_query = "SELECT * FROM favorites WHERE prod_id = '$bID' AND user_id = '$curr_fav_user'";
          $fav_query_run = mysqli_query($connection, $fav_query);
          if(mysqli_num_rows($fav_query_run) > 0) { ?>
              <i class="bi bi-heart-fill "></i>                                           
          <?php } else { ?>
             <i class="bi bi-heart "></i>
          <?php }

        ?>
        
        </a>
      </h2>
      <?php
      if ($product['DiscountID'] != 5) { ?>
        <h3 class="fw-bolder fs-2">
          <span class="text-decoration-line-through">$<?php echo $product['Price'] ?></span>
          <?php } ?>
        <span class="text-light">$<?php echo $product['PriceAfterDiscount'] ?></span>
      </h3>
      <p><b>Book author:</b>
        <?= $author['AuthorName'] ?>
      </p>
      <p><b>Category:</b> <?= $category['CategoryName'] ?></p>
      <?php
      if ($product['Quantity'] <= 0) { ?>
        <p><b>Availability:</b> Out of stock</p>
        <?php } else { ?>
        <p><b>Availability:</b> In stock (<?= $product['Quantity'] ?> products)</p>
        <?php } ?>
      <p><b>Condition:</b> New</p>
      <p><b>Publisher:</b>
        <?= $publisher['PublisherName'] ?>
      </p>
      <?php if ($product['Quantity'] > 0) { ?>
        <label>Quantity:</label>
        <div class="input-group my-3" style="width: 130px">
          <button id="decrement_qty" class="input-group-text decrement-btn" disabled>-</button>
          <input type="text" class="form-control text-center input-qty bg-white" value="1" disabled>
          <button id="increment_qty" class="input-group-text increment-btn">+</button>
        </div>
        <span>
          <button type="submit" class="btn btn-default cart addToCartBtn mb-3" value="<?= $product['BookID'] ?>">Add to
            cart</button>
        </span>
        <?php } else { ?>
        <h3 class="fw-bolder text-light">Product unavailable</h3>
        <button type="submit" class="btn btn-default cart addToCartBtn mb-3" disabled>Add to
          cart</button>
        <?php } ?>
    </div>
  </div>
</section>


<?php include('../includes/footer.php'); ?>