<?php
require_once("../server/user_service.php");
require_once("../server/game_service.php");
require_once("../server/review_service.php");
require_once("../server/order_service.php");

if (!UserService::isLoggedIn()) {
  header("Location: login.php");
  return;
}

$games = GameService::getGamesbypublisher();
$selected = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["action"] == "retrieve-info") {
    $info = [];
    $info["details"] = GameService::getGameDetails($_POST["id"]);
    $info["reviews"] = ReviewService::getReviewsByGameId($_POST["id"]);
    $info["stats"] = CartService::getStatisticsByGameId($_POST["id"]);
    echo json_encode($info);
    return;
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

        <!--CSS-->
        <link rel="stylesheet" href="../assets/css/publisher_catalog.css">

        <!--Other-->
        <title>Catalog - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div id="main-container" class="container-fluid vh-100 d-flex flex-column overflow-hidden" style="margin: 0; padding: 0;">
            <!--Navigation Bar-->
            <nav class="navbar navbar-expand bg-body-secondary">
                <div class="container-fluid px-5">
                    <span class="navbar-brand mb-0 h1 fs-2">Staem</span>

                    <a class="btn btn-outline-primary" href="publisher_account.php">Profile</a>                               
                </div>
            </nav>

            <!--Main Section-->
            <main class="d-flex h-100 '.$overflow.'">
                <section class="w-25 h-100 d-flex flex-column container w-25 border-end border-3 p-0">
                  <h3 class="display-6 p-3 mb-0 bg-primary text-black">My Catalog</h3>
                  <div class="list-group list-group-flush h-100 overflow-y-auto overflow-x-hidden">
                    <?php 
                    foreach ($games as $game) {
                      echo '<button class="list-group-item list-group-item-action mt-0" onclick="viewDetails('. $game["id"] .')">'.$game["title"].'</button>';
                    }

                    if (empty($games)) echo '<h6 class="m-4   text-body-secondary">Contact Us to Fill Your Catalog!</h6>';
                    ?>
                  </div>
                </section>

                <section id="details" class="w-75 h-100 overflow-y-auto overflow-x-hidden">
                  <?php
                  if (!$selected) echo '
                    <h5 class="h-75 w-100 d-flex justify-content-center align-items-center">Select a Game to View!</h5>
                  ';
                  ?>
                </section>
            </main>
        </div>
        

        <!--Bootstrap and Fontawesome Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/53583d85f8.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/publisher.js"></script>
    </body>
</html>