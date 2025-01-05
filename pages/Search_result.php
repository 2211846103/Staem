<?php
require_once("../server/game_service.php");
require_once("../server/order_service.php");
require_once("../server/user_service.php");


if (!UserService::isLoggedIn()) {
  header("Location: login.php");
  return;
}


$games = GameService::getGamesByTitle($_GET["query"]);
$ganres = GameService::getGamesByGenre($_GET["query"]);
$puplishers = GameService::getGamesByPublisher($_GET["query"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["action"] == "add_to_cart") {
      CartService::addToCart($_POST["id"]);
  }
}

?>

<!DOCTYPE html>

<html>
    <head>
        <!--Meta Data-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS and Main CSS-->
        <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">

        <!--Other-->
        <title>Search Result - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid vh-100">
            <!--Navigation Bar (Remove if Unnecessary)-->
            <nav class="navbar navbar-expand bg-body-secondary fixed-top">
                <div class="container-fluid px-5">
                    <a href="index.php" class="navbar-brand mb-0 h1 fs-2">Staem</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Library.php">Library</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                          </li>
                        </ul>
                      </div>
                      <form action="Search_result.php" method="get" class="d-flex" role="search">
                        <input name="query" id="query" onkeyup="search()" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary me-2" type="submit">Search</button>
                      </form>
                      <a class="btn btn-outline-primary">Profile</a>                               
                </div>
            </nav>

            <!--Put your code here-->
            <main class="container">
                <div class="h1 text-primary display-3 fw-bolder mt-3 pt-5 my-4">The Results</div>
                <div id="results">
                <?php

                  foreach ($games as $game) {
                    $cartButton = "";
                    if (CartService::isAdded($game["id"])) $cartButton = "hidden";

                    echo '
                      <div class="border rounded d-lg-flex mb-4">
                        <img src="'. $game["cover"] .' " class="col-lg-2 col-12 rounded-start">
                        <div class="card-body col-10 p-4">
                          <h5 class="card-title fs-1">'. $game["title"] .'</h5>
                          <h5 class="card-text fs-4">'. $game["price"] .'</h5>
                          <button class="btn btn-primary" onclick="addToCart(this, '. $game["id"] .')" '. $cartButton .'><i class="fa-solid fa-cart-shopping"></i></button>
                          <p class="card-text mt-3">'. $game["description"] .'</p>
                        </div>
                      </div>    ';
                  }

                  foreach ($ganres as $game) {
                    $cartButton = "";
                    if (CartService::isAdded($game["id"])) $cartButton = "hidden";

                    echo '
                      <div class="border rounded d-lg-flex mb-4">
                        <img src="'. $game["cover"] .' " class="col-lg-2 col-12 rounded-start">
                        <div class="card-body col-10 p-4">
                          <h5 class="card-title fs-1">'. $game["title"] .'</h5>
                          <h5 class="card-text fs-4">'. $game["price"] .'</h5>
                          <button class="btn btn-primary" onclick="addToCart(this, '. $game["id"] .')" '. $cartButton .'><i class="fa-solid fa-cart-shopping"></i></button>
                          <p class="card-text mt-3">'. $game["description"] .'</p>
                        </div>
                      </div>    ';
                  }

                  foreach ($puplishers as $game) {
                    $cartButton = "";
                    if (CartService::isAdded($game["id"])) $cartButton = "hidden";

                    echo '
                      <div class="border rounded d-lg-flex mb-4">
                        <img src="'. $game["cover"] .' " class="col-lg-2 col-12 rounded-start">
                        <div class="card-body col-10 p-4">
                          <h5 class="card-title fs-1">'. $game["title"] .'</h5>
                          <h5 class="card-text fs-4">'. $game["price"] .'</h5>
                          <button class="btn btn-primary" onclick="addToCart(this, '. $game["id"] .')" '. $cartButton .'><i class="fa-solid fa-cart-shopping"></i></button>
                          <p class="card-text mt-3">'. $game["description"] .'</p>
                        </div>
                      </div>    ';
                  }
                ?>
                </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/53583d85f8.js" crossorigin="anonymous"></script>
        <!--JQuery CDN-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/utils.js"></script>
        <script src="../assets/js/search_result.js"></script>
    </body>
</html>