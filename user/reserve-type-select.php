<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_SESSION['reserve_data']['entry_id'] ?? null;
$semester_id = $_SESSION['reserve_data']['semester_id'] ?? null;

if (!$entry_id) {
    $_SESSION['error'] = "No entry selected for reservation.";
    header("Location: timetable-reserve.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ? AND User_ID = ?");
$stmt->execute([$entry_id, $_SESSION['ID']]);
$entry = $stmt->fetch();

if (!$entry) {
    $_SESSION['error'] = "Invalid entry selection.";
    header("Location: timetable-reserve.php");
    exit();
}

// Fetch current semester if not set
if (!$semester_id) {
    $currentDate = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT ID FROM SEMESTER WHERE Start_Date <= ? AND End_Date >= ? LIMIT 1");
    $stmt->execute([$currentDate, $currentDate]);
    $semester_id = $stmt->fetchColumn();
    
    if (!$semester_id) {
        $_SESSION['error'] = "No active semester found.";
        header("Location: timetable-reserve.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_type = $_POST['type'];
    $_SESSION['reserve_data']['type'] = $reservation_type;
    
    if ($reservation_type === 'single') {
        header("Location: reserve-single-confirm.php");
    } else if ($reservation_type === 'semester') {
        header("Location: reserve-semester-day.php");
    } else {
        $_SESSION['error'] = "Invalid reservation type selected.";
        header("Location: timetable-reserve.php");
    }
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

        <title>Choose Reserve Type - BookItClassroom</title>
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
                    <form method="POST">
                        <button type="submit" name="type" value="single" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Single Booking</p>
                            <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-1-circle-fill primary"></i>
                            </span>
                        </button>
                        <button type="submit" name="type" value="semester" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Whole Semester</p>
                            <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-calendar-week primary"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>