<!DOCTYPE html>

<html>
    <head>
        <!--Meta Data-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Bootstrap CSS and Main CSS-->
        <link rel="stylesheet" href="../assets/css/bootstrap.custom.css">

        <!--Other-->
        <title>User Settings - Staem</title>
    </head>
    <body>
        <!--Main Container-->
        <div class="container-fluid vh-100 d-flex flex-column" style="margin: 0; padding: 0;">
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
                            <a class="nav-link" href="#">Home</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Libray</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Cart</a>
                          </li>
                        </ul>
                      </div>
                      <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-primary me-2" type="submit">Search</button>
                      </form>                              
                </div>
            </nav>

            <!--Put your code here-->
            <main class="row h-100">
              <div class="p-5 pe-2 col-3">
                <ul class="list-group list-group-flush border rounded h-100">
                  <li class="list-group-item active">Account Settings</li>
                  <li class="list-group-item list-group-item-action">Security</li>
                  <li class="list-group-item list-group-item-action mb-auto">Transactions</li>
                  <button class="list-group-item list-group-item-action border-top text-danger">Logout</button>
                </ul>
              </div>
              <div class="p-5 ps-2 col-9">
                <div class="card h-100 border">
                  <div class="card-body d-flex flex-column align-items-center">
                    <h1 class="text-center mb-4">Profile Settings</h1>
                    <form class="w-50">
                      <div class="mb-3">
                          <label for="username" class="form-label">Username</label>
                          <input type="text" class="form-control" id="username" placeholder="Enter your username">
                      </div>
                      <div class="mb-3">
                          <label for="email" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter your email">
                      </div>
                      <div class="d-flex">
                        <button type="submit" class="btn btn-primary me-auto">Save Changes</button>
                        <button class="btn btn-outline-success">Become a Publisher</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </main>
        </div>

        <!--Bootstrap Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>