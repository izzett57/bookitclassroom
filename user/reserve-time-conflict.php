<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_SESSION['reserve_data']['entry_id'] ?? null;
$reserve_data = $_SESSION['reserve_data'];

if (!$entry_id) {
    header("Location: timetable.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ? AND User_ID = ?");
$stmt->execute([$entry_id, $_SESSION['ID']]);
$entry = $stmt->fetch();

if (!$entry) {
    header("Location: timetable.php");
    exit();
}

// Check if there's a time conflict
$is_conflict = ($entry['Time_Start'] != $reserve_data['time_start'] || $entry['Time_End'] != $reserve_data['time_end']);

if (!$is_conflict) {
    // If there's no conflict, redirect to the next page
    header("Location: reserve-type-select.php?id=" . $entry_id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choice = $_POST['choice'];
    if ($choice === 'new') {
        // User chose to use the new time
        // No need to change $reserve_data as it already contains the new time
    } else {
        // User chose to keep the original time
        $reserve_data['time_start'] = $entry['Time_Start'];
        $reserve_data['time_end'] = $entry['Time_End'];
    }
    $_SESSION['reserve_data'] = $reserve_data;
    header("Location: reserve-type-select.php?id=" . $entry_id);
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
        <link rel="stylesheet" href="../assets/css/entry.css">

        <title>Time Conflict - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row">
                <div class="col-9">
                    <div class="heading1 ms-5"><p>Time Conflict</p></div>
                    <div class="subheading1 ms-5"><p>There is a time conflict between the selected event and the time you provided. Please choose which time you want to use.</p></div>
                </div>
            </div>
            <div class="row-auto d-flex flex-column">
                <div class="container mt-5" style="width: 90%; align-content: center;">
                    <form method="POST">
                        <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                            <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Event Name</p>
                            <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($entry['EName']); ?></p>
                        </div>
                        <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                            <div class="d-flex flex-column justify-content-center align-items-center" style="width: 100%;">
                                <p>Original Time:</p>
                                <div class="d-flex justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo date('H:i', strtotime($entry['Time_Start'])); ?>
                                        </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo date('H:i', strtotime($entry['Time_End'])); ?>
                                        </span>
                                    </div>
                                </div>
                                <p class="mt-3">New Time:</p>
                                <div class="d-flex justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo date('H:i', strtotime($reserve_data['time_start'])); ?>
                                        </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo date('H:i', strtotime($reserve_data['time_end'])); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end align-items-center mt-5">
                        <button type="submit" name="choice" value="original" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between me-3">
                                <p class="dongle-regular mt-2" style="font-size: 2rem;">Keep Original Time</p>
                            </button>
                            <button type="submit" name="choice" value="new" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                <p class="dongle-regular mt-2" style="font-size: 2rem;">Use New Time</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>