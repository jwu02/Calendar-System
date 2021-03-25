<?php
session_start();

//clear all session data
$_SESSION = array();
session_destroy();

header('Location: index.php'); //direct user back to main menu in logged out state