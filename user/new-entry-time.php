<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['new_entry'])) {
    header("Location: ../guest/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_time = $_POST['timeFrom'];
    $end_time = $_POST['timeTo'];
    if (!empty($start_time) && !empty($end_time)) {
        $_SESSION['new_entry']['start_time'] = $start_time;
        $_SESSION['new_entry']['end_time'] = $end_time;
        header("Location: new-entry-confirm.php");
        exit();
    }
}

function get_times($default = '00:00', $interval = '+30 minutes') {
    $output = '';
    $current = strtotime('00:00');
    $end = strtotime('23:59');

    while ($current <= $end) {
        $time = date('H:i:s', $current);
        $sel = ($time == $default) ? ' selected' : '';
        $output .= "<option value=\"{$time}\"{$sel}>" . date('H:i ', $current) . '</option>';
        $current = strtotime($interval, $current);
    }
    return $output;
}
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
        <link rel="stylesheet" href="../assets/css/entry.css">
        <!-- Import CSS file(s) end -->

        <!-- Import time select scripts start -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/time-select.js"></script>
        <!-- Import time select scripts end -->

        <title>New Entry - Time - BookItClassroom</title>
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
                        <div class="subheading1 ms-5"><p>What time is the class/event?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-group text-center" style="height: 60px; width: 20%;">
                                    <select class="form-control text-center text-time custom-select" style="height: 100%;" id="starttime" name="timeFrom" required>
                                        <?php echo get_times(); ?>
                                    </select>
                                </div><br><br>
                                <span class="text-time mx-5">-</span>
                                <div class="form-group text-center" style="height: 60px; width: 20%;">
                                    <select class="form-control text-center text-time custom-select" style="height: 100%;" id="endtime" name="timeTo" disabled="" required>
                                        <?php echo get_times(); ?>
                                    </select>
                                </div>
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