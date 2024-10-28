<?php

include '../../head.php';
include '../../init.php';
include '../../includings/studentRedirection.php';
include '../../includings/functions.php';

if (isset($_SESSION['email'])) {
    $studentRow = get_user_row($_SESSION['email'], 'student', $conn);
}

?>
<link rel="stylesheet" href="../../assets/CSS/refreshSection.css">

<div class="panel me" id="panelMe">
    <div style="background-color: var(--darkblue);" class="title">
        <p> من أنا؟ </p>
    </div>
    <form method="post" action="../../includings/editProfile.php">
        <div class="content">
            <textarea maxlength="100" name="bio"><?php
            if ($studentRow['student_bio']) {
                echo $studentRow['student_bio'];
            } else {
                echo "لا يوجد تعريف قصير للتلميذ";
            }
            ?></textarea>

        </div>
        <input type="submit" style="font-family: 'Cairo';" class="next_btn" name="update_bio" value="حفظ التغييرات">
    </form>
</div><br>