<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Import Bootstrap start -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Import Bootstrap end -->

        <!-- Import CSS file start -->
        <link rel="stylesheet" href="../assets/css/guest.css">
        <!-- Import CSS file end -->

        <title>BookItClassroom</title>
    </head>
    <body>
        <!-- Nav bar start -->
        <nav class="navbar bg-transparent px-5 py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Logo start -->
                    <a class="navbar-brand" href="./index.php">
                        <img src="../assets/logo.png" class="img-fluid" width="316" height="51">
                    </a>
                    <!-- Logo end -->
                </div>
                <!-- Profile button start -->
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
                        <li><a class="dropdown-item inter-regular" href="./register-name.php">Register</a></li>
                        <li><a class="dropdown-item inter-regular" href="./login.php">Sign In</a></li>
                    </ul>
                </li>
                <!-- Profile button end -->
            </div>
        </nav>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-8 d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1"><p>Register Complete!</p></div>
                        <!-- Subheading -->
                        <div class="subheading1"><p>Would you like to log in?</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex">
                    <div class="container d-flex justify-content-center align-items-center text-center">
                        <!-- Register form start -->
                        <div class="row">
                            <!-- Buttons start -->
                            <div class="col">
                                <!-- Yes button start -->
                                <button type="button" class="btn btn-lg custom-btn-noanim d-flex align-items-center" href="#">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Yes</p>
                                </button>
                                <!-- Yes button end -->
                                <!-- No button start -->
                                    <a class="dongle-regular custom-btn-inline primary" href="#" style="text-decoration: none; font-size: 2rem">no</a>
                                <!-- No button end -->
                            </div>
                            <!-- Buttons end -->
                        </div>
                        <!-- Register form end --> 
                    </div>
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
