<div id="RemoveTeacherOverlay">
  <div id="AddAdminOverlay-content">
    <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
    <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
    <div class="AddAdminContentAll">
      <div class="AddAdminContent">
        <p style="color: var(--mainblue)">حذف الأستاذ </p>


        <p>هل أنت متأكد من حذف الأستاذ</p>
        <p style="font-size: 20px; font-weight: 500;" id="teacherName">
      </p>
        <p style="color: var(--grey); width: 70%; text-align:center">
        الأساتذة الذين لا يزالون يديرون حلقات لا يمكن حذفهم من قاعدة بيانات المدرسة مباشرة
      </p>
          <div class="CardButtons" style="width:auto">
            <button class="backButton" id="RemoveTeachercloseBtn">
              <p>
                لا، الرجوع
              </p>
            </button>
            <button id="confirmRemoveTeacher" class="confirmButton" onclick="location='deleteLogic.php?roleToDelete=teacher&action=delete&teacher_id=4&eps_num=4'">
              <p>
                نعم متأكد
              </p>
            </button>
          </div>
      </div>
      <button class="deleteButton" id="RemoveTeachercloseBtnX">
        <img src="../../assets/images/icons/delete.png">
      </button>
    </div>

  </div>
</div>