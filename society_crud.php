<?php
require "db_connection.php";

//variable names to check
$variable_name = array ("id","name","day","start_time","end_time","location","description");
 
foreach ($variable_name as $value) { //check each variable name in array variable_name
    if (isset($_GET[$value])) { 
        $$value = $_GET[$value]; //$$ changes the strings to a variable to check if data is entered and set it to that value
    } else {
        $$value = NULL; //otherwise set it to null
    }
}

//array storing the operation words concatenated in message later
$operation = array("create","created","update","updated","delete","deleted");

//create society
if (isset($_GET["create"])) {
    //define the operation used, to use to return a message later
    $op_index = 0;
    $operation[$op_index];

    //query to insert data into database
    $insertSociety_sql = "INSERT INTO societies (society_name,society_day,society_startTime,society_endTime,society_location,society_description) 
    VALUES ('$name','$day','$start_time','$end_time','$location','$description');";
    $sql = $insertSociety_sql;
}

//update society
if (isset($_GET["update"])) {
    $op_index = 2;
    $operation[$op_index];

    //query to update society details in database
    $updateSociety_sql = "UPDATE societies 
    SET society_name='$name', society_day='$day', society_startTime='$start_time', society_endTime='$end_time', 
    society_location='$location', society_description='$description' WHERE society_ID='$id';";
    $sql = $updateSociety_sql;
}

//delete society
if (isset($_GET["delete"])) {
    $op_index = 4;
    $operation[$op_index];

    //query to delete society from database
    $query_deleteSociety = "DELETE FROM societies WHERE society_ID='$id';";
    $sql = $query_deleteSociety;
}

//execute the sql statement and check if it was successfully executed
if (mysqli_query($db, $sql)) {
    echo "Society ".$operation[$op_index+1]; //then a message is returned to the browser
} else {
    echo "Failed to ".$operation[$op_index]." society";
}
//the page is refrehsed in 1 seconds and lead the user back to the main menu
header("refresh: 1; url=societies.php");