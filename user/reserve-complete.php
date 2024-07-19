<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    error_log("Session data missing. SESSION: " . print_r($_SESSION, true));
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
$reserve_data = $_SESSION['reserve_data'];

if (!$entry_id) {
    error_log("Entry ID missing");
    header("Location: timetable.php");
    exit();
}

error_log("Starting reservation process. Entry ID: $entry_id, Reserve Data: " . print_r($reserve_data, true));

$pdo = dbConnect();

try {
    $pdo->beginTransaction();

    if ($reserve_data['type'] === 'SINGLE') {
        // Single booking logic (unchanged)
    } elseif ($reserve_data['type'] === 'SEMESTER') {
        if (!isset($reserve_data['semester_id']) || !isset($reserve_data['day'])) {
            throw new Exception("Missing semester_id or day for semester booking");
        }

        $stmt = $pdo->prepare("SELECT ID, Start_Date, End_Date FROM SEMESTER WHERE ID = ?");
        $stmt->execute([$reserve_data['semester_id']]);
        $semester = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$semester) {
            throw new Exception("Invalid semester ID: " . $reserve_data['semester_id']);
        }

        error_log("Semester data: " . print_r($semester, true));

        $start_date = new DateTime($semester['Start_Date']);
        $end_date = new DateTime($semester['End_Date']);
        $interval = new DateInterval('P1D'); // 1 day interval
        $period = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

        $stmt = $pdo->prepare("INSERT INTO BOOKING (Type, Booking_Date, Semester_ID, Entry_ID, Classroom) VALUES (?, ?, ?, ?, ?)");
        
        $insertCount = 0;
        foreach ($period as $date) {
            $current_day = strtoupper($date->format('l'));
            error_log("Checking date: " . $date->format('Y-m-d') . ", Day: $current_day");
            if ($current_day === $reserve_data['day']) {
                $booking_date = $date->format('Y-m-d');
                $stmt->execute(['SEMESTER', $booking_date, $reserve_data['semester_id'], $entry_id, $reserve_data['classroom']]);
                $insertCount++;
                error_log("Semester booking inserted for date: $booking_date. ID: " . $pdo->lastInsertId());
            }
        }
        error_log("Total semester bookings inserted: $insertCount");

        if ($insertCount === 0) {
            throw new Exception("No bookings were inserted for the semester. Selected day: " . $reserve_data['day']);
        }
    } else {
        throw new Exception("Invalid reservation type: " . $reserve_data['type']);
    }

    // Update the ENTRY table with the assigned classroom
    $stmt = $pdo->prepare("UPDATE ENTRY SET Assigned_Class = ? WHERE ID = ?");
    $stmt->execute([$reserve_data['classroom'], $entry_id]);
    error_log("Entry updated with assigned classroom");

    $pdo->commit();
    $success = true;
    error_log("Reservation completed successfully");
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error during reservation process: " . $e->getMessage());
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