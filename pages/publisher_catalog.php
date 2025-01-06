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
        <title>Publisher Catalog - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div id="main-container" class="container-fluid vh-100 d-flex flex-column overflow-hidden" style="margin: 0; padding: 0;">
            <!--Navigation Bar-->
            <nav class="navbar navbar-expand bg-body-secondary">
                <div class="container-fluid px-5">
                    <span class="navbar-brand mb-0 h1 fs-2">Staem</span>

                    <a class="btn btn-outline-primary">Profile</a>                               
                </div>
            </nav>

            <!--Main Section-->
            <?php 
            $overflow = "overflow-scroll";
            if (empty($games)) $overflow = "overflow-hidden";
            echo '
            <main class="d-flex h-100 '.$overflow.'">'
              ?>
                <section class="w-25 h-100 d-flex flex-column container w-25 border-end border-3 p-0">
                  <h3 class="display-6 p-3 bg-primary text-black">My Catalog</h3>
                  <div class="list-group list-group-flush h-100 overflow-scroll">
                    <?php 
                    foreach ($games as $game) {
                      echo '<button class="list-group-item list-group-item-action">'.$game["title"].'</button>';}
                    ?>
                  </div>
                </section>

                <section class="w-75 h-100">
                  <div id="game-overview-container" class="d-flex flex-column justify-content-around p-4 bg-body-tertiary">
                    <h1 class="display-5">Game Title</h1>
                    <div class="d-flex h-25">
                      <div class="h-100 w-75">
                        <?php 
                        echo '
                        <h5>Description</h5>
                        <p class="text-body-secondary text-truncate ">
                          '.$game["description"].'
                        </p>
                        ';
                        ?>
                      </div>
                      <div class="p-3 w-25 d-flex flex-column align-items-start justify-content-center">
                        <?php 
                        echo'
                        <div class="w-100 d-flex">
                          <span class="fw-bold me-auto">Avg Ratings:</span>
                          <span> '.$game["rating"].' <i class="fa-solid fa-star text-info"></i></span>
                        </div>
                        <div class="w-100 d-flex">
                          <span class="fw-bold me-auto">Price:</span>
                          <span>'.$game["price"].'</span>
                        </div>
                        ';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div id="game-statistics-container" class="overflow-scroll border-top py-4 px-5">
                    
                    <h4 class="display-6">Report:</h4>
                    <div class="w-100 d-flex mb-3 justify-content-around">
                      <div class="card h-100 m-3 border bg-body-secondary">
                        <div class="card-body">
                          <?php
                          echo'
                          <h4 class="card-title">Total Purchases:</h4>
                          <h1 class="card-text text-primary">'.$stats["copies_sold"].'</h1>
                          <h5 class="card-subtitle text-body-secondary">Copies were sold</h5>
                          ';
                          ?>
                        </div>
                      </div>
                      <div class="card h-100 m-3 border bg-body-secondary">
                        <div class="card-body">
                          <?php
                          echo'
                          <h4 class="card-title">Total Refunds:</h4>
                          <h1 class="card-text text-primary">'.$stats["refunds"].'</h1>
                          <h5 class="card-subtitle text-body-secondary">People have Refunded</h5>
                          ';
                          ?>
                        </div>
                      </div>
                      <div class="card h-100 m-3 border bg-body-secondary">
                        <div class="card-body">
                          <?php
                          echo'
                          <h4 class="card-title">Net Revenue:</h4>
                          <h1 class="card-text text-primary">'.$stats["revenue_gained"].'</h1>
                          <h5 class="card-subtitle text-body-secondary">In net revenue</h5>
                          ';
                          ?>
                        </div>
                      </div>
                    </div>
                    <h4 class="display-6">Reviews:</h4>
                    <div class="card container h-100 border overflow-scroll">

                      <div class="card-body">

                        <div class="card border mb-3">
                          <div class="card-header">Author:</div>
                          <div class="card-body d-flex align-items-center">
                            <div class="card-text me-auto w-75">asdfh asjdks jskdjsj ksjdk jsj ks</div>
                            <div class="w-25 d-flex">
                              <span class="fw-bold me-auto">Rating:</span>
                              <span> 5.3 <i class="fa-solid fa-star text-info"></i></span>
                            </div>
                          </div>
                        </div>
                        <div class="card border  mb-3">
                          <?php
                          echo'
                          <div class="card-header">Author:</div>
                          <div class="card-body d-flex align-items-center">
                            <div class="card-text me-auto w-75">asdfh asjdks jskdjsj ksjdk jsj ks</div>
                            <div class="w-25 d-flex">
                              <span class="fw-bold me-auto">Rating:</span>
                              <span> 5.3 <i class="fa-solid fa-star text-info"></i></span>
                            </div>
                          </div>
                          ';
                          ?>
                        </div>
                        <div class="card border mb-3">
                          <div class="card-header">Author:</div>
                          <div class="card-body d-flex align-items-center">
                            <div class="card-text me-auto w-75">asdfh asjdks jskdjsj ksjdk jsj ks</div>
                            <div class="w-25 d-flex">
                              <span class="fw-bold me-auto">Rating:</span>
                              <span> 5.3 <i class="fa-solid fa-star text-info"></i></span>
                            </div>
                          </div>
                        </div>
                        <div class="card border mb-3">
                          <div class="card-header">Author:</div>
                          <div class="card-body d-flex align-items-center">
                            <div class="card-text me-auto w-75">asdfh asjdks jskdjsj ksjdk jsj ks</div>
                            <div class="w-25 d-flex">
                              <span class="fw-bold me-auto">Rating:</span>
                              <span> 5.3 <i class="fa-solid fa-star text-info"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </main>
        </div>
        

        <!--Bootstrap and Fontawesome Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/53583d85f8.js" crossorigin="anonymous"></script>
    </body>
</html>