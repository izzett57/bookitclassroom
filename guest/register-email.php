<?php

session_start();

$errors = []; // Initialize an array to hold error messages

if (isset($_POST['next'])) {
    // Validate email
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        foreach ($_POST as $key => $value) {
            $_SESSION['INFO'][$key] = $value;
        }
    } else {
        $errors['email'] = "Invalid email format";
    }

    $keys = array_keys($_SESSION['INFO']);

    if (in_array('next', $keys)) {
        unset($_SESSION['INFO']['next']);
    }

    // Redirect only if there are no errors
    if (empty($errors)) {
        header('Location: register-password.php');
        exit();
    }
}

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

        <title>Register - Email - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-guest-back.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1"><p>Register</p></div>
                        <!-- Subheading -->
                        <div class="subheading1"><p>Please enter your email.</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex flex-column">
                    <div class="container w-75">
                        <!-- Register email form start -->
                        <form class="row" action="" method="POST">
                            <!-- Email input start -->
                            <div class="col">
                                <label class="form-label inter-regular" for="email" style="letter-spacing: 4px; color: #272937;">EMAIL</label><br>
                                <input class="form-control" type="text" name="email" value="<?= isset($SESSION['INFO']['email'])
            ? $_SESSION['INFO']['email'] : '' ?>"><br>
                        <!-- Error message start -->
                            <?php if (!empty($errors['email'])): ?>
                    <div style="color: red;"><?= $errors['email']; ?></div>
                <?php endif; ?>
                        <!-- Error message end -->
                            </div>
                            <!-- Email input end -->
                            <div class="row pt-4">
                                <!-- Spacing start -->
                                <div class="col">
                                </div>
                                <!-- Spacing end -->
                                <!-- Buttons start -->
                                <div class="col d-flex justify-content-end align-items-center">
                                    <!-- Back button start -->
                                    <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="#" style="text-decoration: none; font-size: 2rem">back</a>
                                    <!-- Back button end -->
                                    <!-- Next button start -->
                                    <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between" name="next" value="next">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
                                    </button>
                                    <!-- Next button end -->
                                </div>
                                <!-- Buttons end -->
                            </div>
                        </form>
                        <!-- Register email form end --> 
                    </div>
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
