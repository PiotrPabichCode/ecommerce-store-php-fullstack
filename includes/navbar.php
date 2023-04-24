<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top text-center">
  <div class="container px-4 px-lg-5">
    <a class="navbar-brand" href="/index.php">Bibliopolium</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
        class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse align-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?#questions">About</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">Shop</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/views/products.php">All Products</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex px-3" action="" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" id="search-book" aria-label="Search">
      </form>
      <?php
      if (isset($_GET['search-book'])) {
        $search_book = $_GET['search-book'];
        $searches = getSearchBooks($connection, $search_book);
        if (mysqli_num_rows($search_book) > 0) {
          $searchData = mysqli_fetch_all($searches);
          header('Location: alamakota');
          exit(1);
        }
      }
      ?>
      <a href="/views/cart.php">
        <button class="btn btn-outline-dark" type="text">
          <i class="bi-cart-fill me-1"></i>Cart
            <b id="cart-update">
              <span class="badge bg-dark text-white ms-1 rounded-pill"><?= countCartItems($connection) ?></span>
            </b>
        </button>
      </a>
      <a href="/views/favorites.php" class="lock">
        <i class="bi bi-heart ms-3 icon-unlock style='font-size: 2rem'"></i>
        <i class="bi bi-heart-fill ms-3 icon-lock style='font-size: 2rem'"></i>
      </a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2">
        <li class="nav-item dropdown">
          <a class="nav-link lock" name="accountNavbar" href="?hello=true" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="bi bi-person me-1 icon-unlock style='font-size: 2rem'"></i>
            <i class="bi bi-person-fill me-1 icon-lock style='font-size: 2rem'"></i>
          </a>
          <ul class="dropdown-menu" aria-labelledby="accountNavbar">
            <li><a class="dropdown-item" href="/views/account.php">My account</a></li>
            <li><a class="dropdown-item" href="/utils/logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>