<html>
    <head>
        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="schedule.php">Schedule</a>
            <a class="active" href="timeOff.php">Time Off</a>
            <a href="availability.php">Availability</a>

            <?php
                session_start(); //initialize the session
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ //check if logged in
                    echo "<a href='logout.php'>Sign Out</a>";
                }
                else {
                    header("location: login.php");
                    exit();
                }

                //connect to db
                require("config.php");
                
                //initialize variables and set as empty
                $start = $end = "";
                $start_err = $end_err = "";

                if($_SERVER["REQUEST_METHOD"] == "POST"){  //check if form has been submitted
                    //verify start
                    if(!empty($_POST["start"])){
                        $start = date("Y-m-d H:i:s", strtotime($_POST["start"]));
                        echo $start;
                        if($start < date("Y-m-d H:i:s")) {
                            $start = "";
                            $start_err = "Start date time is before current time.";
                        }
                    }
                    else {
                        $start_err = "Start date time is invalid";
                    }
                    //verify end
                    if(!empty(trim($_POST["end"]))){
                        $end = date("Y-m-d H:i:s", strtotime($_POST["end"]));
                        if($end < date("Y-m-d H:i:s")) {
                            $end = "";
                            $end_err = "End date time is before current time.";
                        }
                        elseif(!empty($start) && $end < $start) {
                            $end = "";
                            $end_err = "End date time is before start time.";
                        }
                    }
                    else {
                        $end_err = "End date time is invalid";
                    }

                    // Check input errors before inserting in database
                    if(empty($start_err) && empty($end_err)){
                        // Prepare an insert statement
                        $sql = "INSERT INTO timeOff (user, start, end) VALUES (?, ?, ?)";
                        
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "iss", $param_user, $param_start, $param_end);
                            
                            // Set parameters
                            $param_user = $_SESSION["id"];
                            $param_start = $start;
                            $param_end = $end;
                            
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                                // Redirect to home page
                                header("location: index.php");
                            } else{
                                echo "<br>Oops! Something went wrong. Please try again later.";
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
                        }
                        else {
                            echo mysqli_error($link);
                        }
                    }
                    // Close connection
                    mysqli_close($link);
                }
            ?>
        </div>
        <title>Time Off</title>
        <h1>Time Off</h1>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Start</label>
                <input type="datetime-local" name="start" class="form-control <?php echo (!empty($start_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $start_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="datetime-local" name="end" class="form-control <?php echo (!empty($end_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $end_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Make Request">
            </div>
        </form>
        <h2>Previous requests</h2>
        <table style="width:100%">
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>Requested</th>
                <th>Status</th>
            <tr>
            <?php
                $result = mysqli_query($link, "SELECT start, end, requested, approval FROM timeOff WHERE user=" . $_SESSION["id"]);

                printf("Select returned %d rows.\n", mysqli_num_rows($result));
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>".$row["start"]."</td><td>".$row["end"]."</td><td>".$row["requested"]."</td><td>".$row["approval"]."</td></tr>";
                }

                // Close connection
                mysqli_close($link);
            ?>
        </table>
    </body>
</html>