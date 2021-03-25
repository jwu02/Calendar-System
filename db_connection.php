<?php
session_start();

//defining variables to be used later to connect to db
$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "calendarsystem";

//connecting to mySQL database, die outputs whatever message written if the connection attempt failed
$db = mysqli_connect($db_host,$db_username,$db_pass) or die("Could not connect to MySQL");

//select the database we will be using
$chosen_db = mysqli_select_db($db, $db_name) or die("No database");