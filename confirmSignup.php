<?php include 'head.php' ?>
<title>Sign Up</title>
<link rel="icon" href="assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="assets/CSS/general.css">
<link rel="stylesheet" href="assets/CSS/User/confirmUser.css">
<style>
   @media (max-width:800px) {
      .conf .right {
         display: none;
      }

      .conf .left {
         width: 100%;
         margin: 0 auto;
      }
   }
</style>
</head>

<body dir=rtl>

   <div class="all conf signup">
      <div style="height: 100vh;" class="right">
         <div class="right_elements">
            <img style="width: 100%; padding-bottom: 10px;" src="assets/images/signUp/Layer_1.png" alt="SignUp">
            <img style="width: 28%;" class="auth_icon" src="assets/images/logo/Durar - Dark blue logo.png" alt="Durar">
            <p style="font-size: 36px;"> مرحبا بك في منصتنا <br> منصة دُرر </p>
         </div>
      </div>
      <div style="margin-top: -70px" class=left>
         <div style="width: 80%;" class="auth_container">
            <div class="header" style="border: 1px solid var(--mainblue); border-radius: 30px; padding: 10% 20%;">
               <p class="title" style="line-height: 37px; text-align: center">
                  التحقق من أنك صاحب البريد الالكتروني
               </p>
               <p class="text" style="color:#636363; line-height: 37px; text-align: center">
               أدخل رمز التحقق الذي أرسلناه في بريدك الالكتروني
            </p>
            <p style=" color:#636363; line-height: 37px; text-align: center">
               إذا لم تتلقَ رسالة التحقق بعد في صندوق الوارد الخاص بك، يُرجى التحقق من مجلد البريد العشوائي "spam"
            </p><br><br>
            <p style="text-align: center; color:#636363;" >لم يصلك البريد؟  <a href="includings/resendConfiirmtion.php" style="color: black">أرسل رمز التحقق مجددا</a></p>
            <form action="includings/confirmCode.php" method="post">
               <div dir="ltr" class="otp-bx">
                  <input style="width: 200px; font-family: 'Cairo'" type="text" id="digit" name="otp" maxlength="6"
                     required placeholder="مثل: 102145">
               </div>
               <br><br>
               <div class="buttons">
                  <a style="font-size: 16px; padding: 16px; margin-left: 10px;" class="return_btn" href="signup.php">
                     العودة
                  </a>
                  <button class="next_btn" style="font-size: 16px; padding: 8px 25px;" name="submit"
                     style="margin-right: 10px;" type="submit">
                     التالي
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
   
</body>

</html>