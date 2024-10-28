<?php

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if ($_SESSION['role'] == 'student') {
   $stmt = mysqli_prepare($conn, "SELECT school_id from student
                                 where student_email=?");
}
else if ($_SESSION['role'] == 'teacher') {
   $stmt = mysqli_prepare($conn, "SELECT school_id from teacher
                                 where teacher_email=?");
}
else if ($_SESSION['role'] == 'administrator') {
   $stmt = mysqli_prepare($conn, "SELECT school_id from administrator
                                 where admin_email=?");
}

mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rowResult = mysqli_fetch_assoc($result);
$_SESSION['school_id'] = $rowResult['school_id'];

if ($_SESSION['school_id']) {
   header("Location: index.php");
} else {
   // nothing
}
