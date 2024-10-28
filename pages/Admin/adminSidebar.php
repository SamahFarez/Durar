<?php

include '../../includings/adminSchool.php';

?>

<link rel="stylesheet" href="../../assets/CSS/User/profilepicture.css">

<div class="side_bar">
   <div class="sidebar_elements">
      <div align="center" class="profile">
         <a href="profile.php">
            <img class="profilePicture" src="<?php echo '../../' . $_SESSION['profilePicture'] ?>" alt="admin picture">
         </a>
         <p style="font-size: 18px; padding:0 10px" class="teacher_name">
            <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?>
         </p>
         <p style="margin-top: 10px;" class="teacher_role"> مشرف </p>
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
         <a href="../../pages/School/index.php" class="sidebar_links">
            <img src="../../assets/images/Teacher/schoolIcon.png" alt="icon">
            <p class="respons">
               <?php
               if ($school_name) {
                  echo $school_name;
               } else {
                  echo "ليس منضم";
               }
               ?>
            </p>
            </p>
         </a><br>
      </div>

      <hr>

      <div class="settings">
         <p style="font-size: 18px;" class="sidebar_title"> الإعدادات العامة </p>
         <a href="settings.php" class="sidebar_links">
            <img src="../../assets/images/Teacher/settingIcon.png" alt="icon">
            <p class="respons"> الإعدادات </p>
         </a>
      </div>
   </div>
</div>