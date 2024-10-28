<?php

session_start();
include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

// getting the halakah_id
$halakah_id = $_GET['halakah_id'];

// upcoming exams
$upcomingStmt = mysqli_prepare($conn, "SELECT exam_id, exam_name, exam_date, exam_time
                                       from exams
                                       where halakah_id=? and exam_date >= NOW();");
mysqli_stmt_bind_param($upcomingStmt, "i", $halakah_id);
mysqli_stmt_execute($upcomingStmt);
$result_up = mysqli_stmt_get_result($upcomingStmt);
// previous exams
$previousStmt = mysqli_prepare($conn, "SELECT exam_id, exam_name, exam_date, exam_time
                                       from exams
                                       where halakah_id=? and exam_date < NOW();");
mysqli_stmt_bind_param($previousStmt, "i", $halakah_id);
mysqli_stmt_execute($previousStmt);
$result_prev = mysqli_stmt_get_result($previousStmt);
?>


<title>Exams List</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userMain.css">
<link rel="stylesheet" href="../../assets/CSS/landingPage.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body id="newExam" dir="rtl">
   <!--Nav bar-->
   <div class="main">
      <?php include '../Teacher/teacherNav.html' ?>

      <?php include 'hala9aSidebar.php' ?>
      <!--side bar toggler-->
      <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
      <div class="newExam" style="width: 75%; display:inline-block;">
         <div class="hala9a-num">
            <p class="text-1">
               <?php echo "الحلقة: " . $halakah_name ?>
            </p>
            <p class="text-2">تحفيظ القران الكريم</p>
         </div>
         <div class="session">
            <!-- Style not working idk why -->
            <div class="session-1">
               <p class="session-1-text" style="text-align:center">الامتحانات المقبلة</p>
            </div>

            <!-- Cards here -->
            <div style="overflow-x: scroll;" class="nextExams">

               <?php
               while ($row_up = mysqli_fetch_assoc($result_up)) {
                  ?>
                  <a class="exam_container"
                     href="nextExam.php?exam_id=<?php echo $row_up['exam_id'] ?>&halakah_id=<?php echo $halakah_id ?>&halakah_name=<?php echo $halakah_name ?>">

                     <p class="class">
                        <?php echo $row_up['exam_name'] ?>
                     </p>
                     <hr>
                     <div style="font-size: 18px;">
                        <p style="color:var(--mainblue)">يوم:</p>
                        <p>
                           <?php echo $row_up['exam_date'] ?>
                        </p>
                     </div>
                     <div>
                        <p style="color:var(--mainblue)">على:</p>
                        <p>
                           <?php echo $row_up['exam_time'] ?>
                        </p>
                     </div>
                  </a>
               <?php } ?>

            </div>
         </div>
         <div class="studentsList">
            <div class="session-1">
               <p class="session-1-text">الامتحانات السابقة</p>
            </div>
            <div style="overflow-x: scroll;" class="prevExams">

               <?php
               while ($row_prev = mysqli_fetch_assoc($result_prev)) {
                  ?>
                  <a class="exam_container"
                     href="PrevExam.php?exam_id=<?php echo $row_prev['exam_id'] ?>&halakah_id=<?php echo $halakah_id ?>&halakah_name=<?php echo $halakah_name ?>">
                     <p class="class">
                        <?php echo $row_prev['exam_name'] ?>
                     </p>
                  </a>
               <?php } ?>

            </div>
         </div>
      </div>
   </div>
   <div id="footer">
      <?php include 'teacherFooter.html' ?>
   </div>

   <script src="../../js/sidebars.js"></script>

</body>