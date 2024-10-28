<?php

include '../../head.php';
// for other categories of users not authorized here
include '../../includings/teacherRedirection.php';
// for non logged in users
include '../../includings/landingRedirection.php';

?>


<title>teacher Profile</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
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

<body dir="rtl">
   <!--Nav bar-->
   <?php include 'teacherNav.html' ?>


   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'teacherSidebar.php' ?>

      <section class="main_elements">
         <!--side bar toggler-->
         <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
         <section style="display: block;" class="changePassword panels_container" id="changePassword">

            <div class="grid_container">
               <div class="panel setting1">
                  <div class="title">
                     <p> الإعدادات </p>
                  </div>
               </div>

               <div class="panel setting2">
                  <div class="title2">
                     <a href="settings.php">
                        <p> تعديل الحساب </p>
                     </a>
                  </div>
               </div>
               <div style="background-color: var(--mainblue);" class="panel setting3">
                  <div class="title2" id="bgColorEditProfile">
                     <a href="#editPassword">
                        <p style="color: var(--whiteFFF)"> تغيير كلمة السر </p>
                     </a>
                  </div>
               </div>
            </div>

            <br><br>

            <form action="../../includings/changePassword.php" method="post">
               <label style="position: relative;" for="oldPassword">
                  <div class="titles">
                     <p class="title"> كلمة المرور القديمة: </p>
                     <input type="password" name="current_password" id="login_password" placeholder="أدخل كلمة المرور"
                        required>
                     <span class="material-icons" id="eye_login" onclick="toggle_login_password()">visibility</span>
                  </div>
               </label>
               <label style="position: relative;" for="newPassword">
                  <div class="titles">
                     <p class="title"> كلمة المرور الجديدة: </p>
                     <input type="password" name="new_password" id="password" placeholder="أدخل كلمة المرور" required>
                     <span class="material-icons" id="eye" onclick="toggle_password()">visibility</span>
                  </div>
               </label>
               <label style="position: relative;" for="oldPassword">
                  <div class="titles">
                     <p class="title"> تأكيد كلمة المرور الجديدة: </p>
                     <input type="password" name="confirm_password" id="confirm_pass" placeholder="أدخل كلمة المرور"
                        required>
                     <span class="material-icons" id="eye_confirm" onclick="toggle_confirm_password()">visibility</span>
                  </div>
               </label>
               <button class="changePasswordButton" name="submit_changepw" type="submit"> حفظ </button>
            </form>

         </section>

      </section>
   </div>

   <div id="footer">
      <?php include 'teacherFooter.html' ?>
   </div>
   <script src="../../js/showPassword.js"></script>
   <script src="../../js/sidebars.js"></script>

</body>