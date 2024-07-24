<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['new_entry'])) {
    header("Location: ../guest/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day = $_POST['day'];
    if (!empty($day)) {
        $_SESSION['new_entry']['day'] = $day;
        header("Location: new-entry-time.php");
        exit();
    }
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

        <title>New Entry - Day - BookItClassroom</title>
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
                        <div class="heading1 ms-5"><p>New Entry</p></div>
                        <div class="subheading1 ms-5"><p>Which day is the class/event?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex justify-content-center align-items-center">
                                <?php
                                $days = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'];
                                foreach ($days as $day) {
                                    echo "<input type='radio' id='day$day' name='day' value='$day' class='dayInput' required>";
                                    echo "<label for='day$day' class='dayContainer'>";
                                    echo "<span class='heading1'>" . substr($day, 0, 1) . "</span>";
                                    echo "</label>";
                                }
                                ?>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
                                </button>
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