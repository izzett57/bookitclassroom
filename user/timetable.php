<?php
require_once '../assets/db_conn.php';
require_once '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

try {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("
        SELECT e.*, b.ID as Booking_ID, b.Type as Booking_Type, b.Booking_Date, b.Classroom as Reserved_Classroom, s.ID as Semester_ID 
        FROM ENTRY e 
        LEFT JOIN BOOKING b ON e.ID = b.Entry_ID 
        LEFT JOIN SEMESTER s ON b.Semester_ID = s.ID
        WHERE e.User_ID = ? 
        ORDER BY CASE WHEN b.Booking_Date IS NULL THEN 1 ELSE 0 END, b.Booking_Date ASC, e.Time_Start ASC
    ");
    $stmt->execute([$_SESSION['ID']]);
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("Fetched entries: " . print_r($entries, true));
} catch (PDOException $e) {
    error_log("Error fetching entries: " . $e->getMessage());
    die("Error fetching entries: " . $e->getMessage());
}

function formatTime($time) {
    return date('H:i', strtotime($time));
}

function formatDate($date) {
    return date('Y-m-d', strtotime($date));
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

        <title>Timetable - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_SESSION['success']) . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="heading1 ms-5"><p>Timetable</p></div>
                        <div class="subheading1 ms-5"><p>Here is a list of your classes/events.</p></div>
                    </div>
                    <div class="col d-flex justify-content-center">
                        <div class="pt-3">
                        <button onclick="location.href='new-entry-name.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">New Entry</p>
                            <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-plus-circle-fill primary"></i>
                            </span>
                        </button>
                        </div>
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
                        <th scope="col" style="width: 10%;">Type</th>
                        <th scope="col" style="width: 19%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($entries)): ?>
                            <tr>
                                <td colspan="7">No entries found. Click "New Entry" to add one.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($entries as $index => $entry): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($entry['EName']); ?></td>
                                <td><?php echo $entry['Booking_Date'] ? formatDate($entry['Booking_Date']) : 'Not booked'; ?></td>
                                <td><?php echo formatTime($entry['Time_Start']) . ' - ' . formatTime($entry['Time_End']); ?></td>
                                <td><?php echo htmlspecialchars($entry['Reserved_Classroom'] ?? '-'); ?></td>
                                <td><?php echo $entry['Booking_Type'] ?? 'Not booked'; ?></td>
                                <td class="d-flex justify-content-evenly">
                                    <?php if ($entry['Booking_ID']): ?>
                                        <a href="unreserve.php?id=<?php echo $entry['Booking_ID']; ?>&type=<?php echo $entry['Booking_Type']; ?>" class="custom-btn-inline" style="text-decoration: none;" onclick="return confirm('Are you sure you want to unreserve this classroom?');">
                                            Unreserve
                                            <i class="bi bi-calendar-x"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="edit-entry-name.php?id=<?php echo $entry['ID']; ?>" class="custom-btn-inline" style="text-decoration: none;">
                                            Edit
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="delete-entry.php?id=<?php echo $entry['ID']; ?>" class="custom-btn-inline" style="text-decoration: none;" onclick="return confirm('Are you sure you want to delete this entry?');">
                                            Delete
                                            <i class="bi bi-trash-fill"></i>
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