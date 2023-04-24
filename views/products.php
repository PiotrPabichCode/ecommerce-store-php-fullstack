<?php
session_start();

include("../utils/connect.php");

$limit = 30;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$result = $connection->query("SELECT * FROM books LIMIT $start, $limit");
$books = $result->fetch_all(MYSQLI_ASSOC);

$result1 = $connection->query("SELECT count(BookID) AS id FROM books");
$booksCount = $result1->fetch_all(MYSQLI_ASSOC);
$total = $booksCount[0]['id'];
$pages = ceil($total / $limit);

$Previous = ($page - 1 == 0) ? 1 : $page - 1;
$Next = ($page + 1 > $pages) ? $page : $page + 1;

?>

<?php include('../includes/header.php'); ?>

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
      <a href="products.php" class="text-white">
        Products
      </a>
    </h6>
  </div>
</div>

<!-- Products -->

<section class="py-2">
  <div class="container rounded bg-white px-4 px-lg-5 mt-5">
  <!-- <form class="py-2" action="" method="get">
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
      ?> -->
    <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 pt-3">
      <?php foreach ($books as $book): ?>
        <div class="col mb-5">
          <div class="card h-100">
            <!-- Product image-->

            <a href="item.php?product=<?= $book['BookID'] ?>">
              <img class="card-img-top img-item" src="<?php echo $book['imageL'] ?>" alt="..." />
            </a>
            <!-- Product details-->
            <div class="card-body p-4">
              <div class="text-center">
                <!-- Product name-->
                <h3 class="fw-bolder">
                  <?php echo $book['Booktitle'] ?>
                </h3>
                <!-- Product price-->
                <?php
                if ($book['DiscountID'] != 5) { ?>
                  <span class="text-muted text-decoration-line-through">$<?php echo $book['Price'] ?></span>
                  <?php } ?>$<?php echo $book['PriceAfterDiscount'] ?>
              </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
              <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    </div>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end py-5">
        <li class="page-item">
          <a class="page-link" href="products.php?page=<?= $Previous; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo; Previous</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <li class="page-item"><a class="page-link" href="products.php?page=<?= $i; ?>">
              <?= $i; ?>
            </a></li>
          <?php endfor; ?>
        <li class="page-item">
          <a class="page-link" href="products.php?page=<?= $Next; ?>" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
          </a>
        </li>
      </ul>
    </nav>

  </div>

</section>

<?php include('../includes/footer.php'); ?>