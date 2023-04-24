<?php
session_start();

function checkAccount()
{
  if (isset($_SESSION['LoggedIn'])) {
    header('Location: views/login.php');
    exit();
  }
}

if (isset($_GET['hello'])) {
  unset($_GET['hello']);
  checkAccount();
}
?>


<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<div class="index">
  <section class="bg-dark text-light p-5 p-lg-0 pt-lg-5 text-center text-sm-start">
    <div class="container">
      <div class="d-sm-flex align-items-center justify-content-between">
        <div>
          <h1>Are you a <span class="text-warning"> Book Lover </span>?</h1>
          <p class="lead my-4">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam
            beatae fuga animi distinctio perspiciatis adipisci velit maiores
            totam tempora accusamus modi </p>
          <button class="btn btn-primary btn-lg" onclick="location.href='views/registration.php'" type="button">Sign
            up</button>
        </div>
        <img class="img-fluid w-50 d-none d-sm-block" src="img/book.svg" alt="" />
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="bg-primary text-light p-5">
    <div class="container">
      <div class="d-md-flex justify-content-between align-items-center">
        <h3 class="mb-3 mb-md-0">Sign Up For Our Newsletter</h3>

        <div class="input-group news-input">
          <input type="text" class="form-control" placeholder="Enter Email" />
          <button class="btn btn-dark btn-lg" type="button">Submit</button>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container bg-white px-4 px-lg-5 mt-5">
      <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center">
        <?php
        include('utils/connect.php');
        $query = "SELECT * from books order by rand() limit 8";
        $query_run = mysqli_query($connection, $query);

        foreach ($query_run as $ritem) { ?>
          <div class="col mb-5">
            <div class="card h-100">
              <a href="views/item.php?product=<?= $ritem['BookID'] ?>">
                <img class="card-img-top img-item" src="<?= $ritem['imageL'] ?>" alt="..." />
              </a>
              <div class="card-body p-4">
                <div class="text-center">
                  <h5 class="fw-bolder">
                    <?= $ritem['Booktitle'] ?> <br><br>
                    <?php if ($ritem['DiscountID'] != 5) { ?>
                      <span class="text-muted text-decoration-line-through">$<?php echo $ritem['Price'] ?></span>
                      <?php } ?>
                      <span class="">$<?php echo $ritem['PriceAfterDiscount'] ?></span>
                  </h5>
                </div>
              </div>
              <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
              </div>
            </div>
          </div>
          <?php }
        ?>
      </div>
    </div>
  </section>

  <!-- Learn Sections -->

  <!-- Question Accordion -->
  <section id="questions" class="p-5">
    <div class="container">
      <h2 class="text-center mb-4">Frequently Asked Questions</h2>
      <div class="accordion accordion-flush" id="questions">
        <!-- Item 1 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#question-one">
              What can I buy on this website?
            </button>
          </h2>
          <div id="question-one" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              At Bibliopolium you can buy books of all kinds. From the ancients to today's novelties. Do not hesitate,
              we invite you to see our offer.
            </div>
          </div>
        </div>
        <!-- Item 2 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#question-two">
              How can I sign up?
            </button>
          </h2>
          <div id="question-two" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              To register on our website, click on the Sign Up button on the home page, if you already have an account,
              click on the icon in the upper right corner and press My account.
            </div>
          </div>
        </div>
        <!-- Item 3 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#question-three">
              What do I need to know?
            </button>
          </h2>
          <div id="question-three" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam
              beatae fuga animi distinctio perspiciatis adipisci velit maiores
              totam tempora accusamus modi explicabo accusantium consequatur,
              praesentium rem quisquam molestias at quos vero. Officiis ad
              velit doloremque at. Dignissimos praesentium necessitatibus
              natus corrupti cum consequatur aliquam! Minima molestias iure
              quam distinctio velit.
            </div>
          </div>
        </div>
        <!-- Item 4 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#question-four">
              What book can you recommend me?
            </button>
          </h2>
          <div id="question-four" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam
              beatae fuga animi distinctio perspiciatis adipisci velit maiores
              totam tempora accusamus modi explicabo accusantium consequatur,
              praesentium rem quisquam molestias at quos vero. Officiis ad
              velit doloremque at. Dignissimos praesentium necessitatibus
              natus corrupti cum consequatur aliquam! Minima molestias iure
              quam distinctio velit.
            </div>
          </div>
        </div>
        <!-- Item 5 -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#question-five">
              Where can I see my purchase history?
            </button>
          </h2>
          <div id="question-five" class="accordion-collapse collapse" data-bs-parent="#questions">
            <div class="accordion-body">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam
              beatae fuga animi distinctio perspiciatis adipisci velit maiores
              totam tempora accusamus modi explicabo accusantium consequatur,
              praesentium rem quisquam molestias at quos vero. Officiis ad
              velit doloremque at. Dignissimos praesentium necessitatibus
              natus corrupti cum consequatur aliquam! Minima molestias iure
              quam distinctio velit.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include('includes/footer.php'); ?>