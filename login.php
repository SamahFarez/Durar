<div dir="rtl" class="modal_container" id="modal_container">
   <div style="border-radius: 30px; overflow: hidden" class="all modal login_modal">
      <div class="right">
         <div class="right_elements">
            <img style="width: 60%; padding-bottom: 10px;" src="assets/images/logo/Durar - Dark blue logo.png" alt="Durar">
            <p style="font-size: 22px; padding-bottom: 20px"> جديد معنا؟ </p>
            <a style="font-size: 80%; padding: 4% 9%;" class="auth-btn" href="signup.php"> انشاء حساب </a>
         </div>
      </div>
      <div class="left signup">
         <form action="loginLogic.php" style="text-align: center" id="loginForm" method="POST">
            <p style="padding-top: 30px; font-size: 20px; float: right;"> مرحبا بك </p>
            <label for="email">
               <input type="text" name="email" id="email" placeholder="أدخل بريدك الالكتروني" required>
            </label>
            <label style="position: relative;" for="password">
               <input type="password" name="password" id="login_password" placeholder="أدخل كلمة المرور" required>
               <span class="material-icons" id="eye_login" onclick="toggle_login_password()">visibility</span>
            </label>
            <label for="role">
               <select name="role" id="loginRole" placeholder="اختر دورك" required>
                  <option value="" disabled selected> اختر دورك </option>
                  <option value="student"> طالب </option>
                  <option value="teacher"> أستاذ </option>
                  <option value="administrator"> مشرف </option>
               </select>
            </label>
            <div align="left">
               <a href="authentication/forgotPassword.php" style="cursor:pointer; color: var(--darkblue); text-decoration: none">
                  نسيت كلمة المرور؟
               </a>
            </div>
            <br><br>
            <button style="font-family: 'Cairo';" class="next_btn" type="submit"> الدخول </button>
            <a id="close" style="font-size: 16px; margin-right: 5px" class="return_btn" href="#"> العودة </a>
         </form>
      </div>
   </div>
</div>