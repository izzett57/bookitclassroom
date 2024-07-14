<?php
require_once '../assets/db_conn.php';
session_start();

if (!isset($_SESSION['ID']) || !isset($_SESSION['new_entry'])) {
    header("Location: ../guest/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        
        <?php include('../assets/import-bootstrap.php'); ?>

        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <link rel="stylesheet" href="../assets/css/entry.css">

        <title>New Entry - Time - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            // (Keep your existing JavaScript here)
        </script>
    </head>
    
    <body>
        <nav class="navbar bg-transparent px-5 py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button onclick="history.back()" type="button" class="btn btn-light btn-circle me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-arrow-left-circle-fill primary" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                        </button>
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/logo.png" class="img-fluid" width="316" height="51">
                    </a>
                </div>
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
                        <li><a class="dropdown-item inter-regular" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item inter-regular" href="logout.php">Sign Out</a></li>
                    </ul>
                </li>
            </div>
        </nav>

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
                        <form method="POST" action="new-entry-time.php">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-group text-center" style="height: 60px; width: 20%;">
                                    <select class="form-control text-center text-time custom-select" style="height: 100%;" id="starttime" name="timeFrom" required>
                                        <?php echo get_times(); ?>
                                    </select>
                                </div>
                                <span class="text-time mx-5">-</span>
                                <div class="form-group text-center" style="height: 60px; width: 20%;">
                                    <select class="form-control text-center text-time custom-select" style="height: 100%;" id="endtime" name="timeTo" required>
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

        <?php include('../assets/footer.php'); ?>
    </body>
</html>