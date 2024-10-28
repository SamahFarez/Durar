<?php

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if ($_SESSION['role'] != 'teacher') {
   if ($_SESSION['role'] == 'student') {
      header('Location: ../Student/');
   }
   else if ($_SESSION['role'] == 'administrator') {
      header('Location: ../Admin/');
   }
}