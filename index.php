<?php
require "db_connection.php";

require "header.php"
?>

    <div id="event-container">
        <table id="calendar">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>

            <tr>
            <?php
                function createEventStrip($event) {
                    /*event name strips implemented as submit buttons, to reload current page 
                    and pass unique id of event clicked to query*/
                    echo "<form method='POST'>
                        <input class='event-strip' type='submit' value='$event[event_name]' name='submit' /><br/>
                        <input type='hidden' value='$event[event_ID]' name='id' />
                    </form>";
                }

                $day = date('w', strtotime(date('Y-m'))); /*return a numeric representation of the first day 
    of the month (0 for Sunday, 6 for Saturday)*/
                $createdBlock_counter = 0; //to count the number of date blocks created in order move down a row when full
                for ($x = 0; $x < $day; $x++) {
                    echo "<td></td>"; //create empty date blocks
                    $createdBlock_counter++;
                }

                $total_days = (int)date('t'); //return the number of days in the given month as an integer
                $date = 1;
                
                //variables to be used as part of the query
                $current_month = date('m');
                $current_year = date('Y');

                //loop for creating dateblocks with appropriate dates
                while ($date < $total_days) {

                    //move on to a new line when 7 blocks in a row are created and stop when end of the month reached
                    while ($createdBlock_counter != 7 and $date <= $total_days) {
                        //convert a single character date to two characters 'dd'
                        $current_date = (string) $date;
                        $current_date_length = strlen($current_date);
                        if ($current_date_length = 1) {
                            $current_date = "0".$current_date;
                        }
                        
                        //sql query to select all data from events table, which updates everytime for a new date block
                        $query_date = "SELECT * FROM events WHERE event_date='$current_year-$current_month-$current_date';";
                        $sql = $query_date;
                        //send sql query to database and store in variable called records
                        $records = mysqli_query($db, $sql);

                        //create new date block with date label
                        echo "<td><input type='button' value='$date'";
                        
                        if (isset($_SESSION["logged_in"])) { //if user is logged in
                            echo "onclick='show(\"event-form\")'";
                        }
                        
                        echo " /></br>";
                        
                        //loop for displaying events in the blocks
                        $strip_counter = 0; //reset strip counter for each date block

                        /*store result of query in varaible $event, check if there are any more records 
                        and if the maxmimum number of allowed strips exceeded*/
                        while (($strip_counter < 3) && ($event = mysqli_fetch_assoc($records))) {
                            createEventStrip($event);
                            $strip_counter++; //record the number of strips created
                        }
                        
                        //check if there is another event to be displayed
                        if ($temp1 = mysqli_fetch_assoc($records)) {
                            if ($temp2 = mysqli_fetch_assoc($records)) {//check if there is another event to be displayed
                                //if so, create an ellipsis strip
                                echo "<form method='POST'>
                                    <input class='ellipsis-strip' type='submit' value='. . .' name='more_events' /><br/>
                                    <input type='hidden' value='$current_date' name='current_date' />
                                </form>";
                            } else {
                                createEventStrip($temp1); //if there aren't then an ellipsis strip is not needed
                            }
                        }

                        echo "</td>"; //close table data element after all events displayed in a single date block
                        $date++;
                        $createdBlock_counter++;
                    }

                    //reset counter
                    $createdBlock_counter = 0;
                    //close the table row and create a new one
                    echo "</tr>";
                    echo "<tr>";
                }
                echo "</tr>";
            ?>
        </table>
        
        <div id="daily-view">
            <h3><u>Daily view</u></h3>
            <?php
                //check more_events name exist (if ellipsis strip clicked)
                if(isset($_POST['more_events'])) {
                    $fetch_date = $_POST['current_date'];
                    displayExtraEvents($db, $fetch_date);
                }

                //function to display all events in the daily view panel
                function displayExtraEvents($db, $fetch_date) {
                    //variables to be used as part of the query
                    $current_month = date('m');
                    $current_year = date('Y');

                    //sql query to select all data from events table
                    $query_date = "SELECT * FROM events WHERE event_date='$current_year-$current_month-$fetch_date';";
                    $sql = $query_date;
                    //send sql query to database and store in variable called records
                    $records = mysqli_query($db, $sql);

                    //loop to display all events for the particular day
                    while ($event = mysqli_fetch_assoc($records)) {
                        createEventStrip($event);
                    }
                }
            ?>
        </div>
    </div>

    <?php
    //test for existence of 'submit' variable
    if(isset($_POST['submit'])) {
        $fetch_id = $_POST['id']; //store id posted in variable for query
        showEvent($fetch_id, $db);
    }

    //function to display more information of the event clicked
    function showEvent($fetch_id, $db) {
        //sql query to fetch record for event clicked
        $query_eventID = "SELECT * FROM events WHERE event_ID='$fetch_id';";
        $sql = $query_eventID;

        //execute query
        $record = mysqli_query($db, $sql);
        $event_request = mysqli_fetch_row($record);

        //display event information in a div container
        echo "<div id='event-info' class='add-form'>
            {$event_request[1]}
            <button id='close-button' onclick='hide(\"event-info\")'>×</button><br/>
            {$event_request[2]}<br/>
            {$event_request[3]} - {$event_request[4]}<br/>
            {$event_request[5]}<br/>
            {$event_request[6]}<br/>";

        if (isset($_SESSION["logged_in"])) { //if user is logged in
            echo "<form onsubmit='return deleteConfirmation()' action='event_crud.php' method='GET'>
                    <input type ='button' id='edit-button' class='header-button' value='Edit' onclick='show(\"edit-form\")' />
                    <input type='submit' id='delete-button' class='delete-button' value='Delete' name='delete' />
                    <input type='hidden' value='{$event_request[0]}' name='id'/>
                </form>";
        }

        echo "</div>";

        if (isset($_SESSION["logged_in"])) { //if user is logged in
            //pass array of record fetched to function editEvent()
            editEvent($event_request);
        }
    }

    //function to create form with event details in inputs boxes which already filled in for user to edit
    function editEvent($event_request) {
        echo "<form id='edit-form' class='add-form' onsubmit='return validateTime(\"edit-startTime\",\"edit-endTime\")' action='event_crud.php' method='GET' style='display: none;'>
            <input type='hidden' value='{$event_request[0]}' name='id'/>
            <input type='text' id='edit-name' value='{$event_request[1]}' name='name' maxlength='40' required /><br/>
            <input type='date' id='edit-date' value='{$event_request[2]}' name='date' min='".date('Y-m-d')."' required /><br/>
            <input type='time' id='edit-startTime' value='{$event_request[3]}' name='start_time' /> - 
            <input type='time' id='edit-endTime' value='{$event_request[4]}' name='end_time' /><br/>
            <input type='text' id='edit-location' value='{$event_request[5]}' name='location' maxlength='30' /><br/>
            <input type='text' id='edit-description' value='{$event_request[6]}' name='description' maxlength='400' /><br/>

            <input type='submit' id='save-button' class='header-button' value='Save' name='update' />
            <input type='button' class='cancel-button' value='Cancel' onclick='hide(\"edit-form\")' />
        </form>";
    }
    ?>

    <!--input event form-->
    <form id="event-form" class="add-form" onsubmit="return validateTime('start-time','end-time')" action="event_crud.php" method="GET">
        <input type="text" id="name" placeholder="Event name" name="name" maxlength="40" required/><br/>
        <input type="date" id="date" name="date" min="<?php echo date('Y-m-d')?>" required /><br/>
        <input type="time" id="start-time" name="start_time" /> - 
        <input type="time" id="end-time" name="end_time" /><br/>
        <input type="text" id="location" placeholder="Location" name="location" maxlength="30" /><br/>
        <textarea id="description" placeholder="Description" name="description" maxlength="400" rows="5"></textarea><br/>

        <input type="submit" class='header-button' value="Add" name="create" />
        <input type="button" class='cancel-button' value="Cancel" onclick="hide('event-form')" />
    </form>

    <script type='text/javascript' src='script.js'></script>
</body>
</html>