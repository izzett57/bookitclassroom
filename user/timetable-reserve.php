<?php
require_once '../assets/db_conn.php';
require_once '../assets/isLoggedIn.php';

if (!isset($_SESSION['ID']) || !isset($_SESSION['reserve_data'])) {
    header("Location: ../guest/login.php");
    exit();
}

$reserve_data = $_SESSION['reserve_data'];

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT e.*, b.Classroom AS Reserved_Classroom 
                       FROM ENTRY e 
                       LEFT JOIN BOOKING b ON e.ID = b.Entry_ID 
                       WHERE e.User_ID = ? 
                       ORDER BY e.Time_Start");
$stmt->execute([$_SESSION['ID']]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatTime($time) {
    return date('H:i', strtotime($time));
}

function checkTimeConflict($entry, $selected_date, $selected_time_start, $selected_time_end) {
    return (
        $entry['Time_Start'] < $selected_time_end &&
        $entry['Time_End'] > $selected_time_start
    );
}

// Get current semester
$currentDate = date('Y-m-d');
$stmt = $pdo->prepare("SELECT ID FROM SEMESTER WHERE Start_Date <= ? AND End_Date >= ? LIMIT 1");
$stmt->execute([$currentDate, $currentDate]);
$currentSemester = $stmt->fetchColumn();

if (!$currentSemester) {
    die("No active semester found.");
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
                        <th scope="col" style="width: 45%;">Event</th>
                        <th scope="col" style="width: 14%;">Time</th>
                        <th scope="col" style="width: 10%;">Classroom</th>
                        <th scope="col" style="width: 14%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($entries)): ?>
                            <tr>
                                <td colspan="5">No entries found. Click "New Entry" to add one.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($entries as $index => $entry): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($entry['EName']); ?></td>
                                <td><?php echo formatTime($entry['Time_Start']) . ' - ' . formatTime($entry['Time_End']); ?></td>
                                <td><?php echo htmlspecialchars($entry['Assigned_Class'] ?? '-'); ?></td>
                                <td class="d-flex justify-content-evenly">
                                <?php if ($entry['Assigned_Class']): ?>
                                    <a class="custom-btn-inline" href="unreserve.php?id=<?php echo $entry['ID']; ?>" style="text-decoration: none;">
                                        Unreserve
                                        <i class="bi bi-bookmark-dash-fill"></i>    
                                    </a>
                                <?php else: ?>
                                    <?php
                                    $time_conflict = checkTimeConflict($entry, $reserve_data['date'], $reserve_data['time_start'], $reserve_data['time_end']);
                                    $reserve_url = $time_conflict ? "reserve-time-conflict.php" : "reserve-type-select.php";
                                    $params = http_build_query([
                                        'id' => $entry['ID'],
                                        'classroom' => $reserve_data['classroom'],
                                        'date' => $reserve_data['date'],
                                        'time_start' => $reserve_data['time_start'],
                                        'time_end' => $reserve_data['time_end'],
                                        'semester_id' => $currentSemester
                                    ]);
                                    ?>
                                    <a class="custom-btn-inline" href="<?php echo $reserve_url . '?' . $params; ?>" style="text-decoration: none;">
                                        Reserve
                                        <i class="bi bi-bookmark-plus-fill"></i>
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