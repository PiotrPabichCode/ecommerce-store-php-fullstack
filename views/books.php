<?php
session_start();

include("../utils/connect.php");

$limit = 30;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

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
      <a href="admin.php" class="text-white">
        Panel /
      </a>
      <a href="books.php" class="text-white">
        Books
      </a>
    </h6>
  </div>
</div>

<!-- Products -->

<section class="py-2 admin-panel">
    <div class="container rounded bg-white py-3" id="pills-newItem" role="tabpanel" aria-labelledby="pills-newItem-tab">
        <h4 class="display-4 text-center">Admin panel</h4>
        <hr><br>
        <a href="users.php"><button class="btn btn-outline-primary">Users</button></span></a><span>
        <a href="books.php"><button class="btn btn-primary">Books</button></span></a><span>
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
      <div id="mybooks">
      <table class="table table-bordered table-striped text-center">
        <tbody>
            <?php
            if (isset($_SESSION['UserID'])) {
                $curr_user = $_SESSION['UserID'];
                $counter = 1 + ($page - 1) * $limit;
                $query = "SELECT * FROM books LIMIT $start, $limit";
                $items = mysqli_query($connection, $query);
                
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
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
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
                            <td class="align-middle linker-title"> <a href="item.php?product=<?= $fitem['BookID'] ?>"><img src="<?= $fitem['imageL'] ?>" widht="50px" height="50px" alt="<?= $fitem['imageL'] ?>"></a> </td>
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
                            <td class="align-middle"><a href="edit-book.php?id=<?= $fitem['BookID'] ?>" class="btn btn-primary"
                                                        id="edit-item">Edit</a></td>
                            <!-- Delete item -->
                            <form method="POST">
                            <td class="align-middle"><button class="btn btn-danger delete-item-books"
                                    value="<?= $fitem['BookID'] ?>" name="<?= $fitem['BookID'] ?>">Delete</button></td>
                            </form>
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

    </div>
        <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end py-5">
        <li class="page-item">
          <a class="page-link" href="books.php?page=<?= $Previous; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo; Previous</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <li class="page-item"><a class="page-link" href="books.php?page=<?= $i; ?>">
              <?= $i; ?>
            </a></li>
          <?php endfor; ?>
        <li class="page-item">
          <a class="page-link" href="books.php?page=<?= $Next; ?>" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
          </a>
        </li>
      </ul>
    </nav>

  </div>
    </div>
 
</section>

<?php include('../includes/footer.php'); ?>