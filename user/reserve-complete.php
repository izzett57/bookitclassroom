<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    $_SESSION['error'] = "Invalid session data. Please start the reservation process again.";
    header("Location: reserve.php");
    exit();
}

$reserve_data = $_SESSION['reserve_data'];
$entry_id = $reserve_data['entry_id'] ?? null;

if (!$entry_id) {
    $_SESSION['error'] = "No entry selected for reservation.";
    header("Location: timetable-reserve.php");
    exit();
}

$pdo = dbConnect();

try {
    $pdo->beginTransaction();

    // Fetch the entry details
    $stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ? AND User_ID = ?");
    $stmt->execute([$entry_id, $_SESSION['ID']]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$entry) {
        throw new Exception("Entry not found or doesn't belong to the current user.");
    }

    // Fetch the current semester
    $currentDate = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT ID FROM SEMESTER WHERE Start_Date <= ? AND End_Date >= ? LIMIT 1");
    $stmt->execute([$currentDate, $currentDate]);
    $semester_id = $stmt->fetchColumn();

    if (!$semester_id) {
        throw new Exception("No active semester found for the current date.");
    }

    if ($reserve_data['type'] === 'SINGLE') {
        $stmt = $pdo->prepare("INSERT INTO BOOKING (Type, Booking_Date, Entry_ID, Classroom, Semester_ID) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            'SINGLE',
            $reserve_data['date'],
            $entry_id,
            $reserve_data['classroom'],
            $semester_id  // Add the semester_id for single bookings as well
        ]);
        $booking_id = $pdo->lastInsertId();
        if (!$booking_id) {
            throw new Exception("Failed to insert booking.");
        }
    } elseif ($reserve_data['type'] === 'SEMESTER') {
        $stmt = $pdo->prepare("SELECT Start_Date, End_Date FROM SEMESTER WHERE ID = ?");
        $stmt->execute([$semester_id]);
        $semester = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$semester) {
            throw new Exception("Invalid semester ID: " . $semester_id);
        }

        $start_date = new DateTime($semester['Start_Date']);
        $end_date = new DateTime($semester['End_Date']);
        $interval = new DateInterval('P1D'); // 1 day interval
        $period = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

        $stmt = $pdo->prepare("INSERT INTO BOOKING (Type, Booking_Date, Semester_ID, Entry_ID, Classroom) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($period as $date) {
            if (strtoupper($date->format('l')) === $reserve_data['day']) {
                $booking_date = $date->format('Y-m-d');
                $stmt->execute(['SEMESTER', $booking_date, $semester_id, $entry_id, $reserve_data['classroom']]);
            }
        }
    } else {
        throw new Exception("Invalid reservation type: " . $reserve_data['type']);
    }

    // Update the ENTRY table with the assigned classroom
    $stmt = $pdo->prepare("UPDATE ENTRY SET Assigned_Class = ? WHERE ID = ?");
    $stmt->execute([$reserve_data['classroom'], $entry_id]);

    $pdo->commit();
    $success = true;
    $_SESSION['success'] = "Reservation completed successfully.";
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error during reservation process: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred during the reservation process: " . $e->getMessage();
}

// Clear the session data
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
                        <?php else: ?>
                            <div class="heading1" style="font-size: 5rem;"><p>Reservation Failed</p></div>
                            <div class="subheading1"><p>An error occurred: <?php echo htmlspecialchars($_SESSION['error']); ?></p></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <button onclick="location.href='timetable.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">View Timetable</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-calendar3 primary"></i>
                        </span>
                    </button>
                    <button onclick="location.href='reserve.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Make Another Reservation</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-plus-circle primary"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>