<?php
require "db_connection.php";

//variable names to check
$variable_name = array ("id","name","date","start_time","end_time","location","description");
 
foreach ($variable_name as $value) { //check each variable name in array variable_name
    if (isset($_GET[$value])) { 
        $$value = $_GET[$value]; //$$ changes the strings to a variable to check if data is entered and set it to that value
    } else {
        $$value = NULL; //otherwise set it to null
    }
}

//array storing the operation words concatenated in message later
$operation = array("create","created","update","updated","delete","deleted");

//create event
if (isset($_GET["create"])) {
    //define the operation used, to use to return a message later
    $op_index = 0;
    $operation[$op_index];

    //query to insert data into database
    $insertEvent_sql = "INSERT INTO events (event_name,event_date,event_startTime,event_endTime,event_location,event_description) 
    VALUES ('$name','$date','$start_time','$end_time','$location','$description');";
    $sql = $insertEvent_sql;
}

//update event
if (isset($_GET["update"])) {
    $op_index = 2;
    $operation[$op_index];

    //query to update event details in database
    $updateEvent_sql = "UPDATE events 
    SET event_name='$name', event_date='$date', event_startTime='$start_time', event_endTime='$end_time', 
    event_location='$location', event_description='$description' WHERE event_ID='$id';";
    $sql = $updateEvent_sql;
}

//delete event
if (isset($_GET["delete"])) {
    $op_index = 4;
    $operation[$op_index];

    //query to delete event from database
    $query_deleteEvent = "DELETE FROM events WHERE event_ID='$id';";
    $sql = $query_deleteEvent;
}

//execute the sql statement and check if it was successfully executed
if (mysqli_query($db, $sql)) {
    echo "Event ".$operation[$op_index+1]; //then a message is returned to the browser
} else {
    echo "Failed to ".$operation[$op_index]." event";
}
//the page is refrehsed in 1 seconds and lead the user back to the main menu
header("refresh:1; url=index.php");