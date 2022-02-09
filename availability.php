<html>
    <head>
        <div class="topnav">
            <a href="index.php">Home</a>
            <a href="schedule.php">Schedule</a>
            <a href="timeOff.php">Time Off</a>
            <a class="active" href="availability.php">Availability</a>
            <?php
                session_start(); //initialize the session
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ //check if logged in
                    echo "<a href='logout.php'>Sign Out</a></div>";
                }
                else {
                    header("location: login.php");
                    exit();
                }

                //connect to db
                require("config.php");
                
                //initialize variables and set as empty
                $start = $end = $startDate = "";
                $sundayStart_err = $sundayEnd_err = "";
                $mondayStart_err = $mondayEnd_err = "";
                $tuesdayStart_err = $tuesdayEnd_err = "";
                $wednesdayStart_err = $wednesdayEnd_err = "";
                $thursdayStart_err = $thursdayEnd_err = "";
                $fridayStart_err = $fridayEnd_err = "";
                $saturdayStart_err = $saturdaydayEnd_err = "";

                if($_SERVER["REQUEST_METHOD"] == "POST") {  //check if form has been submitted
                    //verify startDate
                    if(!empty($_POST["startDate"])) {
                        $startDate = date("Y-m-d", strtotime($_POST["startDate"]));
                        if($startDate < date("Y-m-d")) {
                            $startDate = "";
                            $startDate_err = "Start date is before today.";
                        }
                    }
                    else {
                        $startDate_err = "Start date is invalid";
                    }

                    //only continue if startDate is valid
                    if(empty($startDate_err)) {

                        //-------------------------Sunday-------------------------//
                        //validate start
                        if(!empty($_POST["sundayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["sundayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $sundayStart_err = "Sunday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $sundayStart_err = "Sunday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $sundayStart_err = "Sunday start time is invalid.";
                        }
                        //validate end
                        if(empty($sundayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["sundayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["sundayEnd"]));
                                if($end < $start){
                                    $sundayEnd_err = "Sunday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $sundayEnd_err = "Sunday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $sundayEnd_err = "Sunday start time is invalid.";
                            }
                        }
                        else {
                            $sundayEnd_err = "Sunday start time is invalid therefore so is Sunday end time.";
                        }
                        //insert into db
                        if(empty($sundayStart_err) && empty($sundayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "SUNDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Sunday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        //-------------------------Monday-------------------------//
                        //validate start
                        if(!empty($_POST["mondayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["mondayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $mondayStart_err = "Monday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $mondayStart_err = "Monday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $mondayStart_err = "Monday start time is invalid.";
                        }
                        //validate end
                        if(empty($mondayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["mondayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["mondayEnd"]));
                                if($end < $start){
                                    $mondayEnd_err = "Monday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $mondayEnd_err = "Monday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $mondayEnd_err = "Monday start time is invalid.";
                            }
                        }
                        else {
                            $mondayEnd_err = "Monday start time is invalid therefore so is Monday end time.";
                        }
                        //insert into db
                        if(empty($mondayStart_err) && empty($mondayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "MONDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Monday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        //-------------------------Tuesday-------------------------//
                        //validate start
                        if(!empty($_POST["tuesdayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["tuesdayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $tuesdayStart_err = "Tuesday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $tuesdayStart_err = "Tuesday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $tuesdayStart_err = "Tuesday start time is invalid.";
                        }
                        //validate end
                        if(empty($tuesdayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["tuesdayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["tuesdayEnd"]));
                                if($end < $start){
                                    $tuesdayEnd_err = "Tuesday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $tuesdayEnd_err = "Tuesday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $tuesdayEnd_err = "Tuesday start time is invalid.";
                            }
                        }
                        else {
                            $tuesdayEnd_err = "Tuesday start time is invalid therefore so is Monday end time.";
                        }
                        //insert into db
                        if(empty($tuesdayStart_err) && empty($tuesdayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "TUESDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Tuesday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        //-------------------------Wednesday-------------------------//
                        //validate start
                        if(!empty($_POST["wednesdayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["wednesdayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $wednesdayStart_err = "Wednesday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $wednesdayStart_err = "Wednesday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $wednesdayStart_err = "Wednesday start time is invalid.";
                        }
                        //validate end
                        if(empty($wednesdayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["wednesdayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["wednesdayEnd"]));
                                if($end < $start){
                                    $wednesdayEnd_err = "Wednesday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $wednesdayEnd_err = "Wednesday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $wednesdayEnd_err = "Wednesday start time is invalid.";
                            }
                        }
                        else {
                            $wednesdayEnd_err = "Wednesday start time is invalid therefore so is Wednesday end time.";
                        }
                        //insert into db
                        if(empty($wednesdayStart_err) && empty($wednesdayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "WEDNESDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Wednesday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        //-------------------------Thursday-------------------------//
                        //validate start
                        if(!empty($_POST["thursdayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["thursdayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $thursdayStart_err = "Thursday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $thursdayStart_err = "Thursday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $thursdayStart_err = "Thursday start time is invalid.";
                        }
                        //validate end
                        if(empty($thursdayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["thursdayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["thursdayEnd"]));
                                if($end < $start){
                                    $thursdayEnd_err = "Thursday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $thursdayEnd_err = "Thursday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $thursdayEnd_err = "Thursday start time is invalid.";
                            }
                        }
                        else {
                            $thursdayEnd_err = "Thursday start time is invalid therefore so is Thursday end time.";
                        }
                        //insert into db
                        if(empty($thursdayStart_err) && empty($thursdayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "THURSDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Thursday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        //-------------------------Friday-------------------------//
                        //validate start
                        if(!empty($_POST["fridayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["fridayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $fridayStart_err = "Friday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $fridayStart_err = "Friday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $fridayStart_err = "Friday start time is invalid.";
                        }
                        //validate end
                        if(empty($fridayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["fridayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["fridayEnd"]));
                                if($end < $start){
                                    $fridayEnd_err = "Friday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $fridayEnd_err = "Friday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $fridayEnd_err = "Friday start time is invalid.";
                            }
                        }
                        else {
                            $fridayEnd_err = "Friday start time is invalid therefore so is Friday end time.";
                        }
                        //insert into db
                        if(empty($fridayStart_err) && empty($fridayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "FRIDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Friday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        //-------------------------Saturday-------------------------//
                        //validate start
                        if(!empty($_POST["saturdayStart"])) {
                            $start = date("H:i:s", strtotime($_POST["saturdayStart"]));
                            if($start < date("H:i:s", strtotime("00:00:00"))){
                                $saturdayStart_err = "Saturday start time is before 00:00:00 and therefore invalid. Input was " . $start;
                            }
                            elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                $saturdayStart_err = "Saturday start time is after 23:59:59 and therefore invalid. Input was " . $start;
                            }
                        }
                        else {
                            $saturdayStart_err = "Saturday start time is invalid.";
                        }
                        //validate end
                        if(empty($saturdayStart_err)) { //end time is invalid if start time is invalid
                            if(!empty($_POST["saturdayEnd"])) {
                                $end = date("H:i:s", strtotime($_POST["saturdayEnd"]));
                                if($end < $start){
                                    $saturdayEnd_err = "Saturday end time is before start time and therefore invalid.";
                                }
                                elseif($start > date("H:i:s", strtotime("23:59:59"))) {
                                    $saturdayEnd_err = "Saturday start time is after 23:59:59 and therefore invalid. Input was " . $end;
                                }
                            }
                            else {
                                $saturdayEnd_err = "Saturday start time is invalid.";
                            }
                        }
                        else {
                            $saturdayEnd_err = "Saturday start time is invalid therefore so is Saturday end time.";
                        }
                        //insert into db
                        if(empty($saturdayStart_err) && empty($saturdayEnd_err)) {
                            // Prepare an insert statement
                            $sql = "INSERT INTO availability (user, day, start, end, startDate) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "issss", $param_user, $param_day, $param_start, $param_end, $param_startDate);
                                
                                // Set parameters
                                $param_user = $_SESSION["id"];
                                $param_day = "SATURDAY";
                                $param_start = $start;
                                $param_end = $end;
                                $param_startDate = $startDate;
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Notify of success
                                    echo "Saturday availability successfully updated!";
                                } else{
                                    echo "<br>Oops! Something went wrong. Please try again later.";
                                }

                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                //print error
                                echo mysqli_error($link);
                            }
                        }

                        
                    }
                    // Close connection
                    mysqli_close($link);
                }
            ?>
        <title>Availability</title>
        <h1>Availability</h1>
    </head>
    <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Availibility starting on </label>
                <input type="date" name="startDate" class="form-control <?php echo (!empty($startDate_err)) ? 'is-invalid' : ''; ?>" step=1>
                <span class="invalid-feedback"><?php echo $startDate_err; ?></span>
            </div>

            <label>Sunday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="sundayStart" class="form-control <?php echo (!empty($sundayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $sundayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="sundayEnd" class="form-control <?php echo (!empty($sundayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $sundayEnd_err; ?></span>
            </div>

            <label>Monday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="mondayStart" class="form-control <?php echo (!empty($mondayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $mondayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="mondayEnd" class="form-control <?php echo (!empty($mondayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $mondayEnd_err; ?></span>
            </div>

            <label>Tuesday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="tuesdayStart" class="form-control <?php echo (!empty($tuesdayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $tuesdayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="tuesdayEnd" class="form-control <?php echo (!empty($tuesdayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $tuesdayEnd_err; ?></span>
            </div>

            <label>Wednesday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="wednesdayStart" class="form-control <?php echo (!empty($wednesdayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $wednesdayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="wednesdayEnd" class="form-control <?php echo (!empty($wednesdayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $wednesdayEnd_err; ?></span>
            </div>

            <label>Thursday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="thursdayStart" class="form-control <?php echo (!empty($thursdayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $thursdayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="thursdayEnd" class="form-control <?php echo (!empty($thursdayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $thursdayEnd_err; ?></span>
            </div>

            <label>Friday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="fridayStart" class="form-control <?php echo (!empty($fridayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $fridayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="fridayEnd" class="form-control <?php echo (!empty($fridayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $fridayEnd_err; ?></span>
            </div>

            <label>Saturday</label>
            <div class="form-group">
                <label>Start</label>
                <input type="time" name="saturdayStart" class="form-control <?php echo (!empty($saturdayStart_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $saturdayStart_err; ?></span>
            </div>
            <div class="form-group">
                <label>End</label>
                <input type="time" name="saturdayEnd" class="form-control <?php echo (!empty($saturdayEnd_err)) ? 'is-invalid' : ''; ?>" step=60>
                <span class="invalid-feedback"><?php echo $saturdayEnd_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Make Request">
            </div>
        </form>
        <h2>Previous requests</h2>
        <table style="width:100%">
            <tr>
                <th>Day</th>
                <th>Start</th>
                <th>End</th>
                <th>Date starting</th>
                <th>Requested on</th>
                <th>Status</th>
            <tr>
            <?php
                $result = mysqli_query($link, "SELECT day, start, end, startDate, dateRequested, approval, supervisor, approvalTime FROM availability WHERE user=" . $_SESSION["id"]);

                printf("Select returned %d rows.\n", mysqli_num_rows($result));
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>".$row["day"]."</td><td>".$row["start"]."</td><td>".$row["end"]."</td><td>".$row["startDate"]."</td><td>".$row["dateRequested"]."</td><td>".$row["approval"]."</td><td>".$row["supervisor"]."</td><td>".$row["approvalTime"]."</td></tr>";
                }

                // Close connection
                mysqli_close($link);
            ?>
        </table>
    </body>
</html>