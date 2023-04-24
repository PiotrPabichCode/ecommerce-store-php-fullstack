<?php
session_start();

include("../utils/connect.php");

?>

<?php include('../includes/header.php');
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
</style>


<div class="py-3 bg-primary linker">
  <div class="container">
    <h6 class="text-white">
      <a href="../index.php" class="text-white">
        Home /
      </a>
      <a href="cart.php" class="text-white">
        Cart
      </a>
    </h6>
  </div>
</div>

<!-- Shopping Cart -->

<div class="py-5">
  <div class="container">
    <div class="card card-body shadow">

      <div class="row">
        <div class="col-md-12">
          <div id="mycart">
            <?php
            $items = getCartItems($connection);
            if ($items == null || mysqli_num_rows($items) == 0) { ?>
              <h5 class="text-center mb-3">Your cart is empty</h5>
              <?php } else { ?>
              <div class="row align-items-center">
                <div class="col-md-5">
                  <h6 class="fw-bold">Product</h6>
                </div>
                <div class="col-md-3">
                  <h6 class="fw-bold">Price</h6>
                </div>
                <div class="col-md-2">
                  <h6 class="fw-bold">Quantity</h6>
                </div>
                <div class="col-md-2">
                  <h6 class="fw-bold">Remove</h6>
                </div>
              </div>
              <hr>
              <?php foreach ($items as $citem) { ?>
                <div class="card shadow-sm mt-3">
                  <div class="row product_data align-items-center">
                    <div class="col-md-2">
                      <a href="item.php?product=<?= $citem['bid'] ?>">
                        <img src="<?= $citem['imageL'] ?>" alt="Image" width="80px">
                      </a>
                    </div>
                    <div class="col-md-3">
                      <h5>
                        <?= $citem['Booktitle'] ?>
                      </h5>
                    </div>
                    <div class="col-md-3">
                      <h5>$<?= $citem['PriceAfterDiscount'] ?></h5>
                    </div>
                    <div class="col-md-2">
                      <input type="hidden" class="prodID" value="<?= $citem['prod_id'] ?>">
                      <input type="hidden" class="prodID1" value="<?= $citem['Quantity'] ?>">
                      <div class="input-group" style="width: 130px">
                        <button id="decrement_qty" class="input-group-text decrement-btn update-qty">-</button>
                        <input id="increment-btn" type="text" class="form-control text-center input-qty bg-white"
                          value="<?= $citem['prod_qty'] ?>" disabled>
                        <button id="increment_qty" class="input-group-text increment-btn update-qty" <?php if ($citem['Quantity'] == $citem['prod_qty']) {
                        echo 'disabled'; } ?>>+</button>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button class="btn btn-danger delete-item" value="<?= $citem['cid'] ?>">
                        <i class="bi bi-trash me-2"></i>Remove</button>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <div class="float-end mt-3">
                  <a href="checkout.php" class="btn btn-outline-primary">Proceed to checkout</a>
                </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include('../includes/footer.php'); ?>