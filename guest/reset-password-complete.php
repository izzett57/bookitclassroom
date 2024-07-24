<?php
session_start();
if (!isset($_SESSION['password_reset_complete'])) {
    header("Location: index.php");
    exit();
}
unset($_SESSION['password_reset_complete']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Import Bootstrap start -->
        <?php include('../assets/import-bootstrap.php'); ?>
        <!-- Import Bootstrap end -->

        <!-- Import CSS file(s) start -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <!-- Import CSS file(s) end -->

        <title>Reset Password Complete! - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-guest.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-8 d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1" style="font-size: 5rem;"><p>Your password has been changed!</p></div>
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
                                <button type="button" onclick="location.href='login.php'" class="btn btn-lg custom-btn-noanim d-flex align-items-center">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Yes</p>
                                </button>
                                <!-- Yes button end -->
                                <!-- No button start -->
                                    <a onclick="location.href='index.php'" class="dongle-regular custom-btn-inline primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">no</a>
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
        <?php include('../assets/footer.php'); ?>
        <!-- Footer end -->
    </body>
</html>