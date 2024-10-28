<?php

include '../../head.php';
include_once('../../init.php');
include '../../includings/functions.php';

if (get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role'])) {
    $school_id = get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role']);
}
$schoolRow = get_school_row($school_id, $conn);
?>
<div id="editSchoolCardOverlay">
    <div id="AddAdminOverlay-content">
        <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
        <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
        <div class="AddAdminContentAll">
            <div class="AddAdminContent" style="gap: 5px">
                <p>تعديل البطاقة التقنية </p>
                <form method="post" action="../../includings/editSchoolInfo.php" class="editSchoolCard">
                    <section>
                        <label for="name">اسم المدرسة:</label>
                        <p>
                            <?php echo $schoolRow['school_name'] ?>
                        </p>
                    </section>
                    <section>
                        <label for="name" style="color: var(--mainblue);">المقر:</label>
                        <input type="text" id="school_address" name="school_address" placeholder="إلكتروني/مقر المدرسة">
                    </section>
                    <section>
                        <label for="name" style="color: var(--mainblue);">نوع التعليم:</label>
                        <select name="school_type" id="school_type" style="background-color: var(--WhiteFFF); border: 0; font-family: Cairo; text-align: right">
                            <option value="" disabled selected> اختر تعليم المدرسة </option>
                            <option value="الكترونية"> الكترونية </option>
                            <option value="ميدانية"> ميدانية </option>
                        </select>
                    </section>
                    <section>
                        <label for="name" style="color: var(--mainblue);">نطاق المدرسة:</label>
                        <select name="school_range" id="school_range" style="background-color: var(--WhiteFFF); border: 0; font-family: Cairo; text-align: right">>
                            <option value="" disabled selected> اختر نطاق المدرسة </option>
                            <option value="عالمي"> عالمي </option>
                            <option value="اقليمي"> اقليمي </option>
                            <option value="محلي"> محلي </option>
                        </select>
                    </section>
                    <section>
                        <label for="name">إجمالي الطلبة:</label>
                        <p>
                        <?php echo isset($schoolRow['school_nbstudent']) ? $schoolRow['school_nbstudent'] : "غير محدد"; ?>
                        </p>
                    </section>
                    <section>
                        <label for="name">إجمالي الأساتذة:</label>
                        <p>
                            <?php echo $schoolRow['school_nbteachers'] ?>
                        </p>
                    </section>
                    <section>
                        <label for="name">إجمالي الحلقات:</label>
                        <p>
                            <?php echo $schoolRow['school_nbhalakah'] ?>
                        </p>
                    </section>
                    <section>
                        <label for="name">إجمالي المشرفين</label>
                        <p>
                            <?php echo $schoolRow['school_nbadmin'] ?>
                        </p>
                    </section>
                    <div class="CardButtons2" style="width: 100%">
                        <a href="settings.php" id="editSchoolCardskipBtn" class="third-btn" style="width: 100px; border-radius:20px; display:flex; justify-content:center; align-items:center">
                            <p>
                                لا, العودة
                            </p>
                        </a>
                        <button type="submit" id="editSchoolCardConfirmBtn" class="confirmButton" style="padding: 10px 30px">
                            <p>
                                نعم متأكد
                            </p>
                        </button>
                </form>
            </div>
            <button class="deleteButton" id="editSchoolCardskipBtnX">
                <img src="../../assets/images/icons/delete.png">
            </button>
        </div>
    </div>
</div>
</div>