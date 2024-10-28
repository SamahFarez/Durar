<div id="RemoveAdminOverlay">
  <div id="AddAdminOverlay-content">
    <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
    <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
    <div class="AddAdminContentAll">
      <div class="AddAdminContent">

        <p>هل أنت متأكد من حذف المشرف</p>
        <p style="font-size: 20px; font-weight: 500;" id='adminName'>
      </p>
        <p style="color: var(--grey); width: 70%; text-align:center">
        حذف المشرفين يمسحهم من قاعدة بيانات المدرسة ويفقدهم
صلاحياتهم الإدارية في مدرستكم  
        </p>
        <div class="CardButtons">
          <button class="backButton" id="RemoveAdmincloseBtn">
            <p>
              لا، الرجوع
            </p>
          </button>
          <button id="confirmRemoveAdmin" class="confirmButton" onclick="location='deleteLogic.php?roleToDelete=admin&action=delete&admin_id=4'">
            <p>
              نعم متأكد
            </p>
          </button>

        </div>
      </div>
      <button class="deleteButton" id="RemoveAdmincloseBtnX">
        <img src="../../assets/images/icons/delete.png">
      </button>
    </div>

  </div>
</div>