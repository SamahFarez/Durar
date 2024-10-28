<?php

include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';

$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];
$exam_id = $_GET['exam_id'];

// exam info
$examInfo = mysqli_prepare($conn, "SELECT E.exam_id, E.exam_name, E.exam_date, E.exam_period, E.exam_description, E.exam_time
                                 from exams E
                                 where exam_id=?");
mysqli_stmt_bind_param($examInfo, "i", $exam_id);
mysqli_stmt_execute($examInfo);
$examInfoRes = mysqli_stmt_get_result($examInfo);
$examInfoRow = mysqli_fetch_assoc($examInfoRes);

// students marks
$studMarks = mysqli_prepare($conn, "SELECT S.student_id, S.student_fname, S.student_lname, E.remark, E.mark
                                 from student S left join grades E
                                 on S.student_id=E.student_id
                                 where exam_id=?");
mysqli_stmt_bind_param($studMarks, "i", $exam_id);
mysqli_stmt_execute($studMarks);
$marksRes = mysqli_stmt_get_result($studMarks);

// average
$average = mysqli_prepare($conn, "SELECT  ROUND(avg(E.mark), 2) as avg
                                 from grades E
                                 where exam_id=?");
mysqli_stmt_bind_param($average, "i", $exam_id);
mysqli_stmt_execute($average);
$avgRes = mysqli_stmt_get_result($average);
$avgRow = mysqli_fetch_assoc($avgRes);

?>


<title>Previous Exam</title>
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
               <p class="session-1-text" style="text-align:center">امتحان حضوري: <span>
                     <?php echo $examInfoRow['exam_name'] ?>
                  </span></p>
            </div>

            <div class="examTime">
               <p>يوم: <span>
                     <?php echo $examInfoRow['exam_date'] ?>
                  </span> على: <span>
                     <?php echo $examInfoRow['exam_time'] ?>
                  </span></p>
               <p>لمدة <span>
                     <?php echo $examInfoRow['exam_period'] . " دقيقة" ?>
                  </span></p>
            </div>
            <div style="background-color:var(--whiteFFF);border-radius:5px; width:100%" class="seesion-2">
               <p class="session-2-text">
                  <?php
                  if ($examInfoRow['exam_description']) {
                     echo $examInfoRow['exam_description'];
                  } else {
                     echo "هذا الامتحان لا يحتوي على وصف";
                  }
                  ?>
               </p>
            </div>
         </div>
         <div class="studentsList">

            <div class="session-1">
               <p class="session-1-text">العلامات</p>
            </div>

            <div class="table_marks" style="overflow-x: scroll;">
               <table style="text-align:right" class="examsTable">
                  <thead>
                     <tr>
                        <th>الاسم</th>
                        <th>اللقب</th>
                        <th style="width:25%">الملاحظات</th>
                        <th style="width:15%">العلامة</th>
                        <th style="width:10%">تعديل</th>
                     </tr>
                  </thead>
                  <tbody>

                     <?php
                     while ($marksRow = mysqli_fetch_assoc($marksRes)) {
                        ?>
                        <tr data-student-id="<?php echo $marksRow['student_id'] ?>">

                           <td style="padding: 0 10px 0;">
                              <?php echo $marksRow['student_fname'] ?>
                           </td>
                           <td style="padding: 0 10px 0;">
                              <?php echo $marksRow['student_lname'] ?>
                           </td>
                           <td style="width:35%; padding: 0 20px 0;">
                              <span class="remark">
                                 <?php echo $marksRow['remark'] ?>
                              </span>
                              <select class="edit-remark" style="display: none;">
                                 <option value="ناجح">ناجح</option>
                                 <option value="راسب">راسب</option>
                              </select>
                           </td>
                           <td style="width:15%; padding: 0 20px 0;">
                              <span class="mark">
                                 <?php echo $marksRow['mark'] ?>
                              </span>
                              <input type="number" class="edit-mark" style="display: none;"
                                 value="<?php echo $marksRow['mark'] ?>">
                           </td>
                           <td style="width:10%;">
                              <a style="cursor: pointer; display:flex; justify-content:center" class="edit-button"
                                 onclick="openEditForm(<?php echo $marksRow['student_id'] ?>, <?php echo $exam_id; ?>)">
                                 <img src="../../assets/images/icons/edit_dark_blue.png" alt="edit">
                              </a>
                           </td>
                        </tr>
                     <?php } ?>

                  </tbody>
               </table>
            </div>

            <div class="session-3" style="gap:0px;padding: 0 7px;margin-top:-10px">
               <div class="Mean" style="width:85%;padding: 10px 30px 10px 10px">المعدل</div>
               <div style="display: flex; justify-content:center; align-items:center; padding: 0; width:26%"
                  class="MeanNumber">
                  <?php echo $avgRow['avg'] ?>
               </div>
            </div>
            <div style="display: flex; justify-content:flex-end; cursor:pointer" class="session-3">
               <a class="session-3-text">حفظ</a>
            </div>

         </div>
      </div>
   </div>

   <div id="footer">
      <?php include 'teacherFooter.html' ?>
   </div>

   <script src="../../js/sidebars.js"></script>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
      var halakahId = <?php echo $halakah_id; ?>;
      var halakahName = <?php echo $halakah_name; ?>;
      var examId = <?php echo $exam_id; ?>;
   </script>
   <script src="../../js/editExam.js"></script>
</body>