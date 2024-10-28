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
<script src="../../js/refreshsection.js"></script>
</head>

<body dir="rtl">
   <!--Nav bar-->
   <?php include 'studentNav.html' ?>


   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'studentSidebar.php' ?>

      <section class="main_elements">
         <!--side bar toggler-->
         <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">

         <section style="display: block;" class="editProfile panels_container" id="editProfile">

            <div class="grid_container">
               <div class="panel setting1">
                  <div class="title">
                     <p> الإعدادات </p>
                  </div>
               </div>

               <div style="background-color: var(--mainblue);" class="panel setting2">
                  <div class="title2">
                     <a href="#editProfile">
                        <p style="color: var(--whiteFFF)"> تعديل الحساب </p>
                     </a>
                  </div>
               </div>
               <div class="panel setting3">
                  <div class="title2" id="bgColorEditProfile">
                     <a href="changePass.php">
                        <p> تغيير كلمة السر </p>
                     </a>
                  </div>
               </div>
            </div>

            <br>

            <div class="panel me" id="panelMe">
               <div
                  style="background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
                  class="title">
                  <p> من أنا؟ </p>
                  <a style="margin-left: 20px; cursor: pointer;" id="edit-button" onclick="refreshBio('panelMe')">
                     <img src="../../assets/images/icons/edit.png" alt="edit">
                  </a>
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

            <div class="panel id" id="panelID">
               <div
                  style="background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
                  class="title">
                  <p> المعلومات الشخصية </p>
                  <a style="margin-left: 20px; cursor: pointer" id="edit-button"
                     onclick="refreshID('panelID', 'student')">
                     <img src="../../assets/images/icons/edit.png" alt="edit">
                  </a>
               </div>
               <div class="content">
                  <div class="content_element editable">
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
                        <tr>
                           <th> رقم الهاتف: </th>
                           <td dir="ltr">
                              <?php echo $studentRow['student_phone'] ?>
                           </td>
                        </tr>
                        <th> عدد الحلقات المنضم اليها: </th>

                        <!-- <td> <?php echo ($epsCountRow['total_classes'] != 0) ? $epsCountRow['total_classes'] : "0 "; ?> -->
                        <td>
                           <?php echo (!empty($epsCountRow) && isset($epsCountRow['total_classes']) && $epsCountRow['total_classes'] != 0) ? $epsCountRow['total_classes'] : "0 "; ?>
                           حلقات
                        </td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div><br>

            <div class="panel contact" id="panelContact">
               <div
                  style="background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
                  class="title">
                  <p> تغيير البريد الالكتروني</p>
                  <a style="margin-left: 20px; cursor: pointer" id="edit-button"
                     onclick="refreshContact('panelContact')">
                     <img src="../../assets/images/icons/edit.png" alt="edit">
                  </a>
               </div>
               <div class="content">
                  <table class="content_element editable">
                     <tr>
                        <th> البريد الالكتروني: </th>
                        <td>
                           <?php echo $studentRow['student_email'] ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>

            <div class="panel" id="panelProfilePic">
               <div
                  style="margin-top: 20px; border-radius: 5px; background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
                  class="title">
                  <p> تغيير صورة الحساب</p>
                  <a style="margin-left: 20px; cursor: pointer" id="edit-button"
                     onclick="refreshProfilePic('panelProfilePic')">
                     <img src="../../assets/images/icons/edit.png" alt="edit">
                  </a>
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