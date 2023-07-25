<?php

include 'components/connect.php';
include 'components/navbar.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <link rel="stylesheet" href="css/homeStyle.css">
  <link rel="stylesheet" href="css/navStyle.css">

</head>

<body>

  <div id="loading-screen">
    <div id="loading-spinner"></div><br>
    <p>Page is loading...</p>
  </div>
  <!-- <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="..." class="rounded me-2" alt="...">
        <strong class="me-auto">Bootstrap</strong>
        <small id="lblTime">11 mins ago</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Hello, world! This is a toast message.
      </div>
    </div>
  </div> -->

  <div class="aboutxt">
    <img src="images/pexels-anna-shvets-3683074 - Copy.jpg" class="bg-img">
    <div class="top-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, earum magnam.
      Molestiae nam vel repellat nesciunt. Accusamus architecto fugit amet ad expedita voluptates ipsum nihil fugiat officia quaerat,
      neque eius?
    </div>
    <button class="moreBtn"><a class="Lmore" href="about.php"> Learn More</a></button>
  </div>

  <div>
    <h2 class="slider-header">Top Categories</h2>
  </div>

  <div class="container">
    <div class="row">
      <div class="splide">
        <div class="splide__track">
          <div class="splide__list">
            <div class="col-sm-4 splide__slide m-2">
              <div class="card bg-dark text-white">
                <div class="card-body card_1">
                  <h5 class="card-title">Baby Care</h5>
                  <p class="card-text"><br><br><br></p>
                  <a href="product.php" class="btn btn-primary">Read more</a>
                </div>
              </div>
            </div>
            <div class="col-sm-4 splide__slide m-2">
              <div class="card bg-dark text-white">
                <div class="card-body card_2">
                  <h5 class="card-title">Beauty Care</h5>
                  <p class="card-text"><br><br><br></p>
                  <a href="product.php" class="btn btn-primary">Read more</a>
                </div>
              </div>
            </div>
            <div class="col-sm-4 splide__slide m-2">
              <div class="card bg-dark text-white">
                <div class="card-body card_3">
                  <h5 class="card-title">Vitamins and Suppplies</h5>
                  <p class="card-text"><br><br><br></p>
                  <a href="product.php" class="btn btn-primary">Read more</a>
                </div>
              </div>
            </div>
            <div class="col-sm-4 splide__slide m-2">
              <div class="card bg-dark text-white">
                <div class="card-body card_4">
                  <h5 class="card-title">Mobility Aids</h5>
                  <p class="card-text"><br><br><br></p>
                  <a href="product.php" class="btn btn-primary">Read more</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js"></script>

  <script src="js/slider.js"></script>
  <script src="js/loadingScreen.js"></script>

  <?php
  include 'components/footer.php';
  ?>
</body>

</html>