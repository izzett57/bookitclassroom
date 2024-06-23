<?php

session_start();

if (isset($_POST['next'])) {
    foreach ($_POST as $key => $value) 
    {
        $_SESSION['INFO'][$key] = $value;
    }


$keys = array_keys($_SESSION['INFO']);

if (in_array('next', $keys)) {
    unset($_SESSION['INFO']['next']);
}

header('Location: form2.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 1</title>
</head>
<body>
    <form action="" method="POST">
        <label for="">First Name</label><br>
        <input type="text" name="fname" value="<?= isset($SESSION['INFO']['fname'])
            ? $_SESSION['INFO']['fname'] : '' ?>"><br>
        <label for="">Last Name</label><br>
        <input type="text" name="lname" value="<?= isset($SESSION['INFO']['lname'])
            ? $_SESSION['INFO']['lname'] : '' ?>"><br>
        <button type="submit" name="next" value="Next">Next</button>
</body>
</html>