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
                        <div style="margin: auto; width: 38px; height: 38px; border-radius: 100%; overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
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
    <!-- Navbar end -->
</html>
