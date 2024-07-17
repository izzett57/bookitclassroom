<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
$conflicting_booking_id = $_GET['conflict_id'] ?? null;

if (!$entry_id || !$conflicting_booking_id) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();

// Fetch the entry details
$stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ? AND User_ID = ?");
$stmt->execute([$entry_id, $_SESSION['ID']]);
$entry = $stmt->fetch();

// Fetch the conflicting booking details
$stmt = $pdo->prepare("SELECT * FROM BOOKING WHERE ID = ?");
$stmt->execute([$conflicting_booking_id]);
$conflicting_booking = $stmt->fetch();

if (!$entry || !$conflicting_booking) {
    header("Location: timetable.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the entry with the new time
    $stmt = $pdo->prepare("UPDATE ENTRY SET Time_Start = ?, Time_End = ? WHERE ID = ?");
    $stmt->execute([$conflicting_booking['Time_Start'], $conflicting_booking['Time_End'], $entry_id]);

    // Redirect to the confirmation page
    header("Location: reserve-single-confirm.php?id=" . $entry_id);
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

        <title>Reserve - Time Conflict - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row-9">
                    <div class="col">
                        <p class="heading1 ms-5">Time Conflict</p>
                        <p class="subheading1 ms-5" style="width: 85%;">This event has a different timing than the one selected on the map, continuing will update the selected event to the respective timing.</p>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container mt-5" style="width: 90%; align-content: center;">
                        <form method="POST">
                            <input type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
                            <input type="hidden" name="conflicting_booking_id" value="<?php echo $conflicting_booking_id; ?>">
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Event Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($entry['EName']); ?></p>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($conflicting_booking['Time_Start'])); ?>
                                    </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;" style="width: 100%">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($conflicting_booking['Time_End'])); ?>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a onclick="history.back()" class="dongle-regular custom-btn-inline px-3 ms-4 me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Continue</p>
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