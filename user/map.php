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

        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/rome.js"></script>
        <script src="../assets/js/main.js"></script>

        <link rel="stylesheet" href="../assets/css/entry.css">

        <title>Map - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <!-- Nav bar start -->
        <nav class="navbar bg-transparent px-5 py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Back button start -->
                    <button onclick="history.back()" type="button" class="btn btn-light btn-circle me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-arrow-left-circle-fill primary" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </button>
                    <!-- Back button end -->
                    <!-- Logo start -->
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/logo.png" class="img-fluid" width="316" height="51" alt="BookItClassroom Logo">
                    </a>
                    <!-- Logo end -->
                </div>
                <!-- Profile button start -->
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
                <!-- Profile button end -->
            </div>
        </nav>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3">
            <div class="container">
                <div class="row">
                    <!-- Text start -->
                        <!-- Heading -->
                        <div class="heading1" style="background-color: rgba(0, 0, 0, 0.1);"><p>Map</p></div>
                    <!-- Text end -->
                    <div class="container" style="height: 70vh; background-color: rgba(0, 0, 0, 0.2);">
                        <div class="row" style="height: 100%;">
                        <div class="col-8" style="background-color: rgba(0, 0, 0, 0.3);">
                            map
                        </div>
                        <div class="col">
                            <div class="col d-flex justify-content-center align-items-center" style="height: 50%; background-color: rgba(0, 0, 0, 0.4);">
                                <style>
                                    /**
                                    * rome - Customizable date (and time) picker. Opt-in UI, no jQuery!
                                    * @version v2.1.22
                                    * @link https://github.com/bevacqua/rome
                                    * @license MIT
                                    */
                                    .rd-container {
                                        display: block; /* Ensure it's not set to none */
                                        width: 100%; /* Fill the width of its parent */
                                        height: 100%; /* Fill the height of its parent */
                                        background-color: #fff;
                                        padding: 10px;
                                        text-align: center;
                                    }
                                    .rd-container-attachment {
                                    position: absolute;
                                    }
                                    .rd-month {
                                    display: inline-block;
                                    margin-right: 25px;
                                    }
                                    .rd-month:last-child {
                                    margin-right: 0;
                                    }
                                    .rd-back,
                                    .rd-next {
                                    cursor: pointer;
                                    border: none;
                                    outline: none;
                                    background: none;
                                    padding: 0;
                                    margin: 0;
                                    }
                                    .rd-back[disabled],
                                    .rd-next[disabled] {
                                    cursor: default;
                                    }
                                    .rd-back {
                                    float: left;
                                    margin-left: 10px;
                                    }
                                    .rd-next {
                                    float: right;
                                    margin-right: 10px;
                                    }
                                    .rd-back:before {
                                    display: block;
                                    content: '\2190';
                                    }
                                    .rd-next:before {
                                    display: block;
                                    content: '\2192';
                                    }
                                    .rd-day-body {
                                    cursor: pointer;
                                    text-align: center;
                                    /* new */
                                    line-height: 0;
                                    width: 2.8vw!important;
                                    height: 4vh!important;
                                    }
                                    .rd-day-selected,
                                    .rd-time-selected,
                                    .rd-time-option:hover {
                                    cursor: pointer;
                                    background-color: #DA7422;
                                    color: #fff;
                                    /* new */
                                    border-radius: 25%;
                                    }
                                    .rd-day-prev-month,
                                    .rd-day-next-month {
                                    color: #ccc;
                                    }
                                    .rd-day-disabled {
                                    cursor: default;
                                    color: #fcc;
                                    }
                                    .rd-time {
                                    position: relative;
                                    display: inline-block;
                                    margin-top: 5px;
                                    min-width: 80px;
                                    }
                                    .rd-time-list {
                                    display: none;
                                    position: absolute;
                                    overflow-y: scroll;
                                    max-height: 160px;
                                    left: 0;
                                    right: 0;
                                    background-color: #fff;
                                    color: #333;
                                    }
                                    .rd-time-selected {
                                    padding: 5px;
                                    }
                                    .rd-time-option {
                                    padding: 5px;
                                    }
                                    .rd-day-concealed {
                                    visibility: hidden;
                                    }

                                    .rd-days {
                                    margin-top: 20px;
                                    }
                                </style>
                                <div id="inline_cal" class="inter-light"></div>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center" style="height: 50%; background-color: rgba(0, 0, 0, 0.5);">
                                <?php
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
                                <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                        <select class="form-control text-center text-time custom-select" style="height: 100%;" id="starttime" name="timeFrom" required>
                                            <?php echo get_times(); ?>
                                        </select>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2">-</span>
                                    <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                        <select class="form-control text-center text-time custom-select" style="height: 100%;" id="endtime" name="timeTo" required>
                                            <?php echo get_times(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
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