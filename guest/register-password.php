<?php

session_start();

$errorMessage = ''; // Initialize an error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract posted form data
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    // Basic password validation
    if (empty($password)) {
        $errorMessage = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errorMessage = "Password must be at least 8 characters long.";
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errorMessage = "Password must contain both letters and numbers.";
    } elseif ($password !== $confirmPassword) {
        // Check if passwords match
        $errorMessage = "Passwords do not match.";
    } else {
        // Passwords match and meet the validation criteria, proceed with form processing
        $_SESSION['INFO']['password'] = $password;

        // Redirect to the next page
        header('Location: register-complete.php');
        exit;
    }
}

?>

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

        <title>BookItClassroom - Register - Password</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <nav class="navbar bg-transparent px-5 py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Back button start -->
                    <button onclick="history.back()" type="button" class="btn btn-light btn-circle me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-arrow-left-circle-fill primary" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                            </svg>
                    </button>
                    <!-- Back button end -->
                    <!-- Logo start -->
                    <a class="navbar-brand" href="index.php">
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
                <div class="col d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1"><p>Register</p></div>
                        <!-- Subheading -->
                        <div class="subheading1"><p>Please enter your password.</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex flex-column">
                    <div class="container w-75">
                        <!-- Register password form start -->
                        <form class="row" action="" method="POST">
                            <!-- Password input start -->
                            <div>
                                <label class="form-label inter-regular pt-2" for="password" style="letter-spacing: 4px; color: #272937;">PASSWORD</label><br>
                                <input class="form-control" type="password" name="password" value="<?= isset($SESSION['INFO']['password'])
            ? $_SESSION['INFO']['password'] : '' ?>"><br>
                            </div>
                            <!-- Password input end -->
                            <!-- Confirm password input start -->
                            <div>
                                <label class="form-label inter-regular" for="confirmPassword" style="letter-spacing: 4px; color: #272937;">CONFIRM PASSWORD</label><br>
                                <input class="form-control" type="password" name="confirmpassword" value="<?= isset($SESSION['INFO']['confirmpassword'])
            ? $_SESSION['INFO']['confirmpassword'] : '' ?>"><br>
                            </div>
                            <!-- Confirm password input end -->
                             <!-- Error message start -->
                            <?php if (!empty($errorMessage)): ?>
            <div style="color: red;"><?= $errorMessage; ?></div>
        <?php endif; ?>
                            <!-- Error message end -->
                            <div class="row pt-4">
                                <!-- Spacing start -->
                                <div class="col">
                                </div>
                                <!-- Spacing end -->
                                <!-- Buttons start -->
                                <div class="col d-flex justify-content-end align-items-center">
                                    <!-- Back button start -->
                                    <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="#" style="text-decoration: none; font-size: 2rem">back</a>
                                    <!-- Back button end -->
                                    <!-- Next button start -->
                                    <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between" name="submit" value="submit">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Submit</p>
                                    </button>
                                    <!-- Next button end -->
                                </div>
                                <!-- Buttons end -->
                            </div>
                        </form>
                        <!-- Register password form end --> 
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
