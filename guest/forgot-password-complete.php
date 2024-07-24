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

        <title>Email Sent! - BookItClassroom</title>
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
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1"><p>Email sent!</p></div>
                        <!-- Subheading -->
                        <div class="subheading1"><p>Check your email for further instructions.</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex">
                    <div class="container d-flex justify-content-center align-items-center text-center">
                        <!-- Register form start -->
                        <div class="row">
                            <!-- Buttons start -->
                            <div class="col">
                                <!-- Login button -->
                                <button onclick="location.href='./index.php'" type="button" class="btn custom-btn-home btn-lg d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Back to Home</p>
                                    <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                        <i class="bi bi-house-door-fill primary"></i>
                                    </span>
                                </button>
                                <!-- Login button end -->
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