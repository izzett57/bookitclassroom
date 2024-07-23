<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE User_ID = ? ORDER BY Time_Start");
$stmt->execute([$_SESSION['ID']]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatTime($time) {
    return date('H:i', strtotime($time));
}

function formatDate($date) {
    return date('Y-m-d', strtotime($date));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_entry_id = filter_input(INPUT_POST, 'entry_id', FILTER_SANITIZE_NUMBER_INT);
    if ($selected_entry_id) {
        $_SESSION['reserve_data']['entry_id'] = $selected_entry_id;
        header("Location: reserve-time-conflict.php");
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

        <title>Select Entry - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Select Entry to Reserve</p></div>
                        <div class="subheading1 ms-5"><p>Choose an entry from your timetable to complete the reservation.</p></div>
                    </div>
                </div>
                <div class="row">
                    <form method="POST">
                        <table class="table table-striped table-hover text-center inter-regular">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 3%;">#</th>
                                    <th scope="col" style="width: 25%;">Event</th>
                                    <th scope="col" style="width: 15%;">Date</th>
                                    <th scope="col" style="width: 14%;">Time</th>
                                    <th scope="col" style="width: 14%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($entries)): ?>
                                    <tr>
                                        <td colspan="5">No entries found. Add an entry to your timetable first.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($entries as $index => $entry): ?>
                                    <tr>
                                        <th scope="row"><?php echo $index + 1; ?></th>
                                        <td><?php echo htmlspecialchars($entry['EName']); ?></td>
                                        <td><?php echo formatDate($entry['Time_Start']); ?></td>
                                        <td><?php echo formatTime($entry['Time_Start']) . ' - ' . formatTime($entry['Time_End']); ?></td>
                                        <td>
                                            <button type="submit" name="entry_id" value="<?php echo $entry['ID']; ?>" class="btn btn-primary btn-sm">
                                                Select
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>