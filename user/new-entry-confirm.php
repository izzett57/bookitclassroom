<?php
require_once '../assets/db_conn.php';
session_start();

if (!isset($_SESSION['ID']) || !isset($_SESSION['new_entry'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry = $_SESSION['new_entry'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("INSERT INTO ENTRY (User_ID, EName, Day, Time_Start, Time_End) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['ID'], $entry['name'], $entry['day'], $entry['start_time'], $entry['end_time']]);
    
    $_SESSION['last_entry_id'] = $pdo->lastInsertId();
    header("Location: new-entry-complete.php");
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

        <title>New Entry - Confirmation - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-user-back.php');
        ?>
        <!-- Nav bar end -->
        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>New Entry</p></div>
                        <div class="subheading1 ms-5"><p>Are the information for the class/event correct?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 90%; align-content: center;">
                        <form method="POST">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="dayBox">
                                    <span class="dayBoxText heading1"><?php echo $entry['day']; ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center text-center mt-5">
                                <span class="d-flex justify-content-center align-items-center timeBox text-time me-5">
                                    <?php echo date('H:i', strtotime($entry['start_time'])); ?>
                                </span>
                                <span class="text-time d-flex justify-content-center align-items-center ">
                                    -
                                </span>
                                <span class="d-flex justify-content-center align-items-center timeBox text-time ms-5">
                                    <?php echo date('H:i', strtotime($entry['end_time'])); ?>
                                </span>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center pt-4">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Event Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($entry['name']); ?></p>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center pt-2">
                                <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content end -->
        <?php include('../assets/footer.php'); ?>
    </body>
</html> 