<?php
include '../assets/db_conn.php';


$pdo = dbConnect();

// Fetch all classrooms
$stmt = $pdo->query("SELECT CName, Floor FROM CLASSROOM ORDER BY Floor, CName");
$classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group classrooms by floor
$classroomsByFloor = [];
foreach ($classrooms as $classroom) {
    $classroomsByFloor[$classroom['Floor']][] = $classroom['CName'];
}

// Get the selected floor from the session, or set it to 1 if not set
$selected_floor = $_GET['floor'] ?? 1;

// Determine which SVG file to use based on the selected floor
$svg_file = "../assets/svg/map/floor-{$selected_floor}.svg";
if (!file_exists($svg_file)) {
    $svg_file = "../assets/svg/map/classroom.svg"; // Fallback to default if floor-specific SVG doesn't exist
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['ID']);

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

        <title>Map - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">

        <style>
            [id^="1"] rect, [id^="2"] rect, [id^="3"] rect { 
                stroke: rgba(69, 218, 34, 1.0);
                fill: rgba(69, 218, 34, 0.3);
                transition: all 0.3s ease;
                cursor: pointer;
            }
            [id^="1"] tspan, [id^="2"] tspan, [id^="3"] tspan {
                user-select: none;
                fill: rgba(49, 136, 28, 1.0);
                transition: all 0.3s ease;
                pointer-events: none;
            }
            [id^="1"]:hover rect, [id^="2"]:hover rect, [id^="3"]:hover rect {
                stroke: rgba(69, 218, 34, 0.7);
                fill: rgba(69, 218, 34, 0.2);
            }
            [id^="1"]:hover tspan, [id^="2"]:hover tspan, [id^="3"]:hover tspan {
                fill: rgba(49, 136, 28, 0.8);
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

        <form id="classroomForm" action="classroom-schedule.php" method="GET" class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3">
            <div class="container">
                <div class="row">
                    <div class="heading1"><p>Map - Floor <?php echo $selected_floor; ?></p></div>
                    <?php if (!$is_logged_in): ?>
                        <div class="alert alert-info" role="alert">
                            You are viewing as a guest. To make bookings, please <a href="login.php">log in</a> or <a href="register-name.php">register</a>.
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
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between" <?php echo $is_logged_in ? '' : 'disabled'; ?>>
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;"><?php echo $is_logged_in ? '' : ' (Login Required)'; ?></p>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="selectedClassroomInput" name="classroom" value="">
            <input type="hidden" id="selectedDateInput" name="date" value="">
            <input type="hidden" id="isLoggedIn" value="<?php echo $is_logged_in ? 'true' : 'false'; ?>">
        </form>

        <?php include('../assets/footer.php'); ?>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const svgObject = document.getElementById('svg-object');
            const selectedClassroomElement = document.getElementById('selectedClassroom');
            const selectedClassroomInput = document.getElementById('selectedClassroomInput');
            const selectedDateInput = document.getElementById('selectedDateInput');
            const startTimeSelect = document.getElementById('starttime');
            const endTimeSelect = document.getElementById('endtime');
            const classroomForm = document.getElementById('classroomForm');
            const isLoggedIn = document.getElementById('isLoggedIn').value === 'true';

            function initPanZoom(svgDocument) {
                injectCSS(svgDocument);
                window.panZoom = svgPanZoom(svgDocument.querySelector('svg'), {
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
                    [id^="1"] rect, [id^="2"] rect, [id^="3"] rect { 
                        stroke: rgba(69, 218, 34, 1.0);
                        fill: rgba(69, 218, 34, 0.3);
                        transition: all 0.3s ease;
                        cursor: pointer;
                    }
                    [id^="1"] tspan, [id^="2"] tspan, [id^="3"] tspan {
                        user-select: none;
                        fill: rgba(49, 136, 28, 1.0);
                        transition: all 0.3s ease;
                        pointer-events: none;
                    }
                    [id^="1"]:hover rect, [id^="2"]:hover rect, [id^="3"]:hover rect {
                        stroke: rgba(69, 218, 34, 0.7);
                        fill: rgba(69, 218, 34, 0.2);
                    }
                    [id^="1"]:hover tspan, [id^="2"]:hover tspan, [id^="3"]:hover tspan {
                        fill: rgba(49, 136, 28, 0.8);
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
            }

            svgObject.addEventListener('load', function() {
                const svgDoc = svgObject.contentDocument;
                const svgElement = svgDoc.querySelector('svg');
                initPanZoom(svgDoc);

                svgElement.addEventListener('click', function(event) {
                    event.preventDefault();
                    if (event.target.tagName.toLowerCase() === 'rect' && event.target.parentNode.id.match(/^[123]/)) {
                        const classroomGroup = event.target.parentNode;
                        const classroomName = classroomGroup.id;
                        selectedClassroomElement.textContent = classroomName;
                        selectedClassroomInput.value = classroomName;
                        checkAvailability();
                        
                        if (!isLoggedIn) {
                            alert('To view details or make a booking, please log in or register.');
                        }
                    }
                });
            });

            // Set initial date to today
            const today = new Date();
            selectedDateInput.value = today.toISOString().split("T")[0];

            startTimeSelect.addEventListener('change', checkAvailability);
            endTimeSelect.addEventListener('change', checkAvailability);

            classroomForm.addEventListener('submit', function(e) {
                if (!selectedClassroomInput.value) {
                    e.preventDefault();
                    alert('Please select a classroom first.');
                }
                if (!isLoggedIn) {
                    e.preventDefault();
                    alert('Please log in or register to view classroom details.');
                }
            });

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
                svgDoc.querySelectorAll('g[id]').forEach(element => {
                    element.classList.remove('occupied');
                });
                // Update classrooms based on availability data
                data.forEach(classroom => {
                    const element = svgDoc.getElementById(classroom.name);
                    if (element) {
                        if (!classroom.available) {
                            element.classList.add('occupied');
                        }
                    } else {
                        console.warn(`Classroom element not found: ${classroom.name}`);
                    }
                });
            }

            // Initial availability check
            checkAvailability();

            // Add event listener for calendar date changes
            document.querySelector('.calendar-dates').addEventListener('click', function(e) {
                if (e.target.tagName === 'LI' && !e.target.classList.contains('inactive')) {
                    selectedDateInput.value = e.target.dataset.date;
                    checkAvailability();
                }
            });
        });
        </script>
    </body>
</html>