<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once '../assets/db_conn.php';
require_once '../assets/check-user-type.php';

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

// Fetch user data
$query = "SELECT ID, FName, LName, Email, ProfilePicture FROM USER WHERE ID = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result === false) {
    die("Error getting result: " . $stmt->error);
}

$user = $result->fetch_assoc();

if ($user === null) {
    die("No user found with ID: " . $user_id);
}

$stmt->close();

// Check if the user has a profile picture
$profilePicture = '../assets/uploads/default-profile.jpg'; // Default image path
if (!empty($user['ProfilePicture'])) {
    $uploadedImage = '../assets/uploads/' . $user['ProfilePicture'];
    if (file_exists($uploadedImage)) {
        $profilePicture = $uploadedImage . '?t=' . time();
    } else {
        error_log("Profile picture file not found: " . $uploadedImage);
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = !empty($_POST['firstName']) ? $_POST['firstName'] : $user['FName'];
    $lname = !empty($_POST['lastName']) ? $_POST['lastName'] : $user['LName'];
    $email = !empty($_POST['Email']) ? $_POST['Email'] : $user['Email'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['confirmPassword'];

    $update_fields = [];
    $types = "";
    $params = [];

    if ($fname !== $user['FName']) {
        $update_fields[] = "FName = ?";
        $types .= "s";
        $params[] = $fname;
    }

    if ($lname !== $user['LName']) {
        $update_fields[] = "LName = ?";
        $types .= "s";
        $params[] = $lname;
    }

    if ($email !== $user['Email']) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } else {
            $update_fields[] = "Email = ?";
            $types .= "s";
            $params[] = $email;
        }
    }

    if (!empty($password)) {
        if ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            $update_fields[] = "Password = ?";
            $types .= "s";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    // Handle profile picture upload
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["profilePicture"]["name"];
        $filetype = $_FILES["profilePicture"]["type"];
        $filesize = $_FILES["profilePicture"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            $error = "Error: Please select a valid file format.";
        }

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            $error = "Error: File size is larger than the allowed limit.";
        }

        // Verify MIME type of the file
        if (in_array($filetype, $allowed)) {
            // Check whether file exists before uploading it
            if (!isset($error)) {
                $new_filename = uniqid() . "." . $ext;
                $target = "../assets/uploads/" . $new_filename;
                if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target)) {
                    $update_fields[] = "ProfilePicture = ?";
                    $types .= "s";
                    $params[] = $new_filename;
                    $profilePicture = $target . '?t=' . time(); // Update the preview
                } else {
                    error_log("File upload failed. Error: " . $_FILES["profilePicture"]["error"]);
                    $error = "Error: There was a problem uploading your file. Please try again.";
                }
            }
        } else {
            $error = "Error: There was a problem uploading your file. Please try again.";
        }
    }

    if (!empty($update_fields) && !isset($error)) {
        $update_query = "UPDATE USER SET " . implode(", ", $update_fields) . " WHERE ID = ?";
        $types .= "i";
        $params[] = $user_id;

        $update_stmt = $conn->prepare($update_query);

        if ($update_stmt === false) {
            die("Error preparing update statement: " . $conn->error);
        }

        $update_stmt->bind_param($types, ...$params);

        if (!$update_stmt->execute()) {
            $error = "Error updating user information: " . $update_stmt->error;
        } else {
            $_SESSION['success_message'] = "Profile updated successfully.";
            header("Location: profile.php");
            exit();
        }

        $update_stmt->close();
    } elseif (empty($update_fields) && !isset($error)) {
        $_SESSION['info_message'] = "No changes were made to your profile.";
        header("Location: profile.php");
        exit();
    }
}

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

        <title>Edit Profile - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const profilePicInput = document.getElementById('profilePicture');
                const profilePreview = document.getElementById('profilePreview');

                profilePicInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
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
                <div class="d-flex justify-content-start align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1 ms-5 mt-4">Edit Profile</div>
                    </div>
                    <!-- Text end -->
                </div>
                <!-- Cancel button start -->
                <div class="d-flex justify-content-end">
                    <a onclick="location.href='profile.php'" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">cancel</a>
                </div>
                <!-- Cancel button end -->
                <!-- Profile start -->
                <div class="col d-flex justify-content-center align-items-center">
                    <!-- Picture start -->
                    <div class="container d-flex justify-content-center text-center py-3">
                        <div class="row d-flex justify-content-center">
                            <div class="d-flex justify-content-center align-items-center" style="background-color: white; width: 260px; height: 260px; border-radius: 100%; overflow: hidden;">
                                <img id="profilePreview" src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" style="width: 125%; height: 125%; object-fit: cover;">
                            </div>
                            <label for="profilePicture" class="dongle-regular custom-btn-inline primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">edit</label>
                        </div>
                    </div>
                    <!-- Picture end -->    
                    <!-- Data field start -->
                    <form class="container" method="POST" action="edit-profile.php" enctype="multipart/form-data">
                        <input type="file" id="profilePicture" name="profilePicture" accept="image/*" style="display: none;">
                        <div class="row">
                            <div class="col pt-3">
                                <label class="form-label inter-regular" for="firstName" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">First Name</label><br>
                                <input class="form-control" id="firstName" name="firstName" type="text" value="<?php echo htmlspecialchars($user['FName']); ?>" placeholder="first name">
                            </div>
                            <div class="col pt-3">
                                <label class="form-label inter-regular" for="lastName" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Last Name</label><br>
                                <input class="form-control" id="lastName" name="lastName" type="text" value="<?php echo htmlspecialchars($user['LName']); ?>" placeholder="last name">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Email start -->
                            <div class="pt-3">
                                <label class="form-label inter-regular" for="Email" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Email</label><br>
                                <input class="form-control" id="Email" name="Email" type="email" value="<?php echo htmlspecialchars($user['Email']); ?>" placeholder="email">
                            </div>
                            <!-- Email end -->
                            <!-- Password start -->
                            <div class="pt-3">
                                <label class="form-label inter-regular" for="Password" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Password</label><br>
                                <input class="form-control" id="Password" name="Password" type="password" placeholder="new password">
                            </div>
                            <!-- Password end -->
                            <!-- Confirm password start -->
                            <div class="pt-3">
                                <label class="form-label inter-regular" for="confirmPassword" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Confirm Password</label><br>
                                <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="confirm new password">
                            </div>
                            <!-- Confirm password end -->
                            <?php if (isset($error)): ?>
                            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                            <?php endif; ?>
                            <!-- Done button start -->
                            <div class="d-flex justify-content-end pt-3">
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
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