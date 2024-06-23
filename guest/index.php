<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Import Bootstrap start -->
        <?php 
            include('../assets/import-bootstrap.php');
        ?>
        <!-- Import Bootstrap end -->

        <!-- Import CSS file(s) start -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <!-- Import CSS file(s) end -->

        <title>BookItClassroom - Home</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <nav class="navbar navbar-expand-lg bg-transparent px-5 py-4">
            <div class="container-fluid">
                <!-- Logo start-->
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/logo.png" class="img-fluid" width="316" height="51">
                </a>
                <!-- Logo end -->
                <!-- Profile Button -->
                <li class="dropdown" style="list-style-type: none;">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <button type="button" class="btn btn-light btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-person-circle primary" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                              </svg>
                        </button>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2">
                        <li><a class="dropdown-item inter-regular" href="register-name.php">Register</a></li>
                        <li><a class="dropdown-item inter-regular" href="login.php">Sign In</a></li>
                    </ul>
                </li>
                <!-- Profile button end -->
            </div>
        </nav>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1"><p>Welcome, Guest!</p></div>
                        <!-- Subheading -->
                        <div class="subheading1"><p>What would you like to do today?</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <!-- View map button start -->
                    <button onclick="location.href='#'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">View Map</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-pin-map-fill primary"></i>
                        </span>
                    </button>
                    <!-- View map button end -->
                    <!-- Login button -->
                    <button onclick="location.href='login.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Login</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-box-arrow-in-right primary"></i>
                        </span>
                    </button>
                    <!-- Login button end -->
                </div>
            </div>
        </div>
        <!-- Main content end -->
        <!-- Footer -->
        <?php 
            include('../assets/footer.php');
        ?>
        <!-- Footer end -->
    </body>
</html>
