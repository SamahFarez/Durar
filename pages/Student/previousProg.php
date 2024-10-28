<?php

include '../../init.php';
include '../../head.php';
include '../../includings/studentRedirection.php';
include '../../includings/landingRedirection.php';

$halakahName = isset($_SESSION['halakahName']) ? $_SESSION['halakahName'] : '';
$halakah_id = isset($_GET['halakah_id']) ? $_GET['halakah_id'] : '';

// getting logged in student id
$student_id_query = mysqli_prepare($conn, "SELECT student_id FROM student WHERE student_email = ?");
mysqli_stmt_bind_param($student_id_query, "s", $_SESSION['email']);
mysqli_stmt_execute($student_id_query);
$result_student_id = mysqli_stmt_get_result($student_id_query);
$row_student_id = mysqli_fetch_assoc($result_student_id);

//count student progress
$studentStmt = mysqli_prepare($conn, "SELECT sum(quran_memorized) as memorized, sum(quran_revised) as revised, P.student_id, P.halakah_id
                                      FROM student_progress P JOIN halakah H 
                                      ON P.halakah_id = H.halakah_id 
                                      WHERE H.halakah_id = ? AND P.student_id=?
                                      GROUP BY P.student_id, H.halakah_id");
mysqli_stmt_bind_param($studentStmt, "ii", $halakah_id, $row_student_id['student_id']);
mysqli_stmt_execute($studentStmt);
$result = mysqli_stmt_get_result($studentStmt);
$row = mysqli_fetch_assoc($result);

// count the number of absences of students
$studentAbsence = mysqli_prepare($conn, "SELECT count(*) as numberofabsence
                                      FROM student_progress  
                                      WHERE student_state='غائب' and student_id = ? and halakah_id =? ");
mysqli_stmt_bind_param($studentAbsence, "ii", $row['student_id'], $row['halakah_id']);
mysqli_stmt_execute($studentAbsence);
$result_absence = mysqli_stmt_get_result($studentAbsence);
$numberofabsences = mysqli_fetch_assoc($result_absence);

// count the number of sessions
$studentsession = mysqli_prepare($conn, "SELECT count(session_id) as numberofsessions
                                      FROM student_progress  
                                      WHERE student_id = ? and halakah_id =? ");
mysqli_stmt_bind_param($studentsession, "ii", $row['student_id'], $row['halakah_id']);
mysqli_stmt_execute($studentsession);
$result_sessions_count = mysqli_stmt_get_result($studentsession);
$numberofsessions = mysqli_fetch_assoc($result_sessions_count);

// select all information from student_progress
$studentprogress = mysqli_prepare($conn, "SELECT P.session_id, S.session_number, P.student_evaluation, P.quran_memorized, P.quran_revised, P.student_state 
                                      FROM student_progress P join session S on S.session_id=P.session_id 
                                      WHERE P.student_id = ? and P.halakah_id =? ");
mysqli_stmt_bind_param($studentprogress, "ii", $row['student_id'], $row['halakah_id']);
mysqli_stmt_execute($studentprogress);
$result = mysqli_stmt_get_result($studentprogress);
//$progress = mysqli_fetch_assoc($result);

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

            <section style="display: block;" class="previous_episodes panels_container" id="previous_episodes">
                <div class="panel stats">
                    <div style="display: flex; justify-content: space-between;" class="title">
                        <p> احصائيات عامة </p>
                    </div><br>
                    <div class="all_stats">
                        <!-- Weekly program -->
                        <div class="stat_container">

                            <p class="stat_data"> عدد الغيابات </p>

                            <hr style="margin: 10px auto;">

                            <p class="stat_instance">
                                <?php echo $numberofabsences['numberofabsence'] ?>
                            </p>

                        </div>
                        <div class="stat_container">

                            <p class="stat_data"> مقدار الحفظ </p>

                            <hr style="margin: 10px auto;">

                            <p class="stat_instance">
                                <?php
                                if (isset($row['memorized'])) {
                                    echo ($row['memorized'] != 0) ? $row['memorized'] : 0;
                                }
                                ?> صفحة
                            </p>

                        </div>
                        <div class="stat_container">
                            <p class="stat_data"> مقدار المراجعة </p>

                            <hr style="margin: 10px auto;">

                            <p class="stat_instance">
                                <?php
                                if (isset($row['revised'])) {
                                    echo ($row['revised'] != 0) ? $row['revised'] : 0;
                                }
                                ?> صفحة
                            </p>

                        </div>
                    </div>
                </div><br>

                <div class="panel">
                    <div style="display: flex; justify-content: space-between;" class="title">
                        <p> قائمة الحصص </p>
                        <p style="font-weight: 400;">
                            <?php echo $numberofsessions['numberofsessions'] ?> حصة
                        </p>
                    </div>
                </div>

                <div style="margin-top: 10px;" class="sessions_list">

                    <div class="head row">
                        <div class="box"> الحصة </div>
                        <div class="box"> الحفظ </div>
                        <div class="box"> المراجعة </div>
                        <div class="box"> التقييم </div>
                        <div class="box"> الحضور </div>
                    </div>
                    <?php while ($progress = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="session row">
                            <div class="box">
                                <?php echo "الحصة " . $progress['session_number'] ?>
                            </div>
                            <div class="box">
                                <span>
                                    <?php echo $progress['quran_memorized'] . " صفحة" ?>
                                </span>
                            </div>
                            <div class="box">
                                <span>
                                    <?php echo $progress['quran_revised'] . " صفحة" ?>
                                </span>
                            </div>
                            <div class="box">
                                <?php echo $progress['student_evaluation'] ?>/20
                            </div>
                            <div class="box">
                                <?php echo $progress['student_state'] ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </section>

        </section>
    </div>

    <!-- the footer -->

    <div id="footer">
        <?php include 'studentFooter.html' ?>
    </div>

    <script src="../../js/studentEp.js"></script>
    <script src="../../js/sidebars.js"></script>

</body>