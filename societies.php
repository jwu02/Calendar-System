<?php
require "db_connection.php";

require "header.php";
?>

    <div id="society-container">
        <h1>Societies</h1>

        <?php
        //array to store days of the week from monday to friday
        $append_day = array("Monday","Tuesday","Wednesday","Thursday","Friday");

        //for loop to repeat the code within 5 times (for each day)
        for ($day_count = 0; $day_count < 5; $day_count++) {
            //assign id to the day of the week
            echo "<div id='$append_day[$day_count]'>
                <h2>$append_day[$day_count]</h2>";
        
            //sql query to fetch all society details from societies table
            $query_dayCount = $day_count + 1; //to match day values in database
            $query_day = "SELECT * FROM societies WHERE society_day='$query_dayCount';";
            //send sql query to database and store in variable called records
            $records = mysqli_query($db, $query_day);
            
            //while loop to display all societies for each day from database
            while ($society = mysqli_fetch_assoc($records)) {
                echo "<div class='society'>";

                if (isset($_SESSION["logged_in"])) { //if user is logged in
                    echo "<form method='GET'>
                        <input type='submit' value='$society[society_name]' name='edit' />
                        <input type='hidden' value='$society[society_ID]' name='id' />
                    </form>";
                } else {
                    echo "$society[society_name]<br/>";
                }
                
                echo "$society[society_startTime] - $society[society_endTime]<br/>
                    Location: $society[society_location]<br/>
                    $society[society_description]
                </div>";
            }
            echo "</div>";
        }

        $society_request = array (null,null,null,null,null,null,null); //define array
        if (isset($_GET['edit'])) { //if edit variable is defined
            $fetch_id = $_GET['id']; //store id posted in variable for query

            //sql query to fetch record for society clicked
            $query_societyID = "SELECT * FROM societies WHERE society_ID='$fetch_id';";
            $sql = $query_societyID;

            //execute query
            $record = mysqli_query($db, $sql);
            $society_request = mysqli_fetch_row($record);
        }

        if (isset($_SESSION["logged_in"])) { //if user is logged in
        ?>

        <!--input/edit society form-->
        <form id="society-form" class="add-form" onsubmit="return validateTime('start-time','end-time')" action="society_crud.php" method="GET">
            <input type="hidden" value="<?php echo $society_request[0]; ?>" name="id" />
            <input type="text" id="name" placeholder="Society name" value="<?php echo $society_request[1]; ?>" 
            name="name" maxlength="40" required/><br/>

            <select id="day" name="day" required>
                <!--depending on which if statement in php is true that day is selected as the default value when edit button clicked-->         
                <option value="1" <?php if ($society_request[2] == 1) { echo 'selected="selected"';} ?>>Monday</option>
                <option value="2" <?php if ($society_request[2] == 2) { echo 'selected="selected"';} ?>>Tuesday</option>
                <option value="3" <?php if ($society_request[2] == 3) { echo 'selected="selected"';} ?>>Wednesday</option>
                <option value="4" <?php if ($society_request[2] == 4) { echo 'selected="selected"';} ?>>Thursday</option>
                <option value="5" <?php if ($society_request[2] == 5) { echo 'selected="selected"';} ?>>Friday</option>
            </select><br/>

            <input type="time" id="start-time" value="<?php echo $society_request[3]; ?>" name="start_time" /> - 
            <input type="time" id="end-time" value="<?php echo $society_request[4]; ?>" name="end_time" /><br/>
            <input type="text" id="location" placeholder="Location" value="<?php echo $society_request[5]; ?>" 
            name="location" maxlength="30" /><br/>
            <textarea id="description" placeholder="Description" name="description" maxlength="400" rows="5"><?php echo $society_request[6]; ?></textarea><br/>
            
            <?php
            if (isset($_GET['edit'])) { //display save, delete and cancel button if edit variable defined
                echo '<input type="submit" class="header-button" value="Save" name="update" />
                    <input type="submit" id="delete-button" class="delete-button" value="Delete" name="delete" />
                    <input type="submit" formaction="" class="cancel-button" value="Cancel" />';
            } else { //otherwise display add button only
                echo '<input type="submit" id="add-button" class="header-button" value="Add" name="create" />';
            }
            ?>
        </form>

        <?php } ?> <!--close php if statement-->

    </div>

    <script type='text/javascript' src='script.js'></script>
</body>
</html>