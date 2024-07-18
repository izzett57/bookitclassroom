<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
$semester_id = $_GET['semester_id'] ?? null;
$reserve_data = $_SESSION['reserve_data'];

if (!$entry_id || !$semester_id) {
    header("Location: timetable.php");
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

        <title>Reserve - Type - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1 ms-5"><p>Choose Reserve Type</p></div>
                        <div class="subheading1 ms-5" style="width: 70%;"><p>Would you like to reserve for a single timeslot or the whole semester?</p></div>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <?php
                    $params = http_build_query([
                        'id' => $entry_id,
                        'semester_id' => $semester_id,
                        'type' => 'single'
                    ]);
                    ?>
                    <button onclick="location.href='reserve-single-confirm.php?<?php echo $params; ?>'" type="button" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Single Booking</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                        <i class="bi bi-1-circle-fill primary"></i>
                        </span>
                    </button>
                    <?php
                    $params = http_build_query([
                        'id' => $entry_id,
                        'semester_id' => $semester_id,
                        'type' => 'semester'
                    ]);
                    ?>
                    <button onclick="location.href='reserve-semester-confirm.php?<?php echo $params; ?>'" type="button" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Whole Semester</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                        <i class="bi bi-calendar-week primary"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>