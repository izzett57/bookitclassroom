<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
$classroom = $_GET['classroom'] ?? null;
$date = $_GET['date'] ?? null;
$time_start = $_GET['time_start'] ?? null;
$time_end = $_GET['time_end'] ?? null;
$type = $_GET['type'] ?? null;
$day = $_GET['day'] ?? null;

if (!$entry_id || !$classroom || !$date || !$time_start || !$time_end || !$type) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();

if ($type === 'single') {
    $stmt = $pdo->prepare("INSERT INTO BOOKING (Entry_ID, Classroom, Booking_Date, Time_Start, Time_End, Type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$entry_id, $classroom, $date, $time_start, $time_end, $type]);
} elseif ($type === 'semester') {
    // Get the current semester dates (you'll need to implement this logic)
    $semester_start = '2023-09-01'; // Example start date
    $semester_end = '2023-12-31'; // Example end date

    $stmt = $pdo->prepare("INSERT INTO BOOKING (Entry_ID, Classroom, Booking_Date, Time_Start, Time_End, Type) VALUES (?, ?, ?, ?, ?, ?)");
    
    $current_date = new DateTime($semester_start);
    $end_date = new DateTime($semester_end);
    $interval = new DateInterval('P1W'); // 1 week interval

    while ($current_date <= $end_date) {
        if ($current_date->format('l') === $day) {
            $booking_date = $current_date->format('Y-m-d');
            $stmt->execute([$entry_id, $classroom, $booking_date, $time_start, $time_end, $type]);
        }
        $current_date->add($interval);
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

        <title>Reserve Complete! - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-8 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1" style="font-size: 5rem;"><p>Reserve complete!</p></div>
                        <div class="subheading1"><p>Your reservation has been successfully processed.</p></div>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <a href="timetable.php" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">View Timetable</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-calendar3 primary"></i>
                        </span>
                    </a>
                    <a href="reserve.php" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Make Another Reservation</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-plus-circle primary"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>