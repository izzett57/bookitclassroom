<?php
session_start();
include '../assets/db_conn.php';

if (!isset($_SESSION['ID']) || $_SESSION['User_Type'] !== 'ADMIN') {
    header("Location: ../guest/login.php");
    exit();
}

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $delete_id = $_POST['delete_user'];
    $delete_query = "DELETE FROM USER WHERE ID = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        $_SESSION['success_message'] = "User deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Error deleting user.";
    }
    $delete_stmt->close();
    header("Location: edit-users.php");
    exit();
}

// Fetch all users
$query = "SELECT ID, FName, LName, Email, User_Type FROM USER ORDER BY ID";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

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

        <title>Edit Users - BookItClassroom</title>
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
                        <li><a class="dropdown-item inter-regular" href="logout.php">Sign Out</a></li>
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
                    <div class="col">
                        <div class="heading1 ms-5"><p>Edit Users</p></div>
                        <div class="subheading1 ms-5"><p>Here is a list of users on BookItClassroom.</p></div>
                    </div>
                </div>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
                <?php endif; ?>
                <div class="row">
                    <table class="table table-striped table-hover text-center inter-regular">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 3%;">#</th>
                                <th scope="col" style="width: 31%;">User</th>
                                <th scope="col" style="width: 21%;">Occupation</th>
                                <th scope="col" style="width: 31%;">Email</th>
                                <th scope="col" style="width: 14%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($user['FName'] . ' ' . $user['LName']); ?></td>
                                <td><?php echo htmlspecialchars($user['User_Type']); ?></td>
                                <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                <td class="d-flex justify-content-evenly">
                                    <a class="custom-btn-inline" href="edit-userprofile.php?id=<?php echo $user['ID']; ?>" style="text-decoration: none;">
                                        Edit
                                        <i class="bi bi-pencil-fill"></i>    
                                    </a>
                                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <button type="submit" name="delete_user" value="<?php echo $user['ID']; ?>" class="custom-btn-inline" style="background: none; border: none; color: inherit; cursor: pointer; text-decoration: none;">
                                            Delete
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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