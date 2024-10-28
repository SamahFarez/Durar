<?php

include '../../head.php';
include '../../init.php';
include '../../includings/studentRedirection.php';
// checking if user is already in a school or pending
include '../../includings/has_school.php';
include '../../includings/landingRedirection.php';


?>

<?php include '../../head.php' ?>
<title>Log In</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/confirmUser.css">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>


<body dir="rtl">
   <?php include '../../pages/Student/studentNav.html' ?>

   <div class="auth_container">
      <p class="auth_title">
         انضم الى مدرستك الان
      </p>
      <div class="code_school">
         <p>
         مرحبًا بكم بيننا، يُرجى الاشتراك في إحدى المدارس التي تستخدم موقعنا الإلكتروني حتى تتمكنوا من الاستفادة من خدماتنا.
         <br>
         <br>
         إذا كنتم قد اشتركتم بالفعل في إحدى المدارس، فيرجى التواصل مع أحد المشرفين للتأكد من إضافتكم إلى مدرستكم.         </p>
      </div>
   </div>

   <div id="footer">
      <?php include 'studentFooter.html' ?>
   </div>

</body>