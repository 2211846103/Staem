<?php
require_once("../server/game_service.php");
require_once("../server/order_service.php");
require_once("../server/user_service.php");
require_once("../server/review_service.php");

if (!UserService::isLoggedIn()) {
  header ("Location: login.php");
  return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // second with js
  if ($_POST["action"] == "add_to_cart") {
    CartService::addToCart($_POST["id"]);
    return;
  }
  // third with js
  if ($_POST["action"] == "refund") {
    CartService::refundGame($_POST["id"]);
    return;
  }
}

if (!isset($_GET["id"])) {
  header ("Location: index.php");
  return;
}

$game = GameService::getGameDetails($_GET["id"]);

if (isset($_GET["action"])) {
  // forth
  if ($_GET["action"] == "add-review") {
    $body = $_GET["body"] == "" ? NULL : $_GET["body"];
    $rating = $_GET["rating"] == -1 ? NULL : $_GET["rating"];

    if ($body != NULL || $rating != NULL) {
      ReviewService::addReview([
        'body' => $body,
        'rating' => $rating,
        'game_id' => $_GET["id"]
      ]);

      header("Location: Game_details.php?id=". $_GET["id"]);
      return;
    }
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
        <link rel="stylesheet" href="../assets/css/comments.css">
        <link rel="stylesheet" href="../assets/css/details.css">

        <!--Other-->
        <title><?php echo $game["title"] ?> - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid">
            <!--Navigation Bar (Remove if Unnecessary)-->
            <nav class="navbar navbar-expand bg-body-secondary fixed-top">
                <div class="container-fluid px-5">
                    <a href="#" class="navbar-brand mb-0 h1 fs-2">Staem</a>
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
                      <form action="Search_result.php" method="get" class="d-flex" role="search">
                        <input name="query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary me-2" type="submit">Search</button> 
                      </form>
                      <a class="btn btn-outline-primary" href="user_settings.php">Profile</a>                              
                </div>
            </nav>

            <!--Put your code here-->
            <main class="container vh-100">
                <div class="h1 text-primary display-3 mt-5 pt-5 my-4fw-bolder">
                  <?php
                  echo $game["title"];
                  ?>
                </div>
                <p class="h3 fw-semibold d-flex align-items-center">
                  <?php
                  $rating = $game["rating"] != NULL ? round((float)$game["rating"], 1) : "5.0";

                  echo $rating;

                  echo '
                  <input
                    class="rating bg-transparent ms-4"
                    disabled
                    min="0"
                    max="5"
                    step="0.1"
                    style="--value: '. $rating .'; --fill: var(--bs-dark)"
                    type="range">
                  ';
                  ?>
                </p>
                <div class="d-flex align-items-center h-75 mx-5 p-4">
                    <img id="mainImage" src="<?php echo $game["screenshots"][0] ?>" class="border object-fit-cover rounded h-100 w-75">
                    <div class="card border-0 mh-100 w-25 ms-2 overflow-y-auto overflow-x-hidden">
                      <ul class="mh-100 d-flex flex-column justify-content-center align-items-center px-3">
                        <?php
                        foreach ($game["screenshots"] as $screenshot) {
                          echo '
                          <div class="screenshot-item border rounded mb-3 overflow-hidden">
                            <img src="'. $screenshot .'" class="w-100 object-fit-cover" onclick="setMainImage(\''. $screenshot .'\')">
                          </div>
                          ';
                        }
                        ?>
                      </ul>
                    </div>
                </div>
                <p class="h5 fw-semibold mt-4">
                  <?php echo $game["description"] ?>
                </p>
                <div id="purchase-div" class="d-flex align-items-center mt-4">
                  <h3 class="fw-semibold text-secondary me-4 mt-2">$<?php echo $game["price"] ?></h3>
                  <?php
                  $state = CartService::isAdded($game["id"]);

                  if ($state == PurchaseState::AVAILABLE) echo '
                  <button type="button" class="btn btn-primary btn-lg1" onclick="addToCart(this, '. $game["id"] .')">Add to Cart</button>
                  ';
                  else if ($state == PurchaseState::IN_CART) echo '
                  <button disabled type="button" class="btn btn-primary btn-lg">In Cart</button>
                  ';
                  else echo '
                  <button type="button" class="btn btn-light btn-lg" onclick="refund(this, '. $game["id"] .')">Refund</button>
                  ';
                  ?>
                </div>
                <div>
                  <p class="h3 fw-semibold text-primary mt-3">Publisher</p>
                  <p class="h5 fw-semibold text-secondary"><?php echo $game["username"] ?></p>
                  <p class="h3 fw-semibold text-primary mt-3">Genres</p>
                  <?php
                  foreach ($game["genres"] as $genre) {
                    echo '
                    <p class="h5 fw-semibold text-secondary">'. $genre["name"] .'</p>
                    ';
                  }
                  ?>
                </div>
                <?php
                if ($game["gameplay_desc"]) echo '
                  <div class="mt-4">
                    <p class="h3 fw-semibold text-primary mt-3">Gameplay</p>
                    <p class="h5 fw-semibold">'. $game["gameplay_desc"] .'</p>      
                    <hr>
                  </div>
                ';
                ?>

                <div class="d-flex justify-content-between mb-4">
                  <h2 class="text-primary display-4">Reviews</h2>
                
                  <form class="w-50" action="Game_details.php" method="GET">
                    <label class="form-label">Write a Review</label>
                    <div class="d-flex mb-2">
                      <textarea type="text" class="form-control me-4" name="body"></textarea>
                      <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>

                    <input
                      class="rating bg-transparent"
                      min="0"
                      max="5"
                      oninput="this.style.setProperty('--value', this.value)"
                      step="0.1"
                      type="range"
                      value="1"
                      onchange="updateRating(this.value)">
                    <input id="rating" hidden name="rating" value="-1">
                    <input hidden name="action" value="add-review">
                    <input hidden name="id" value="<?php echo $game["id"] ?>">
                  </form>
                </div>
                
                <div class="row g-4 mb-5 w-50">
                  <?php
                  $reviews = ReviewService::getReviewsByGameId($game["id"]);

                  foreach($reviews as $review) {
                    if ($review["body"] == NULL) continue;

                    echo '
                    <div class="card col-12 bg-body-secondary">
                      <div class="card-body">
                        <div class="d-flex justify-content-between border-bottom">
                          <div class="card-title text-primary h4">'. $review["username"] .'</div>
                          <span class="text-secondary h5">'. $review["date"] .'</span>
                        </div>
                        <div class="card-text my-2">'. $review["body"] .'</div>
                      </div>
                    </div>
                    ';
                  }

                  if (empty($reviews))
                    echo '
                      <h5 class="text-body-secondary w-100 text-center my-5">Be the First to Write a Review!</h5>
                    ';
                  ?>
                </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/53583d85f8.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/details.js"></script>
    </body>
</html>