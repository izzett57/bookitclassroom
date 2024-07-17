<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

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

$stmt = $pdo->prepare("SELECT * FROM CLASSROOM");
$stmt->execute();
$classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$date = date('Y-m-d', strtotime($entry['Time_Start']));
$time_start = date('H:i:s', strtotime($entry['Time_Start']));
$time_end = date('H:i:s', strtotime($entry['Time_End']));

// Fetch bookings for the selected date and time
$stmt = $pdo->prepare("SELECT * FROM BOOKING WHERE Booking_Date = ? AND 
                      ((Time_Start <= ? AND Time_End > ?) OR 
                       (Time_Start < ? AND Time_End >= ?) OR
                       (Time_Start >= ? AND Time_End <= ?))");
$stmt->execute([$date, $time_start, $time_start, $time_end, $time_end, $time_start, $time_end]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$booked_classrooms = array_column($bookings, 'Classroom');
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
        <link rel="stylesheet" href="../assets/css/entry.css"/>
        <link rel="stylesheet" href="../assets/css/calendar.css"/>
        <link rel="stylesheet" href="../assets/css/svg-container.css"/>

        <title>Reserve - Map - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/time-select.js"></script>
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3">
            <div class="container">
                <div class="row">
                    <div class="heading1" style=""><p>Map</p></div>
                    <div class="subheading1" style="">
                        <span>Reserving class/event:</span>
                        <span style="font-weight: 600;"><?php echo htmlspecialchars($entry['EName']); ?></span>
                    </div>
                    <div class="container" style="height: 70vh;">
                        <div class="row" style="height: 100%;">
                            <div class="col-8" style="">
                            <div class="svg-container">
                                <object id="svg-object" type="image/svg+xml" data="../assets/svg/map/classroom.svg"></object>
                            </div>
                            </div>
                            <div class="col">
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                    <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo $time_start; ?>
                                        </span>
                                        </div>
                                        <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo $time_end; ?>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-column justify-content-center align-items-center pt-4">
                                    <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Selected class</p>
                                    <p id="selectedClassroom" class="subheading1" style="margin: 0px 0px 0px -2px;">No classroom selected</p>
                                </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <form id="reserveForm" method="POST" action="reserve-single-confirm.php">
                                    <input type="hidden" name="entry_id" value="<?php echo $entry_id; ?>">
                                    <input type="hidden" id="selectedClassroomInput" name="selected_classroom" value="">
                                    <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between" disabled>
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reserve</p>
                                    </button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('../assets/footer.php'); ?>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classrooms = <?php echo json_encode($classrooms); ?>;
            const bookedClassrooms = <?php echo json_encode($booked_classrooms); ?>;
            const svgObject = document.getElementById('svg-object');
            const selectedClassroomElement = document.getElementById('selectedClassroom');
            const selectedClassroomInput = document.getElementById('selectedClassroomInput');
            const reserveButton = document.querySelector('#reserveForm button');

            svgObject.addEventListener('load', function() {
                const svgDoc = svgObject.contentDocument;
                classrooms.forEach(classroom => {
                    const classroomElement = svgDoc.getElementById(classroom.CName);
                    if (classroomElement) {
                        if (bookedClassrooms.includes(classroom.CName)) {
                            classroomElement.style.fill = 'red';
                            classroomElement.style.cursor = 'not-allowed';
                        } else {
                            classroomElement.style.fill = 'green';
                            classroomElement.style.cursor = 'pointer';
                            classroomElement.addEventListener('click', function() {
                                selectedClassroomElement.textContent = classroom.CName;
                                selectedClassroomInput.value = classroom.CName;
                                reserveButton.disabled = false;
                            });
                        }
                    }
                });
            });
        });
        </script>
    </body>
</html>