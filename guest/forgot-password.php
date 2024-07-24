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

        <title>Forgot Password - BookItClassroom</title>
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
                        <span class="heading1" style="padding-bottom: 15px;">Forgotten your password?</span>
                        <!-- Subheading -->
                        <span class="subheading1" style="padding-right: 400px;">Please enter your email.</span>
                    </div>
                    <!-- Text end -->
                <div class="row-auto d-flex flex-column">
                    <div class="container" style="width: 35%;">
                        <!-- Forgot password form start -->
                        <form class="row" method= "POST" action="send-password-reset.php">
                            <!-- Email input start -->
                            <div class="col">
                                <label class="form-label inter-regular" for="Email" style="letter-spacing: 4px; color: #272937;">EMAIL</label><br>
                                <input class="form-control" id="Email" name="Email" type="text" placeholder="email"><br>
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
                                    <a onclick="history.back()" class="dongle-regular custom-btn-inline me-3 mt-2 primary" style="text-decoration: none; font-size: 2rem; cursor: pointer;">back</a>
                                    <!-- Back button end -->
                                    <!-- Next button start -->
                                    <button href='send-password-reset.php'" type="submit" class="btn btn-lg custom-btn-noanim d-flex align-items-center justify-content-between">
                                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Next</p>
                                    </button>
                                    <!-- Next button end -->
                                </div>
                                <!-- Buttons end -->
                            </div>
                        </form>
                        <!-- Forgot password form end --> 
                         <!--display error message if any is  found-->
                        <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
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
