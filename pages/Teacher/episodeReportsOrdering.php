<?php

include '../../head.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];

?>


<title>Episode</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body dir="rtl">
   <!--Nav bar-->
   <div class="main">
      <?php include '../Teacher/teacherNav.html' ?>

      <?php include 'hala9aSidebar.php' ?>
      <!--side bar toggler-->
      <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
      <div class="newEpisode" style="width: 75%; display:inline-block;">
         <div class="hala9a-num">
            <p class="text-1">
               <?php echo "الحلقة: " . $halakah_name ?>
            </p>
            <p class="text-2">تحفيظ القران الكريم</p>
         </div>
         <div class="session">
            <div class="session-1">
               <p class="session-1-text">الحصة 33</p>
               <p class="session-1-text">31/03/2023</p>
            </div>
            <div class="session-2">
               <p class="session-2-text">هذا نص عشوائي للاختبار، لا يحمل أي معنى محدد. يستخدم هذا النص في تصميم الطباعة
                  والتخطيط الجرافيكي، حيث يمكن استخدامه كنموذج لتصميم الخطوط والأشكال </p>
            </div>
         </div>
         <div class="studentsList">
            <div class="session-1">
               <p class="session-1-text">قائمة الطلبة</p>
            </div>

            <div class=session-3>
               <div class="session-3-a-div" style="background: #0278A8;">
                  <a class="session-3-a" href="episodeReportsOrdering.php" style="color: white">ترتيب حسب الحفظ</a>
                  <img src="../../assets/images/icons/arrowUp2.png" alt="Arrow Up">
               </div>
               <div class="session-3-a-div">
                  <a class="session-3-a" href="#">ترتيب حسب المراجعة</a>
                  <img src="../../assets/images/icons/arrowUp.png" alt="Arrow Down">
               </div>

            </div>

            <table class="studentsTable">
               <thead>
                  <tr>
                     <th>الاسم</th>
                     <th>اللقب</th>
                     <th>الحفظ</th>
                     <th style="font-size: 11px;">عدد <br>الصفحات</th>
                     <th>المراجعة</th>
                     <th style="font-size: 11px;">عدد <br>الصفحات</th>
                     <th>التقييم</th>
                     <th>الحضور</th>
                  </tr>
               </thead>
               <tbody>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>

                  <tr>
                     <td>محمد أحمد</td>
                     <td>محمود</td>
                     <td style="background: #C5EEFF;">من: البقرة 13 <br> الى: البقرة 30</td>
                     <td style="background: #C5EEFF;">17</td>
                     <td>من: البقرة 13 <br> الى: البقرة 30</td>
                     <td>17</td>
                     <td>15/20</td>
                     <td style="background: #AEF7B5;">حاضر</td>
                  </tr>




               </tbody>
            </table>
         </div>
         <div class="hala9a-num" style="margin-left: 10px; margin-right: 10px;">
            <a class="session-5-b" href="#" style="color: #0278A8">عودة</a>
            <div class="session-5-b" style="background: #0278A8;">
               <a class="session-5-b-t" href="#" style="color: white;">تعديل</a>
               <img src="../../assets/images/icons/edit.png" style="width: 20px; height: 20px;">
            </div>
         </div>
      </div>
   </div>

   <div id="footer">
      <?php include 'teacherFooter.html' ?>
   </div>

   <script src="../../js/sidebars.js"></script>

</body>