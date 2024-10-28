<?php
session_start();
$_SESSION['logged_in'] = false;
$_SESSION['role'] = 'none';
// Unset all session variables
session_unset();

// Kill the session
session_destroy();
header("Location: ../index.php");
exit();
