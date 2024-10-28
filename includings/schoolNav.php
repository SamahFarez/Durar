<?php

if ($_SESSION['role'] == 'student') {
   require '../../pages/Student/studentNav.html';
} else if ($_SESSION['role'] == 'administrator') {
   include '../../pages/Admin/adminNav.html';
} else if ($_SESSION['role'] == 'teacher') {
   include '../../pages/Teacher/teacherNav.html';
}