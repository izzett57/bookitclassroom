<?php
include '../assets/db_conn.php';
include '../assets/IsLoggedInAdmin.php';
require_once '../assets/check-user-type.php';

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
        <?php 
            include('../assets/navbar-user-back.php');
        ?>
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