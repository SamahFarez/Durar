<?php

include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';

if (isset($_SESSION['email'])) {
   $teacherProfile = mysqli_prepare($conn, "SELECT * FROM teacher WHERE teacher_email = ?");
   mysqli_stmt_bind_param($teacherProfile, "s", $_SESSION['email']);
   mysqli_stmt_execute($teacherProfile);
   $teachProfResults = mysqli_stmt_get_result($teacherProfile);
   $teacherRow = mysqli_fetch_assoc($teachProfResults);
   // get the number of halakat the student is in
   $teacherClassCount = mysqli_prepare($conn, "SELECT count(H.halakah_id) as total_classes 
                                 FROM teacher S JOIN halakah H
                                 ON S.teacher_id = H.teacher_id
                                 WHERE S.teacher_email = ?
                                 group by H.teacher_id;");
   mysqli_stmt_bind_param($teacherClassCount, "s", $_SESSION['email']);
   mysqli_stmt_execute($teacherClassCount);
   $halakahCountResult = mysqli_stmt_get_result($teacherClassCount);
   $halakahCountRow = mysqli_fetch_assoc($halakahCountResult);
}

?>


<title>Teacher Profile</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body dir="rtl">
   <!--Nav bar-->
   <?php include 'teacherNav.html' ?>


   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'teacherSidebar.php' ?>

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
                     if ($teacherRow['teacher_bio']) {
                        echo $teacherRow['teacher_bio'];
                     } else {
                        echo "لا يوجد تعريف قصير للأستاذ";
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
                              <?php echo $teacherRow['teacher_fname'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> اللقب: </th>
                           <td>
                              <?php echo $teacherRow['teacher_lname'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> بلد الإقامة: </th>
                           <td>
                              <?php echo $teacherRow['teacher_country'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> الجنس: </th>
                           <td>
                              <?php echo $teacherRow['teacher_gender'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> عدد الحلقات المشرف عليها: </th>
                           <td>
                              <?php echo (!empty($halakahCountRow) && isset($halakahCountRow['total_classes']) && $halakahCountRow['total_classes'] != 0 ? $halakahCountRow['total_classes'] : "0 "); ?>
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
                           <?php echo $teacherRow['teacher_email'] ?>
                        </td>
                     </tr>
                     <tr>
                        <th> رقم الهاتف: </th>
                        <td dir="ltr">
                           <?php echo $teacherRow['teacher_phone'] ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </section>

      </section>
   </div>

   <div id="footer">
      <?php include 'teacherFooter.html' ?>
   </div>

   <script src="../../js/sidebars.js"></script>

</body>