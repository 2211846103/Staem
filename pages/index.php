<?php
require_once("../server/game_service.php");
require_once("../server/user_service.php");
require_once("../server/order_service.php");

if (!UserService::isLoggedIn()) {
    header("Location: login.php");
    return;
}

$games = GameService::getTopGames();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "add_to_cart") {
        CartService::addToCart($_POST["id"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Meta Data-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS and Main CSS-->
        <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">
        <link rel="stylesheet" href="../assets/css/homePage.css">


        <!--Title-->
        <title>Staem - Your Game Hub</title>
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
                        <input name="query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary me-2" type="submit">Search</button> 
                    </form>
                    <a class="btn btn-outline-primary" href="user_settings.php">Profile</a>                               
                </div>
            </nav>

            <!-- Main Content -->
            <main class="vh-100">
                <?php
                $topGame = $games[0];

                echo '
                <div id="hero" class="card rounded-0 border-bottom h-75" onclick="viewDetails('. $topGame["id"] .')">
                    <img class="object-fit-cover h-100" src="'. $topGame["hero"] .'" style="filter: blur(5px);">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h5 class="card-title text-primary display-4">'. $topGame["title"] .'</h5>
                        <p class="card-text fs-5">'. $topGame["description"] .'</p>
                    </div>
                </div>
                ';

                unset($games[0]);
                ?>
                <!-- Hero Section -->
                <section class="py-5 text-center">
                    <div class="container">
                        <h1 class="display-4 fw-bolder">Epic Gaming Starts Here</h1>
                        <p class="lead fw-bolder">Browse top games, your next adventure is just one click away.</p>
                    </div>
                </section>

                <!-- Featured Games Section -->
                <section class="py-5">
                    <div class="container vh-100">
                        <p class="h1 fw-bolder text-primary text-start">Most Popular Games</p>
                        <div class="row h-75 row-cols-2 row-cols-lg-4">
                            <?php

                                foreach ($games as $game) {
                                    $cartButton = "";
                                    if (CartService::isAdded($game["id"])) $cartButton = "disabled";
                                    
                                    echo '
                                    <div class="col h-100">
                                        <div class="card h-100 border-0">
                                            <div class="rounded h-75 overflow-hidden d-flex justify-content-center">
                                                <img src="'. $game["cover"] .'" class="object-fit-cover h-100 w-100" onclick="viewDetails('. $game["id"] .')">
                                            </div>
                                            <button class="btn btn-primary position-absolute m-2" onclick="addToCart(this, '. $game["id"] .')" '. $cartButton .'><i class="fa-solid fa-cart-shopping"></i></button>
                                            <div class="card-body h-25">
                                                <h5 class="card-title">'. $game["title"] .'</h5>
                                                <p class="">'. $game["price"] .'$</p>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                </section>
            </main>

        </div>

        <!-- Bootstrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/53583d85f8.js" crossorigin="anonymous"></script>
        <!--JQuery CDN-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/utils.js"></script>
    </body>
</html>
