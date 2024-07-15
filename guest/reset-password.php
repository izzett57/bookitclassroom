<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$token = $_GET['token'] ?? '';
if (empty($token)) {
    die("No token provided. Please request a new password reset link.");
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Import Bootstrap start -->
        <?php include('../assets/import-bootstrap.php'); ?>
        <!-- Import Bootstrap end -->

        <!-- Import CSS file(s) start -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/font-sizing.css">
        <link rel="stylesheet" href="../assets/css/google-fonts.css">
        <!-- Import CSS file(s) end -->

        <title>Reset Password - BookItClassroom</title>
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
                    <!-- Text start -->
                    <div class="row mb-5 text-center">
                        <!-- Heading -->
                        <span class="heading1" style="padding-bottom: 15px;">Reset password</span>
                        <!-- Subheading -->
                        <span class="subheading1" style="">Please enter a new password.</span>
                    </div>
                    <!-- Text end -->
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="width: 50%;">
                        <!-- Reset password form start -->
                        <form class="row" action="reset-password-method.php" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <!-- Password input start -->
                            <div class="col">
                                <label class="form-label inter-regular" for="password" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Password</label><br>
                                <input class="form-control" id="password" name="password" type="password" placeholder="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{12,}" title="Must contain at least one number, one uppercase and lowercase letter, and be at least 12 characters long"><br>
                            </div>
                            <div class="col">
                                <label class="form-label inter-regular" for="password_confirmation" style="letter-spacing: 4px; color: #272937; text-transform: uppercase;">Confirm Password</label><br>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="confirm password" required><br>
                            </div>
                            <!-- Password input end -->
                            <div class="row pt-4">
                                <!-- Spacing start -->
                                <div class="col">
                                </div>
                                <!-- Spacing end -->
                                <!-- Buttons start -->
                                <div class="col d-flex justify-content-end align-items-center">
                                    <!-- Back button start -->
                                    <a onclick="location.href='index.php'" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">cancel</a>
                                    <!-- Back button end -->
                                    <!-- Next button start -->
                                    <button type="submit" name="#" value="#" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Reset</p>
                                    </button>
                                    <!-- Next button end -->
                                </div>
                                <!-- Buttons end -->
                            </div>
                        </form>
                        <!-- Reset password form end --> 
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content end -->
        <!-- Footer -->
        <?php include('../assets/footer.php'); ?>
        <!-- Footer end -->
    </body>
</html>