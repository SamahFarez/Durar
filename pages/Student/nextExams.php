<?php

include '../../init.php';
include '../../head.php';
include '../../includings/studentRedirection.php';
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

$halakah_id = isset($_GET['halakah_id']) ? $_GET['halakah_id'] : '';
$halakahName = isset($_SESSION['halakahName']) ? $_SESSION['halakahName'] : '';
$nextexams = mysqli_prepare($conn, "SELECT E.exam_name, E.exam_date, E.exam_time
                                      FROM exams E JOIN halakah H 
                                      ON E.halakah_id = H.halakah_id 
                                      WHERE H.halakah_id = ? AND E.exam_date > NOW()");
mysqli_stmt_bind_param($nextexams, "s", $halakah_id);
mysqli_stmt_execute($nextexams);
$result = mysqli_stmt_get_result($nextexams);
//$nextexamrow = mysqli_fetch_assoc($result);
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
                    <?php echo $halakahName; ?>
                </p>
                <div class="episode_genre">
                    <p> تحفيظ القرآن الكريم </p>
                </div>
            </div>

            <section style="display: block;" class="next_exams panels_container" id="next_exams">
                <div class="panel exams">
                    <div style="display: flex; justify-content: space-between;" class="title">
                        <p> الامتحانات المقبلة </p>
                    </div><br>
                    <div class="all_exams">
                        <!-- Weekly program -->
                        <?php
                        while ($nextexamrow = mysqli_fetch_assoc($result)) {
                            ?>

                            <div style="text-align: center; padding: 10px 10px; background: var(--whiteFFF); border: 1px solid var(--mainblue); border-radius: 20px;"
                                class="exam_container">
                                <p style="font-weight: 500; line-height: 36px; color: var(--mainblue);"
                                    class="exam_title">
                                    <?php echo $nextexamrow['exam_name'] ?>
                                </p>
                                <hr>
                                <p class="exam_type"> حضوري </p>
                                <hr>
                                <p style="color: var(--mainblue); padding: 10px 0;" class="exact_time">
                                    يوم:
                                    <br>
                                    <span dir=rtl style="color: var(--black);" class="time">
                                        <?php echo $nextexamrow['exam_date'] ?>
                                        <br>
                                    </span> على:
                                    <span style="color: var(--black);" class="time">
                                        <?php echo $nextexamrow['exam_time'] ?>
                                    </span>
                                </p>
                            </div>
                        <?php } ?>

                    </div>
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