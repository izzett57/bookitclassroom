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

    <title>Login - BookItClassroom</title>
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
                    <div class="heading1"><p>Sign In</p></div>
                    <!-- Subheading -->
                    <div class="subheading1"><p>Please enter your credentials.</p></div>
                </div>
                <!-- Text end -->
            </div>
            <div class="col d-flex flex-column">
                <div class="container w-75">
                    <!-- Sign in form start -->
                    <form class="row" action="login-method.php" method="post">
                        <!-- Email input start -->
                        <div>
                            <label class="form-label inter-regular pt-2" for="email" style="letter-spacing: 4px; color: #272937;">EMAIL</label><br>
                            <input class="form-control" id="email" type="email" name="email" placeholder="email" required><br>
                        </div>
                        <!-- Email input end -->
                        <!-- Password input start -->
                        <div>
                            <label class="form-label inter-regular" for="password" style="letter-spacing: 4px; color: #272937;">PASSWORD</label><br>
                            <input class="form-control" id="password" type="password" name="password" placeholder="password" required>
                        </div>
                        <!-- Password input end -->
                        <!-- Forgot password start -->
                        <div>
                            <a class="inter-regular" href="forgot-password.php" style="text-decoration: none; font-size: 0.9rem; color: rgba(218, 116, 34, 0.75);">Forgot your password?</a>
                        </div>
                        <!-- Forgot password end -->
                        <div class="row pt-4">
                            <!-- Spacing start -->
                            <div class="col"></div>
                            <!-- Spacing end -->
                            <!-- Buttons start -->
                            <div class="col d-flex justify-content-end align-items-center">
                                <!-- Register button start -->
                                <a class="dongle-regular custom-btn-inline me-3 mt-2 primary" href="register-name.php" style="text-decoration: none; font-size: 2rem">register</a>
                                <!-- Register button end -->
                                <!-- Login button start -->
                                <button type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                    <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Login</p>
                                </button>
                                <!-- Login button end -->
                            </div>
                            <!-- Buttons end -->
                        </div>
                    </form>
                    <!-- Sign in form end -->
                    <!-- Display error message if any -->
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
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
