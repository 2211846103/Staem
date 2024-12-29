<?php
require_once("../server/user_service.php");

$success = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $success = UserService::login([
    'username' => $_POST["username"],
    'password' => $_POST["password"]
  ]);

  if ($success) header("Location: homepage.php");
}

echo $succss;
?>

<!DOCTYPE html>

<html>
    <head>
        <!--Meta Data-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS and Main CSS-->
        <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">

        <!--Other-->
        <title>Login - Staem</title>
    </head>
    <body class="overflow-hidden">
        <!--Main Container-->
        <div class="container-fluid vh-100" style="margin: 0; padding: 0;">
            <!--Put your code here-->
            <main class="h-100">
                <div class="container h-100 d-flex justify-content-center align-items-center">
                    <div class="card w-50 shadow-sm bg-body-secondary">
                      <div class="card-body bg-body-secondary">
                        <h2 class="text-center mb-4">Log In</h2>
                        <?php
                        if (!$success) echo "<span class='text-danger'>Username or Password is Invalid</span>";
                        ?>
                        <form action="login.php" method="post">
                          <!-- Username -->
                          <div class="mb-3">
                              <label for="username" class="form-label">Username</label>
                              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" required>
                          </div>
                          <!-- Password -->
                          <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                          </div>
                          <!-- Log In Button -->
                          <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Log In</button>
                          </div>
                          <!-- Sign Up Link -->
                          <p class="text-center mt-3">
                            Don't have an account? <a href="signup.html">Sign Up</a>
                          </p>
                        </form>
                      </div>
                    </div>
                  </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!--Custom Javascript-->
        <script src="../assets/js/login.js"></script>
    </body>
</html>