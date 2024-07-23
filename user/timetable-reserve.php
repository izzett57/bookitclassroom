<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$pdo = dbConnect();

// Fetch entries with their most recent booking date
$stmt = $pdo->prepare("
    SELECT e.*, 
           b.ID as Booking_ID,
           b.Booking_Date,
           b.Classroom AS Reserved_Classroom
    FROM ENTRY e
    LEFT JOIN (
        SELECT Entry_ID, ID, Booking_Date, Classroom,
               ROW_NUMBER() OVER (PARTITION BY Entry_ID ORDER BY Booking_Date DESC) as rn
        FROM BOOKING
    ) b ON e.ID = b.Entry_ID AND b.rn = 1
    WHERE e.User_ID = ?
    ORDER BY COALESCE(b.Booking_Date, e.Time_Start) ASC, e.Time_Start ASC
");
$stmt->execute([$_SESSION['ID']]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatTime($time) {
    return date('H:i', strtotime($time));
}

function formatDate($date) {
    return $date ? date('Y-m-d', strtotime($date)) : 'Not booked';
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

        <title>Reserve from Timetable - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <div class="heading1 ms-5"><p>Select Entry to Reserve</p></div>
                        <div class="subheading1 ms-5"><p>Choose an entry from your timetable to make a reservation or unreserve.</p></div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-striped table-hover text-center inter-regular">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 3%;">#</th>
                                <th scope="col" style="width: 25%;">Event</th>
                                <th scope="col" style="width: 15%;">Date</th>
                                <th scope="col" style="width: 14%;">Time</th>
                                <th scope="col" style="width: 14%;">Classroom</th>
                                <th scope="col" style="width: 14%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($entries)): ?>
                                <tr>
                                    <td colspan="6">No entries found. Add an entry to your timetable first.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($entries as $index => $entry): ?>
                                <tr>
                                    <th scope="row"><?php echo $index + 1; ?></th>
                                    <td><?php echo htmlspecialchars($entry['EName']); ?></td>
                                    <td><?php echo formatDate($entry['Booking_Date']); ?></td>
                                    <td><?php echo formatTime($entry['Time_Start']) . ' - ' . formatTime($entry['Time_End']); ?></td>
                                    <td><?php echo $entry['Reserved_Classroom'] ?? 'Not assigned'; ?></td>
                                    <td>
                                        <?php if ($entry['Booking_ID']): ?>
                                            <a href="unreserve.php?id=<?php echo $entry['Booking_ID']; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to unreserve this classroom?');">
                                                Unreserve
                                                <i class="bi bi-calendar-x"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="select-floor.php?entry_id=<?php echo $entry['ID']; ?>" class="btn btn-primary btn-sm">
                                                Reserve
                                                <i class="bi bi-calendar-plus"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>
    </body>
</html>