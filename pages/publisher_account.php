<?php
require_once("../server/user_service.php");

if (!UserService::isLoggedIn()) {
  header("Location : login.php");
  return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  UserService:: updateInfo([
    'username'=> $_POST["username"],
    'email'=> $_POST["email"]
  ]);
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
        <link rel="stylesheet" href="../assets/css/settings.css">

        <!--Other-->
        <title>User Settings - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid vh-100 d-flex flex-column" style="margin: 0; padding: 0;">
            <!--Navigation Bar (Remove if Unnecessary)-->
            <nav class="navbar navbar-expand bg-body-secondary">
                <div class="container-fluid px-5">
                    <a href="publisher_catalog.php" class="navbar-brand mb-0 h1 fs-2">Staem</a>                      
                </div>
            </nav>

            <!--Put your code here-->
            <main class="row h-100">
              <div class="p-5 pe-2 col-3 h-75">
                <ul class="list-group list-group-flush border rounded h-100">
                  <li class="list-group-item active" onclick="window.location.href = 'publisher_account.php'">Account Settings</li>
                  <li class="list-group-item list-group-item-action mb-auto" onclick="window.location.href = 'publisher_security.php'">Security</li>
                  <button class="list-group-item list-group-item-action border-top text-danger" onclick="logout()">Logout</button>
                </ul>
              </div>
              <div class="p-5 ps-2 col-9">
                <div class="card h-100 border">
                  <div class="card-body d-flex flex-column align-items-center">
                    <h1 class="text-center mb-4">Profile Settings</h1>
                    <form class="w-50" id="user_settingsForm" action="user_settings.php" method="post">
                      <div class="mb-3">
                          <label for="username" class="form-label">Username</label>
                          <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username">
                      </div>
                      <div class="mb-3">
                          <label for="email" class="form-label">Email Address</label>
                          <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
                      </div>
                      <div class="d-flex">
                        <button type="submit" class="btn btn-primary me-auto">Save Changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/logout.js"></script>
    </body>
</html>