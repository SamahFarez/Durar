<?php

include '../../head.php';
include '../../init.php';
include '../../includings/functions.php';

if (isset($_SESSION['email'])) {
    $schoolRow = get_school_row($_SESSION['school_id'], $conn);
}

?>
<link rel="stylesheet" href="../../assets/CSS/refreshSection.css">

<div class="panel me" id="panelMe">
    <div style="background-color: var(--darkblue);" class="title">
        <p> عن المدرسة</p>
    </div>
    <form method="post" action="../../includings/editProfile.php">
        <div class="content">
            <textarea id="schoolBio" name="schoolBio" maxlength="100" name="bio"><?php
            if (isset($schoolRow['school_bio']) && $schoolRow['school_bio']) {
                echo $schoolRow['school_bio'];
            } else {
                echo "لا يوجد وصف للمدرسة";
            }
            ?></textarea>

        </div>
        <input type="submit" style="font-family: 'Cairo';" class="next_btn" name="update_bio" value="حفظ التغييرات">
    </form>
</div><br>