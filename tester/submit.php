<?php
    session_start();

    if (isset($_SESSION['INFO'])) {
        extract($_SESSION['INFO']);

        $conn = mysqli_connect('localhost', 'root', '', 'multistep');

        $sql = mysqli_query($conn, "INSERT INTO multistep (first_name, last_name, phone, email, address, age) VALUES ('$fname','$lname','$phone','$email','$address','$age')");

        if ($sql) {
            unset($_SESSION['INFO']);

            echo 'Data has been saved successfully!';

            echo '<a href="form1.php">Go back</a>';
        }else{
            echo mysqli_error($conn);
        }
    }
    ?>
