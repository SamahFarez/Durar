<?php
// Perform necessary database connection and error handling here
include '../../head.php';
include '../../init.php';
include '../../includings/functions.php';
include '../../includings/noSchool_unauthorized.php';

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

// Assuming you have the classname stored in a variable
$classname = "قسم تحفيظ القرآن الكريم";


$email = $_SESSION["email"];
$role = $_SESSION['role'];
$schoolID = get_school_id_from_user($conn, $email, $role);

// Prepare the SQL statement
$query = "SELECT COUNT(*) AS num_halakahs FROM halakah WHERE class_name = ? AND school_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
   // Bind the classname and school ID parameters
   $stmt->bind_param("si", $classname, $schoolID);

   // Execute the statement
   if ($stmt->execute()) {
      $stmt->bind_result($num_halakahs);
      $stmt->fetch();
   }
}
$stmt->close();



// Close the database connection
$conn->close();


$AdminName = $_SESSION['fname'] . " " . $_SESSION['lname'];
?>

<title>School classes</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/Admin/adminEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/SchoolClasses.css">
</head>


<body dir="rtl">
   <!--Nav bar-->
   <?php include '../../includings/schoolNav.php' ?>

   <div class="main">
      <!-- SIDE BAR -->
      <?php include 'schoolSidebar.php' ?>

      <!--MAIN ELEMENTS-->
      <section class="main_elements">
         <!--side bar toggler-->
         <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
         <a href="Episodes.php?classname=قسم تحفيظ القرآن الكريم">
            <div class="Classframe">
               <div class="upperTape">
                  <h1 class="Title">قسم تحفيظ القرآن الكريم</h1>
                  <input type="submit" value="إعدادات القسم" />
               </div><br>
               <div class="text">
                  <p>المشرف :
                     <?php echo $AdminName ?>
                  </p>
                  <p> </p>
                  <p class="numEpisodes">
                     <?php echo $num_halakahs ?> حلقات
                  </p>
               </div>
            </div>
         </a>
      </section>
   </div>


   <div id="footer">
      <!--footer-->
      <?php include '../../includings/schoolFooter.php' ?>
   </div>

   <script src="../../js/sidebars.js"></script>

</body>