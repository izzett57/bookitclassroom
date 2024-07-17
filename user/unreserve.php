<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$booking_id = $_GET['id'] ?? null;

if (!$booking_id) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();

// Check if the booking belongs to the current user
$stmt = $pdo->prepare("SELECT b.*, e.User_ID FROM BOOKING b JOIN ENTRY e ON b.Entry_ID = e.ID WHERE b.ID = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking || $booking['User_ID'] != $_SESSION['ID']) {
    $_SESSION['error'] = "You don't have permission to unreserve this booking.";
    header("Location: timetable.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    // Delete the booking
    $stmt = $pdo->prepare("DELETE FROM BOOKING WHERE ID = ?");
    $stmt->execute([$booking_id]);

    $_SESSION['success'] = "Reservation successfully cancelled.";
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

        <title>Unreserve - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Unreserve Classroom</p></div>
                        <div class="subheading1 ms-5"><p>Are you sure you want to cancel this reservation?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container mt-5" style="width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Classroom</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($booking['Classroom']); ?></p>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($booking['Time_Start'])); ?>
                                    </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;" style="width: 100%">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($booking['Time_End'])); ?>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a href="timetable.php" class="dongle-regular custom-btn-inline px-3 ms-4 me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" name="confirm" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Confirm Unreserve</p>
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