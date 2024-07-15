<?php
require_once '../assets/db_conn.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

// Fetch user's entries from the database
try {
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT e.*, b.Classroom AS Reserved_Classroom 
                           FROM ENTRY e 
                           LEFT JOIN BOOKING b ON e.ID = b.Entry_ID 
                           WHERE e.User_ID = ? 
                           ORDER BY e.Day, e.Time_Start");
    $stmt->execute([$_SESSION['ID']]);
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching entries: " . $e->getMessage());
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
        
        <!-- Import Bootstrap start -->
        <?php include('../assets/import-bootstrap.php'); ?>
        <!-- Import Bootstrap end -->

        <!-- Import CSS file(s) start -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <!-- Import CSS file(s) end --> 

        <title>Timetable - BookItClassroom</title>
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
                    <!-- Text start -->
                    <div class="col-8">
                        <!-- Heading -->
                        <div class="heading1 ms-5"><p>Timetable</p></div>
                        <div class="subheading1 ms-5"><p>Here is a list of your classes/event.</p></div>
                    </div>
                    <!-- Text end -->
                    <div class="col d-flex justify-content-center">
                        <div class="pt-3">
                        <!-- New entry button start -->
                        <button onclick="location.href='new-entry-name.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                            <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">New Entry</p>
                            <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-plus-circle-fill primary"></i>
                            </span>
                        </button>
                        <!-- New entry button end -->
                        </div>
                    </div>
                </div>
                <!-- Table data start -->
                <div class="row">
                <table class="table table-striped table-hover text-center inter-regular">
                    <thead>
                        <tr>
                        <th scope="col" style="width: 3%;">#</th>
                        <th scope="col" style="width: 45%;">Event</th>
                        <th scope="col" style="width: 10%;">Day</th>
                        <th scope="col" style="width: 14%;">Time</th>
                        <th scope="col" style="width: 14%;">Classroom</th>
                        <th scope="col" style="width: 14%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($entries)): ?>
                            <tr>
                                <td colspan="6">No entries found. Click "New Entry" to add one.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($entries as $index => $entry): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($entry['EName']); ?></td>
                                <td><?php echo htmlspecialchars($entry['Day']); ?></td>
                                <td><?php echo formatTime($entry['Time_Start']) . ' - ' . formatTime($entry['Time_End']); ?></td>
                                <td><?php echo htmlspecialchars($entry['Reserved_Classroom'] ?? $entry['Assigned_Class'] ?? '-'); ?></td>
                                <!-- Action start -->
                                <td class="d-flex justify-content-evenly">
                                <?php if ($entry['Reserved_Classroom'] || $entry['Assigned_Class']): ?>
                                    <a class="custom-btn-inline" href="unreserve.php?id=<?php echo $entry['ID']; ?>" style="text-decoration: none;">
                                        Unreserve
                                        <i class="bi bi-bookmark-dash-fill"></i>    
                                    </a>
                                <?php else: ?>
                                    <a class="custom-btn-inline" href="edit-entry-name.php?id=<?php echo $entry['ID']; ?>" style="text-decoration: none;">
                                        Edit
                                        <i class="bi bi-pencil-fill"></i>    
                                    </a>
                                    <a class="custom-btn-inline" href="reserve.php?id=<?php echo $entry['ID']; ?>" style="text-decoration: none;">
                                        Reserve
                                        <i class="bi bi-bookmark-plus-fill"></i>
                                    </a>
                                <?php endif; ?>
                                </td>
                                <!-- Action end -->
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div>
                <!-- Table data end -->
            </div>
        </div>
        <!-- Main content end -->
        <!-- Footer -->
        <?php include('../assets/footer.php'); ?>
        <!-- Footer end -->
    </body>
</html>