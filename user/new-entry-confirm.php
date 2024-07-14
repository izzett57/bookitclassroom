<?php
require_once '../assets/db_conn.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry = $_SESSION['new_entry'];
    $user_id = $_SESSION['ID'];

    try {
        require_once '../assets/db_conn.php';
        $pdo = dbConnect();
        
        // Prepare SQL statement
        $sql = "INSERT INTO ENTRY (User_ID, EName, Day, Time_Start, Time_End) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Execute the statement
        $stmt->execute([
            $user_id,
            $entry['name'],
            $entry['day'],
            $entry['start_time'],
            $entry['end_time']
        ]);

        $_SESSION['last_entry_id'] = $pdo->lastInsertId();

        // If successful, redirect to the completion page
        header("Location: new-entry-complete.php");
        exit();
    } catch (PDOException $e) {
        // If there's an error, you might want to handle it more gracefully in a production environment
        die("Error saving entry: " . $e->getMessage());
    }
}

$entry = $_SESSION['new_entry'];
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
        <nav class="navbar bg-transparent px-5 py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button onclick="history.back()" type="button" class="btn btn-light btn-circle me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-arrow-left-circle-fill primary" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/logo.png" class="img-fluid" width="316" height="51">
                    </a>
                </div>
                <li class="dropdown" style="list-style-type: none;">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <button type="button" class="btn btn-light btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-person-circle primary" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                            </svg>
                        </button>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2">
                        <li><a class="dropdown-item inter-regular" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item inter-regular" href="logout.php">Sign Out</a></li>
                    </ul>
                </li>
            </div>
        </nav>

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
                        <form method="POST" action="new-entry-confirm.php">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="dayBox">
                                    <span class="dayBoxText heading1"><?php echo $entry['day']; ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center text-center mt-5">
                                <span class="d-flex justify-content-center align-items-center timeBox text-time me-5">
                                    <?php echo $entry['start_time']; ?>
                                </span>
                                <span class="text-time d-flex justify-content-center align-items-center ">
                                    -
                                </span>
                                <span class="d-flex justify-content-center align-items-center timeBox text-time ms-5">
                                    <?php echo $entry['end_time']; ?>
                                </span>
                            </div>
                            <p class="text-center mt-3">Event: <?php echo $entry['name']; ?></p>
                            <div class="col d-flex justify-content-end align-items-center mt-5">
                                <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Confirm</p>
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