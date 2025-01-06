<?php
// Include necessary service classes
require_once("../server/order_service.php");
require_once("../server/user_service.php");

// Check if the user is logged in
if (!UserService::isLoggedIn()) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Retrieve transactions for the logged-in user
$transactions = CartService::getUserTransactions();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Meta Data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">
    <link rel="stylesheet" href="../assets/css/settings.css">

    <!-- Page Title -->
    <title>Transaction History - Staem</title>
</head>
<body>
    <!-- Main Container -->
    <div class="container-fluid vh-100 d-flex flex-column" style="margin: 0; padding: 0;">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand bg-body-secondary">
            <div class="container-fluid px-5">
                <!-- Brand Name -->
                <a href="#" class="navbar-brand mb-0 h1 fs-2">Staem</a>
                <!-- Toggle Button for Mobile View -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navigation Links -->
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
                <!-- Search Form -->
                <form action="Search_result.php" class="d-flex" role="search">
                    <input name="query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary me-2" type="submit">Search</button>
                </form> 
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="row h-100">
            <!-- Sidebar with Account Options -->
            <div class="p-5 pe-2 col-3 h-75">
                <ul class="list-group list-group-flush border rounded h-100">
                    <li class="list-group-item list-group-item-action" onclick="window.location.href = 'user_settings.php'">Account Settings</li>
                    <li class="list-group-item list-group-item-action" onclick="window.location.href = 'security.php'">Security</li>
                    <li class="list-group-item list-group-item-action active mb-auto" onclick="window.location.href = 'Transactions.php'">Transactions</li>
                    <button class="list-group-item list-group-item-action border-top text-danger" onclick="logout()">Logout</button>
                </ul>
            </div>
            <!-- Transaction History Section -->
            <div class="p-5 ps-2 col-9">
                <div class="card h-100 border">
                    <div class="card-body">
                        <!-- Section Title -->
                        <h1 class="text-center mb-4">Transaction History</h1>
                        <?php if (empty($transactions)): ?>
                            <!-- Message when no transactions are found -->
                            <p class="text-center">No previous transactions found.</p>
                        <?php else: ?>
                            <!-- Transactions Table -->
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Game Name</th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody id="transactionTable">
                                    <?php foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <th scope="row"><?php echo $transaction['id']; ?></th>
                                            <td><?php echo $transaction['title']; ?></td>
                                            <td><?php echo $transaction['is_purchase'] ? "Purchase" : "Refund"; ?></td>
                                            <td>$<?php echo $transaction['value']; ?></td>
                                            <td><?php echo $transaction['date']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
