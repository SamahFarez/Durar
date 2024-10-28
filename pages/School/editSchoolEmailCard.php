<div id="editSchoolEmailOverlay">
    <div id="AddAdminOverlay-content">
        <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
        <img style="width: 10%; padding-bottom: 20px;" class="auth_icon"
            src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
        <div class="AddAdminContentAll">
            <div class="AddAdminContent" style="gap: 5px">
                <p>ادخلوا بريد مدرستكم الجديد</p>
                <form method="post" action="../../includings/editSchoolInfo.php">
                    <input class="CardInputContainer" type="email" placeholder="ادخل البريد الالكتروني">
                    <div class="CardButtons2" style="width: 100%">
                        <a href="settings.php" id="editSchoolEmailskipBtn" class="third-btn" style="width: 100px; border-radius:20px; display:flex; justify-content:center; align-items:center">
                            <p>
                                العودة
                            </p>
                        </a>
                        <button type="submit" id="editSchoolEmailConfirmBtn" class="confirmButton" style="padding: 10px 30px">
                            <p>
                                حفظ
                            </p>
                        </button>
                    </div>
                </form>
                <button class="deleteButton" id="editSchoolEmailskipBtnX">
                    <img src="../../assets/images/icons/delete.png">
                </button>
            </div>
        </div>
    </div>
</div>