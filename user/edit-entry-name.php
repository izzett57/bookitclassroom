<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$entry_id = $_GET['id'] ?? null;
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['event']);
    if (!empty($new_name)) {
        $update_stmt = $pdo->prepare("UPDATE ENTRY SET EName = ? WHERE ID = ?");
        $update_stmt->execute([$new_name, $entry_id]);
        header("Location: edit-entry-time.php?id=" . $entry_id);
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

        <title>Edit Entry - Name - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Edit Entry</p></div>
                        <div class="subheading1 ms-5"><p>What is the class/event called?</p></div>
                    </div>
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 35%; align-content: center;">
                        <form class="row" method="POST">
                            <div class="col">
                                <label class="form-label inter-regular" for="event" style="letter-spacing: 4px; color: #272937;">Subject/Event Name</label><br>
                                <input class="form-control" id="event" name="event" type="text" placeholder="subject/event name" value="<?php echo htmlspecialchars($entry['EName']); ?>" required><br>
                            </div>
                            <div class="row pt-4">
                                <div class="col d-flex justify-content-end align-items-center">
                                    <a href="timetable.php" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem;">back</a>
                                    <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>