<?php

include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
// form of progress 
include '../../includings/sessionFunctions.php';

$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];

?>


<title>Episode</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<style>
   .table_container {
      overflow-x: scroll;
      max-width: 100%;
   }
</style>
</head>

<body dir="rtl">
   <!--Nav bar-->
   <div class="main">
      <?php include '../Teacher/teacherNav.html' ?>

      <?php include 'hala9aSidebar.php' ?>
      <!--side bar toggler-->
      <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
      <div class="newEpisode" style="width: 75%; display:inline-block;">
         <div class="hala9a-num">
            <p class="text-1">
               <?php echo "الحلقة: " . $halakah_name ?>
            </p>
            <p class="text-2">تحفيظ القران الكريم</p>
         </div>
         <?php showNewSessionForm($conn); ?>
      </div>
   </div>

   <div id="footer">
      <?php include 'teacherFooter.html' ?>
   </div>
   
   <script src="../../js/sidebars.js"></script>

   <script>
      var values = ["حاضر", "غائب", "عذر"];
      var colors = ["#AEF7B5", "#FBBCAE", "#81DFF3"];
      var currentIndex = 0;

      function changeState(input_id) {
         var valueInput = document.getElementById(input_id);
         var parent = valueInput.parentNode;

         // Update the input value
         valueInput.value = values[currentIndex];

         // Update the parent background color
         parent.style.backgroundColor = colors[currentIndex];

         // Increment the index or reset to 0 if it exceeds the length of values
         currentIndex = (currentIndex + 1) % values.length;
      }
   </script>


</body>