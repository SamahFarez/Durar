<?php

include '../../head.php';
include '../../init.php';
include '../../includings/adminRedirection.php';
include '../../includings/functions.php';

if (isset($_SESSION['email'])) {
    $adminRow = get_user_row($_SESSION['email'], 'administrator', $conn);
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
            if ($adminRow['admin_bio']) {
                echo $adminRow['admin_bio'];
            } else {
                echo "لا يوجد تعريف قصير للمشرف";
            }
            ?></textarea>

        </div>
        <input type="submit" style="font-family: 'Cairo';" class="next_btn" name="update_bio" value="حفظ التغييرات">
    </form>
</div><br>