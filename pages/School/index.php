<?php

include '../../head.php';
include_once('../../init.php');
include '../../includings/functions.php';


// for non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

$schoolRow = get_school_row($_SESSION['school_id'], $conn);

?>

<title>my school</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/Admin/adminEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolMain.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolCards.css">
<script src="../../js/refreshsection.js"></script>
</head>

<body dir="rtl">
   <!--Nav bar-->
   <?php include '../../includings/schoolNav.php' ?>

   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'schoolSidebar.php' ?>

      <section class="main_elements">
         <!--side bar toggler-->
         <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
         <section style="display: block;" class="main-section panels_container" id="main-section">
            <div
               style="background-image: url('<?php echo isset($schoolRow['school_cover']) ? '../../' . $schoolRow['school_cover'] : '../../SchoolCover/Default.png'; ?>');
            background-repeat: no-repeat; background-size: cover; width: 100%; height: 330px; border-radius: 5px;
            display: flex; flex-direction: column; justify-content: center; color: var(--whiteFFF); text-shadow: 2px 2px 2px black;"
               class="schoolPanel">


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
               "> <?php echo $schoolRow['school_name'] ?>
               </p>
            </div><br>

            <div id="panelMe" class="panel me" name="panelSchool" style=" margin-bottom: 20px;">
               <div style="display: flex; justify-content: space-between; align-items: center;" class="title">
                  <p> عن المدرسة </p>
                  <?php
                  if ($_SESSION['role'] == 'administrator') {
                     echo '<a style="margin-left: 20px; cursor: pointer;" id="edit-button" onclick="refreshBio()">
                  <img src="../../assets/images/icons/edit.png" alt="edit">
               </a>';
                  }
                  ?>

               </div>
               <div class="content">
                  <p class="content_element">
                     <?php
                     if ($schoolRow['school_bio']) {
                        echo $schoolRow['school_bio'];
                     } else {
                        echo "لا يوجد وصف للمدرسة";
                     }
                     ?>
                  </p>

               </div><br>
            </div>
            <div class="panel id" style=" margin-bottom: 20px;">
               <div class="title">
                  <p> بطاقة تقنية </p>
               </div>
               <div class="content">
                  <div class="content_element">
                     <table>
                        <tr>
                           <th> اسم المدرسة: </th>
                           <td>
                              <?php echo $schoolRow['school_name'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> المقر: </th>
                           <td>
                              <?php echo $schoolRow['school_address'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> نوع التعليم: </th>
                           <td>
                              <?php echo $schoolRow['school_type'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> نطاق المدرسة: </th>
                           <td>
                              <?php echo $schoolRow['school_range'] ?>
                           </td>
                        </tr>
                        <tr>
                           <th> إجمالي الطلبة: </th>
                           <td>
                              <?php
                              showNumOfSchoolStudents($conn, $_SESSION['school_id']);
                              ?>
                           </td>
                        </tr>
                        <tr>
                           <th> إجمالي الأساتذة: </th>
                           <td>
                              <?php
                              showNumOfSchoolTeachers($conn, $_SESSION['school_id']);
                              ?>
                           </td>
                        </tr>
                        <tr>
                           <th> إجمالي الحلقات: </th>
                           <td>
                              <?php
                              showNumbOfHalakat($conn, $_SESSION['school_id']);
                              ?>
                           </td>
                        </tr>
                        <tr>
                           <th> إجمالي المشرفين: </th>
                           <td>
                              <?php
                              showNumbOfAdmins($conn, $_SESSION['school_id']);
                              ?>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div><br>

            <div class="panel contact">
               <div class="title">
                  <p> تواصلوا معنا </p>
               </div>
               <div class="content">
                  <table class="content_element">
                     <tr>
                        <th> البريد الالكتروني: </th>
                        <td>
                           <?php echo $schoolRow['school_email'] ?>
                        </td>
                     </tr>
                     <tr>
                        <th> رقم الهاتف: </th>
                        <td dir="ltr">
                           <?php echo $schoolRow['school_phone'] ?>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </section>

      </section>
   </div>

   <div id="footer">
      <?php include '../userFooter.html' ?>
   </div>

   <script src="../../js/workers,studentManagement.js"></script>
   <script src="../../js/sidebars.js"></script>

</body>