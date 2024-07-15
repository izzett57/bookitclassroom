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
        <link rel="stylesheet" href="../assets/css/entry.css"/>
        <link rel="stylesheet" href="../assets/css/calendar.css"/>
        <!-- Import CSS file(s) end --> 

        <!-- Import time select scripts start -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/time-select.js"></script>
        <!-- Import time select scripts end -->

        <title>Map - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <!-- Nav bar start -->
        <nav class="navbar bg-transparent px-5 py-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Back button start -->
                    <button onclick="history.back()" type="button" class="btn btn-light btn-circle me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-arrow-left-circle-fill primary" viewBox="0 0 16 16">
                            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </button>
                    <!-- Back button end -->
                    <!-- Logo start -->
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/logo.png" class="img-fluid" width="316" height="51" alt="BookItClassroom Logo">
                    </a>
                    <!-- Logo end -->
                </div>
                <!-- Profile button start -->
                <li class="dropdown" style="list-style-type: none;">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <button type="button" class="btn btn-light btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-person-circle primary" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                            </svg>
                        </button>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2">
                        <li><a class="dropdown-item inter-regular" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item inter-regular" href="logout.php">Sign Out</a></li>
                    </ul>
                </li>
                <!-- Profile button end -->
            </div>
        </nav>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <form class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3">
            <div class="container">
                <div class="row">
                    <!-- Text start -->
                        <!-- Heading -->
                        <div class="heading1" style="background-color: rgba(0, 0, 0, 0.1);"><p>Map</p></div>
                    <!-- Text end -->
                    <div class="container" style="height: 70vh; background-color: rgba(0, 0, 0, 0.2);">
                        <div class="row" style="height: 100%;">
                            <!-- Map start -->
                            <div class="col-8" style="background-color: rgba(0, 0, 0, 0.3);">
                            <style>
                                .svg-container {
                                    width: 100%; /* Adjust based on your layout needs */
                                    height: 70vh; /* Maximum size of the container */
                                    margin: auto; /* Center the container */
                                    border: 1px solid #ccc; /* Optional: adds a border around the SVG viewport */
                                    overflow: hidden; /* Ensures no overflow of the SVG content */
                                }
                                .svg-container:active {
                                    cursor: grabbing;
                                }
                            </style>
                            <div class="svg-container">
                                <object id="svg-object" type="image/svg+xml" data="../assets/svg/map/classroom.svg" onload="initPanZoom(this.contentDocument);"></object>
                            </div>
                            <!-- Include svg-pan-zoom library -->
                            <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@latest/dist/svg-pan-zoom.min.js"></script>
                            <script>
                                function injectCSS(svgDocument) {
                                    const style = document.createElementNS("http://www.w3.org/2000/svg", "style");
                                    style.textContent = `
                                        #A1 rect {
                                            stroke: rgba(69, 218, 34, 1.0);
                                            fill: rgba(69, 218, 34, 0.3);
                                        }
                                        #A1 tspan {
                                            user-select: none;
                                            fill: rgba(49, 136, 28, 1.0);
                                        }
                                        #A1:hover rect {
                                            stroke: rgba(69, 218, 34, 0.7);
                                            fill: rgba(69, 218, 34, 0.2);
                                            tspan {
                                                fill: rgba(49, 136, 28, 0.8);
                                            }
                                            cursor: pointer;
                                        }
                                        #A2 rect{
                                            stroke: rgba(218, 34, 34, 0.8);
                                            fill: rgba(244, 196, 196, 0.3);
                                        }
                                        #A2 tspan {
                                            user-select: none;
                                            fill: rgba(136, 28, 28, 1.0);
                                        }
                                        #A2:hover rect {
                                            stroke: rgba(218, 34, 34, 0.5);
                                            fill: rgba(244, 196, 196, 0.2);
                                            tspan {
                                                fill: rgba(136, 28, 28, 0.8);
                                        }
                                            cursor: pointer;
                                        }
                                        #B1 rect{
                                            stroke: rgba(69, 218, 34, 1.0);
                                            fill: rgba(69, 218, 34, 0.3);
                                        }
                                        #B1 tspan {
                                            user-select: none;
                                            fill: rgba(49, 136, 28, 1.0);
                                        }
                                        #B1:hover rect {
                                            stroke: rgba(69, 218, 34, 0.7);
                                            fill: rgba(69, 218, 34, 0.2);
                                            tspan {
                                                fill: rgba(49, 136, 28, 0.8);
                                            }
                                            cursor: pointer;
                                        }
                                        #B2 rect{
                                            stroke: rgba(218, 34, 34, 0.8);
                                            fill: rgba(244, 196, 196, 0.3);
                                        }
                                        #B2 tspan {
                                            user-select: none;
                                            fill: rgba(136, 28, 28, 1.0);
                                        }
                                        #B2:hover rect {
                                            stroke: rgba(218, 34, 34, 0.5);
                                            fill: rgba(244, 196, 196, 0.2);
                                            tspan {
                                                fill: rgba(136, 28, 28, 0.8);
                                        }
                                            cursor: pointer;
                                        }
                                        #C1 rect{
                                            stroke: rgba(218, 34, 34, 0.8);
                                            fill: rgba(244, 196, 196, 0.3);
                                        }
                                        #C1 tspan {
                                            user-select: none;
                                            fill: rgba(136, 28, 28, 1.0);
                                        }
                                        #C1:hover rect {
                                            stroke: rgba(218, 34, 34, 0.5);
                                            fill: rgba(244, 196, 196, 0.2);
                                            tspan {
                                                fill: rgba(136, 28, 28, 0.8);
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
                                        minZoom: 0.7, // Minimum zoom level
                                        maxZoom: 2,   // Maximum zoom level
                                        panEnabled: true,
                                        contain: true // Prevents panning outside the SVG viewport
                                    });
                                }
                            </script>
                            </div>
                            <!-- Map end -->
                            <div class="col">
                                <!-- Calendar start -->
                                <div class="col d-flex justify-content-center align-items-center" style="height: 50%; background-color: rgba(0, 0, 0, 0.4);">
                                    <div class="calendar inter-light">
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
                                <!-- Calendar end -->
                                <!-- Time select start -->
                                <div class="col d-flex justify-content-center align-items-center" style="height: 50%; background-color: rgba(0, 0, 0, 0.5);">
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
                                            <select class="form-control text-center text-time custom-select" style="height: 100%;" id="starttime" name="timeFrom" required>
                                                <?php echo get_times(); ?>
                                            </select>
                                        </div>
                                        <span class="col-1 text-center text-time mx-2">-</span>
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                            <select class="form-control text-center text-time custom-select" style="height: 100%;" id="endtime" name="timeTo" disabled="" required>
                                                <?php echo get_times(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Time select end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Main content end -->
        <!-- Footer -->
        <?php include('../assets/footer.php'); ?>
        <!-- Footer end -->
    </body>
</html>