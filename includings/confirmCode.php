<?php

include_once('../init.php');


session_start();
$role = $_SESSION["role"];
$firstname = $_SESSION["fname"];
$lastname = $_SESSION["lname"];
$name = $firstname . " " . $lastname;
$email = $_SESSION["email"];
$passwordHash = $_SESSION["password"];
$phone = $_SESSION["number"];
$country = $_SESSION["country"];
$gender = $_SESSION["gender"];
$passwordRepeat = $_SESSION["confirm_pass"];
$confirmationCode =  $_SESSION["confirm_code"];

// Prompt the user to enter the confirmation code
$enteredCode = $_POST['otp'];


// Compare the entered code with the generated code
if ($enteredCode == $confirmationCode) {
   if ($role == "student") {
      $sql = "INSERT INTO $role (student_fname, student_lname, student_gender, student_email, student_phone, student_password, student_country ) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $gender, $email, $phone, $passwordHash, $country);
      mysqli_stmt_execute($stmt);
      $_SESSION['logged_in'] = true;
      // storing information in session variables
      header("Location: ../pages/Student/confirmStudent.php");

      //}
   } else if ($role == "teacher") {
      $sql = "INSERT INTO $role (teacher_fname, teacher_lname, teacher_gender, teacher_email, teacher_phone, teacher_password, teacher_country ) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $gender, $email, $phone, $passwordHash, $country);
      mysqli_stmt_execute($stmt);
      $_SESSION['logged_in'] = true;
      // storing information in session variables
      header("Location: ../pages/Teacher/confirmTeacher.php");
   } else if ($role == "administrator") {
      //session_start();
      $sql = "INSERT INTO $role (admin_fname, admin_lname, admin_gender, admin_email, admin_phone, admin_password, admin_country ) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $gender, $email, $phone, $passwordHash, $country);
      mysqli_stmt_execute($stmt);
      $_SESSION['logged_in'] = true;
      // storing information in session variables
      header("Location: ../pages/Admin/index.php");
   } else {
      die("هناك خطأ ما");
   }
} else {
   echo "<script>alert('إن رمز التحقق الذي أدخلتموه خاطئ'); history.go(-1);</script>";
   exit;
}

?>