<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../assets/db_conn.php';

if (!isset($_SESSION['ID'])) {
    header("Location: ../guest/login.php");
    exit();
}

$user_id = $_SESSION['ID'];

// Ensure upload directory exists
$uploadDir = '../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$query = "SELECT * FROM user WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the user has a profile picture
$profilePicture = '../assets/uploads/default-profile.png'; // Default image path
if (!empty($user['ProfilePicture'])) {
    $uploadedImage = '../assets/uploads/' . $user['ProfilePicture'];
    if (file_exists($uploadedImage)) {
        $profilePicture = $uploadedImage . '?t=' . time();
    } else {
        error_log("Profile picture file not found: " . $uploadedImage);
    }
} else {
    error_log("No profile picture set for user ID: " . $user_id);
}

// Determine user role for display
$userRole = ''; // Initialize variable to hold the user role for display
if ($user['User_Type'] === 'MEMBER') {
    $userRole = 'Member';
} elseif ($user['User_Type'] === 'ADMIN') {
    $userRole = 'Admin';
} elseif ($user['User_Type'] === 'LECTURER') {
    $userRole = 'Lecturer';
} elseif ($user['User_Type'] === 'CLUB_LEADER') {
    $userRole = 'Student Club Leader';
}

$stmt->close();
$conn->close();
?>

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

        <title>Profile - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-user-back.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="container">
                <div class="d-flex justify-content-start">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1 ms-5"><p>Profile</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <!-- Edit button start -->
                <div class="d-flex justify-content-end">
                    <a onclick="location.href='edit-profile.php'" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">edit</a>
                </div>
                <!-- Edit button end -->
                <!-- Profile start -->
                <div class="col d-flex justify-content-center align-items-center">
                    <!-- Picture start -->
                    <div class="container d-flex justify-content-center text-center">
                        <div class="row d-flex justify-content-center py-3">
                            <div class="d-flex justify-content-center align-items-center" style="background-color: black; width: 260px; height: 260px; border-radius: 100%; overflow: hidden;">
                                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" style="width: 125%; height: 125%; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                    <!-- Picture end -->
                    <!-- Details start -->
                    <!-- Data field start -->
                    <div class="container justify-content-center">
                        <!-- Name start -->
                        <div class="row">
                            <div class="col pt-3">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">First Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px; text-transform: capitalize;"><?php echo htmlspecialchars($user['FName']); ?></p>
                            </div>
                            <div class="col pt-3">
                                <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Last Name</p>
                                <p class="subheading1" style="margin: 0px 0px 0px -2px; text-transform: capitalize;"><?php echo htmlspecialchars($user['LName']); ?></p>
                            </div>
                        </div>
                        <!-- Name end -->
                        <!-- Email start -->
                        <div class="pt-5">
                            <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Email</p>
                            <p class="subheading1" style="margin: 0px 0px 0px -2px;"><?php echo htmlspecialchars($user['Email']); ?></p>
                        </div>
                        <!-- Email end -->
                        <!-- Occupation start -->
                        <div class="pt-5">
                            <p class="inter-regular" style="letter-spacing: 4px; color: #272937;text-transform: uppercase;">Occupation</p>
                            <p class="subheading1" style="margin: 0px 0px 0px -2px; text-transform: capitalize;"><?php echo htmlspecialchars($userRole); ?></p>
                        </div>
                        <!-- Occupation end -->
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