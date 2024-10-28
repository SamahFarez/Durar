<?php

session_start();

include '../head.php';
include '../init.php';


if ($_SESSION['confirmationCode'] == $_POST['otp']) {
    $newEmail = $_SESSION['newEmail'];
    $email = mysqli_real_escape_string($conn, $newEmail);
    // Update the bio in the database
    if ($_SESSION['role'] == 'student')
        $update_email_query = "UPDATE student SET student_email = '$newEmail' WHERE student_email = '{$_SESSION['email']}'";
    if ($_SESSION['role'] == 'teacher')
        $update_email_query = "UPDATE teacher SET teacher_email = '$newEmail' WHERE teacher_email = '{$_SESSION['email']}'";
    if ($_SESSION['role'] == 'administrator')
        $update_email_query = "UPDATE administrator SET admin_email = '$newEmail' WHERE admin_email = '{$_SESSION['email']}'";
    $result = mysqli_query($conn, $update_email_query);
    $_SESSION['email'] = $newEmail;
    if ($result) {
        // Redirect to the page where the bio was updated

        if ($_SESSION['role'] == 'administrator')
            header("Location: ../pages/Admin/profile.php");
        if ($_SESSION['role'] == 'teacher')
            header("Location: ../pages/Teacher/profile.php");
        if ($_SESSION['role'] == 'student')
            header("Location: ../pages/Student/profile.php");
        exit();
    } else {
        echo 'حدث خطأ خلال تغيير بريدكم الالكتروني، نرجو منكم المحاولة مرة أخرى';
    }
} else {
    echo "<script>alert('إن رمز التحقق الذي أدخلتموه خاطئ'); history.go(-1);</script>";
    exit;
}

?>