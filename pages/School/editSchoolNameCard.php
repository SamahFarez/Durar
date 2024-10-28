<div id="editSchoolNameOverlay">
    <div id="AddAdminOverlay-content">
        <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
        <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
        <div class="AddAdminContentAll">
            <div class="AddAdminContent" style="gap: 5px">
                <p>ادخل اسم مدرستك الجديد</p>
                <form method="post" action="../../includings/editSchoolInfo.php">
                    <input id='school_name' name="school_name" class="CardInputContainer" type="text" placeholder="ادخل الاسم الجديد">
                    <p style="color: var(--grey); width: 100%; text-align:center">
                        لن يتم إشعار المستخدمين بتغيير اسم مدرستكم
                    <div class="CardButtons2" style="width: 100%">
                        <a href="settings.php" id="editSchoolNameskipBtn" class="third-btn" style="width: 100px; border-radius:20px; display:flex; justify-content:center; align-items:center">
                            <p>
                                العودة
                            </p>
                        </a>
                        <button type="submit" id="editSchoolNumberConfirmBtn" class="confirmButton" style="padding: 10px 30px">
                            <p>
                                حفظ
                            </p>
                        </button>
                </form>
            </div>
            <button class="deleteButton" id="editSchoolNameskipBtnX">
                <img src="../../assets/images/icons/delete.png">
            </button>
        </div>
    </div>
</div>
</div>