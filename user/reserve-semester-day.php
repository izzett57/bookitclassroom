<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reservation'])) {
    header("Location: ../guest/login.php");
    exit();
}

$reservation = $_SESSION['reservation'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_day = $_POST['day'] ?? null;
    if ($selected_day) {
        $_SESSION['reservation']['semester_day'] = $selected_day;
        header("Location: reserve-semester-confirm.php");
        exit();
    }
}

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
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

        <title>Select Day for Semester Reservation - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1 ms-5"><p>Select Day for Semester Reservation</p></div>
                        <div class="subheading1 ms-5"><p>Choose the day of the week for your semester-long reservation:</p></div>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <form method="POST">
                        <?php foreach ($days as $day): ?>
                            <button type="submit" name="day" value="<?php echo $day; ?>" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                                <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;"><?php echo $day; ?></p>
                                <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                    <i class="bi bi-calendar-day primary"></i>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>