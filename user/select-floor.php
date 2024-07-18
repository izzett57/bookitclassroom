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
        
        <?php include('../assets/import-bootstrap.php'); ?>

        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <link rel="stylesheet" href="../assets/css/entry.css">

        <title>New Entry - Confirmation - BookItClassroom</title>
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
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Select Floor</p></div>
                        <div class="subheading1 ms-5"><p>Which floor would you like to view?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex flex-column justify-content-center align-items-center pt-1">
                                <div>
                                <object id="svg-object" type="image/svg+xml" data="../assets/svg/map/floor-1.svg" style="width: 200px; height: 200px; transform: skew(0deg, 0deg);"></object>
                                </div>
                                <div>
                                    test 2
                                </div>
                                <div>
                                    test 3
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content end -->
        <?php include('../assets/footer.php'); ?>
    </body>
</html> 