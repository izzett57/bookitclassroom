<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedIn.php';
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
        <link rel="stylesheet" href="../assets/css/entry.css"/>
        <link rel="stylesheet" href="../assets/css/calendar.css"/>
        <link rel="stylesheet" href="../assets/css/svg-container.css"/>
        <!-- Import CSS file(s) end --> 

        <!-- Import time select scripts start -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../assets/js/time-select.js"></script>
        <!-- Import time select scripts end -->

        <title>Timetable - Map - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-user-back.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <form class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center py-3">
            <div class="container">
                <div class="row">
                    <!-- Text start -->
                        <!-- Heading -->
                        <div class="heading1" style=""><p>Map</p></div>
                        <div class="subheading1" style="">
                            <span>Reserving class/event:</span>
                            <span style="font-weight: 600;">Event Name</span>
                        </div>
                    <!-- Text end -->
                    <div class="container" style="height: 70vh;">
                        <div class="row" style="height: 100%;">
                            <!-- Map start -->
                            <div class="col-8" style="">
                            <div class="svg-container">
                                <object id="svg-object" type="image/svg+xml" data="../assets/svg/map/classroom.svg" onload="initPanZoom(this.contentDocument);"></object>
                            </div>
                            <!-- Include svg-pan-zoom library -->
                            <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@latest/dist/svg-pan-zoom.min.js"></script>
                            <script>
                                function injectCSS(svgDocument) {
                                    const style = document.createElementNS("http://www.w3.org/2000/svg", "style");
                                    // A1 example of available
                                    // A2 example of unavailable
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
                                <!-- Calendar end -->
                                <!-- Time select start -->
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                    <div class="d-flex flex-glow justify-content-center align-items-center" style="width: 100%;">
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <!-- <?php echo date('H:i', strtotime($entry['start_time'])); ?> -->
                                            01:00 <!-- placeholder -->
                                        </span>
                                        </div>
                                        <span class="col-1 text-center text-time mx-2" style="user-select: none;">-</span>
                                        <div class="col-5 form-group text-center" style="width: 35%; height: 60px;" style="width: 100%">
                                        <span class="d-flex justify-content-center align-items-center timeBox text-time" style="width: 100%; user-select: none;">
                                            <!-- <?php echo date('H:i', strtotime($entry['end_time'])); ?> -->
                                            02:00 <!-- placeholder -->
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Time select end -->
                                <!-- Selected class start -->
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <div class="d-flex flex-column justify-content-center align-items-center pt-4">
                                    <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Selected class</p>
                                    <p class="subheading1" style="margin: 0px 0px 0px -2px;">Class Name</p>
                                </div>
                                </div>
                                <!-- Selected class end -->
                                <!-- Reserve button start -->
                                <div class="col d-flex justify-content-center align-items-center" style="height: 16.66%;">
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reserve</p>
                                </button>
                                </div>
                                <!-- Reserve button end -->
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