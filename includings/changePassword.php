<?php

include '../head.php';
include '../init.php';
include 'functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $passwordHash = password_hash($currentPassword, PASSWORD_DEFAULT);
    $errors = array();

    if (strlen($newPassword) < 8) {
        array_push($errors, "يجب أن تتكون كلمة المرور الجديدة من 8 أحرف على الأقل");
    }
    
    // Validate the current password
    $userRow = get_user_row($_SESSION['email'], $_SESSION['role'], $conn);
    if ($_SESSION['role'] == 'administrator') {
        $passwordHash = $userRow['admin_password'];
    } else {
        $passwordHash = $userRow[$_SESSION['role'] . '_password'];
    }
    
    if (password_verify($currentPassword, $passwordHash)) {
        // Current password is correct
        if ($newPassword === $confirmPassword) {
            // Update the password in the database
            $newPassword = mysqli_real_escape_string($conn, $newPassword);
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($_SESSION['role'] == 'student')
                $updateQuery = "UPDATE student SET student_password = '$hashedNewPassword' WHERE student_email = '{$_SESSION['email']}'";
            if ($_SESSION['role'] == 'teacher')
                $updateQuery = "UPDATE teacher SET teacher_password = '$hashedNewPassword' WHERE teacher_email = '{$_SESSION['email']}'";
            if ($_SESSION['role'] == 'administrator')
                $updateQuery = "UPDATE administrator SET admin_password = '$hashedNewPassword' WHERE admin_email = '{$_SESSION['email']}'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Password updated successfully
                if ($_SESSION['role'] == 'student')
                    header('Location: ../pages/Student/profile.php');
                if ($_SESSION['role'] == 'teacher')
                    header('Location: ../pages/Teacher/profile.php');
                if ($_SESSION['role'] == 'administrator')
                    header('Location: ../pages/Admin/profile.php');
            } else {
                // Failed to update the password
                echo 'حدث خطأ في تحديث كلمة المرور.';
            }
        } else {
            // New password and confirm password do not match
            echo 'كلمة المرور الجديدة وتأكيد كلمة المرور غير متطابقين.';
        }
    } else {
        // Current password is incorrect
        echo 'كلمة المرور الحالية غير صحيحة.';
    }
}
?>