<?php
include 'head.php';
include 'init.php'
?>
<title>Sign Up</title>
<link rel="icon" href="assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="assets/CSS/general.css">
<link rel="stylesheet" href="assets/CSS/authentication.css">
<style>
   .signup .right {
      height: 100vh;
   }

   span {
      position: absolute;
      left: 15px;
      transform: translate(0, -50%);
      top: 50%;
      color: #7a797e;
   }

   @media (max-width: 800px) {
      form {
         padding-bottom: 30px;
      }

      .signup .right {
         display: none;
      }

      .signup .left {
         width: 90%;
         margin: 0 auto;
      }
   }

   @media (max-width: 700px) {
      .country_number {
         display: flex;
         flex-direction: column;
      }

      .country_number label {
         width: 100%;
      }

      .login_modal .right {
         display: none;
      }

      .login_modal .left {
         width: 100%;
         margin: 0 auto;
      }
   }
</style>
</head>

<body dir="rtl">
   <div class="all signup">
      <div class="right">
         <div class="right_elements">
            <img style="width: 100%; padding-bottom: 10px;" src="assets/images/signUp/Layer_1.png" alt="layer">
            <img style="width: 28%;" class="auth_icon" src="assets/images/logo/Durar - Dark blue logo.png" alt="Durar">
            <p style="font-size: 36px;"> مرحبا بك في منصتنا <br> منصة دُرر </p>
            <p style="font-size: 16px; padding-bottom: 10px;"> لديك حساب بالفعل؟ </p>
            <a id="login_link" class="auth-btn third-btn" href="#"> تسجيل الدخول </a>
         </div>
      </div>
      <div class="left left_extra">
         <form action="signupLogic.php" method="post">
            <p class="form_title"> إنشاء حساب </p>
            <label for="firstname">
               <input type="text" name="firstname" id="firstname" placeholder="أدخل اسمك الشخصي" required>
            </label>
            <label for="lastname">
               <input type="text" name="lastname" id="lastname" placeholder="أدخل اسم العائلة" required>
            </label>
            <label for="gender">
               <select name="gender" id="gender" required>
                  <option value="" disabled selected> الجنس </option>
                  <option value="ذكر"> ذكر </option>
                  <option value="أنثى"> أنثى </option>
               </select>
            </label>
            <label for="email">
               <input type="email" name="email" id="email" placeholder="أدخل بريدك الالكتروني" required>
            </label>
            <div style="grid-template-columns: 100%; gap: 2%;" class="country_number">
               <label for="country">
                  <select name="country" id="country" required>
                     <option value="" disabled selected>أدخل بلد إقامتك</option>
                     <?php
                     $sql = "SELECT * FROM countries";
                     $result = mysqli_query($conn, $sql);
                     while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                     }
                     ?>
                  </select>
               </label>
               <label for="number">
                  <input style="width: 100%;" type="number" name="number" id="number" pattern="" placeholder="أدخل رقم هاتفك" required>
               </label>
            </div>
            <label for="role">
               <select name="role" id="role" placeholder="اختر دورك" required>
                  <option value="" disabled selected> اختر دورك </option>
                  <option value="student"> طالب </option>
                  <option value="teacher"> أستاذ </option>
                  <option value="administrator"> مشرف </option>
               </select>
            </label>
            <label style="position: relative;" for="password">
               <input type="password" name="password" id="password" placeholder="أدخل كلمة المرور" required>
               <span class="material-icons" id="eye" onclick="toggle_password()">visibility</span>
            </label>
            <label style="position: relative;" for="confirm_pass">
               <input type="password" name="confirm_pass" id="confirm_pass" placeholder="قم بتأكيد كلمة المرور" required>
               <span class="material-icons" id="eye_confirm" onclick="toggle_confirm_password()">visibility</span>
            </label>
            <div class="buttons">
               <a style="padding: 16px;" class="return_btn" href="index.php">
                  العودة
               </a>
               <button style="font-family: 'Cairo';" class="next_btn" name="submit">
                  التالي
               </button>
            </div>
         </form>
      </div>
   </div>

   <!--THE MODAL OF LOGGING IN-->
   <?php include 'login.php' ?>
   <script src="js/loginModal.js"></script>
   <script src="js/showPassword.js"></script>
</body>



</html>