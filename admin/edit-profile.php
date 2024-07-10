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

        <title>BookItClassroom - Edit Profile</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="../assets/js/my.js"></script>
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
                        <li><a class="dropdown-item inter-regular" href="register-name.php">Register</a></li>
                        <li><a class="dropdown-item inter-regular" href="login.php">Sign In</a></li>
                    </ul>
                </li>
                <!-- Profile button end -->
            </div>
        </nav>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="d-flex justify-content-start" style="background-color: red;">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1 ms-3"><p>Edit Profile</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <!-- Cancel button start -->
                <div class="d-flex justify-content-end" style="background-color: orange;">
                    <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="#" style="text-decoration: none; font-size: 2rem">cancel</a>
                </div>
                <!-- Cancel button end -->
                <!-- Profile start -->
                <div class="col d-flex justify-content-center align-items-center" style="background-color:yellow;">
                    <!-- Picture start -->
                    <div class="container d-flex justify-content-center text-center py-3" style="background-color:green;">
                        <div class="row d-flex justify-content-center">
                            <div class="d-flex justify-content-center align-items-center" style="background-color: white; width: 260px; height: 260px; border-radius: 250px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="250px" height="250px" fill="currentColor" class="bi bi-person-circle primary" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>
                            </div>
                            <a onclick="href='#'" class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="#" style="text-decoration: none; font-size: 2rem">edit</a>
                        </div>
                    </div>
                    <!-- Picture end -->
                    <!-- Details start -->
                    <!-- Data field start -->
                    <div class="container justify-content-center" style="background-color:blue;">
                        <div class="row">
                            <div class="col" style="background-color:lightblue;">
                                <label class="form-label inter-regular" for="firstName" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">First Name</label><br>
                                <input class="form-control" id="firstName" type="text" placeholder="first name">
                            </div>
                            <div class="col" style="background-color:lightgreen;">
                                <label class="form-label inter-regular" for="lastName" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Last Name</label><br>
                                <input class="form-control" id="lastName" type="text" placeholder="last name">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Email start -->
                            <div style="background-color:purple;">
                                    <label class="form-label inter-regular" for="email" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Email</label><br>
                                    <input class="form-control" id="email" type="text" placeholder="email">
                            </div>
                            <!-- Email end -->
                            <!-- Password start -->
                            <div style="background-color:pink;">
                                    <label class="form-label inter-regular" for="password" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Password</label><br>
                                    <input class="form-control" id="password" type="password" placeholder="password">
                            </div>
                            <!-- Password end -->
                            <!-- Confirm password start -->
                            <div style="background-color:pink;">
                                    <label class="form-label inter-regular" for="confirmPassword" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Confirm Password</label><br>
                                    <input class="form-control" id="confirmPassword" type="password" placeholder="confirm password">
                            </div>
                            <!-- Confirm password end -->
                            <!-- Occupation start -->
                            <div style="background-color:pink;">
                                    <label class="form-label inter-regular" for="User_Type" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Occupation</label><br>
                                    <div class="bs-example">
                                        <ul class="nav nav-pills" role="tablist">
                                            <li role="presentation" class="dropdown"> <a href="#" class="dropdown-toggle" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Dropdown <span class="caret"></span> </a>
                                            <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                            </ul>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                            <!-- Occupation end -->
                            <!-- Done button start -->
                            <div class="d-flex justify-content-end" style="background-color:pink;">
                                <a onclick="href='#'" class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="#" style="text-decoration: none; font-size: 2rem">done</a>
                            </div>
                            <!-- Done button end -->
                        </div>
                    </div>
                    <!-- Data field end -->
                    <!-- Details end -->
                </div>
                <!-- Profile end -->
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
