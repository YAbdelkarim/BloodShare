<?php
session_start();
unset($_SESSION['logged_in']);  

// Unset all of the session variables.
$_SESSION = array();
 
// Destroy the session.
session_destroy();
       unset($_SESSION['logged_in']);  

// Redirect to login page
header("Location: ../");
exit;
?>