
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

        <title>Home - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-guest.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                <div class="col-7 d-flex justify-content-center align-items-center">
                    <!-- Text start -->
                    <div>
                        <!-- Heading -->
                        <div class="heading1"><p>Welcome, Guest!</p></div>
                        <!-- Subheading -->
                        <div class="subheading1"><p>What would you like to do today?</p></div>
                    </div>
                    <!-- Text end -->
                </div>
                <div class="col d-flex flex-column align-items-center justify-content-center">
                    <!-- View map button start -->
                    <button onclick="location.href='select-floor.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">View Map</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-pin-map-fill primary"></i>
                        </span>
                    </button>
                    <!-- View map button end -->
                    <!-- Login button -->
                    <button onclick="location.href='login.php'" type="button" class="btn custom-btn btn-lg d-flex align-items-center justify-content-between" style="border-radius: 36px;">
                        <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Login</p>
                        <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                            <i class="bi bi-box-arrow-in-right primary"></i>
                        </span>
                    </button>
                    <!-- Login button end -->
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
