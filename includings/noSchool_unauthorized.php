<?php

// this prevents users that have no school yet from
// entering unauthorized pages
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if (!isset($_SESSION['school_id'])) {
   if ($_SESSION['role'] == 'student') {
      header("Location: ../../pages/Student/confirmStudent.php");
   }
   else if ($_SESSION['role'] == 'teacher') {
      header("Location: ../../pages/Teacher/confirmTeacher.php");
   }
   else if ($_SESSION['role'] == 'administrator') {
      header("Location: ../../pages/Admin/");
   }
}