<?php
require_once("../server/game_service.php");
require_once("../server/order_service.php");
require_once("../server/user_service.php");


if (!UserService::isLoggedIn()) {
  header("Location: login.php");
  return;
}

$titles = GameService::getGamesByTitle($_GET["query"]);
$genres = GameService::getGamesByGenre($_GET["query"]);
$descs = GameService::getGamesByDesc($_GET["query"]);

$list = [];
foreach ([$descs, $genres, $titles] as $queryResult) {
  foreach ($queryResult as $result) {
    $result["state"] = CartService::isAdded($result["id"]);
    $list[$result["id"]] = $result;
  }
}

// ignore
if (isset($_GET["action"]) && $_GET["action"] == "retrieve") {
  echo json_encode($list);
  return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["action"] == "add-to-cart") {
      CartService::addToCart($_POST["id"]);
      return;
  }
}
// ignore
?>

<!DOCTYPE html>

<html>
    <head>
        <!--Meta Data-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS and Main CSS-->
        <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">
        <link rel="stylesheet" href="../assets/css/results.css">

        <!--Other-->
        <title>Browse Games - Staem</title>
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
                            <a class="nav-link" href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Library.php">Library</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                          </li>
                        </ul>
                      </div>
                      <form class="d-flex" role="search">
                        <input name="query" id="query" onkeyup="search()" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary me-2" type="submit">Search</button>
                      </form>
                      <a class="btn btn-outline-primary" href="user_settings.php">Profile</a>                               
                </div>
            </nav>

            <!--Put your code here-->
            <main class="container vh-100">
              <div class="h1 text-primary fw-bolder mt-3 pt-5 my-4">Result</div>
              <div id="results" class="h-75">
              <?php
              if (empty($list))
                echo ' <div class="h1 text-primary fw-bolder mt-3 pt-5 my-4"> There is no games </div>';

              foreach ($list as $game) {
                $cartButton = "";
                if ($game["state"] == PurchaseState::AVAILABLE)
                  $cartButton = '<button class="add-to-cart btn btn-primary" value="'. $game["id"] .'"><i class="fa-solid fa-cart-shopping"></i></button>';
                else if ($game["state"] == PurchaseState::IN_CART)
                  $cartButton = '<button class="btn btn-primary" disabled>In Cart</button>';

                echo '
                  <div class="result border rounded d-lg-flex mb-4 h-50" onclick="viewDetails('. $game["id"] .')">
                  <div class="col-lg-2 col-12 rounded-start overflow-hidden">
                  <img src="'. $game["cover"] .' " class="h-100 w-100 object-fit-cover">
                  </div>
                  <div class="card-body col-10 p-4">
                    <h5 class="card-title fs-1">'. $game["title"] .'</h5>
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="card-text text-body-secondary fs-4">$'. $game["price"] .'</h5>
                      '. $cartButton .'
                    </div>
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