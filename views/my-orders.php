<?php
session_start();
include('../includes/header.php');
checkUserLogin($connection);
include('../includes/navbar.php');

if (!isset($_GET['id'])) {
  header('Location : admin.php');
  exit(1);
}
?>

<div class="py-3 bg-primary linker">
  <div class="container">
    <h6 class="text-white">
      <a href="../index.php" class="text-white">
        Home /
      </a>
      <a href="my-orders.php?id=<?=$_GET['id']?>" class="text-white">
        My orders
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
              if ($_GET['id'] == $_SESSION['UserID'] || $_SESSION['Admin'] == 1) { ?>
                <div class="card-header bg-primary">
                  <span class="text-white fs-3">Order</span> 
                  <a href="users.php" class="btn btn-warning float-end"><i class="bi bi-reply"></i> Back</a>
                </div>
                <table class="table table-bordered table-striped text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tracking number</th>
                      <th>Price</th>
                      <th>Date</th>
                      <th>More details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $orders = getOrders($connection);

                    if (mysqli_num_rows($orders) > 0) {
                      foreach ($orders as $order) { ?>
                        <tr>
                          <td class="align-middle">
                            <?= $order['id'] ?>
                          </td>
                          <td class="align-middle"><?= $order['tracking_no'] ?></td>
                          <td class="align-middle">$<?= $order['total_price'] ?></td>
                          <td class="align-middle">
                            <?= $order['created_at'] ?>
                          </td>
                          <td class="align-middle"><a href="order-details.php?t=<?= $order['tracking_no'] ?>&id=<?= $_GET['id'] ?>&back=my-orders.php"
                              class="btn btn-primary">More details</a></td>
                        </tr>
                        <?php }

                    } else { ?>
                      <td class="align-middle" colspan="5">No orders yet</td>
                      <?php }
                    ?>
                  </tbody>
                </table>

                <?php } else { ?>
                
                <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include('../includes/footer.php'); ?>