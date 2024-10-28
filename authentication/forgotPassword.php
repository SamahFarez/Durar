<?php include 'head.php' ?>
<title>Forgot Password</title>
<link rel="icon" href="../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../assets/CSS/general.css">
<link rel="stylesheet" href="../assets/CSS/User/confirmUser.css">
</head>

<body dir=rtl>

   <div class="all conf signup">
      <div style="height:100vh" class="right">
         <div class="right_elements">
            <img style="width: 100%; padding-bottom: 10px;" src="../assets/images/signUp/Layer_1.png" alt="SignUp">
            <img style="width: 28%;" class="auth_icon" src="../assets/images/logo/Durar - Dark blue logo.png" alt="Durar">
            <p style="font-size: 36px;"> مرحبا بك في منصتنا <br> منصة دُرر </p>
         </div>
      </div>
      <div style="margin-top:-70px" class="left">
         <div style="width: 80%;" class="auth_container">
            <div style="border: 1px solid var(--mainblue); border-radius: 30px; padding: 10% 20%;">
               <p style="font-size: 28px; line-height: 37px; text-align: center">
                  هل نسيت كلمة المرور؟
               </p>
               <p style="font-size: 20px; color:#636363; line-height: 37px; text-align: center">
                  يرجى إدخال عنوان بريدك الإلكتروني و دورك<br><br>
                  بعد النقر على "التالي"، <br>
                  ستتلقى رابطًا لاستعادة كلمة المرور الخاصة بك
               </p>
               <br>
               <form action="../includings/resetPasswordEmail.php" method="post">
                  <label dir="ltr" class="otp-bx">
                     <input style="width:100%; font-family: 'Cairo'; font-size:16px;" type="email" name="email" placeholder="أدخل بريدك الالكتروني" required>
                  </label>
                  <br>
                  <label for="role">
                     <select name="role" id="loginRole" placeholder="اختر دورك" required>
                        <option value="" disabled selected> اختر دورك </option>
                        <option value="student"> طالب </option>
                        <option value="teacher"> أستاذ </option>
                        <option value="administrator"> مشرف </option>
                     </select>
                  </label>
                  <br>
                  <div class="buttons">
                     <a style="font-size: 16px; padding: 16px; margin-left: 10px;" class="return_btn" href="javascript:history.back();">
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

</body>

</html>