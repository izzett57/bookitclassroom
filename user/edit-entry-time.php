<?php
require_once '../assets/db_conn.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
if (!$entry_id) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ? AND User_ID = ?");
$stmt->execute([$entry_id, $_SESSION['ID']]);
$entry = $stmt->fetch();

if (!$entry) {
    header("Location: timetable.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_time = $_POST['timeFrom'];
    $end_time = $_POST['timeTo'];
    if (!empty($start_time) && !empty($end_time)) {
        $update_stmt = $pdo->prepare("UPDATE ENTRY SET Time_Start = ?, Time_End = ? WHERE ID = ?");
        $update_stmt->execute([$start_time, $end_time, $entry_id]);
        header("Location: edit-entry-confirm.php?id=" . $entry_id);
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

        <title>Edit Entry - Time - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                var initialEndTimeOptions = []; // Store initial "End Time" options

                // Generate initial "End Time" options
                for (var hour = 0; hour < 24; hour++) {
                    for (var minute = 0; minute < 60; minute += 30) {
                        var timeString = (hour < 10 ? "0" + hour : hour) + ":" + (minute === 0 ? "00" : minute);
                        initialEndTimeOptions.push($('<option>', {
                            value: timeString,
                            text: timeString
                        }));
                    }
                }

                $('#starttime').change(function() {
                    var starttime = $(this).val();
                    var currentEndTime = $('#endtime').val(); // Capture the currently selected "End Time"

                    var startHoursMinutes = starttime.split(':');
                    var startTotalMinutes = parseInt(startHoursMinutes[0]) * 60 + parseInt(startHoursMinutes[1]);

                    // Clear current "End Time" options
                    $('#endtime').empty();

                    // Dynamically generate "End Time" options based on "Start Time"
                    $.each(initialEndTimeOptions, function(index, option) {
                        var optionTime = $(option).val();
                        var optionHoursMinutes = optionTime.split(':');
                        var endTotalMinutes = parseInt(optionHoursMinutes[0]) * 60 + parseInt(optionHoursMinutes[1]);

                        if (endTotalMinutes > startTotalMinutes) {
                            $('#endtime').append($(option).clone()); // Use clone to avoid removing from initialEndTimeOptions
                        }
                    });

                    // Re-select the previously selected "End Time" if still valid
                    if ($('#endtime option[value="' + currentEndTime + '"]').length > 0) {
                        $('#endtime').val(currentEndTime);
                    } else {
                        // Optionally, handle the case where the previous "End Time" is no longer valid
                        // e.g., select the next valid "End Time" automatically or leave as is
                    }

                    $('#endtime').removeAttr('disabled');
                });
                $('select').on('focus', function() {
                    $(this).children('option').css('font-size', '18px'); // Smaller font size for options
                }).on('blur change', function() {
                    $(this).children('option').css('font-size', '16px'); // Revert to original font size
                });
                $('select').selectmenu({
                    open: function(event, ui) {
                        var menuWidget = $(this).selectmenu("menuWidget");
                        menuWidget.find("li").removeClass("ui-state-focus"); // Optional: Remove focus class on open to avoid styling conflicts
                    }
                }).selectmenu("menuWidget").addClass("custom-hover-style");
            });
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
                        <div class="heading1 ms-5"><p>Edit Entry</p></div>
                        <div class="subheading1 ms-5"><p>What time is the class/event?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-group text-center" style="height: 60px; width: 20%;">
                                    <select class="form-control text-center text-time custom-select" style="height: 100%;" id="starttime" name="timeFrom" required>
                                        <?php echo get_times($entry['Time_Start']); ?>
                                    </select>
                                </div>
                                <span class="text-time mx-5">-</span>
                                <div class="form-group text-center" style="height: 60px; width: 20%;">
                                    <select class="form-control text-center text-time custom-select" style="height: 100%;" id="endtime" name="timeTo" disabled="" required>
                                        <?php echo get_times($entry['Time_End']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a href="edit-entry-day.php?id=<?php echo $entry_id; ?>" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem;">back</a>
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