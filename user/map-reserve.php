<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
require_once '../assets/check-user-type.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

// Check if selected_floor is set in the session, if not, redirect to select-floor.php
if (!isset($_SESSION['selected_floor'])) {
    header("Location: select-floor-reserve.php");
    exit();
}

$selected_floor = $_SESSION['selected_floor'];

// Connect to the database
$pdo = dbConnect();

// Fetch classrooms for the selected floor
$stmt = $pdo->prepare("SELECT CName, Floor FROM CLASSROOM WHERE Floor = ? ORDER BY CName");
$stmt->execute([$selected_floor]);
$classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $selected_classroom = filter_input(INPUT_POST, 'selected_classroom', FILTER_SANITIZE_STRING);
    $selected_date = filter_input(INPUT_POST, 'selected_date', FILTER_SANITIZE_STRING);
    $time_from = filter_input(INPUT_POST, 'timeFrom', FILTER_SANITIZE_STRING);
    $time_to = filter_input(INPUT_POST, 'timeTo', FILTER_SANITIZE_STRING);

    // Validate date format (assuming YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $selected_date)) {
        die("Invalid date format");
    }

    $_SESSION['reserve_data'] = [
        'classroom' => $selected_classroom,
        'date' => $selected_date,
        'time_start' => $time_from,
        'time_end' => $time_to
    ];

    header("Location: select-entry.php");
    exit();
}

// Determine which SVG file to use based on the selected floor
$svg_file = "../assets/svg/map/floor-{$selected_floor}.svg";
if (!file_exists($svg_file)) {
    $svg_file = "../assets/svg/map/classroom.svg"; // Fallback to default if floor-specific SVG doesn't exist
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

        <title>Reserve - Map - BookItClassroom</title>
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
                    <div class="heading1"><p>Map - Floor <?php echo htmlspecialchars($selected_floor); ?></p></div>
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
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                    <?php
                                    function get_times($default = '00:00', $interval = '+30 minutes') {
                                        $output = '';
                                        $current = strtotime('00:00');
                                        $end = strtotime('23:59');
                                    
                                        while ($current <= $end) {
                                            $time = date('H:i:s', $current);
                                            $sel = ($time == $default) ? ' selected' : '';
                                            $output .= "<option value=\"{$time}\"{$sel}>" . date('H:i ', $current) . '</option>';
                                            $current = strtotime($interval, $current);
                                        }
                                        return $output;
                                    }
                                    ?>
                                    <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                            <select class="form-control text-center text-time custom-select" style="height: 100%; user-select: none;" id="starttime" name="timeFrom" required>
                                                <?php echo get_times(); ?>
                                            </select>
                                        </div>
                                        <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                            <select class="form-control text-center text-time custom-select" style="height: 100%; user-select: none;" id="endtime" name="timeTo" disabled="" required>
                                                <?php echo get_times(); ?>
                                            </select>
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
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
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
            const startTimeSelect = document.getElementById('starttime');
            const endTimeSelect = document.getElementById('endtime');

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

            startTimeSelect.addEventListener('change', checkAvailability);
            endTimeSelect.addEventListener('change', checkAvailability);

            function checkAvailability() {
                const date = selectedDateInput.value;
                const timeStart = startTimeSelect.value;
                const timeEnd = endTimeSelect.value;

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