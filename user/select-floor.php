<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_floor = $_POST['floor'];
    $_SESSION['selected_floor'] = $selected_floor;
    header("Location: map-reserve.php");
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

        <title>Select Floor - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>
        
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Select Floor</p></div>
                        <div class="subheading1 ms-5"><p>Which floor would you like to view?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column pb-5">
                    <div class="container" style="width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex flex-column justify-content-center align-items-center pt-1">
                                <!-- Floor 3 -->
                                <div class="row" style="margin-bottom: -90px;">
                                    <div class="col">
                                        <img src="../assets/svg/map/floor-3.svg" style="width: 200px; height: 200px; transform: scale(2.0, 1.0) rotateX(60deg) rotateY(0deg) rotateZ(-45deg);"></img>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center" style="margin-left: 200px;">
                                        <button type="submit" name="floor" value="3" class="btn btn-lg custom-btn-noanim d-flex align-items-center" style="display: inline-block; position: absolute;">
                                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">3F</p>
                                        </button>
                                    </div>
                                </div>
                                <!-- Floor 2 -->
                                <div class="row" style="margin-bottom: -90px;">
                                    <div class="col">
                                        <img src="../assets/svg/map/floor-2.svg" style="width: 200px; height: 200px; transform: scale(2.0, 1.0) rotateX(60deg) rotateY(0deg) rotateZ(-45deg);"></img>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center" style="margin-left: 200px;">
                                        <button type="submit" name="floor" value="2" class="btn btn-lg custom-btn-noanim d-flex align-items-center" style="display: inline-block; position: absolute">
                                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">2F</p>
                                        </button>
                                    </div>
                                </div>
                                <!-- Floor 1 -->
                                <div class="row" style="margin-bottom: -90px;">
                                    <div class="col">
                                        <img src="../assets/svg/map/floor-1.svg" style="width: 200px; height: 200px; transform: scale(2.0, 1.0) rotateX(60deg) rotateY(0deg) rotateZ(-45deg);"></img>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center" style="margin-left: 200px;">
                                        <button type="submit" name="floor" value="1" class="btn btn-lg custom-btn-noanim d-flex align-items-center" style="display: inline-block; position: absolute">
                                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">1F</p>
                                        </button>
                                    </div>
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