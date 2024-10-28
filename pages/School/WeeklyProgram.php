<?php

session_start();
include '../../head.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
// function of timetable
include '../../init.php';
include '../../includings/functions.php'
    ?>

<title>School classes</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/WeeklyProgram.css">
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
            <!-- timetable -->

            <div class="titleBar">
                <p>الجدولة الأسبوعية للحلقات</p>
                <a style="margin-left: 20px;" href="WeeklyProgramEditByHalakah.php">
                    <img src="../../assets/images/icons/edit.png" alt="edit">
                </a>
            </div>

            <?php schoolTimeTable($conn, "byHalakah") ?>

            <!-- teachers time table-->
            <div class="titleBar">
                <p>الجدولة الأسبوعية للأساتذة</p>
                <div style="display:flex; flex-direction:row; gap: 15px">
                    <a href="">
                        <img src="../../assets/images/icons/angle-up.png" alt="hide">
                    </a>
                    <!-- <a style="margin-left: 20px;" href="WeeklyProgramEditByTeacher.php">
                        <img src="../../assets/images/icons/edit.png" alt="edit">
                    </a> -->
                </div>
            </div>

            <section class="teachersTimetable" id="teachersTimetable">
                <div class="firstRow">
                    <div class="day">
                        <p> اليوم </p>
                    </div>

                    <div class="day">
                        <p> الأستاذ </p>
                    </div>

                    <div class="day">
                        <p> التوقيت </p>
                    </div>
                </div>

                <?php schoolTimeTable($conn, "byTeacher") ?>
            </section>
        </section>
    </div>
    <div id="footer">
        <!--footer-->
        <?php include '../../includings/schoolFooter.php' ?>
    </div>

    <script src="../../js/sidebars.js"></script>

</body>