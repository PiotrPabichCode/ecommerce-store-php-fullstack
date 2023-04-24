<?php
session_start();
include('../includes/header.php');
checkUserLogin($connection);
include('../includes/navbar.php');

if (isset($_GET['t'])) {
    $tracking_number = $_GET['t'];
    $order = validTrackingNumber($connection, $tracking_number);
    if (mysqli_num_rows($order) < 0) {
        ?>
        <h4>Something went wrong</h4>
        <?php
        exit(1);
    }

} else { ?>
    <h4>Something went wrong</h4>
    <?php
    exit(1);
}

if (!isset($_GET['back'])) {
    header('Location: admin.php');
    exit(1);
}

if (!isset($_GET['id'])) {
    header('Location: '.$_GET['back'].'');
    exit(1);
}
if ($_SESSION['UserID'] != $_GET['id'] && $_SESSION['Admin'] != 1) {
    header('Location: '.$_GET['back'].'');
    exit(1);
}

$orderData = mysqli_fetch_array($order);
?>

<div class="py-3 bg-primary linker">
    <div class="container">
        <h6 class="text-white">
            <a href="../index.php" class="text-white">
                Home /
            </a>
            <a href="my-orders.php?id=<?= $_GET['id'] ?>" class="text-white">
                My orders /
            </a>
            <a href="" class="text-white">
                Order details
            </a>
        </h6>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="card card-body shadow">

            <div class="row">
                <div class="col-md-12">
                    <div class="p-3">
                        <?php
                        if (isset($_GET['id'])) {
                            if ($_GET['id'] == $_SESSION['UserID'] || $_SESSION['Admin'] == 1) {

                            } else { ?>
                                <h5 class="text-center mb-3">Not enough </h5>
                            <?php }
                        }
                        ?>
                        <div class="card">
                            <div class="card-header bg-primary">
                                <span class="text-white fs-3">View order</span> 
                                <a href="my-orders.php?id=<?= $_GET['id']?>" class="btn btn-warning float-end"><i class="bi bi-reply"></i> Back</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Delivery details</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Name</label>
                                                <div class="border p-1">
                                                    <?= $orderData['name']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">E-mail</label>
                                                <div class="border p-1">
                                                    <?= $orderData['email']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Phone</label>
                                                <div class="border p-1">
                                                    <?= $orderData['phone']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Tracking number</label>
                                                <div class="border p-1">
                                                    <?= $orderData['tracking_no']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="fw-bold">Address</label>
                                                <div class="border p-1">
                                                    <?= $orderData['pincode']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Order details</h4>
                                        <hr>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php
                                                $currUser = $_SESSION['UserID'];
                                                $query = "SELECT o.id as oid, o.tracking_no, o.user_id, oi.*, oi.qty as orderqty, b.* 
                                            FROM orders o, order_items oi, books b WHERE o.user_id='$currUser'
                                            AND oi.order_id=o.id AND b.BookID=oi.prod_id 
                                            AND o.tracking_no='$tracking_number'";
                                                $query_run = mysqli_query($connection, $query);
                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $item) { ?>
                                                        <tr>
                                                            <td class="align-middle">
                                                                <a href="item.php?product=<?= $item['BookID'] ?>">
                                                                    <img src="<?= $item['imageL']; ?>" width="50px"
                                                                        height="50px" alt="<?= $item['Booktitle']; ?>">
                                                                </a>
                                                            </td>
                                                            <td class="align-middle">
                                                                $<?= $item['price']; ?>
                                                            </td>
                                                            <td class="align-middle">
                                                                x<?= $item['orderqty']; ?>
                                                            </td>
                                                        </tr>
                                                        <?php }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <h4>Total price : <span class="float-end fw-bold">$<?= $orderData['total_price']; ?></span></h4>

                                        <hr>
                                        <label class="fw-bold">Payment mode</label>
                                        <div class="border p-1 mb-3">
                                            <?= $orderData['payment_mode']; ?>
                                        </div>
                                        <label class="fw-bold">Status</label>
                                        <div class="border p-1 mb-3">
                                            <?php
                                            if ($orderData['status'] == 0) {
                                                echo "Under proccess";
                                            } else if ($orderData['status'] == 1) {
                                                echo "Completed";
                                            } else if ($orderData['status'] == 2) {
                                                echo "Cancelled";
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer.php'); ?>