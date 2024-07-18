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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_classroom = $_POST['selected_classroom'];
    $selected_date = $_POST['selected_date'];

    $_SESSION['reserve_data'] = [
        'entry_id' => $entry_id,
        'classroom' => $selected_classroom,
        'date' => $selected_date,
        'time_start' => $entry['Time_Start'],
        'time_end' => $entry['Time_End']
    ];
    
    header("Location: timetable-reserve.php");
    exit();
}

// Fetch all classrooms
$stmt = $pdo->query("SELECT CName, Floor FROM CLASSROOM ORDER BY Floor, CName");
$classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group classrooms by floor
$classroomsByFloor = [];
foreach ($classrooms as $classroom) {
    $classroomsByFloor[$classroom['Floor']][] = $classroom['CName'];
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
        <link rel="stylesheet" href="../assets/css/entry.css"/>
        <link rel="stylesheet" href="../assets/css/calendar.css"/>
        <link rel="stylesheet" href="../assets/css/svg-container.css"/>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/time-select.js"></script>

        <title>Timetable - Map - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <form class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3" method="POST">
            <div class="container">
                <div class="row">
                    <div class="heading1"><p>Map</p></div>
                    <div class="subheading1">
                        <span>Reserving class/event:</span>
                        <span style="font-weight: 600;"><?php echo htmlspecialchars($entry['EName']); ?></span>
                    </div>
                    <div class="container" style="height: 70vh;">
                        <div class="row" style="height: 100%;">
                            <div class="col-8">
                                <div class="svg-container">
                                    <object id="svg-object" type="image/svg+xml" data="../assets/svg/map/classroom.svg" onload="initPanZoom(this.contentDocument);"></object>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@latest/dist/svg-pan-zoom.min.js"></script>
                                <script>
                                    function injectCSS(svgDocument) {
                                        const style = document.createElementNS("http://www.w3.org/2000/svg", "style");
                                        style.textContent = `
                                            [id^="1"] rect, [id^="2"] rect, [id^="3"] rect { 
                                                stroke: rgba(69, 218, 34, 1.0);
                                                fill: rgba(69, 218, 34, 0.3);
                                            }
                                            [id^="1"] tspan, [id^="2"] tspan, [id^="3"] tspan {
                                                user-select: none;
                                                fill: rgba(49, 136, 28, 1.0);
                                            }
                                            [id^="1"]:hover rect, [id^="2"]:hover rect, [id^="3"]:hover rect {
                                                stroke: rgba(69, 218, 34, 0.7);
                                                fill: rgba(69, 218, 34, 0.2);
                                                tspan {
                                                    fill: rgba(49, 136, 28, 0.8);
                                                }
                                                cursor: pointer;
                                            }
                                        `;
                                        svgDocument.querySelector('svg').appendChild(style);
                                    }

                                    function initPanZoom(svgDocument) {
                                        injectCSS(svgDocument);
                                        svgPanZoom(svgDocument.querySelector('svg'), {
                                            zoomEnabled: true,
                                            controlIconsEnabled: true,
                                            fit: true,
                                            center: true,
                                            minZoom: 0.7,
                                            maxZoom: 2,
                                            panEnabled: true,
                                            contain: true
                                        });
                                    }
                                </script>
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
                                    <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo date('H:i', strtotime($entry['Time_Start'])); ?>
                                        </span>
                                        </div>
                                        <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;" style="width: 100%">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <?php echo date('H:i', strtotime($entry['Time_End'])); ?>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-column justify-content-center align-items-center pt-4">
                                    <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Selected class</p>
                                    <p id="selectedClassroom" class="subheading1" style="margin: 0px 0px 0px -2px;">Class Name</p>
                                </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reserve</p>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="selectedClassroomInput" name="selected_classroom" value="">
            <input type="hidden" id="selectedDateInput" name="selected_date" value="">
        </form>

        <?php include('../assets/footer.php'); ?>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const svgObject = document.getElementById('svg-object');
            const selectedClassroomElement = document.getElementById('selectedClassroom');
            const selectedClassroomInput = document.getElementById('selectedClassroomInput');
            const selectedDateInput = document.getElementById('selectedDateInput');

            svgObject.addEventListener('load', function() {
                const svgDoc = svgObject.contentDocument;
                const svgElement = svgDoc.querySelector('svg');

                svgElement.addEventListener('click', function(event) {
                    const clickedElement = event.target.closest('g[id]');
                    if (clickedElement && clickedElement.nodeName === 'g') {
                        const classroomName = clickedElement.id;
                        selectedClassroomElement.textContent = classroomName;
                        selectedClassroomInput.value = classroomName;
                    }
                });
            });

            // Update the selected date when a date is clicked in the calendar
            dates.addEventListener("click", (e) => {
                e.preventDefault();
                if (e.target.tagName === "LI" && !e.target.classList.contains("inactive")) {
                    selectedDate = new Date(year, month, parseInt(e.target.textContent));
                    const formattedDate = selectedDate.toISOString().split("T")[0];
                    selectedDateInput.value = formattedDate;
                    console.log(`Selected date: ${formattedDate}`);
                    renderCalendar();
                }
            });

            // Set initial date to today
            const today = new Date();
            selectedDateInput.value = today.toISOString().split("T")[0];
        });
        </script>
    </body>
</html>