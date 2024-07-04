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
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['email'] === $email && password_verify($password, $row['password'])) {
            	$_SESSION['email'] = $row['email'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
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
	
} else {
	header("Location: login.php");
	exit();
}
?>
