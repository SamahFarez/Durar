<?php
session_start();
include('init.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   $email = $_POST["email"];
   $role = $_POST["role"];
   $password = $_POST["password"];

   $passwordHash = password_hash($password, PASSWORD_DEFAULT);
   $errors = array();

   // Validating input
   if (empty($email) or empty($role) or empty($password)) {
      array_push($errors, "لقد أدخلت معلومات ناقصة");
   }
   if (strlen($password) < 8) {
      array_push($errors, "يجب أن تتكون كلمة المرور من 8 أحرف على الأقل");
   }


   // Check if user exists
   if ($role == "student") {

      $sql = "SELECT * FROM $role WHERE student_email = ? limit 1";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);
      $user_data = mysqli_fetch_assoc($result);

      if ($result && $rowCount > 0) {
         $passwordHash = $user_data['student_password'];
         if (password_verify($password, $passwordHash)) {
            $_SESSION['email'] = $user_data['student_email'];
            $_SESSION['role'] = $role;
            $_SESSION['fname'] = $user_data['student_fname'];
            $_SESSION['lname'] = $user_data['student_lname'];
            $_SESSION['profilePicture'] = $user_data['student_pic'];
            $_SESSION['school_id'] = $user_data['school_id'];
            $_SESSION['logged_in'] = true;
            header("Location: ./pages/Student/confirmStudent.php");
            die();
         } else {
            array_push($errors, "كلمة سر خاطئة");
         }
      } else {
         array_push($errors, "البريد الالكتروني غير موجود");
      }
   }
   if ($role == "teacher") {

      $sql = "SELECT * FROM $role WHERE teacher_email = ? limit 1";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);
      $user_data = mysqli_fetch_assoc($result);

      if ($result && $rowCount > 0) {
         $passwordHash = $user_data['teacher_password'];
         if (password_verify($password, $passwordHash)) {
            $_SESSION['email'] = $user_data['teacher_email'];
            $_SESSION['role'] = $role;
            $_SESSION['fname'] = $user_data['teacher_fname'];
            $_SESSION['lname'] = $user_data['teacher_lname'];
            $_SESSION['profilePicture'] = $user_data['teacher_pic'];
            $_SESSION['school_id'] = $user_data['school_id'];
            $_SESSION['logged_in'] = true;
            header("Location: ./pages/Teacher/confirmTeacher.php");
            die();
         } else {
            array_push($errors, "كلمة سر خاطئة");
         }
      } else {
         array_push($errors, "البريد الالكتروني غير موجود");
      }
   }
   if ($role == "administrator") {

      $sql = "SELECT * FROM administrator WHERE admin_email = ? limit 1";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rowCount = mysqli_num_rows($result);
      $user_data = mysqli_fetch_assoc($result);

      if ($result && $rowCount > 0) {
         $passwordHash = $user_data['admin_password'];
         if (password_verify($password, $passwordHash)) {
            $_SESSION['email'] = $user_data['admin_email'];
            $_SESSION['role'] = $role;
            $_SESSION['fname'] = $user_data['admin_fname'];
            $_SESSION['lname'] = $user_data['admin_lname'];
            $_SESSION['profilePicture'] = $user_data['admin_pic'];
            $_SESSION['school_id'] = $user_data['school_id'];
            $_SESSION['logged_in'] = true;
            header("Location: ./pages/Admin/");
            die();
         } else {
            array_push($errors, "كلمة سر خاطئة");
         }
      } else {
         array_push($errors, "البريد الالكتروني غير موجود");
      }
   }

   // Output any errors
   if (count($errors) > 0) {
      $error_str = implode("<br>", $errors);
?>
      <div style="font-family: Cairo; margin: 20px auto; display: flex; flex-direction: column; justify-content: center; align-items: center;">
         <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: .25rem; padding: .75rem 1.25rem; width: 50%; text-align: center; font-size: 24px;">
            <?php echo $error_str; ?>
         </div>
         <div style="font-family: Cairo; margin-top: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center; font-size: 24px;">
            <p>
               هل أنت جديد معنا؟ سجل حسابا جديدا:
               <a href="signup.php"> من هنا </a>
            </p>
            <p>
               العودة الى الصفحة الرئيسية:
               <a href="index.php"> من هنا </a>
            </p>
         </div>
      </div>
<?php
   }
}
?>