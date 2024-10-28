<?php

session_start();

include '../../head.php';
include '../../init.php';

?>

<link rel="stylesheet" href="../../assets/CSS/refreshSection.css">

<div class="panel contact" id="panelContact">
    <div style="background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
        class="title">
        <p> تغيير البريد الالكتروني </p>
    </div>
    <div class="content">
        <form method="post" action="../../includings/editProfile.php">
            <table class="content_element editable">
                <tr>
                    <th> البريد الالكتروني: </th>
                    <td>
                        <input type="email" name="email" id="email"
                            placeholder="<?php echo $_SESSION['email']?>">
                    </td>
                </tr>
            </table>
            <input type="submit" style="font-family: 'Cairo';" class="next_btn" name="update_bio" value="حفظ التغييرات">
        </form>
    </div>
</div>