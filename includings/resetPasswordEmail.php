<?php

session_start();
include '../head.php';
include '../init.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


if (isset($_POST['submit'])) {
   // getting the user email and role
   $reset_email = $_POST['email'];
   $reset_role = $_POST['role'];
   $_SESSION['reset_email'] = $reset_email;
   $_SESSION['reset_role'] = $reset_role;

   //generate a random token
   $token = md5(rand()) . "durar";
   $_SESSION['reset_token'] = $token;
   
   if (!filter_var($reset_email, FILTER_VALIDATE_EMAIL)) {
      echo "<script>alert('البريد الإلكتروني غير صالح'); location.href = '../authentication/forgotPassword.php';</script>";
      die();
   }

   // checking if user exists based on their role
   if (isset($reset_email) && isset($reset_role)) {
      if ($reset_role === "student" || $reset_role === "teacher") {
         $stmt = mysqli_prepare($conn, "SELECT * FROM $reset_role WHERE {$reset_role}_email = ?");
         mysqli_stmt_bind_param($stmt, "s", $reset_email);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $rowCountStudentTeacher = mysqli_num_rows($result);
      }
      elseif ($reset_role === "administrator") {
         $stmt = mysqli_prepare($conn, "SELECT * FROM $reset_role WHERE admin_email = ?");
         mysqli_stmt_bind_param($stmt, "s", $reset_email);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         $rowCountAdmin = mysqli_num_rows($result);
      }

      if ($rowCountStudentTeacher === 0 || $rowCountAdmin === 0) {
         echo "<script>alert('البريد الإلكتروني غير موجود. يرجى الاشتراك بحساب جديد'); location.href = '../signup.php';</script>";
         die();
      } else {
         // sending the mail to the corresponding email address
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
         $mail->addAddress($reset_email); // Add a recipient
         $mail->addReplyTo('no-reply@gmail.com', 'No-Reply');

         $mail->isHTML(true); // Set email format to HTML

         // Set up the email subject and body
         $subject = 'Durar Reset Password Link';
         $body = '<p dir="rtl">أنتم تتلقون هذا البريد الإلكتروني كاستجابة لطلبكم.</p>';
         $body .= '<p dir="rtl">لإعادة ضبط كلمة المرور الخاصة بكم وإكمال عملية إعادة الوصول إلى حسابكم،';
         $body .= ' يرجى النقر على <a href="http://localhost/YottaMind/authentication/resetPasswordForm.php?token=' . $token . '">هذا الرابط</a></p>';
         $body .= '<p dir="rtl">نتمنى لكم تجربة ممتعة ومفيدة.</p>';
         $body .= '<p dir="rtl">تحياتنا،<br>فريق دُرَر</p>';

         $mail->Subject = $subject;
         $mail->Body = $body;

         if (!$mail->send()) {
            echo 'Error: ' . $mail->ErrorInfo;
            exit();
         } else {
            echo "<script>alert('لقد تم إرسال بريد إلكتروني لإعادة ضبط كلمة المرور الخاصة بكم'); location.href = '../';</script>";
            die();
         }
      }

      mysqli_stmt_close($stmt);
   } else {
      echo "<script>alert('حدث خطأ ما'); location.href = '../';</script>";
      die();
   }
}
