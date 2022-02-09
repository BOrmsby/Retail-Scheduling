<html>
    <head>
        <div class="topnav">
            <a href="index.php">Home</a>
            <a class="active" href="schedule.php">Schedule</a>
            <a href="timeOff.php">Time Off</a>
            <a href="availability.php">Availability</a>
            <?php
                session_start(); //initialize the session
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ //check if logged in
                    echo "<a href='logout.php'>Sign Out</a>";
                }
                else {
                    header("location: login.php");
                    exit();
                }?>
        </div>
        <title>Schedule</title>
        <h1>Schedule</h1>
    </head>
    <body>
        Your schedule will appear here.
    </body>
</html>