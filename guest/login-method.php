<?php 
session_start(); 
include "../assets/db_conn.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($email)) {
        header("Location: login.php?error=Email is required");
        exit();
    } else if (empty($password)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        // Using prepared statements to prevent SQL injection
        $sql = "SELECT * FROM user WHERE Email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: login.php?error=SQL error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['Email'] === $email && password_verify($password, $row['Password'])) {
                    $_SESSION['Email'] = $row['Email'];
                    $_SESSION['name'] = $row['FName'] . ' ' . $row['LName'];
                    $_SESSION['ID'] = $row['ID'];
                    header("Location: ../user/index.php");
                    exit();
                } else {
                    header("Location: login.php?error=Incorrect Email or password");
                    exit();
                }
            } else {
                header("Location: login.php?error=Incorrect Email or password");
                exit();
            }
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
