<?php

include '../../head.php';
include '../../init.php';
// Get Halakah information
$statement = mysqli_prepare($conn, "SELECT S.school_name, S.school_id FROM school S join teacher T on S.school_id=T.school_id where T.teacher_email=?");
mysqli_stmt_bind_param($statement, "s", $_SESSION['email']);
mysqli_stmt_execute($statement);
$statementResult = mysqli_stmt_get_result($statement);
$statementRow = mysqli_fetch_assoc($statementResult);

?>
<link rel="stylesheet" href="../../assets/CSS/User/profilepicture.css">

<div style="font-size: 16px;" class="side_bar">
   <div class="sidebar_elements">
      <div align="center" class="profile">
         <a href="profile.php">
            <img class="profilePicture" src="<?php echo '../../' . $_SESSION['profilePicture'] ?>" alt="teacher picture">
         </a>
         <p style="font-size: 18px; padding: 0 10px" class="teacher_name">
            <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?>
         </p>
         <p style="margin-top: 10px;" class="teacher_role"> أستاذ </p>
      </div><br>

      <hr>

      <div class="school">
         <p style="font-size: 18px;" class="sidebar_title"> الرئيسية </p>
         <a href="index.php" class="sidebar_links">
            <img src="../../assets/images/icons/main - teacher episode icons.png" alt="icon">
            <p class="respons"> الرئيسية </p>
         </a>
      </div><br>

      <hr>

      <div class="school">
         <p style="font-size: 18px;" class="sidebar_title"> مدرستي </p>
         <a href="../../pages/School/" class="sidebar_links">
            <img src="../../assets/images/Teacher/schoolIcon.png" alt="icon">
            <p class="respons">
               <?php
               if (isset($statementRow['school_name'])) {
                  echo $statementRow['school_name'];
               } else {
                  echo "ليس منضم";
               }
               ?>
            </p>
         </a><br>
      </div>

      <hr>

      <div class="settings">
         <p style="font-size: 18px;" class="sidebar_title"> الإعدادات العامة </p>
         <a href="settings.php" class="sidebar_links">
            <img src="../../assets/images/Teacher/settingIcon.png" alt="icon">
            <p class="respons" href="settings.php"> الإعدادات </p>
         </a>
      </div>
   </div>
</div>