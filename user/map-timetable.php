<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$pdo = dbConnect();

// Check if entry_id is in the GET parameters or in the session
$entry_id = $_GET['id'] ?? $_SESSION['entry_id'] ?? null;

if ($entry_id) {
    $stmt = $pdo->prepare("SELECT * FROM ENTRY WHERE ID = ? AND User_ID = ?");
    $stmt->execute([$entry_id, $_SESSION['ID']]);
    $entry = $stmt->fetch();

    if ($entry) {
        $_SESSION['entry_id'] = $entry_id; // Store the entry_id in the session
    } else {
        $entry = null; // Set entry to null if not found
    }
} else {
    $entry = null; // Set entry to null if no entry_id is provided
}

// Get the selected floor from the session, or set it to 1 if not set
$selected_floor = $_SESSION['selected_floor'] ?? 1;

// Determine which SVG file to use based on the selected floor
$svg_file = "../assets/svg/map/floor-{$selected_floor}.svg";
if (!file_exists($svg_file)) {
    $svg_file = "../assets/svg/map/classroom.svg"; // Fallback to default if floor-specific SVG doesn't exist
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_classroom = $_POST['selected_classroom'];
    $selected_date = $_POST['selected_date'];

    $_SESSION['reserve_data'] = [
        'entry_id' => $entry_id,
        'classroom' => $selected_classroom,
        'date' => $selected_date,
        'time_start' => $entry ? $entry['Time_Start'] : null,
        'time_end' => $entry ? $entry['Time_End'] : null
    ];
    
    header("Location: reserve-time-conflict.php?id=" . $entry_id);
    exit();
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

        <style>
            .classroom { 
                cursor: pointer;
            }
            .classroom rect { 
                stroke: rgba(69, 218, 34, 1.0);
                fill: rgba(69, 218, 34, 0.3);
                transition: all 0.3s ease;
            }
            .classroom tspan {
                user-select: none;
                fill: rgba(49, 136, 28, 1.0);
                transition: all 0.3s ease;
                pointer-events: none;
            }
            .classroom:hover rect {
                stroke: rgba(69, 218, 34, 0.7);
                fill: rgba(69, 218, 34, 0.2);
            }
            .classroom:hover tspan {
                fill: rgba(49, 136, 28, 0.8);
            }
            .occupied {
                cursor: not-allowed;
            }
            .occupied rect {
                stroke: rgba(255, 0, 0, 1.0);
                fill: rgba(255, 0, 0, 0.3);
            }
            .occupied tspan {
                fill: rgba(139, 0, 0, 1.0);
            }
            .occupied:hover rect {
                stroke: rgba(255, 0, 0, 0.7);
                fill: rgba(255, 0, 0, 0.2);
            }
            .occupied:hover tspan {
                fill: rgba(139, 0, 0, 0.8);
            }
        </style>
    </head>
    
    <body>
        <?php include('../assets/navbar-user-back.php'); ?>

        <form class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3" method="POST">
            <div class="container">
                <div class="row">
                    <div class="heading1"><p>Map - Floor <?php echo $selected_floor; ?></p></div>
                    <?php if ($entry): ?>
                    <div class="subheading1">
                        <span>Reserving class/event:</span>
                        <span style="font-weight: 600;"><?php echo htmlspecialchars($entry['EName']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="container" style="height: 70vh;">
                        <div class="row" style="height: 100%;">
                            <div class="col-8">
                                <div class="svg-container">
                                    <object id="svg-object" type="image/svg+xml" data="<?php echo $svg_file; ?>" onload="initPanZoom(this.contentDocument);"></object>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@latest/dist/svg-pan-zoom.min.js"></script>
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
                                <?php if ($entry): ?>
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
                                <?php endif; ?>
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

        function injectCSS(svgDocument) {
            const style = document.createElementNS("http://www.w3.org/2000/svg", "style");
            style.textContent = `
                .classroom { 
                    cursor: pointer;
                }
                .classroom rect { 
                    stroke: rgba(69, 218, 34, 1.0);
                    fill: rgba(69, 218, 34, 0.3);
                    transition: all 0.3s ease;
                }
                .classroom tspan {
                    user-select: none;
                    fill: rgba(49, 136, 28, 1.0);
                    transition: all 0.3s ease;
                    pointer-events: none;
                }
                .classroom:hover rect {
                    stroke: rgba(69, 218, 34, 0.7);
                    fill: rgba(69, 218, 34, 0.2);
                }
                .classroom:hover tspan {
                    fill: rgba(49, 136, 28, 0.8);
                }
                .occupied {
                    cursor: not-allowed;
                }
                .occupied rect {
                    stroke: rgba(255, 0, 0, 1.0);
                    fill: rgba(255, 0, 0, 0.3);
                }
                .occupied tspan {
                    fill: rgba(139, 0, 0, 1.0);
                }
                .occupied:hover rect {
                    stroke: rgba(255, 0, 0, 0.7);
                    fill: rgba(255, 0, 0, 0.2);
                }
                .occupied:hover tspan {
                    fill: rgba(139, 0, 0, 0.8);
                }
            `;
            svgDocument.querySelector('svg').appendChild(style);

            // Add 'classroom' class to clickable elements
            svgDocument.querySelectorAll('g[id^="1"], g[id^="2"], g[id^="3"]').forEach(element => {
                element.classList.add('classroom');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const svgObject = document.getElementById('svg-object');
            const selectedClassroomElement = document.getElementById('selectedClassroom');
            const selectedClassroomInput = document.getElementById('selectedClassroomInput');
            const selectedDateInput = document.getElementById('selectedDateInput');

            svgObject.addEventListener('load', function() {
                const svgDoc = svgObject.contentDocument;
                const svgElement = svgDoc.querySelector('svg');

                svgElement.addEventListener('click', function(event) {
                    const clickedElement = event.target.closest('.classroom');
                    if (clickedElement && !clickedElement.classList.contains('occupied')) {
                        const classroomName = clickedElement.id;
                        selectedClassroomElement.textContent = classroomName;
                        selectedClassroomInput.value = classroomName;
                        checkAvailability();
                    }
                });
            });

            // Update the selected date when a date is clicked in the calendar
            dates.addEventListener("click", (e) => {
                e.preventDefault();
                if (e.target.tagName === "LI" && !e.target.classList.contains("inactive")) {
                    selectedDate = new Date(year, month, parseInt(e.target.textContent) + 1);
                    const formattedDate = selectedDate.toISOString().split("T")[0];
                    selectedDateInput.value = formattedDate;
                    console.log(`Selected date: ${formattedDate}`);
                    selectedDate = new Date(year, month, parseInt(e.target.textContent));
                    renderCalendar();
                    checkAvailability();
                }
            });

            // Set initial date to today
            const today = new Date();
            selectedDateInput.value = today.toISOString().split("T")[0];

            function checkAvailability() {
                const date = selectedDateInput.value;
                const timeStart = '<?php echo $entry ? $entry['Time_Start'] : '00:00:00'; ?>';
                const timeEnd = '<?php echo $entry ? $entry['Time_End'] : '23:59:59'; ?>';

                if (!date || !timeStart || !timeEnd) {
                    return;
                }

                fetch('check-availability.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `date=${date}&time_start=${timeStart}&time_end=${timeEnd}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received availability data:', data);
                    updateClassroomAvailability(data);
                })
                .catch(error => {
                    console.error('Error in checkAvailability:', error);
                    alert(`An error occurred while checking classroom availability: ${error.message}\nPlease check the console for more details.`);
                });
            }

            function updateClassroomAvailability(data) {
                const svgDoc = svgObject.contentDocument;
                // Reset all classrooms to available
                svgDoc.querySelectorAll('.classroom').forEach(element => {
                    element.classList.remove('occupied');
                });
                // Update classrooms based on availability data
                data.forEach(classroom => {
                    const element = svgDoc.getElementById(classroom.name);
                    if (element) {
                        if (!classroom.available) {
                            element.classList.add('occupied');
                            // If the currently selected classroom is now occupied, deselect it
                            if (selectedClassroomInput.value === classroom.name) {
                                selectedClassroomElement.textContent = 'Class Name';
                                selectedClassroomInput.value = '';
                            }
                        }
                    } else {
                        console.warn(`Classroom element not found: ${classroom.name}`);
                    }
                });
            }

            // Initial availability check
            checkAvailability();
        });
        </script>
    </body>
</html>