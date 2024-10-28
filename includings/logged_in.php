<?php

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
// this is used to redirect logged in users directly from landing page (index.php)

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
   // User is already logged in, redirect to their main page
   if (isset($_SESSION['role']) && $_SESSION['role'] == 'teacher') {
      header('Location: pages/Teacher/');
   } elseif (isset($_SESSION['role']) && $_SESSION['role']  == 'student') {
      header('Location: pages/Student/');
   } elseif (isset($_SESSION['role']) && $_SESSION['role']  == 'administrator') {
      header('Location: pages/Admin/');
   }
   exit;
} else {
   // User is not logged in
}
