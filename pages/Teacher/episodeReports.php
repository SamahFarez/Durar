<?php

include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

include '../../includings/sessionFunctions.php';
include '../../includings/functions.php';

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
               <p class="session-1-text">الحصة
                  <?php echo $_SESSION['session_number']; ?>
               </p>
               <p class="session-1-text">
                  <?php echo $_SESSION['session_date']; ?>
               </p>
            </div>
            <div class="session-2">
               <p class="session-2-text">
                  <?php echo $_SESSION['session_report'] ?>
               </p>
            </div>
         </div>
         <div class="studentsList">
            <div class="session-1">
               <p class="session-1-text">قائمة الطلبة</p>
               <p class="session-1-text" style="font-weight: 400;">
                  <?php showNumberOfStudents($conn, $halakah_id) ?> طالب
               </p>
            </div>
            <!-- students progress -->
            <div style="overflow-x: scroll;">
               <?php showSession($conn, $_SESSION['session_id']) ?>
            </div>
         </div>
      </div>

      <div id="footer">
         <?php include 'teacherFooter.html' ?>
      </div>

      <script src="../../js/sidebars.js"></script>

</body>