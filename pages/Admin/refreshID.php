<?php

session_start();
include '../../head.php';
include '../../init.php';
include '../../includings/functions.php';


if (isset($_SESSION['email'])) {
    $adminRow = get_user_row($_SESSION['email'], 'administrator', $conn);
}
?>

<link rel="stylesheet" href="../../assets/CSS/refreshSection.css">

<div style="background-color: var(--darkblue); display: flex; justify-content: space-between; align-items: center;"
    class="title">
    <p> بطاقة تعريفية </p>
</div>
<div class="content">
    <div class="content_element editable">
        <form action="../../includings/editProfile.php" method="post">
            <table>
                <tr>
                    <th> الاسم: </th>
                    <td>
                        <input type="text" id="fname" name="fname"
                            placeholder="<?php echo $adminRow['admin_fname'] ?>">
                    </td>
                </tr>
                <tr>
                    <th> اللقب: </th>
                    <td>
                        <input type="text" id="lname" name="lname"
                            placeholder="<?php echo $adminRow['admin_lname'] ?>">
                    </td>
                </tr>
                <tr>
                    <th> بلد الإقامة: </th>
                    <td>
                        <select name="country" id="country" id="country">
                            <option value="" disabled selected>
                                <?php echo $adminRow['admin_country'] ?>
                            </option>
                            <?php
                            $sql = "SELECT * FROM countries";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                            }
                            ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <th> الجنس: </th>
                    <td>
                        <select name="gender" id="gender">
                            <option value="" disabled selected>
                                <?php echo $adminRow['admin_gender'] ?>
                            </option>
                            <option value="ذكر"> ذكر </option>
                            <option value="أنثى"> أنثى </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th> رقم الهاتف: </th>
                    <td dir="ltr">
                        <input type="tel" name="tel" id="tel" placeholder="<?php echo $adminRow['admin_phone'] ?>">
                    </td>
                </tr>
            </table>
            <input type="submit" style="font-family: 'Cairo';" class="next_btn" name="update_bio" id="update_bio"
                value="حفظ التغييرات">
        </form>
    </div>
</div>