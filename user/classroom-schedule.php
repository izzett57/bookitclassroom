<?php
require_once '../assets/db_conn.php';
require_once '../assets/isLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$classroom = $_GET['classroom'] ?? null;
$date = $_GET['date'] ?? date('Y-m-d'); // Use current date if not provided

if (!$classroom) {
    header("Location: map.php");
    exit();
}

// Fetch bookings for the classroom from the given date onwards
try {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT b.ID as BookingID, b.Booking_Date, e.ID as EntryID, e.EName, e.Time_Start, e.Time_End, e.User_ID 
                           FROM BOOKING b 
                           JOIN ENTRY e ON b.Entry_ID = e.ID 
                           WHERE b.Classroom = ? AND b.Booking_Date >= ?
                           ORDER BY b.Booking_Date, e.Time_Start");
    $stmt->execute([$classroom, $date]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching bookings: " . $e->getMessage());
}

// Function to format time
function formatTime($time) {
    return date('H:i', strtotime($time));
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

        <title><?php echo htmlspecialchars($classroom); ?> - Schedule - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="heading1 ms-5"><p>Classroom Schedule</p></div>
                        <div class="subheading1 ms-5"><p>Here is a list of bookings for <?php echo htmlspecialchars($classroom); ?> from <?php echo date('Y-m-d', strtotime($date)); ?> onwards.</p></div>
                    </div>
                </div>
                <div class="row">
                <table class="table table-striped table-hover text-center inter-regular">
                    <thead>
                        <tr>
                        <th scope="col" style="width: 3%;">#</th>
                        <th scope="col" style="width: 30%;">Event</th>
                        <th scope="col" style="width: 15%;">Date</th>
                        <th scope="col" style="width: 15%;">Time</th>
                        <th scope="col" style="width: 22%;">Booked By</th>
                        <th scope="col" style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="6">No bookings found for this classroom from <?php echo date('Y-m-d', strtotime($date)); ?> onwards.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $index => $booking): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($booking['EName']); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($booking['Booking_Date'])); ?></td>
                                <td><?php echo formatTime($booking['Time_Start']) . ' - ' . formatTime($booking['Time_End']); ?></td>
                                <td><?php echo ($booking['User_ID'] == $_SESSION['ID']) ? 'You' : 'Another user'; ?></td>
                                <td>
                                <?php if ($booking['User_ID'] == $_SESSION['ID']): ?>
                                    <a class="custom-btn-inline" href="unreserve.php?id=<?php echo $booking['BookingID']; ?>" style="text-decoration: none;">
                                        Unreserve
                                        <i class="bi bi-bookmark-dash-fill"></i>    
                                    </a>
                                <?php else: ?>
                                    -
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