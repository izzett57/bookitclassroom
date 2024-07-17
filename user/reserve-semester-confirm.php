<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['semester_reservation'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_SESSION['semester_reservation']['entry_id'] ?? null;
$day = $_SESSION['semester_reservation']['day'] ?? null;

if (!$entry_id || !$day) {
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

// Fetch available classrooms
$stmt = $pdo->prepare("SELECT * FROM CLASSROOM");
$stmt->execute();
$classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_classroom = $_POST['classroom'] ?? null;
    if ($selected_classroom) {
        $_SESSION['semester_reservation']['classroom'] = $selected_classroom;
        header("Location: reserve-semester-complete.php");
        exit();
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
        <link rel="stylesheet" href="../assets/css/entry.css"/>

        <title>Reserve - Semester - Confirm - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Semester Reservation</p></div>
                        <div class="subheading1 ms-5"><p>Please select a classroom for your semester-long reservation:</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container mt-5" style="width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Event Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($entry['EName']); ?></p>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Day</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($day); ?></p>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($entry['Time_Start'])); ?>
                                    </span>
                                    </div>
                                    <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                    <div class="col-5 form-group text-center" style="width: 15%; height: 60px;" style="width: 100%">
                                    <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                        <?php echo date('H:i', strtotime($entry['Time_End'])); ?>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Select Classroom</p>
                                <select name="classroom" class="form-select" required>
                                    <option value="">Choose a classroom</option>
                                    <?php foreach ($classrooms as $classroom): ?>
                                        <option value="<?php echo htmlspecialchars($classroom['CName']); ?>">
                                            <?php echo htmlspecialchars($classroom['CName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a href="reserve-semester-day.php?id=<?php echo $entry_id; ?>" class="dongle-regular custom-btn-inline px-3 ms-4 me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
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