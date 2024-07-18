<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reservation']) || !isset($_SESSION['reservation']['semester_day'])) {
    header("Location: ../guest/login.php");
    exit();
}

$reservation = $_SESSION['reservation'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = dbConnect();
    
    // Get the current semester dates (you should implement this logic based on your system)
    $semester_start = '2023-09-01'; // Example start date
    $semester_end = '2023-12-31'; // Example end date
    
    $stmt = $pdo->prepare("INSERT INTO BOOKING (User_ID, Classroom, Booking_Date, Time_Start, Time_End, Type) VALUES (?, ?, ?, ?, ?, 'SEMESTER')");
    
    $current_date = new DateTime($semester_start);
    $end_date = new DateTime($semester_end);
    $interval = new DateInterval('P1W'); // 1 week interval
    
    while ($current_date <= $end_date) {
        if ($current_date->format('l') === $reservation['semester_day']) {
            $booking_date = $current_date->format('Y-m-d');
            $time_end = date('H:i:s', strtotime($reservation['time'] . ' +1 hour'));
            $stmt->execute([$_SESSION['ID'], $reservation['classroom'], $booking_date, $reservation['time'], $time_end]);
        }
        $current_date->add($interval);
    }

    unset($_SESSION['reservation']);
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

        <title>Confirm Semester Reservation - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1 ms-5"><p>Confirm Semester Reservation</p></div>
                        <div class="subheading1 ms-5">
                            <p>Please confirm the following semester reservation details:</p>
                            <ul>
                                <li>Classroom: <?php echo htmlspecialchars($reservation['classroom']); ?></li>
                                <li>Day: <?php echo htmlspecialchars($reservation['semester_day']); ?></li>
                                <li>Time: <?php echo date('g:i A', strtotime($reservation['time'])) . ' - ' . date('g:i A', strtotime($reservation['time'] . ' +1 hour')); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <form method="POST">
                        <button type="submit" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Confirm Semester Reservation</p>
                            <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-check-circle primary"></i>
                            </span>
                        </button>
                    </form>
                    <a href="map-timetable.php?classroom=<?php echo urlencode($reservation['classroom']); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html> 