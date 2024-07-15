<!DOCTYPE html>
<html lang="en">
    <!-- Navbar start -->
    <nav class="navbar navbar-expand-lg bg-transparent px-5 py-4">
        <div class="container-fluid">
            <!-- Logo start-->
            <a class="navbar-brand" href="index.php">
                <img src="../assets/logo.png" class="img-fluid" width="316" height="51">
            </a>
            <!-- Logo end -->
            <!-- Profile Button -->
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
