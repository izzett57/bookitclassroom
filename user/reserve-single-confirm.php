<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reservation'])) {
    header("Location: ../guest/login.php");
    exit();
}

$reservation = $_SESSION['reservation'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("INSERT INTO BOOKING (User_ID, Classroom, Booking_Date, Time_Start, Time_End, Type) VALUES (?, ?, ?, ?, ?, 'SINGLE')");
    $time_end = date('H:i:s', strtotime($reservation['time'] . ' +1 hour'));
    $stmt->execute([$_SESSION['ID'], $reservation['classroom'], $reservation['date'], $reservation['time'], $time_end]);

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

        <title>Confirm Single Reservation - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1 ms-5"><p>Confirm Single Reservation</p></div>
                        <div class="subheading1 ms-5">
                            <p>Please confirm the following reservation details:</p>
                            <ul>
                                <li>Classroom: <?php echo htmlspecialchars($reservation['classroom']); ?></li>
                                <li>Date: <?php echo date('F j, Y', strtotime($reservation['date'])); ?></li>
                                <li>Time: <?php echo date('g:i A', strtotime($reservation['time'])) . ' - ' . date('g:i A', strtotime($reservation['time'] . ' +1 hour')); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <form method="POST">
                        <button type="submit" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Confirm Reservation</p>
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