<?php

include 'init.php';
include 'head.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   $firstname = $_POST["firstname"];
   $lastname = $_POST["lastname"];
   $email = $_POST["email"];
   $gender = $_POST["gender"];
   $country = $_POST["country"];
   $phone = $_POST["number"];
   $role = $_POST["role"];
   $password = $_POST["password"];
   $passwordRepeat = $_POST["confirm_pass"];

   $passwordHash = password_hash($password, PASSWORD_DEFAULT);
   $errors = array();

   // Validating input

   if (empty($firstname) or empty($lastname) or empty($gender) or empty($email) or empty($role) or empty($phone) or empty($country) or empty($password) or empty($passwordRepeat)) {
      array_push($errors, "لقد أدخلت معلومات ناقصة");
   }

   if (!preg_match("/^(?=.[^ ])[a-zA-Z ء-يًٌٍ ]*[a-zA-Z ء-يًٌٍ]$/u", $firstname) or !preg_match("/^(?=.[^ ])[a-zA-Z ء-يًٌٍ ]*[a-zA-Z ء-يًٌٍ]$/u", $lastname)) {
      array_push($errors, "هناك خطأ في اسم أو لقب المستخدم");
   }
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($errors, "البريد الإلكتروني غير صالح");
   }
   if (!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
      array_push($errors, "رقم الهاتف غير صالح");
   }
   if (strlen($password) < 8) {
      array_push($errors, "يجب أن تتكون كلمة المرور من 8 أحرف على الأقل");
   }
   if ($password !== $passwordRepeat) {
      array_push($errors, "كلمة السر غير متطابقة");
   }

   // Check if user already exists
   if ($role == "student") {
      $stmt =  mysqli_prepare($conn, "SELECT * FROM $role WHERE student_email = ?");
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);
      if ($rowCount > 0) {
         array_push($errors, "البريد الالكتروني موجود من قبل");
      }
      mysqli_stmt_close($stmt);
   }
   if ($role == "teacher") {
      $stmt =  mysqli_prepare($conn, "SELECT * FROM $role WHERE teacher_email = ?;");
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);
      if ($rowCount > 0) {
         array_push($errors, "البريد الالكتروني موجود من قبل");
      }
      mysqli_stmt_close($stmt);
   }
   if ($role == "administrator") {

      $stmt =  mysqli_prepare($conn, "SELECT * FROM $role WHERE admin_email = ?;");
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);
      if ($rowCount > 0) {
         array_push($errors, "البريد الالكتروني موجود من قبل");
      }
      mysqli_stmt_close($stmt);
   }

   // Display all errors 
   if (count($errors) > 0) {
      foreach ($errors as  $error) {
         echo "<div style='margin: 20px auto; display: flex; justify-content: center; font-size: 24px;' class='alert alert-danger'>$error</div>";
      }
   } else {

      // Preparing the conf email
      $mail = new PHPMailer(true);

      $mail->isSMTP();
      $mail->SMTPAuth = true;

      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->Username = 'YottaMindCo@gmail.com';
      $mail->Password = 'okmcmkxicniodrfz';


      //Sending the email
      $mail->setFrom('YottaMindCo@gmail.com', 'YottaMind');
      $mail->addAddress($email, $name); // Add a recipient
      $mail->addReplyTo('no-reply@gmail.com', 'No-Reply');

      $mail->isHTML(true); // Set email format to HTML

      $confirmationCode = substr(uniqid('', true), -6);


      // Set up the email subject and body
      $subject = 'Durar Confirmation Code';
      $body = '<p dir="rtl">:نشكركم على التسجيل في موقعنا، يرجى استخدام الرمز التالي للتحقق من حسابك</p>';
      $body .= '<p dir="rtl">:رمز التحقق ' . $confirmationCode . '</p>';
      $body .= '<p dir="rtl">شكرًا لكم على اختيار موقعنا، نتمنى لكم تجربة ممتعة ومفيدة.</p>';
      $body .= '<p dir="rtl">تحياتنا،<br>فريق دُرَر</p>';

      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->AltBody = 'نشكركم على التسجيل في موقعنا، يرجى استخدام الرمز التالي للتحقق من حسابك: رمز التحقق: ' . $confirmationCode . 'شكرًا لكم على اختيار موقعنا، نتمنى لكم تجربة ممتعة ومفيدة. تحياتنا، فريق دُرَر';

      // Send the email
      if (!$mail->send()) {
         echo 'Error: ' . $mail->ErrorInfo;
         exit();
      }

      session_start();
      $_SESSION["email"] = $email;
      $_SESSION["lname"] = $lastname;
      $_SESSION["fname"] = $firstname;
      $_SESSION["password"] = $passwordHash;
      $_SESSION["role"] = $role;
      $_SESSION["number"] = $phone;
      $_SESSION["country"] = $country;
      $_SESSION["gender"] = $gender;
      $_SESSION["confirm_pass"] = $passwordRepeat;
      $_SESSION["confirm_code"] =  $confirmationCode;
      $_SESSION['profilePicture'] = 'profile_picture/student/studentPic.png';

      header("Location: confirmSignup.php");
      die;
   }
}
?>

<link rel="icon" href="assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="assets/CSS/general.css">
<link rel="stylesheet" href="assets/CSS/authentication.css">