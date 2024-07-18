<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
$semester_id = $_GET['semester_id'] ?? null;
$reserve_data = $_SESSION['reserve_data'];

if (!$entry_id || !$semester_id) {
    header("Location: timetable.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day = $_POST['day'];
    if (!empty($day)) {
        $reserve_data['day'] = $day;
        $reserve_data['type'] = 'SEMESTER';
        $reserve_data['semester_id'] = $semester_id;
        $_SESSION['reserve_data'] = $reserve_data;
        header("Location: reserve-semester-confirm.php?id=" . $entry_id . "&semester_id=" . $semester_id);
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

        <title>Reserve - Semester - Day - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Semester Reservation</p></div>
                        <div class="subheading1 ms-5"><p>Which day of the week is the class/event?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex justify-content-center align-items-center">
                                <?php
                                $days = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'];
                                foreach ($days as $day): ?>
                                    <input type="radio" id="day<?php echo $day; ?>" name="day" value="<?php echo $day; ?>" class="dayInput" required>
                                    <label for="day<?php echo $day; ?>" class="dayContainer">
                                        <span class="heading1"><?php echo substr($day, 0, 1); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem;">back</a>
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