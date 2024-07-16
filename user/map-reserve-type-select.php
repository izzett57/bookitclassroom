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
        <link rel="stylesheet" href="../assets/css/entry.css"/>
        <!-- Import CSS file(s) end -->

        <title>Reserve - Type - BookItClassroom</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <body>
        <!-- Nav bar start -->
        <?php 
            include('../assets/navbar-user-back.php');
        ?>
        <!-- Nav bar end -->

        <!-- Main content start -->
        <div class="container main-content bg-white rounded-3 d-flex flex-column justify-content-center">
            <div class="row justify-content-evenly">
                    <!-- Text start -->
                    <div class="row d-flex justify-content-center mb-5 text-center">
                        <!-- Heading -->
                        <span class="heading1" style="padding-bottom: 30px;">Choose Reserve Type</span>
                        <!-- Subheading -->
                        <span class="subheading1" style="width: 70%;">Would you like to reserve for a single timeslot or the whole semester?</span>
                    </div>
                    <!-- Text end -->
                <div>
                    <div class="container">
                        <!-- Reserve type form start -->
                        <form class="row">
                            <!-- Spacing start -->
                            <div class="col"></div>
                            <!-- Spacing end -->
                            <!-- Buttons start -->
                            <div class="col">
                            <button type="button" name="" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                                <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Single Booking</p>
                                <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-1-circle-fill primary"></i>
                                </span>
                            </button>
                            </div>
                            <!-- Buttons end -->
                            <!-- Buttons start -->
                            <div class="col">
                            <button type="button" name="" class="btn custom-btn-rtype btn-lg d-flex align-items-center justify-content-between mb-3" style="border-radius: 36px;">
                                <p class="dongle-regular mt-2" style="font-size: 3rem; flex-grow: 1;">Whole Semester</p>
                                <span class="bg-light d-flex rounded-5 align-items-center justify-content-center" style="font-size: 1.5rem;">
                                <i class="bi bi-calendar-week primary"></i>
                                </span>
                            </button>
                            </div>
                            <!-- Buttons end -->
                            <!-- Spacing start -->
                            <div class="col"></div>
                            <!-- Spacing end -->
                        </form>
                        <!-- Reserve type form end -->
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
