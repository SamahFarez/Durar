<div style="height: 180vh; font-size: 16px;" class="side_bar">
   <div class="sidebar_elements">
      <div align="center" class="profile">
         <a href="index.php">
            <img src="../../assets/images/School/schoolIcon.png" alt="school icon">
         </a>
         <p style="font-size: 18px; padding:0 10px" class="teacher_name">
            <?php
            if (isset($schoolRow['school_name'])) {
               echo $schoolRow['school_name'];
            }
            ?>
         </p>
         <p class="teacher_role"> مدرسة </p>
      </div><br>

      <hr>

      <div class="school">
         <p style="font-size: 18px;" class="sidebar_title"> إدارة العمال والطلبة </p>
         <a href="admins.php" class="sidebar_links">
            <img src="../../assets/images/icons/workers.png" alt="icon">
            <p class="respons"> المشرفون </p>
         </a>
         <a href="teachers.php" class="sidebar_links">
            <img src="../../assets/images/icons/teachers.png" alt="icon">
            <p class="respons"> المعلمون </p>
         </a>
         <a href="students.php" class="sidebar_links">
            <img src="../../assets/images/icons/students.png" alt="icon">
            <p class="respons"> الطلاب </p>
         </a><br>
      </div>

      <?php if ($_SESSION['role'] == 'administrator') { ?>

         <hr>

         <div class="episodes">
            <p style="font-size: 18px;" class="sidebar_title"> إدارة الأقسام والحلقات </p>
            <a href="GivenClasses.php" class="sidebar_links">
               <img src="../../assets/images/icons/classes.png" alt="icon">
               <p class="respons"> الأقسام المقدمة </p>
            </a>
            <a href="WeeklyProgram.php" class="sidebar_links">
               <img src="../../assets/images/icons/timetable.png" alt="icon">
               <p class="respons" style="line-height: 1.5"> البرنامج الأسبوعي للحلقات </p>
            </a><br>
         </div>

         <hr>

         <div class="settings">
            <p style="font-size: 18px;" class="sidebar_title"> الإحصائيات والإنجازات </p>
            <a href="attendence.php" class="sidebar_links">
               <img src="../../assets/images/icons/attendance.png" alt="icon">
               <p class="respons"> الحضور والغياب </p>
            </a>
            <a href="insightsPerformance.php" class="sidebar_links">
               <img src="../../assets/images/icons/progress.png" alt="icon">
               <p class="respons"> الحفظ والمراجعة </p>
            </a>
            <a href="InsightsExams.php" class="sidebar_links">
               <img src="../../assets/images/icons/exams.png" alt="icon">
               <p class="respons"> الامتحانات </p>
            </a><br>

            <hr>

            <div class="settings">
               <p style="font-size: 18px;" class="sidebar_title"> الإعدادات العامة </p>
               <a href="settings.php" class="sidebar_links">
                  <img src="../../assets/images/Teacher/settingIcon.png" alt="icon">
                  <p class="respons"> الإعدادات </p>
               </a><br>
            </div>
         </div>
      <?php } ?>
   </div>
</div>