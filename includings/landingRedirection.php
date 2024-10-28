<?php

// this is used to prevent non logged in users from accesing unauthorized places
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if ($_SESSION['logged_in']) {
   // User is already logged in, redirected to their main page
   
} else {
   // User is not logged in, redirect to the landing page
   header('Location: ../../index.php');
   exit;
}
