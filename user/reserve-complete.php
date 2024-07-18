<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
$reserve_data = $_SESSION['reserve_data'];

if (!$entry_id) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();

try {
    $pdo->beginTransaction();

    if ($reserve_data['type'] === 'SINGLE') {
        $stmt = $pdo->prepare("INSERT INTO BOOKING (Type, Booking_Date, Semester_ID, Entry_ID, Classroom) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['SINGLE', $reserve_data['date'], $reserve_data['semester_id'], $entry_id, $reserve_data['classroom']]);
    } elseif ($reserve_data['type'] === 'SEMESTER') {
        $stmt = $pdo->prepare("SELECT Start_Date, End_Date FROM SEMESTER WHERE ID = ?");
        $stmt->execute([$reserve_data['semester_id']]);
        $semester = $stmt->fetch();

        $start_date = new DateTime($semester['Start_Date']);
        $end_date = new DateTime($semester['End_Date']);
        $interval = new DateInterval('P1D'); // 1 day interval
        $period = new DatePeriod($start_date, $interval, $end_date);

        $stmt = $pdo->prepare("INSERT INTO BOOKING (Type, Booking_Date, Semester_ID, Entry_ID, Classroom) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($period as $date) {
            if ($date->format('l') === date('l', strtotime($reserve_data['date']))) {
                $stmt->execute(['SEMESTER', $date->format('Y-m-d'), $reserve_data['semester_id'], $entry_id, $reserve_data['classroom']]);
            }
        }
    } else {
        throw new Exception("Invalid reservation type.");
    }

    // Update the ENTRY table with the assigned classroom
    $stmt = $pdo->prepare("UPDATE ENTRY SET Assigned_Class = ? WHERE ID = ?");
    $stmt->execute([$reserve_data['classroom'], $entry_id]);

    $pdo->commit();
    $success = true;
} catch (Exception $e) {
    $pdo->rollBack();
    $error = $e->getMessage();
}

// Clear the session data
unset($_SESSION['selected_floor']);
unset($_SESSION['reserve_data']);
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

        <title>Reservation Complete - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-8 d-flex justify-content-center align-items-center">
                    <div>
                        <?php if (isset($success)): ?>
                            <div class="heading1" style="font-size: 5rem;"><p>Reservation Complete!</p></div>
                            <div class="subheading1"><p>Your reservation has been successfully processed.</p></div>
                        <?php elseif (isset($error)): ?>
                            <div class="heading1" style="font-size: 5rem;"><p>Reservation Failed</p></div>
                            <div class="subheading1"><p>An error occurred: <?php echo htmlspecialchars($error); ?></p></div>
                        <?php endif; ?>
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