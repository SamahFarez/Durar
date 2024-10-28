<?php include '../head.php'; ?>
<title>Forgot Password</title>
<link rel="icon" href="../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../assets/CSS/general.css">
<link rel="stylesheet" href="../assets/CSS/User/confirmUser.css">
<style>
   span {
      position: absolute;
      left: 15px;
      transform: translate(0, -50%);
      top: 50%;
      color: #7a797e;
   }
</style>
</head>

<body dir=rtl>

   <div class="all conf signup">
      <div class="right">
         <div class="right_elements">
            <img style="width: 100%; padding-bottom: 10px;" src="../assets/images/signUp/Layer_1.png" alt="SignUp">
            <img style="width: 28%;" class="auth_icon" src="../assets/images/logo/Durar - Dark blue logo.png" alt="Durar">
            <p style="font-size: 36px;"> مرحبا بك في منصتنا <br> منصة دُرر </p>
         </div>
      </div>
      <div class=left>
         <div style="width: 80%;" class="auth_container">
            <div style="border: 1px solid var(--mainblue); border-radius: 30px; padding: 10% 20%;">
               <p style="font-size: 28px; line-height: 37px; text-align: center">
                  إعادة تعيين كلمة المرور
               </p>
               <p style="font-size: 20px; color:#636363; line-height: 37px; text-align: center">
                  يرجى تعيين كلمة مرور جديدة لحسابك<br>
               </p><br>
               <form action="../includings/updateResetPassword.php" method="post">
                  <label style="position: relative;" class="otp-bx">
                     <input style="width:100%; font-family: 'Cairo'; font-size:16px; padding-right:10px;
                              text-align:right; " type="password" name="password" id="password" placeholder="أدخل كلمة المرور" required>
                     <span class="material-icons" id="eye" onclick="toggle_password()">visibility</span>
                  </label>
                  <br>
                  <label style="position: relative;" class="otp-bx">
                     <input style="width:100%; font-family: 'Cairo'; font-size:16px; padding-right:10px;
                              text-align:right; " type="password" name="confirm_password" id="confirm_pass" placeholder="قم بتأكيد كلمة المرور" required>
                     <span class="material-icons" id="eye_confirm" onclick="toggle_confirm_password()">visibility</span>
                  </label>
                  <input type="text" name="token" value="<?php if (isset($_GET['token'])) {
                                                                  echo $_GET['token'];
                                                               } ?>" hidden>
                  <br>
                  <div class="buttons" style="display:flex; flex-direction: row;">
                     <a style="font-size: 16px; padding: 16px; margin-left: 10px; display: flex;" class="return_btn" href="../">
                        العودة
                     </a>
                     <button style="font-size: 16px" name="submit" style="margin-right: 10px;" type="submit">
                        التالي
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <script src="../js/showPassword.js"></script>
</body>

</html>