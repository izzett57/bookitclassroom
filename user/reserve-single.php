<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
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
        <link rel="stylesheet" href="../assets/css/entry.css"/>
        <!-- Import CSS file(s) end -->

        <title>Reserve - Single - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-user-back.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                    <!-- Text start -->
                    <div class="row d-flex justify-content-center mb-5 text-center">
                        <!-- Heading -->
                        <span class="heading1" style="padding-bottom: 30px;">Single Reservation Entry</span>
                        <!-- Subheading -->
                        <span class="subheading1" style="width: 70%;">Would you like to confirm this reservation?</span>
                    </div>
                    <!-- Text end -->
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="width: 35%;">
                        <!-- Reserve conflict form start -->
                        <form>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Event Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;">Event Name</p>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Classroom</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;">Classroom Name</p>
                            </div>
                            <!-- Time select start -->
                            <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <!-- <?php echo date('H:i', strtotime($entry['start_time'])); ?> -->
                                        01:00 <!-- placeholder -->
                                    </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 35%; height: 60px;" style="width: 100%">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <!-- <?php echo date('H:i', strtotime($entry['end_time'])); ?> -->
                                        02:00 <!-- placeholder -->
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Time select end -->
                                <!-- Buttons start -->
                                <div class="col d-flex justify-content-center align-items-center mt-5">
                                    <!-- Back button start -->
                                    <a onclick="history.back()" class="dongle-regular custom-btn-inline px-3 ms-4 me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                    <!-- Back button end -->
                                    <!-- Next button start -->
                                    <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reserve</p>
                                    </button>
                                    <!-- Next button end -->
                                </div>
                                <!-- Buttons end -->
                        </form>
                        <!-- Reserve conflict form end -->
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
