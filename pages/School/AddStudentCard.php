<?php

include '../../init.php';

if (isset($_POST["submit"]) && isset($_POST["form"]) && $_POST["form"] == "form2") {

  $studentEmailToAdd = $_POST["addStudent"];
  if (!filter_var($studentEmailToAdd, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('البريد الإلكتروني غير صالح'); location.href = './students.php';</script>";
    die();
  }
  if (isset($studentEmailToAdd)) {
    // check if student is already in a school
    $studentSchoolStmt = mysqli_prepare($conn, "SELECT student_lname, student_fname, school_id from student where student_email = ?");
    mysqli_stmt_bind_param($studentSchoolStmt, "s", $studentEmailToAdd);
    mysqli_stmt_execute($studentSchoolStmt);
    $studentSchoolResult = mysqli_stmt_get_result($studentSchoolStmt);
    $studentSchoolRow = mysqli_fetch_assoc($studentSchoolResult);
    // in case student exists in other school, cannot add
    if (!empty($studentSchoolRow['school_id']) and ($studentSchoolRow['school_id'] != $_SESSION['school_id'])) {
      echo "<script>alert('الطالب(ة) " . $studentSchoolRow["student_fname"] . " " . $studentSchoolRow["student_lname"] . " ينتمي لمدرسة أخرى. لا يمكن اضافته(ا) لهذه المدرسة' )</script>";
    } else {
      $stmt = mysqli_prepare($conn, "UPDATE student SET school_id = ? WHERE student_email = ?");
      mysqli_stmt_bind_param($stmt, "ss", $_SESSION['school_id'], $studentEmailToAdd);
      mysqli_stmt_execute($stmt);

      $_SESSION[$studentEmailToAdd] = true;

      if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION[$studentEmailToAdd] = false;
        $stmt_stud = mysqli_prepare($conn, "SELECT student_fname, student_lname FROM student WHERE student_email = ?");
        mysqli_stmt_bind_param($stmt_stud, "s", $studentEmailToAdd);
        mysqli_stmt_execute($stmt_stud);
        $result_stud = mysqli_stmt_get_result($stmt_stud);
        $row_stud = mysqli_fetch_assoc($result_stud);
        $student_fname = $row_stud['student_fname'];
        $student_lname = $row_stud['student_lname'];

        echo "<script>alert('تم اضافة الطالب(ة) " . $student_fname . " " . $student_lname . "');
        setTimeout(function() {
          location.href = './students.php';
        }, 500); 
      </script>";
      } else {
        // No rows were affected, meaning the email does not exist
        echo "<script>alert('البريد الإلكتروني المضاف غير موجود أو الطالب(ة) مضاف من قبل');</script>";
      }
      mysqli_stmt_close($stmt);
    }
  }
}
?>
<div id="AddStudentOverlay">
  <div id="AddAdminOverlay-content">
    <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
    <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
    <div class="AddAdminContentAll">

      <div class="AddAdminContent" id="addStudent1">
        <p style="color: var(--mainblue)">إضافة طالب</p>
        <p>أدخل ايمايل المستخدم الطالب الجديد</p>
        <div class="searchContainer">
          <form method="post">
            <input type="hidden" name="form" value="form2">
            <input type="text" placeholder="أدخل ايمايل المستخدم" name="addStudent">

        </div>
      </div>

      <div class="AddAdminContent" id="addStudentButtons">
        <div class="CardButtons">
          <button class="backButton" id="AddStudentcloseBtn">
            <p>
              الرجوع
            </p>
          </button>
          <button id="confirmAddStudent" class="confirmButton" name="submit">
            <p>
              حفظ
            </p>
          </button>

        </div>
      </div>
      </form>

      <button class="deleteButton" id="AddStudentcloseBtnX">
        <img src="../../assets/images/icons/delete.png">
      </button>
    </div>

  </div>
</div>