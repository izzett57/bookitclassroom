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

header('Location: form3.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 2</title>
</head>
<body>
    <form action="" method="POST">
        <label for="">Phone Number</label><br>
        <input type="text" name="phone" value="<?= isset($SESSION['INFO']['phone'])
            ? $_SESSION['INFO']['phone'] : '' ?>"><br>
        <label for="">Email</label><br>
        <input type="text" name="email" value="<?= isset($SESSION['INFO']['email'])
            ? $_SESSION['INFO']['email'] : '' ?>"><br>
        <button type="submit" name="next" value="Next">Next</button>
        <a href="form1.php">Previous</a>
</body>
</html>