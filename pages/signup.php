<?php
require_once("../server/user_service.php");

/*UserService::register([
  'username' => "",
  'email' => "",
  'password' => ""
]);*/
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
        <title>Sign up - Staem</title>
    </head>
    <body  class="overflow-hidden">
        <!--Main Container-->
        <div class="container-fluid vh-100" style="margin: 0; padding: 0;">
        

            <!--Put your code here-->
            <main class="h-100">
              <div class="container h-100 d-flex justify-content-center align-items-center">
                <div class="card w-50 shadow-sm bg-body-secondary">
                  <div class="card-body bg-body-secondary">
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <form action="/signup.php" method="post" onsubmit="return register()">
                      <!-- Username -->
                      <div class="mb-3">                                                                        
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" required>
                      </div>
                      <!-- Email -->
                      <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                      </div>
                      <!-- Password -->
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                      </div>
                      <!-- Sign Up Button -->
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                      </div>
                      <!-- Already have an account -->
                      <p class="text-center mt-3">
                        Already have an account? <a href="login.html">Log In</a>
                      </p>
                    </form>
                  </div>
                </div>
                </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!--JQuery CDN-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!--Custom Script-->
        <script src="../assets/js/signup.js"></script>
    </body>
</html>