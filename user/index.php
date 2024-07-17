<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM USER WHERE ID = ?");
$stmt->execute([$_SESSION['ID']]);
$user = $stmt->fetch();

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

        <title>Home - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <?php include('../assets/navbar-user.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <div>
                        <div class="heading1"><p>Welcome, <?php echo htmlspecialchars($user['FName']); ?>!</p></div>
                        <div class="subheading1"><p>What would you like to do today?</p></div>
                    </div>
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <button onclick="location.href='map.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">View Map</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-pin-map-fill primary"></i>
                        </span>
                    </button>
                    <button onclick="location.href='reserve-type-select.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reserve</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-bookmarks-fill primary"></i>
                        </span>
                    </button>
                     <button onclick="location.href='timetable.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Timetable</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-calendar3 primary"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>