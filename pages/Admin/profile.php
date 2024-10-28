<?php

session_start();

include '../../head.php';
include '../../init.php';
// for other categories of users not authorized here
include '../../includings/adminRedirection.php';
// for non logged in users
include '../../includings/landingRedirection.php';
include '../../includings/functions.php';


if (isset($_SESSION['email'])) {
   $adminRow = get_user_row($_SESSION['email'], 'administrator', $conn);
}

?>


<title>Admin Profile</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body dir="rtl">
   <!--Nav bar-->
   <?php include 'adminNav.html' ?>


   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'adminSidebar.php' ?>

      <section class="main_elements">
         <section class="main-section panels_container" id="main-section">
            <!--side bar toggler-->
            <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <div class="panel me">
               <div class="title">
                  <p> من أنا؟ </p>
               </div>
               <div class="content">
                  <p class="content_element">

                     <?php
                     if ($adminRow['admin_bio']) {
                        echo $adminRow['admin_bio'];
                     } else {
                        echo "لا يوجد تعريف قصير للمشرف";
                     }
                     ?>

                  </p>
               </div>
            </div><br>

            <div class="panel id">
               <div class="title">
                  <p> بطاقة تعريفية </p>
               </div>
               <div class="content">
                  <div class="content_element">
                     <table>
                        <tr>
                           <th> الاسم: </th>
                           <td>
                              <?php echo $adminRow['admin_fname'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> اللقب: </th>
                           <td>
                              <?php echo $adminRow['admin_lname'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> بلد الإقامة: </th>
                           <td>
                              <?php echo $adminRow['admin_country'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> الجنس: </th>
                           <td>
                              <?php echo $adminRow['admin_gender'] ?>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div><br>

            <div class="panel contact">
               <div class="title">
                  <p> تواصلوا معي </p>
               </div>
               <div class="content">
                  <table class="content_element">
                     <tr>
                        <th> البريد الالكتروني: </th>
                        <td>
                           <?php echo $adminRow['admin_email'] ?>
                        </td>
                     </tr>
                     <tr>
                        <th> رقم الهاتف: </th>
                        <td dir="ltr">
                           <?php echo $adminRow['admin_phone'] ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </section>

      </section>
   </div>

   <div id="footer">
      <?php include 'adminFooter.html' ?>
   </div>

   <script src="../../js/sidebars.js"></script>

</body>