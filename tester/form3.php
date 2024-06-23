<?php

session_start();

if (isset($_POST['submit'])) {
    foreach ($_POST as $key => $value) 
    {
        $_SESSION['INFO'][$key] = $value;
    }

$keys = array_keys($_SESSION['INFO']);

if (in_array('submit', $keys)) {
    unset($_SESSION['INFO']['submit']);
}

header('Location: submit.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 3</title>
</head>
<body>
    <form action="" method="POST">
        <label for="">Address</label><br>
        <input type="text" name="address" value="<?= isset($SESSION['INFO']['address'])
            ? $_SESSION['INFO']['address'] : '' ?>"><br>
        <label for="">Age</label><br>
        <input type="text" name="age" value="<?= isset($SESSION['INFO']['age'])
            ? $_SESSION['INFO']['age'] : '' ?>"><br>
        <button type="submit" name="submit" value="submit">Submit</button>
        <a href="form2.php">Previous</a>
</body>
</html>