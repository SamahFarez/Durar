<?php
include '../head.php';
include '../init.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is selected
    if ($_FILES['profile_picture']['name']) {
        $targetDir = '../profile_picture/' . $_SESSION['role'] . '/';
        $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);

        if (is_writable($targetDir)) {
            echo 'The folder is writable.';
        } else {
            echo 'The folder is not writable.';
        }
        $savedPath = '/profile_picture/' . $_SESSION['role'] . '/' . basename($_FILES['profile_picture']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        // Validate the file type
        if ($imageFileType == 'jpg' || $imageFileType == 'jpeg' || $imageFileType == 'png') {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                // Perform database update using the $profilePictureURL
                $pic = mysqli_real_escape_string($conn, $savedPath);
                // Update the bio in the database
                if ($_SESSION['role'] == 'student')
                    $update_pic_query = "UPDATE student SET student_pic = '$pic' WHERE student_email = '{$_SESSION['email']}'";
                if ($_SESSION['role'] == 'teacher')
                    $update_pic_query = "UPDATE teacher SET teacher_pic = '$pic' WHERE teacher_email = '{$_SESSION['email']}'";
                if ($_SESSION['role'] == 'administrator')
                    $update_pic_query = "UPDATE administrator SET admin_pic = '$pic' WHERE admin_email = '{$_SESSION['email']}'";
                $result = mysqli_query($conn, $update_pic_query);
                if ($result) {
                    $_SESSION['profilePicture'] = $pic;
                    // Redirect or display a success message
                    if ($_SESSION['role'] == 'administrator')
                        header("Location: ../pages/Admin/profile.php");
                    if ($_SESSION['role'] == 'teacher')
                        header("Location: ../pages/Teacher/profile.php");
                    if ($_SESSION['role'] == 'student')
                        header("Location: ../pages/Student/profile.php");
                    exit;
                }
            } else {
                // Failed to move the uploaded file
                echo 'حدث خطأ في تغيير صورة المستخدم الخاصة بك';
            }
        } else {
            // Invalid file type
            echo 'ملف الصورة غير مقبول، يرجى تغييره';
        }
    } else {
        // No file selected
        echo 'يرجى اختيار صورة للتغيير';
    }
}