<?php
require "db_connection.php";

if (isset($_POST["login"])) {
    //store the username & password in variables
    $username = $_POST["username"];
    $password = $_POST["password"];
  
    //create SQL string using the parameter sent in the page request
    $query_loginDetails = "SELECT * FROM users WHERE `username`='$username' AND `password`='$password';";
    $sql = $query_loginDetails;

    //execute SQL
    $result = mysqli_query($db, $sql);

    //if there is an existing record which matches the username and password entered
    if (mysqli_num_rows($result) == 1) {
        $user_record = mysqli_fetch_assoc($result);
        $_SESSION["logged_in"] = true; //store boolean value in SESSION variable to reuse in website
        $_SESSION["user_ID"] = $user_record["user_ID"];
        $_SESSION["username"] = $username; //store username to use in settings page
  
        echo "Login successful"; //redirect user to main menu page if login OK
        header("Refresh:1; url=index.php"); //redirect user to chosen page after login is successful
    } else {
        echo "Login error";
        header("Refresh:1; url=login.php");
    }
}

