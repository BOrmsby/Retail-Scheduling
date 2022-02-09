<html>
    <head>
        <div class="topnav">
            <a class="active" href="index.php">Home</a>
            <a href="schedule.php">Schedule</a>
            <a href="timeOff.php">Time Off</a>
            <a href="availability.php">Availability</a>
            <?php
                session_start(); //initialize the session
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ //check if logged in
                    if(isset($_SESSION["scheduler"]) && count($_SESSION["scheduler"]) > 0) {
                        echo "<a href='requests.php'>View Requests</a><a href='makeSchedule.php'>Make Schedule</a>";
                    }
                    echo "<a href='logout.php'>Sign Out</a>";
                }
                else {
                    header("location: login.php");
                    exit();
                }
            ?>
        </div>
        <title>Home</title>
        <h1>Home</h1>
    </head>
    <body>
        TODO: Add stuff<br>
    </body>
</html>