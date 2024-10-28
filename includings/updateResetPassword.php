<?php

session_start();
include '../head.php';
include '../init.php';

if (isset($_POST['submit'])) {
   $token = $_POST['token']; // token sent with email to user
   $reset_token = $_SESSION['reset_token']; // to verify that the last token is the only valid one
   $reset_password = $_POST['password'];
   $confirm_password = $_POST['confirm_password'];
   $user_email = $_SESSION['reset_email'];
   $user_role = $_SESSION['reset_role'];

   $passwordHash = password_hash($reset_password, PASSWORD_DEFAULT);
   $errors = array();

   // validate password
   if (strlen($reset_password) < 8) {
      array_push($errors, "يجب أن تتكون كلمة المرور من 8 أحرف على الأقل");
   }
   if ($reset_password !== $confirm_password) {
      array_push($errors, "كلمة السر غير متطابقة");
   }
   if ($token !== $reset_token) {
      array_push($errors, "الرابط الذي استخدمته منتهي الصلاحية، يرجى المحاولة من جديد");
   }

   if (count($errors) > 0) {
      foreach ($errors as  $error) {
         echo "<div style='margin: 20px auto; display: flex; justify-content: center; font-size: 24px;' class='alert alert-danger'>$error</div>";
      }
      echo '<div style="font-family: Cairo; margin-top: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center; font-size: 24px;">
            <p>
               العودة الى الصفحة السابقة:
               <a href="javascript:history.back();"> من هنا </a>
            </p>
            <p>
               العودة الى الصفحة الرئيسية:
               <a href="../"> من هنا </a>
            </p>
         </div>';
   } else {
      if ($user_role === "student" || $user_role === "teacher") {
         $update_stmt = mysqli_prepare($conn, "UPDATE $user_role 
                                       SET {$user_role}_password = ?
                                       WHERE {$user_role}_email = ?");
         mysqli_stmt_bind_param($update_stmt, "ss", $passwordHash, $user_email);
      } elseif ($user_role === "administrator") {
         $update_stmt = mysqli_prepare($conn, "UPDATE $user_role 
                                       SET admin_password = ?
                                       WHERE admin_email = ?");
         mysqli_stmt_bind_param($update_stmt, "ss", $passwordHash, $user_email);
      }

      if (mysqli_stmt_execute($update_stmt)) {
         echo "<script>alert('تم تغيير كلمة المرور الخاصة بكم بنجاح.'); location.href = '../';</script>";
         // unset the session variables
         unset($_SESSION['reset_email']);
         unset($_SESSION['reset_role']);
         unset($_SESSION['reset_token']);
         die();
      } else {
         echo "<script>alert('حدث خطأ ما. حاول مرة أخرى'); location.href = '../';</script>";
      }
      mysqli_stmt_close($update_stmt);
   }
}
