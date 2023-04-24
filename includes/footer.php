<!-- Footer -->
<!-- <footer class="p-5 bg-dark text-white text-center fixed-bottom position-absolute w-100">
    <div class="container">
      <p class="lead">Copyright &copy; 2022 Piotr Pabich</p>

      <a href="#" class="position-absolute end-0 p-5 bottom-0">
        <i class="bi bi-arrow-up-circle h1"></i>
      </a>
    </div>
  </footer> -->

<section id="footer" class="p-5 bg-dark text-white text-center">
  <p class="lead">Copyright &copy; 2022 Piotr Pabich</p>

  <a href="#">
    <i class="bi bi-arrow-up-circle h1"></i>
  </a>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="../custom.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
  alertify.set('notifier', 'position', 'top-right');
    <?php
    if (isset($_SESSION['message'])) {
      ?>
        alertify.success('<?= $_SESSION['message']; ?>');

          <?php
          unset($_SESSION['message']);
    }

    if (isset($_SESSION['error_message'])) {
      ?>
        alertify.error('<?= $_SESSION['error_message']; ?>');

          <?php
          unset($_SESSION['error_message']);
    }
    ?>
</script>
</body>

</html>