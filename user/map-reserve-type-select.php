<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
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

        <title>Reserve - Type - BookItClassroom</title>
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
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1 ms-5"><p>Choose Reserve Type</p></div>
                        <!-- Subheading -->
                        <div class="subheading1 ms-5" style="width: 70%;"><p>Would you like to reserve for a single timeslot or the whole semester?</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <!-- View map button start -->
                    <button type="button" name="" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Single Booking</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                        <i class="bi bi-1-circle-fill primary"></i>
                        </span>
                    </button>
                    <!-- View map button end -->
                    <!-- Timetable button -->
                    <button type="button" name="" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Whole Semester</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                        <i class="bi bi-calendar-week primary"></i>
                        </span>
                    </button>
                    <!-- Timetable button end -->
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

