<?php
require_once("../server/user_service.php");
require_once("../server/game_service.php");

if (!UserService::isLoggedIn()) {
  header("Location: login.php");
  return;
}

$games = GameService::getLibrary();
?>

<!DOCTYPE html>

<html>
    <head>
        <!--Meta Data-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS and Main CSS-->
        <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">
        <link rel="stylesheet" href="../assets/css/Library.css">

        <!--Other-->
        <title>Library - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid vh-100">
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
                            <a class="nav-link active" aria-current="page" href="Library.php">Library</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                          </li>
                        </ul>
                      </div>
                      <form action="Search_result.php" class="d-flex" role="search">
                        <input name="query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary me-2" type="submit">Search</button>
                      </form>
                      <a class="btn btn-outline-primary" href="user_settings.php">Profile</a>                               
                </div>
            </nav>

            <!--Put your code here-->   
            <?php
            $overflow = "overflow-scroll";
            if (empty($games)) $overflow = "overflow-hidden";
            echo '
            <main class="text-center vh-100 '. $overflow .'">
            ';
            ?>
                <div class="h1 text-primary fw-bolder display-3 mt-5 pt-5 my-4">Library</div>
                <div class="container text-center">
                  <div class="row g-4 row-cols-2 row-cols-lg-4 mb-4">
                    <?php
                      foreach ($games as $game) {
                        echo '
                        <div class="col d-flex justify-content-center">
                          <div class="card border">
                              <div class="rounded h-75 overflow-hidden d-flex justify-content-center">
                                  <img src="'. $game["cover"] .'" class="object-fit-cover h-100 w-100" onclick="viewDetails('. $game["id"] .')">
                              </div>
                              <div class="card-body d-flex align-items-center justify-content-center">
                                <p class=" card-text fw-bolder fs-3">'. $game["title"] .'</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        ';
                      }

                      if (empty($games)) {
                        echo '
                        <p class="w-100 mt-5 pt-5 h3 text-body-secondary">You Haven\'t Bought Any Games Yet :(</p>
                        ';
                      }
                    ?>
                </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../assets/js/utils.js"></script>
    </body>
</html>