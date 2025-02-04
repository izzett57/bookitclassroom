<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_SESSION['reserve_data']['entry_id'] ?? null;
$semester_id = $_SESSION['reserve_data']['semester_id'] ?? null;
$reserve_data = $_SESSION['reserve_data'];

if (!$entry_id || !$semester_id) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM SEMESTER WHERE ID = ?");
$stmt->execute([$semester_id]);
$semester = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ?");
$stmt->execute([$entry_id]);
$entry = $stmt->fetch();

if (!$semester || !$entry) {
    die("Invalid semester ID or entry ID");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserve_data['type'] = 'SEMESTER';
    $reserve_data['semester_id'] = $semester_id;
    $_SESSION['reserve_data'] = $reserve_data;

    header("Location: reserve-complete.php");
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
        <link rel="stylesheet" href="../assets/css/entry.css"/>

        <title>Reserve - Semester - Confirm - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Semester Reservation</p></div>
                        <div class="subheading1 ms-5"><p>Would you like to confirm this reservation?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container mt-5" style="width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Classroom</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($reserve_data['classroom']); ?></p>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Event Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($entry['EName']); ?></p>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                            <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Semester</p>
                            <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($semester['ID'] . " - " . $semester['Year']); ?></p>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Every</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($reserve_data['day']); ?></p>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($reserve_data['time_start'])); ?>
                                    </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;" style="width: 100%">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($reserve_data['time_end'])); ?>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a onclick="history.back()" class="dongle-regular custom-btn-inline px-3 ms-4 me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" name="confirm" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reserve</p>
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