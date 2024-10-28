<?php
include '../../head.php';
include '../../includings/teacherRedirection.php';
?>

<link rel="stylesheet" href="../../assets/CSS/refreshSection.css">

<div class="panel" id="panelProfilePic">
    <div style="margin-top: 20px; border-radius: 5px; background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
        class="title">
        <p> تغيير صورة الحساب</p>
    </div>
    <form action="../../includings/upload_profile_picture.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_picture">
            <input type="submit" style="font-family: 'Cairo';" class="next_btn" name="update_bio" value="حفظ الصورة">
    </form>
</div>