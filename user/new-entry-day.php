<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Import Bootstrap start -->
        <?php 
            include('../assets/import-bootstrap.php');
        ?>
        <!-- Import Bootstrap end -->

        <!-- Import CSS file(s) start -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <!-- Import CSS file(s) end --> 

        <title>New Entry - Name - BookItClassroom</title>
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
                        <img src="../assets/logo.png" class="img-fluid" width="316" height="51">
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
                        <li><a class="dropdown-item inter-regular" href="#">Sign Out</a></li>
                    </ul>
                </li>
                <!-- Profile button end -->
            </div>
        </nav>
        <!-- Nav bar end -->
        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row">
                    <!-- Text start -->
                    <div class="col-9">
                        <!-- Heading -->
                        <div class="heading1 ms-5"><p>New Entry</p></div>
                        <div class="subheading1 ms-5"><p>Which day is the class/event?</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="height: 45vh; width: 35%; align-content: center;">
                        <!-- Event day form start -->
                        <!-- CSS start (todo) -->
                        <style>
                            /* The container */
                            .dayContainer {
                            display: block;
                            position: relative;
                            padding-left: 35px;
                            margin-bottom: 12px;
                            font-size: 22px;
                            }

                            /* Hide the browser's default radio button */
                            .dayContainer input {
                            position: absolute;
                            opacity: 0;
                            cursor: pointer;
                            }

                            /* Create a custom radio button */
                            .checkmark {
                            position: absolute;
                            top: 0;
                            left: 0;
                            height: 25px;
                            width: 25px;
                            background-color: #eee;
                            border-radius: 50%;
                            }

                            /* On mouse-over, add a grey background color */
                            .dayContainer:hover input ~ .checkmark {
                            background-color: #ccc;
                            cursor: pointer;
                            }

                            /* When the radio button is checked, add a blue background */
                            .dayContainer input:checked ~ .checkmark {
                            background-color: #2196F3;
                            }

                            /* Create the indicator (the dot/circle - hidden when not checked) */
                            .checkmark:after {
                            content: "";
                            position: absolute;
                            display: none;
                            }

                            /* Show the indicator (dot/circle) when checked */
                            .dayContainer input:checked ~ .checkmark:after {
                            display: block;
                            }

                            /* Style the indicator (dot/circle) */
                            .dayContainer .checkmark:after {
                                top: 9px;
                                left: 9px;
                                width: 8px;
                                height: 8px;
                                border-radius: 50%;
                                background: white;
                            }
                        </style>
                        <!-- CSS end -->
                        <form>
                            <div class="row row-cols-5">
                                <div class="col">
                                <label class="dayContainer">
                                <input type="radio" name="day" value="MONDAY">
                                <span class="checkmark"></span>
                                </label>
                                </div>
                                <div class="col">
                                <label class="dayContainer">
                                <input type="radio" name="day" value="TUESDAY">
                                <span class="checkmark"></span>
                                </label>
                                </div>
                                <div class="col">
                                <label class="dayContainer">
                                <input type="radio" name="day" value="WEDNESDAY">
                                <span class="checkmark"></span>
                                </label>
                                </div>
                                <div class="col">
                                <label class="dayContainer">
                                <input type="radio" name="day" value="THURSDAY">
                                <span class="checkmark"></span>
                                </label>
                                </div>
                                <div class="col">
                                <label class="dayContainer">
                                <input type="radio" name="day" value="FRIDAY">
                                <span class="checkmark"></span>
                                </label>
                                </div>
                            </div>
                            <!-- Buttons start -->
                                <div class="col d-flex justify-content-end align-items-center mt-5">
                                    <!-- Back button start -->
                                    <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                    <!-- Back button end -->
                                    <!-- Next button start -->
                                    <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
                                    </button>
                                    <!-- Next button end -->
                                </div>
                                <!-- Buttons end -->
                        </form>
                        <!-- Event day form end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content end -->
        <!-- Footer -->
        <?php 
            include('../assets/footer.php');
        ?>
        <!-- Footer end -->
    </body>
</html>
