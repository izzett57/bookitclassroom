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

        <title>BookItClassroom - Edit User Profile</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">

        <script>
            function setOccupation(item) {
                // Get the text from the clicked item
                var itemText = item.textContent || item.innerText;

                // Find the dropdown button. Assuming it's the immediate parent's previous sibling
                var dropdownButton = item.closest('.dropend').querySelector('.oc-dropdown');

                // Set the dropdown button's text to the selected item's text
                dropdownButton.textContent = itemText;
            }
        </script>
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
                <div class="d-flex justify-content-start align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1 ms-5 mt-4">Edit User Profile</div>
                    </div>
                    <!-- Text end -->
                </div>
                <!-- Cancel button start -->
                <div class="d-flex justify-content-end">
                    <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="#" style="text-decoration: none; font-size: 2rem">cancel</a>
                </div>
                <!-- Cancel button end -->
                <!-- Profile start -->
                <div class="col d-flex justify-content-center align-items-center">
                    <!-- Picture start -->
                    <div class="container d-flex justify-content-center text-center py-3">
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
                    <!-- Data field start -->
                    <form class="container">
                        <div class="row">
                            <div class="col pt-3">
                                <label class="form-label inter-regular" for="firstName" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">First Name</label><br>
                                <input class="form-control" id="firstName" type="text" placeholder="first name">
                            </div>
                            <div class="col pt-3">
                                <label class="form-label inter-regular" for="lastName" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Last Name</label><br>
                                <input class="form-control" id="lastName" type="text" placeholder="last name">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Email start -->
                            <div class="pt-3">
                                    <label class="form-label inter-regular" for="email" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Email</label><br>
                                    <input class="form-control" id="email" type="text" placeholder="email">
                            </div>
                            <!-- Email end -->
                            <!-- Password start -->
                            <div class="pt-3">
                                    <label class="form-label inter-regular" for="password" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Password</label><br>
                                    <input class="form-control" id="password" type="password" placeholder="password">
                            </div>
                            <!-- Password end -->
                            <!-- Confirm password start -->
                            <div class="pt-3">
                                    <label class="form-label inter-regular" for="confirmPassword" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Confirm Password</label><br>
                                    <input class="form-control" id="confirmPassword" type="password" placeholder="confirm password">
                            </div>
                            <!-- Confirm password end -->
                            <!-- Occupation start -->
                            <label class="form-label inter-regular pt-3" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Occupation</label><br>
                            <div class="dropend">
                                <button class="btn btn-light oc-dropdown inter-regular" type="button" id="dropdownMenu1" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #FFF; color: #272937; border: 1px solid #dee2e6; width: 15rem;">
                                    Dropdown button
                                </button>
                                <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenu1">
                                    <li><a class="dropdown-item" onclick="setOccupation(this)" href="#">Admin</a></li>
                                    <li><a class="dropdown-item" onclick="setOccupation(this)" href="#">Lecturer</a></li>
                                    <li><a class="dropdown-item" onclick="setOccupation(this)" href="#">Student Club Leader</a></li>
                                    <li><a class="dropdown-item" onclick="setOccupation(this)" href="#">Member</a></li>
                                </ul>
                            </div>
                            <!-- Occupation end -->
                            <!-- Done button start -->
                            <div class="d-flex justify-content-end pt-3">
                                <button type="submit" name="#" value="#" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Done</p>
                                </button>
                            </div>
                            <!-- Done button end -->
                        </div>
                    </form>
                    <!-- Data field end -->
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
