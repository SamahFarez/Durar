<?php

if ($_SESSION['role'] == 'student') {
   require '../../pages/Student/studentFooter.html';
} else if ($_SESSION['role'] == 'administrator') {
   include '../../pages/Admin/adminFooter.html';
} else if ($_SESSION['role'] == 'teacher') {
   include '../../pages/Teacher/teacherFooter.html';
}