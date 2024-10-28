<?php
//session_start();
include '../../head.php';
include("../../init.php");
include '../../includings/studentRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
include '../../includings/functions.php';
include '../../includings/landingRedirection.php';



$halakahName = isset($_GET['halakah_name']) ? $_GET['halakah_name'] : '';
$halakah_id = isset($_GET['halakah_id']) ? $_GET['halakah_id'] : '';
$halakahBio = isset($_GET['halakah_bio']) ? $_GET['halakah_bio'] : '';
$halakahNbStudents = isset($_GET['halakah_nbstudents']) ? $_GET['halakah_nbstudents'] : '';
// after clicking search
if (isset($_POST['submit'])) {
    $tmp = $_POST['search'];
    $search = "%" . $tmp . "%";
    $stmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, COALESCE(sum(P.quran_memorized), 0) as sumMemo, COALESCE(sum(P.quran_revised), 0) as sumRevised
                                    FROM student S
                                    LEFT JOIN student_progress P ON S.student_id = P.student_id AND P.halakah_id = ?
                                    WHERE S.student_id IN (SELECT student_id FROM student_halakah WHERE halakah_id = ?)
                                    AND (S.student_fname like ? OR S.student_lname like ?)
                                    GROUP BY S.student_id");
    mysqli_stmt_bind_param($stmt, "ssss", $halakah_id, $halakah_id, $search, $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $stmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, COALESCE(sum(P.quran_memorized), 0) as sumMemo, COALESCE(sum(P.quran_revised), 0) as sumRevised
                                    FROM student S
                                    LEFT JOIN student_progress P ON S.student_id = P.student_id AND P.halakah_id = ?
                                    WHERE S.student_id IN (SELECT student_id FROM student_halakah WHERE halakah_id = ?)
                                    GROUP BY S.student_id");
    mysqli_stmt_bind_param($stmt, "ss", $halakah_id, $halakah_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
// keep session variable of halakahname
$_SESSION['halakahName'] = $halakahName;

// updating weekly timetable
$weektimetable = mysqli_prepare($conn, "SELECT T.timetalbe_week_day, T.timetalbe_session_start_time,T.timetalbe_session_end_time
                        From timetable T join halakah H
                        on T.halakah_id=H.halakah_id
                        where H.halakah_id=?");
mysqli_stmt_bind_param($weektimetable, "s", $halakah_id);
mysqli_stmt_execute($weektimetable);
$weekResult = mysqli_stmt_get_result($weektimetable);
//$weekRow = mysqli_fetch_assoc($Result);
?>


<title>Student Episode</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body dir="rtl">
    <!-- the navbar -->
    <?php include 'studentNav.html' ?>

    <div class="main">
        <!-- SIDE BAR -->
        <?php include 'studEpSidebar.php' ?>


        <section class="main_elements">
            <!--side bar toggler-->
            <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <!-- Episode information --->
            <div class="episode_info">
                <p class="episode_number"> الحلقة
                    <?php echo $halakahName ?>
                </p>
                <div class="episode_genre">
                    <p> تحفيظ القرآن الكريم </p>
                </div>
            </div>

            <!-- First (main) section-->
            <section style="display: block;" class="main-section panels_container" id="main-section">
                <div class="panel">
                    <div style="display: flex; justify-content: space-between;" class="title">
                        <p> عن الحلقة </p>
                    </div>
                    <div class="content">
                        <p class="content_element">
                            <?php
                            if (!empty($halakahBio)) {
                                echo $halakahBio;
                            } else {
                                echo "هذه الحلقة لا تحمل وصفا";
                            }
                            ?>
                        </p>
                    </div>

                </div><br>

                <div class="panel">
                    <div style="display: flex; justify-content: space-between;" class="title">
                        <p> قائمة الطلبة </p>
                    </div><br>
                    <form method="post" class="search_student">
                        <img src="../../assets/images/icons/search.png" alt="">
                        <input type="text" name="search" placeholder="ابحث عن طالب" required>
                        <input type="submit" name="submit" value="submit" hidden>
                    </form>
                </div><br>

                <?php
                if (isset($_POST['submit'])) {
                    ?>
                    <div style="font-size: 20px;">
                        <p>
                            <?php echo "نتائج البحث عن '$tmp'"; ?>
                        </p>
                    </div><br>
                <?php } ?>

                <div style="overflow-x: scroll;" class="students_list">

                    <div style="display: grid; gap:1%;" class="head row">
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                            class="box"> الاسم </div>
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                            class="box"> اللقب </div>
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                            class="box"> مقدار الحفظ </div>
                        <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                            class="box"> مقدار المراجعة </div>
                    </div>

                    <!-- Retreiving data from database -->
                    <div style="display: grid; gap:1%; grid-column-gap:1%"
                        class="student row">

                        <?php

                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                                class="box">
                                <?php echo $row['student_fname'] ?>
                            </div>
                            <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                                class="box">
                                <?php echo $row['student_lname'] ?>
                            </div>
                            <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                                class="box">
                                <?php echo $row['sumMemo'] ?>
                            </div>
                            <div style="display: flex; justify-content:flex-start; align-items:center; padding-right:10%"
                                class="box">
                                <?php echo $row['sumRevised'] ?>
                            </div>

                            <?php
                        }

                        ?>

                    </div>

                </div>
            </section>

        </section>
    </div>

    <!-- the footer -->

    <div id="footer">
        <?php include 'studentFooter.html' ?>
    </div>

    <script src="../../js/sidebars.js"></script>
</body>