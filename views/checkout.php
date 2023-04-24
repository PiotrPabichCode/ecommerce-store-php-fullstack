<?php
session_start();
include('../includes/header.php');
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
        /* white-space: nowrap; */
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 700px;
        max-height: 150px;
    }
    .active-payment {
        background-color: green !important;
    }
</style>

<div class="py-3 bg-primary linker">
    <div class="container">
        <h6 class="text-white">
            <a href="../index.php" class="text-white">
                Home /
            </a>
            <a href="cart.php" class="text-white">
                Cart /
            </a>
            <a href="checkout.php" class="text-white">
                Checkout
            </a>
        </h6>
    </div>
</div>

<!-- Checkout -->

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow">
            <form action="../controllers/handleorder.php" method="POST">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <h5>User details</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">Country</label>
                                <input type="text" name="country" required placeholder="Enter your country"
                                    class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">First Name</label>
                                <input type="text" name="fname" required placeholder="Enter your first name"
                                    class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">Last Name</label>
                                <input type="text" name="lname" required placeholder="Enter your last name"
                                    class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">E-mail</label>
                                <input type="email" name="email" required placeholder="Enter your email"
                                    class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Street</label>
                                <input type="text" name="street" required placeholder="Enter your street name"
                                    class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="fw-bold">Home no.</label>
                                <input type="text" name="homeno" placeholder="Home no." class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="fw-bold">Flat no.</label>
                                <input type="text" name="flatno" placeholder="Flat no." class="form-control">
                            </div>

                            <!-- <div class="col-md-12 mb-3">
                                <label class="fw-bold">Pin code</label>
                                <input type="text" name="pincode" required placeholder="Enter your pin code"
                                    class="form-control">
                            </div> -->

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Zip code</label>
                                <input type="text" name="zipcode" required placeholder="Enter your zip code"
                                    class="form-control">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="fw-bold">City</label>
                                <input type="text" name="city" required placeholder="Enter your city"
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Prefix</label>
                                <input type="text" name="prefix" required placeholder="Enter phone prefix"
                                    class="form-control">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="fw-bold">Phone</label>
                                <input type="text" name="phone" required placeholder="___ ___ ___" class="form-control">
                            </div>

                            <!-- <div class="col-md-12 mb-3">
                                <label class="fw-bold">Address</label>
                                <textarea name="address" required class="form-control" rows="5"></textarea>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-lg-6  col-sm-12">
                        <h5>Order details</h5>
                        <hr>
                        <?php
                        $items = getCartItems($connection);
                        $totalPrice = 0;
                        if ($items == null || mysqli_num_rows($items) == 0) { ?>
                            <h5 class="text-center mb-3">Your cart is empty</h5>
                            <?php } else {
                            foreach ($items as $citem) { ?>
                                <div class="card shadow-sm mt-3">
                                    <div class="row product_data align-items-center">
                                        <div class="col-md-2">
                                            <img src="<?= $citem['imageL'] ?>" alt="Image" width="80px">
                                        </div>
                                        <div class="col-md-3">
                                            <h5 class="linker-title">
                                                <?= $citem['Booktitle'] ?>
                                            </h5>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>$<?= $citem['PriceAfterDiscount'] ?></h5>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>x <?= $citem['prod_qty'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $totalPrice += $citem['PriceAfterDiscount'] * $citem['prod_qty'];
                            } ?>
                            <hr>
                            <h3>Create new account</h3>
                            <p>You can create new account, if you give us your password</p>
                            <div class="col-md-12 mb-3">
                                <input type="password" name="password" placeholder="Password to your account"
                                    class="form-control">
                            </div>
                            <div class="col-md-12 mb-3 text-center" data-toggle="buttons">
                                <label class="fw-bold payment-label">Payment mode</label> <br>
                                <!-- <span>
                                <button class="btn btn-outline-success col-md-3 payment-btn form-check" type="button" id="cash">
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Cash
                                            </label>
                                        </div>
                                    </button>
                                </span>
                                <span>
                                    <button class="btn btn-outline-success col-md-3 payment-btn form-check" type="button" id="cash">
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck2">
                                            <label class="form-check-label" for="defaultCheck2">
                                                Bank transfer
                                            </label>
                                        </div>
                                    </button>
                                </span>
                                <span>
                                <button class="btn btn-outline-success col-md-3 payment-btn form-check" type="button" id="cash">
                                        <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck3">
                                            <label class="form-check-label" for="defaultCheck3">
                                                Credit card
                                            </label>
                                        </div>
                                    </button>
                                </span> -->
                                    <label class="btn btn-outline-success col-md-3 col-sm-12">
                                        <input type="radio" name="payment_id" id="option1" value="Cash" autocomplete="off"> Cash
                                    </label>
                                    <label class="btn btn-outline-success col-md-3 col-sm-12">
                                        <input type="radio" name="payment_id" id="option2" value="Bank transfer" autocomplete="off"> Bank transfer
                                    </label>
                                    <label class="btn btn-outline-success col-md-3 col-sm-12">
                                        <input type="radio" name="payment_id" id="option3" value="Credit card" autocomplete="off"> Credit card
                                    </label>
                                <!-- <span><button class="btn btn-outline-success col-md-3 payment-btn" type="button" id="bank_transfer">Bank transfer</button></span>
                                <span><button class="btn btn-outline-success col-md-3 payment-btn" type="button" id="credit-card">Credit card</button></span> -->
                                <!-- <input type="select" name="paymentmode" required placeholder="Choose payment mode" class="form-control"> -->

                            </div>
                            <h5>Total price : <span class="float-end fw-bold">$<?= $totalPrice ?></span></h5>
                            <div>
                                <input type="hidden" name="payment_mode" value="Cash">
                                <button type="submit" name="place-order-btn" class="btn btn-primary w-100">Confirm and place
                                    order</button>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("button").click(function(){
    $("payment-label").id = 
    $("active-payment").addClass("active");
    });
</script>


<?php include('../includes/footer.php'); ?>