<?php
include '../../head.php';
include_once('../../init.php');
include '../../includings/functions.php';

// for non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

if ($_SESSION['role'] == 'administrator') {
   $stmt = mysqli_prepare($conn, "SELECT school_id from administrator where admin_email=?");
   mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
   $row = mysqli_fetch_assoc($result);
   $school_id = $row['school_id'];
} else {
   $school_id = $_SESSION['school_id'];
}

// after clicking search
if (isset($_POST['submit']) && isset($_POST['search'])) {
   $tmp = $_POST['search'];
   $search = "%" . $tmp . "%";
   $stmt = mysqli_prepare($conn, "SELECT A.admin_fname, A.admin_lname, A.admin_id
                                 FROM administrator A
                                 WHERE A.school_id = ? AND (A.admin_fname LIKE ? OR A.admin_lname LIKE ?)");
   mysqli_stmt_bind_param($stmt, "sss", $school_id, $search, $search);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
} else {
   $stmt = mysqli_prepare($conn, "SELECT A.admin_fname, A.admin_lname, A.admin_id FROM administrator A WHERE A.school_id = ?;");
   mysqli_stmt_bind_param($stmt, "s", $school_id);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
}

if (isset($_COOKIE['adminDeleted']) && $_COOKIE['adminDeleted'] == true) {
   echo "<script>
   alert('تم حذف المشرف(ة)');
 </script>";
} elseif (isset($_COOKIE['errorDeletingAdmin']) && $_COOKIE['errorDeletingAdmin'] == true) {
   echo "<script>
alert('تعذر حذف المشرف(ة) لخطب ما');

</script>";
} elseif (isset($_COOKIE['lastAdmin']) && $_COOKIE['lastAdmin'] == true) {
   echo "<script>
alert('لا يمكن ترك المدرسة بدون مشرفين');

</script>";
}

?>


<title>Admins</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/Admin/adminEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolMain.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolCards.css">

</head>

<body dir="rtl">
   <!--Nav bar-->
   <?php include '../../includings/schoolNav.php' ?>

   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'schoolSidebar.php' ?>

      <section class="main_elements">
         <!--side bar toggler-->
         <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
         <section style="display: block;" class="admins_list panels_container main-section" id="admins_list">
            <div class="panel">
               <div style="display: flex; justify-content: space-between; border-radius: 5px;" class="title">
                  <p> قائمة المشرفين
                  </p>
               </div><br>
               <form method="post" class="search_student">
                  <img src="../../assets/images/icons/search.png" alt="search">
                  <input type="text" name="search" placeholder="ابحث عن المشرف">
                  <input type="submit" name="submit" value="submit" hidden>
               </form>
            </div><br>


            <?php
            if (isset($_POST['submit']) && isset($_POST['search'])) {
               ?>
               <div>
                  <p>
                     <?php echo "نتائج البحث عن '$tmp'"; ?>
                  </p>
               </div><br>
            <?php } ?>

            <?php if ($_SESSION['role'] == 'administrator') { ?>
               <div class="students_list">

                  <div style="display: grid; grid-gap: 1%" class="head row">
                     <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                        class="box"> الاسم </div>
                     <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                        class="box"> اللقب </div>
                     <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                        class="box"> الدور </div>
                     <div
                        style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%;"
                        class="box"> حذف </div>
                  </div>

                  <?php
                  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                  for ($i = 0; $i < count($rows); $i++) {
                     ?>
                     <div style="display: grid; grid-gap: 1%" class="student row">
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                           class="box">
                           <?php echo $rows[$i]['admin_fname'] ?>
                        </div>
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                           class="box">
                           <?php echo $rows[$i]['admin_lname'] ?>
                        </div>
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                           class="box">
                           <?php echo "مشرف عام" ?>
                        </div>
                        <button class="box" style="display:flex; justify-content:center;"
                           onclick="showRemoveAdminOverlay(event, <?php echo $rows[$i]['admin_id']; ?>, '<?php echo $rows[$i]['admin_fname'] . ' ' . $rows[$i]['admin_lname']; ?>')">
                           X </button>
                     </div>
                     <?php
                  }
                  ?>
                  <?php
                  include "RemoveAdminCard.php";
                  ?>

               </div>
               <!-- ADDING Admin -->
               <button class="add_admin" onclick=" showAddAdminOverlay()">
                  <img src="../../assets/images/icons/plus.png" alt="" srcset="">
               </button>

               <?php include 'AddAdminCard.php' ?>
            <?php } else { ?>
               <div class="students_list">

                  <div style="display: grid; grid-template-columns: 33% 33% 33%; grid-gap: 1%" class="head row">
                     <div class="box"> الاسم </div>
                     <div class="box"> اللقب </div>
                     <div class="box"> الدور </div>
                  </div>

                  <?php
                  while ($row = mysqli_fetch_assoc($result)) {
                     ?>
                     <div style="display: grid; grid-template-columns: 33% 33% 33%; grid-gap: 1%" class="student row">
                        <div class="box">
                           <?php echo $row['admin_fname'] ?>
                        </div>
                        <div class="box">
                           <?php echo $row['admin_lname'] ?>
                        </div>
                        <div class="box">
                           <?php echo "مشرف عام" ?>
                        </div>
                     </div>
                     <?php
                  }
                  ?>

               </div>
            <?php } ?>


         </section>

      </section>
   </div>

   <div id="footer">
      <!--footer-->
      <?php include '../../includings/schoolFooter.php' ?>
   </div>

   <script src="../../js/workers,studentManagement.js"></script>
   <script src="../../js/addAdminCard.js"></script>
   <script src="../../js/removeAdminCard.js"></script>
   <script src="../../js/sidebars.js"></script>

</body>