<!DOCTYPE html>
<html lang="en">
    <!-- Navbar start -->
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
    <!-- Navbar end -->
</html>
