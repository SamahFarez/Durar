<div id="editSchoolNumberOverlay">
    <div id="AddAdminOverlay-content">
        <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
        <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
        <div class="AddAdminContentAll">
            <div class="AddAdminContent" style="gap: 5px">
                <form method="post" action="../../includings/editSchoolInfo.php">
                    <p>ادخلوا رقم مدرستكم الجديد</p>
                    <input id="school_num" name="school_num" class="CardInputContainer" type="text" placeholder="ادخل رقم الهاتف الجديد">
                    <div class="CardButtons2" style="width: 100%">
                        <a href="settings.php" id="editSchoolNumberskipBtn" class="third-btn" style="width: 100px; border-radius:20px; display:flex; justify-content:center; align-items:center">
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
            <button class="deleteButton" id="editSchoolNumberskipBtnX">
                <img src="../../assets/images/icons/delete.png">
            </button>
        </div>
    </div>
</div>
</div>