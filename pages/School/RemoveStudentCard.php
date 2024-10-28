<?php
include_once('../../init.php');
// for non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
?>
<div id="RemoveStudentOverlay">
  <div id="AddAdminOverlay-content">
    <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
    <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
    <div class="AddAdminContentAll">
      <div class="AddAdminContent">
        <p style="color: var(--mainblue)">حذف الطالب </p>


        <p>هل أنت متأكد من حذف الطالب</p>
        <p style="font-size: 20px; font-weight: 500;" id="studentName">
        </p>
        <p style="color: var(--grey); width: 70%; text-align:center">
        سيتم حذف كل ما يتعلق بالطالب من انجازات واحصائيات نهائيا من بيانات المدرسة
      </p>
        <div class="CardButtons" style="width: 100%">
          <button class="backButton" id="RemoveStudentcloseBtn">
            <p>
              لا، الرجوع
            </p>
          </button>
          <button id="confirmRemoveStudent" class="confirmButton" onclick="location='deleteLogic.php?roleToDelete=student&action=delete&student_id=4'">
            <p>
              نعم متأكد
            </p>
          </button>
        </div>
      </div>
      <button class="deleteButton" id="RemoveStudentcloseBtnX">
        <img src="../../assets/images/icons/delete.png">
      </button>
    </div>

  </div>
</div>

<script src="../../js/removeStudentCard.js"></script>
