<?php

include '../../head.php';
include '../../init.php';
include '../../includings/studentRedirection.php';
include '../../includings/landingRedirection.php';
include '../../includings/functions.php';


if (isset($_SESSION['email'])) {
   $studentRow = get_user_row($_SESSION['email'], 'student', $conn);
   // get the number of halakat the student is in
   $epsCountRow = count_episodes($_SESSION['email'], 'student', $conn);
}

?>


<title>Student Profile</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body dir="rtl">
   <!--Nav bar-->
   <?php include 'studentNav.html' ?>


   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'studentSidebar.php' ?>

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
                     if ($studentRow['student_bio']) {
                        echo $studentRow['student_bio'];
                     } else {
                        echo "لا يوجد تعريف قصير للتلميذ";
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
                              <?php echo $studentRow['student_fname'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> اللقب: </th>
                           <td>
                              <?php echo $studentRow['student_lname'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> بلد الإقامة: </th>
                           <td>
                              <?php echo $studentRow['student_country'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> الجنس: </th>
                           <td>
                              <?php echo $studentRow['student_gender'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> عدد الحلقات المنضم اليها: </th>
                           <td>
                              <?php echo (!empty($epsCountRow) && isset($epsCountRow['total_classes']) && $epsCountRow['total_classes'] != 0) ? $epsCountRow['total_classes'] : "0 "; ?>
                              حلقات
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
                           <?php echo $studentRow['student_email'] ?>
                        </td>
                     </tr>
                     <tr>
                        <th> رقم الهاتف: </th>
                        <td dir="ltr">
                           <?php echo $studentRow['student_phone'] ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </section>

      </section>
   </div>

   <div id="footer">
      <?php include 'studentFooter.html' ?>
   </div>

   <script src="../../js/sidebars.js"></script>
</body>