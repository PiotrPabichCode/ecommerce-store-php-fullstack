<?php
include('../includes/header.php');
session_start();
checkUserLogin($connection);
checkIfAdmin($connection);

include("../utils/connect.php");

$limit = 30;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result1 = $connection->query("SELECT count(UserID) AS id FROM users");
$booksCount = $result1->fetch_all(MYSQLI_ASSOC);
$total = $booksCount[0]['id'];
$pages = ceil($total / $limit);

$Previous = ($page - 1 == 0) ? 1 : $page - 1;
$Next = ($page + 1 > $pages) ? $page : $page + 1;

?>

<style>
  img {
    background-size: cover;
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
      <a href="users.php" class="text-white">
        Users
      </a>
    </h6>
  </div>
</div>

<!-- Products -->

<section class="py-2 admin-panel">
    <div class="container rounded bg-white py-3" id="pills-newItem" role="tabpanel" aria-labelledby="pills-newItem-tab">
        <h4 class="display-4 text-center">Admin panel</h4>
        <hr><br>
        <a href="users.php"><button class="btn btn-primary">Users</button></span></a><span>
        <a href="books.php"><button class="btn btn-outline-primary">Books</button></span></a><span>
        <a href="create-book.php"><button class="btn btn-outline-primary">Add book</button></span></a><span>
        <div class="container rounded bg-white px-4 px-lg-5 mt-5">
  <form class="py-2" action="" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" id="search-book" aria-label="Search">
      </form>
      <?php
      if (isset($_GET['search-book'])) {
        $search_book = $_GET['search-book'];
        $searches = getSearchBooks($connection, $search_book);
        if (mysqli_num_rows($search_book) > 0) {
          $searchData = mysqli_fetch_all($searches);
        }
      }
      ?>
    <table class="table table-bordered table-striped text-center">
        <tbody>
            <?php
            if (isset($_SESSION['UserID'])) {
                $curr_user = $_SESSION['UserID'];
                $counter = 1 + ($page - 1) * $limit;
                $query = "SELECT * FROM users LIMIT $start, $limit";
                $items = mysqli_query($connection, $query);
                
                if (mysqli_num_rows($items) > 0) { ?>
                    <h1 class="display-4 fs-1">Users</h1>
                    <hr>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First name</th>
                            <th scope="col">Last name</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Orders</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($items as $fitem) {
                        ?>

                        <tr>
                            <td class="align-middle"><?= $counter ?></td>
                            <td class="align-middle linker-title"><?= $fitem['FirstName']?></td>
                            <td class="align-middle linker-title"><?= $fitem['LastName']?></td>
                            <td class="align-middle linker-title"><?= $fitem['Email']?></td>
                            <td class="align-middle">
                              <a href="my-orders.php?id=<?= $fitem['UserID']?>">
                                <button class="btn btn-primary">Orders</button>
                              </a>
                            </td>
                        <tr>
                            <?php
                            $counter++;
                    }
                } else { ?>
                    <td colspan="5">No more records</td>
                <?php  }
            } ?>

        </tbody>
    </table>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end py-5">
        <li class="page-item">
          <a class="page-link" href="users.php?page=<?= $Previous; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo; Previous</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <li class="page-item"><a class="page-link" href="users.php?page=<?= $i; ?>">
              <?= $i; ?>
            </a></li>
          <?php endfor; ?>
        <li class="page-item">
          <a class="page-link" href="users.php?page=<?= $Next; ?>" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
          </a>
        </li>
      </ul>
    </nav>

  </div>
    </div>

</section>

<?php include('../includes/footer.php'); ?>