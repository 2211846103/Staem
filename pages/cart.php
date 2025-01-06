<?php
require_once("../server/user_service.php");
require_once("../server/order_service.php");

if (!UserService::isLoggedIn()) {
    header("Location: login.php");
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "get_games") {
        echo json_encode(CartService::getCartGames());
        return;
    }
    if ($_POST["action"] == "remove-from-cart") {
        CartService::removeFromCart($_POST["id"]);
        return;
    }
    if ($_POST["action"] == "cancel-order") {
        CartService::cancelOrder();
        return;
    }
    if ($_POST["action"] == "checkout") {
        CartService::checkout();
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
        <link rel="stylesheet" href="../assets/css/cart.css">

        <!--Other-->
        <title>Cart - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid overflow-hidden vh-100 p-0 m-0">
            <!--Navigation Bar (Remove if Unnecessary)-->
            <nav class="navbar navbar-expand bg-body-secondary">
                <div class="container-fluid px-5">
                    <a href="#" class="navbar-brand mb-0 h1 fs-2">Staem</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                          <li class="nav-item">
                            <a class="nav-link"  href="index.php">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Library.php">Library</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" href="cart.php" aria-current="page">Cart</a>
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

            <main>
                <div class="container mt-5 vh-100">
                    <div class="row h-75">
                        <!-- Cart Items -->
                        <div id="cart_items" class="col-8 h-100"></div>
                        <!-- Cart Summary -->
                        <div class="col-4">
                            <h2 class="mb-4">Order Summary</h2>
                            <!-- <div class="bg-body-secondary"> -->
                                <div class="card border">
                                    <div class="card-body">
                                        <h5>Total:</h5>
                                        <p id="total" class="fs-3"></p>
                                        <button class="btn btn-success w-100 mt-3" onclick="checkout()">Checkout</button>
                                        <button class="btn w-100 mt-2 btn-outline-danger" onclick="cancelOrder()">Cancel Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
            </main>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/53583d85f8.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/cart.js"></script>
    </body>
</html>