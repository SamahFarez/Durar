<?php

include '../../init.php';

if (isset($_POST["submit"]) && isset($_POST["form"]) && $_POST["form"] == "form1") {

  $adminEmailToAdd = $_POST["addAdmin"];
  if (!filter_var($adminEmailToAdd, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('البريد الإلكتروني غير صالح'); location.href = './admins.php';</script>";
    die();
  }
  if (isset($adminEmailToAdd)) {
    // check if admin is already in a school
    $adminSchoolStmt = mysqli_prepare($conn, "SELECT admin_lname, admin_fname, school_id from administrator where admin_email = ?");
    mysqli_stmt_bind_param($adminSchoolStmt, "s", $adminEmailToAdd);
    mysqli_stmt_execute($adminSchoolStmt);
    $adminSchoolResult = mysqli_stmt_get_result($adminSchoolStmt);
    $adminSchoolRow = mysqli_fetch_assoc($adminSchoolResult);
    // in case admin exists in other school, cannot add
    if (!empty($adminSchoolRow['school_id']) and ($adminSchoolRow['school_id'] != $_SESSION['school_id'])) {
      echo "<script>alert('المشرف(ة) " . $adminSchoolRow["admin_fname"] . " " . $adminSchoolRow["admin_lname"] . " ينتمي لمدرسة أخرى. لا يمكن اضافته(ا) لهذه المدرسة' )</script>";

    } else {
      $_POST[$adminEmailToAdd] = false;
      $stmt = mysqli_prepare($conn, "UPDATE administrator SET school_id = ? WHERE admin_email = ?");
      mysqli_stmt_bind_param($stmt, "ss", $_SESSION['school_id'], $adminEmailToAdd);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) {
        $stmt = mysqli_prepare($conn, "SELECT admin_fname, admin_lname FROM administrator WHERE admin_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $adminEmailToAdd);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $admin_fname = $row['admin_fname'];
        $admin_lname = $row['admin_lname'];

        $stmt = mysqli_prepare($conn, "UPDATE school SET school_nbadmin = school_nbadmin + 1 WHERE school_id = ?");
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['school_id']);
        mysqli_stmt_execute($stmt);
        $_POST[$adminEmailToAdd] = true;
        // The update was successful
        echo "<script>alert('تم اضافة المشرف(ة) " . $admin_fname . " " . $admin_lname . "');
            setTimeout(function() {
              location.href = './admins.php';
            }, 500); 
          </script>";
      } else {
        if ($_POST[$adminEmailToAdd] != true) {
          // No rows were affected, meaning the email does not exist
          echo "<script>alert('البريد الإلكتروني المضاف غير موجود أو المشرف(ة) مضاف من قبل');</script>";
        }
      }
      mysqli_stmt_close($stmt);
    }
  }
}
?>
<div id="AddAdminOverlay">
  <div id="AddAdminOverlay-content">
    <img style="width: 10%; padding-bottom: 10px;" src="../../assets/images/School/Card Decoration.png" alt="">
    <img style="width: 10%; padding-bottom: 20px;" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
    <div class="AddAdminContentAll">
      <div class="AddAdminContent" id="addAdmin1">

        <p>هل أنت متأكد من إضافة المشرف
        </p>
        <p style="color: var(--grey); width: 70%; text-align:center">إضافة مشرفين يعطيهم صلاحيات في تسيير شؤون مدرستكم
          حول الدور المختار لهم وفق الدليل المقدم أدناه</p>
        <div class="CardButtons">
          <button class="backButton" id="close-btn">
            <p>
              لا، الرجوع
            </p>
          </button>
          <button id="move2addAdmin2" class="confirmButton">
            <p>
              نعم متأكد
            </p>
          </button>

        </div>
      </div>

      <div class="AddAdminContent" id="addAdmin2">
        <p>أدخل ايمايل مستخدم المشرف الجديد</p>
        <div class="searchContainer">

          <form method="post">
            <input type="hidden" name="form" value="form1">
            <input type="text" placeholder="أدخل ايمايل المستخدم" name="addAdmin">

        </div>
      </div>

      <div class="AddAdminContent" id="addAdminButtons2">
        <div class="CardButtons">
          <a href="admins.php" class="third-btn" style="width: 100px; border-radius:20px; display:flex; justify-content:center; align-items:center">
            <p>
              العودة
            </p>
          </a>
          <button id="confirmAddAdmin" class="confirmButton" type="submit" name="submit">
            <p>
              حفظ
            </p>
          </button>
        </div>
      </div>
      </form>
      <button class="deleteButton" id="close-btnX">
        <img src="../../assets/images/icons/delete.png">
      </button>
    </div>
  </div>
</div>