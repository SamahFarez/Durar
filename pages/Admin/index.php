<?php

   include '../../head.php';
   // for other categories of users not authorized here
   include '../../includings/adminRedirection.php';
   // for non logged in users
   include '../../includings/landingRedirection.php';

   include '../../includings/functions.php';
   include '../../init.php';

   if(get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role'])){
      $school_id =get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role']);
   }
   if(isset($school_id)){
      $school_name= get_school_name($conn,$school_id);
   }
   
?>


   <title>Administrator</title>
   <link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
   <link rel="stylesheet" href="../../assets/CSS/general.css">
   <link rel="stylesheet" href="../../assets/CSS/User/userMain.css">
   <link rel="stylesheet" href="../../assets/CSS/nav.css">
   <link rel="stylesheet" href="../../assets/CSS/footer.css">
   <link rel="stylesheet" href="../../assets/CSS/Admin/adminMain.css">
   </head>

   <body dir="rtl">
      <!--Nav bar-->
      <header>
         <?php include 'adminNav.html' ?>
      </header>

      <!-- welcome -->
      <div class="technical_info_admin" id="technical_info_admin">
         <div class="elements">
            <img src="../../assets/images/LandingPage/BismiAllah.png" alt="Bismillah">
            <p class="Head_title"> موقع درر </p>
            <p style="margin-top: -80px;" class="description"> الموقع عبارة عن منصة إلكترونية تساعد الأساتذة والأستاذات, المرشدين والمرشدات على
               تنظيم الحلقة أو الفوج و
               مراقبة تطور طلبتهم سواء في حفظ القرآن او تعلم الأحكام او غير ذلك. </p>
         </div>
      </div>
      <section style="margin: -10px auto 30px;" align="center" class="my_school_main welcome" id="my_school">
         <p style="font-weight: 700; color: var(--mainblue); text-decoration-line: underline;"> مدرستي </p>
<?php

if(isset($_SESSION['school_id'])){
    
   ?>
      <!-- my school -->
      
         <div style="background-image: url('../../assets/images/Admin/art-lanterns-middle-eastern-background 1.png');
            background-repeat: no-repeat; background-size: cover; width: 100%; height: 330px; border-radius: 5px;
            display: flex; flex-direction: column; justify-content: center; color: var(--whiteFFF); text-shadow: 2px 2px 2px black;" class="schoolPanel">
            <p style="font-weight: 700;
               font-size: 24px;
               line-height: 45px;
               margin-bottom: -20px;
               margin: 0 auto;
               "> مرحبا بكم في مدرسة
            </p>
            <p style="font-family: 'Reem Kufi';
               font-size: 40px;
               line-height: 60px;
               margin: 0 auto;
               "> <?php echo $school_name?>
            </p>
         </div>
         <a href="../School/index.php">
            <div class="admin-main-button">
               انتقل إلى صفحة المدرسة
            </div>
         </a>
   <?php } else { ?>
   <a href="../School/MakeSchool.php">
   <div class="admin-main-button">
   أنشئ مدرستك الخاصة الآن من هنا 
   </div>
</a>
   <?php } ?>
      </section>

      <!-- timetable -->


      <!-- footer -->
      <div id="footer">
         <?php include 'adminFooter.html' ?>
      </div>
   </body>