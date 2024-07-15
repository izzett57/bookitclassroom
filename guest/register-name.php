<?php
session_start(); // Ensure session_start() is called at the beginning

// Initialize an array to hold error messages
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    // Basic validation for first_name
    if (empty($fname)) {
        $errors['fname'] = 'First name is required.';
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
        $errors['fname'] = 'Only letters and white space allowed in first name.';
    }

    // Basic validation for last_name
    if (empty($lname)) {
        $errors['lname'] = 'Last name is required.';
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
        $errors['lname'] = 'Only letters and white space allowed in last name.';
    }

    // Check if there are any errors
    if (count($errors) == 0) {
        // Store POST data in session if no errors
        foreach ($_POST as $key => $value) {
            $_SESSION['INFO'][$key] = $value;
        }

        // Remove 'next' from session INFO if present
        if (isset($_SESSION['INFO']['next'])) {
            unset($_SESSION['INFO']['next']);
        }

        // Redirect if no errors
        header('Location: register-email.php');
        exit(); // Ensure no further code is executed after redirection
    }
    // If there are errors, they are now in $errors array and can be displayed to the user
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

        <title>Register - Name - BookItClassroom</title>
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
                        <div class="subheading1"><p>Please enter your name.</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex flex-column">
                    <div class="container w-75">
                        <!-- Register name form start -->
                        <form class="row" action="" method="POST">
                            <!-- First name input start -->
                            <div class="col">
                                <label class="form-label inter-regular" for="firstName" style="letter-spacing: 4px; color: #272937;">FIRST NAME</label><br>
                                <input class="form-control" type="text" name="fname" value="<?= isset($SESSION['INFO']['fname'])
            ? $_SESSION['INFO']['fname'] : '' ?>"><br>
            <!--error message starts here for first name-->
                    <?php if (isset($errors['fname'])): ?>
            <div class="error"><?php echo $errors['fname']; ?></div>
        <?php endif; ?>
                            </div>
                            <!-- First name input end -->
                            <!-- Last name input start -->
                            <div class="col">
                                <label class="form-label inter-regular" for="lastName" style="letter-spacing: 4px; color: #272937;">LAST NAME</label><br>
                                <input class="form-control" type="text" name="lname" value="<?= isset($SESSION['INFO']['lname'])
            ? $_SESSION['INFO']['lname'] : '' ?>"><br>
                    <?php if (isset($errors['lname'])): ?>
            <div class="error"><?php echo $errors['lname']; ?></div>
        <?php endif; ?>

                            </div>
                            <!-- Last name input end -->
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
                        <!-- Register name form end --> 
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
