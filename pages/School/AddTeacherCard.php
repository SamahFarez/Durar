<?php

include '../../init.php';

if (isset($_POST["submit"]) && isset($_POST["form"]) && $_POST["form"] == "form3") {

  $teacherEmailToAdd = $_POST["addTeacher"];
  if (!filter_var($teacherEmailToAdd, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('البريد الإلكتروني غير صالح'); location.href = './teachers.php';</script>";
    die();
  }
  if (isset($teacherEmailToAdd)) {
    // check if teacher is already in a school
    $teacherSchoolStmt = mysqli_prepare($conn, "SELECT teacher_lname, teacher_fname, school_id from teacher where teacher_email = ?");
    mysqli_stmt_bind_param($teacherSchoolStmt, "s", $teacherEmailToAdd);
    mysqli_stmt_execute($teacherSchoolStmt);
    $teacherSchoolResult = mysqli_stmt_get_result($teacherSchoolStmt);
    $teacherSchoolRow = mysqli_fetch_assoc($teacherSchoolResult);
    // in case teacher exists in other school, cannot add
    if (!empty($teacherSchoolRow['school_id']) and ($teacherSchoolRow['school_id'] != $_SESSION['school_id'])) {
      echo "<script>alert('الأستاذ(ة) " . $teacherSchoolRow["teacher_fname"] . " " . $teacherSchoolRow["teacher_lname"] . " ينتمي لمدرسة أخرى. لا يمكن اضافته(ا) لهذه المدرسة' )</script>";
    } else {
      $_POST[$teacherEmailToAdd] = false;
      $stmt = mysqli_prepare($conn, "UPDATE teacher SET school_id = ? WHERE teacher_email = ?");
      mysqli_stmt_bind_param($stmt, "ss", $_SESSION['school_id'], $teacherEmailToAdd);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) {
        $stmt = mysqli_prepare($conn, "SELECT teacher_fname, teacher_lname FROM teacher WHERE teacher_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $teacherEmailToAdd);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $teacher_fname = $row['teacher_fname'];
        $teacher_lname = $row['teacher_lname'];

        $stmt = mysqli_prepare($conn, "UPDATE school SET school_nbteachers = school_nbteachers + 1 WHERE school_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['school_id']);
        mysqli_stmt_execute($stmt);
        $_POST[$teacherEmailToAdd] = true;
        // The update was successful
        echo "<script>alert('تم اضافة الأستاذ(ة) " . $teacher_fname . " " . $teacher_lname . "');
        setTimeout(function() {
          location.href = './teachers.php';
        }, 500); 
      </script>";
      } else {
        if ($_POST[$teacherEmailToAdd] != true) {
          // No rows were affected, meaning the email does not exist
          echo "<script>alert('البريد الإلكتروني المضاف غير موجود أو الأستاذ(ة) مضاف من قبل');</script>";
        }
      }
      mysqli_stmt_close($stmt);
    }
  }
}
?>
<div id="AddTeacherOverlay">
  <div id="AddAdminOverlay-content">
    <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
    <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
    <div class="AddAdminContentAll">

      <div class="AddAdminContent" id="addTeacher1">
        <p style="color: var(--mainblue)">إضافة أستاذ</p>
        <p>أدخل ايمايل المستخدم الأستاذ الجديد</p>
        <div class="searchContainer">
          <form method="post">
            <input type="hidden" name="form" value="form3">
            <input type="text" placeholder="أدخل ايمايل المستخدم" name="addTeacher">


        </div>
      </div>

      <div class="AddAdminContent" id="AddTeacherButtons">
        <div class="CardButtons">
          <button class="backButton" id="AddTeachercloseBtn">
            <p>
              الرجوع
            </p>
          </button>
          <button id="confirmAddTeacher" class="confirmButton" name="submit">
            <p>
              حفظ
            </p>
          </button>

        </div>
      </div>
      </form>

      <button class="deleteButton" id="AddTeachercloseBtnX">
        <img src="../../assets/images/icons/delete.png">
      </button>
    </div>

  </div>
</div>