<?php
require_once("../server/user_service.php");

if (!UserService:: isloggedIn()){
   header(header: "Location : login.php");
   return;
}

$success = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $success = UserService:: changePassword([
    'newPass' => $_POST["newPass"],
    'currentPass' => $_POST["currentPass"]
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
        <title>Security Settings - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid vh-100 d-flex flex-column overflow-hidden" style="margin: 0; padding: 0;">
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
                  <li class="list-group-item list-group-item-action" onclick="window.location.href = 'publisher_account.php'">Account Settings</li>
                  <li class="list-group-item list-group-item-action active mb-auto" onclick="window.location.href = 'publisher_security.php'">Security</li>
                  <button class="list-group-item list-group-item-action border-top text-danger" onclick="logout()">Logout</button>
                </ul>
              </div>
              <div class="p-5 ps-2 col-9">
                <div class="card h-100 border">
                  <div class="card-body d-flex flex-column align-items-center">
                    <h1 class="text-center mb-4">Change Password</h1>
                    <form class="w-50" id="passwordForm" action="security.php" method="post">
                      <p class="text-danger" id="error">
                        <?php if (!$success) echo 'Current Password is Incorrect'?>
                      </p>
                      <div class="mb-3">
                          <label for="currentPassword" class="form-label">Current Password</label>
                          <input type="password" class="form-control" name="currentPass" id="currentPassword" placeholder="Enter your current password" >
                      </div>
                      <div class="mb-3">
                          <label for="newPassword" class="form-label">New Password</label>
                          <input type="password" class="form-control" name="newPass" id="newPassword" placeholder="Enter a new password" >
                      </div>
                      <div class="mb-3">
                          <label for="confirmPassword" class="form-label">Confirm New Password</label>
                          <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your new password" >
                      </div>
                      <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
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
        <script src="../assets/js/security.js"></script>
        <script src="../assets/js/logout.js"></script>
    </body>
</html>