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

        <title>Timetable - BookItClassroom</title>
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
                        <!-- Placeholder start -->
                        <tr>
                        <th scope="row">1</th>
                        <td>Subject 1</td>
                        <td>Tuesday</td>
                        <td>14:00 - 15:00</td>
                        <td>A1</td>
                        <!-- Action start -->
                        <td class="d-flex justify-content-evenly">
                        <a class="custom-btn-inline" href="#" style="text-decoration: none;">
                            Unreserve
                            <i class="bi bi-bookmark-dash-fill"></i>    
                        </a>
                        <!-- Action end -->
                        </svg>
                        </td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Subject 2</td>
                        <td>Monday</td>
                        <td>16:00 - 17:00</td>
                        <td>-</td>
                        <!-- Action start -->
                        <td class="d-flex justify-content-evenly">
                        <a class="custom-btn-inline" href="edit-entry.php" style="text-decoration: none;">
                            Edit
                            <i class="bi bi-pencil-fill"></i>    
                        </a>
                        <a class="custom-btn-inline" href="reserve-event.php" style="text-decoration: none;">
                            Reserve
                            <i class="bi bi-bookmark-plus-fill"></i>
                        </a>
                        <!-- Action end -->
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Subject 3</td>
                        <td>Thursday</td>
                        <td>17:00 - 19:00</td>
                        <td>B2</td>
                        <!-- Action start -->
                        <td class="d-flex justify-content-evenly">
                        <a class="custom-btn-inline" href="#" style="text-decoration: none;">
                            Unreserve
                            <i class="bi bi-bookmark-dash-fill"></i>    
                        </a>
                        <!-- Action end -->
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Subject 4</td>
                        <td>Wednesday</td>
                        <td>12:00 - 15:00</td>
                        <td>-</td>
                        <!-- Action start -->
                        <td class="d-flex justify-content-evenly">
                        <a class="custom-btn-inline" href="edit-entry.php" style="text-decoration: none;">
                            Edit
                            <i class="bi bi-pencil-fill"></i>    
                        </a>
                        <a class="custom-btn-inline" href="reserve-event.php" style="text-decoration: none;">
                            Reserve
                            <i class="bi bi-bookmark-plus-fill"></i>
                        </a>
                        <!-- Action end -->
                        </tr>
                        <!-- Placeholder end -->
                    </tbody>
                </table>
                </div>
                <!-- Table data end -->
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
