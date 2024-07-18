<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$pdo = dbConnect();
$stmt = $pdo->prepare("SELECT * FROM CLASSROOM");
$stmt->execute();
$classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$date = $_GET['date'] ?? date('Y-m-d');
$time_start = $_GET['time_start'] ?? '08:00:00';
$time_end = $_GET['time_end'] ?? '09:00:00';

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

        <title>Map - BookItClassroom</title>
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
                    <div class="container" style="height: 70vh;">
                        <div class="row" style="height: 100%;">
                            <div class="col-8" style="">
                            <div class="svg-container">
                                <object id="svg-object" type="image/svg+xml" data="../assets/svg/map/classroom.svg"></object>
                            </div>
                            </div>
                            <div class="col">
                                <div class="col calendar inter-light" style="margin: auto;">
                                    <div class="">
                                    <header>
                                        <h3></h3>
                                        <nav>
                                        <button id="calendar-prev"></button>
                                        <button id="calendar-next"></button>
                                        </nav>
                                    </header>
                                    <section>
                                        <ul class="calendar-days">
                                        <li>Sun</li>
                                        <li>Mon</li>
                                        <li>Tue</li>
                                        <li>Wed</li>
                                        <li>Thu</li>
                                        <li>Fri</li>
                                        <li>Sat</li>
                                        </ul>
                                        <ul class="calendar-dates" style="font-weight: 500;"></ul>
                                    </section>
                                    </div>
                                    <script src="../assets/js/calendar.js" defer></script>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                    <form id="timeForm" method="GET">
                                        <input type="hidden" name="date" id="selectedDate" value="<?php echo $date; ?>">
                                        <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                            <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                                <select class="form-control text-center text-time custom-select" style="height: 100%; user-select: none;" id="starttime" name="time_start" required>
                                                    <?php echo get_times($time_start); ?>
                                                </select>
                                            </div>
                                            <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                            <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                                <select class="form-control text-center text-time custom-select" style="height: 100%; user-select: none;" id="endtime" name="time_end" required>
                                                    <?php echo get_times($time_end); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-column justify-content-center align-items-center pt-4">
                                    <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Selected class</p>
                                    <p id="selectedClassroom" class="subheading1" style="margin: 0px 0px 0px -2px;">No classroom selected</p>
                                </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <button id="viewClassBtn" type="button" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between" disabled>
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">View Class</p>
                                </button>
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
            const viewClassBtn = document.getElementById('viewClassBtn');

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
                                viewClassBtn.disabled = false;
                            });
                        }
                    }
                });
            });

            viewClassBtn.addEventListener('click', function() {
                const selectedClassroom = selectedClassroomElement.textContent;
                if (selectedClassroom !== 'No classroom selected') {
                    window.location.href = `classroom-schedule.php?classroom=${selectedClassroom}`;
                }
            });

            // Time selection logic
            const startTimeSelect = document.getElementById('starttime');
            const endTimeSelect = document.getElementById('endtime');
            const timeForm = document.getElementById('timeForm');

            function updateEndTimeOptions() {
                const startTime = startTimeSelect.value;
                for (let option of endTimeSelect.options) {
                    option.disabled = option.value <= startTime;
                }
                if (endTimeSelect.value <= startTime) {
                    endTimeSelect.value = endTimeSelect.querySelector('option:not(:disabled)').value;
                }
            }

            startTimeSelect.addEventListener('change', updateEndTimeOptions);
            updateEndTimeOptions();

            [startTimeSelect, endTimeSelect].forEach(select => {
                select.addEventListener('change', () => timeForm.submit());
            });

            // Calendar logic
            const calendar = document.querySelector('.calendar');
            const selectedDateInput = document.getElementById('selectedDate');

            calendar.addEventListener('click', function(e) {
                if (e.target.classList.contains('calendar-date')) {
                    selectedDateInput.value = e.target.dataset.date;
                    timeForm.submit();
                }
            });
        });
        </script>
    </body>
</html>