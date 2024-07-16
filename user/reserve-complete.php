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

        <title>Edit Entry Complete! - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php 
            include('../assets/navbar-user.php');
        ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-8 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1" style="font-size: 5rem;"><p>Reserve complete!</p></div>
                        <div class="subheading1"><p>Would you like to reserve another class/event?</p></div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="container d-flex justify-content-center align-items-center text-center">
                        <form method="POST">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" name="reserve" value="yes" class="btn btn-lg custom-btn-noanim d-flex align-items-center">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Yes</p>
                                    </button>
                                    <button type="submit" name="reserve" value="no" class="dongle-regular custom-btn-inline primary" style="text-decoration: none; font-size: 2rem; cursor: pointer; background-color: #FFF; border: none;">no</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>