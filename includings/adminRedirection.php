<?php

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if ($_SESSION['role'] != 'administrator') {
   if ($_SESSION['role'] == 'teacher') {
      header('Location: ../Teacher/');
   }
   else if ($_SESSION['role'] == 'student') {
      header('Location: ../Student/');
   }
}