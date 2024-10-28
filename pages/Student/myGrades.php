<?php

include '../../init.php';
include '../../head.php';
include '../../includings/studentRedirection.php';
include '../../includings/landingRedirection.php';


$halakahName = isset($_SESSION['halakahName']) ? $_SESSION['halakahName'] : '';

// exams and mark by order
$order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Default order is ascending

// Perform the SQL query to retrieve the exams based on the order
if ($order === 'asc') {
    $orderBy = 'ASC';
} elseif ($order === 'desc') {
    $orderBy = 'DESC';
} else {
    $orderBy = ''; // Default order (if order parameter is not set or invalid)
}
// show the exams of the halakah
$examhalakah = mysqli_prepare($conn, "SELECT S.student_id, E.exam_id, E.exam_name, G.mark
                                    from grades G join student S 
                                    on G.student_id=S.student_id
                                    join exams E 
                                    on G.exam_id=E.exam_id
                                    where S.student_email=? AND E.exam_date < NOW()
                                    group by E.exam_id");
mysqli_stmt_bind_param($examhalakah, "s", $_SESSION['email']);
mysqli_stmt_execute($examhalakah);
$examResult = mysqli_stmt_get_result($examhalakah);

// get the average of all exams of one halakah
$averagehalakah = mysqli_prepare($conn, "SELECT S.student_id, E.exam_name, ROUND(avg(G.mark), 2) as average
                                        FROM grades G 
                                        JOIN student S ON G.student_id=S.student_id 
                                        JOIN exams E ON G.exam_id=E.exam_id 
                                        WHERE S.student_email=? AND E.exam_date < NOW()");
mysqli_stmt_bind_param($averagehalakah, "s", $_SESSION['email']);
mysqli_stmt_execute($averagehalakah);
$Result_avg = mysqli_stmt_get_result($averagehalakah);
$row_avg = mysqli_fetch_assoc($Result_avg);

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

            <section style="display: block;" class="my_grades panels_container" id="my_grades">
                <div class="panel">
                    <div style="display: flex; border-radius: 5px; margin-bottom: 10px;" class="title">
                        <p> العلامات </p>
                    </div>

                    <div style="margin-top: 10px;" class="grades_list">

                        <div class="head row">
                            <div class="box title_of_exam"> الامتحان </div>
                            <div class="box grade_of_exam"> العلامة </div>
                        </div>
                        <?php
                        while ($examRow = mysqli_fetch_assoc($examResult)) {
                            ?>

                        <div class="exam row">
                            <div class="box title_of_exam">
                                <?php echo $examRow['exam_name'] ?>
                            </div>
                            <div class="box grade_of_exam">
                                <?php echo $examRow['mark'] ?>/20
                            </div>
                        </div>
                        <?php } ?>


                        <div class="head row">
                            <div class="box title_of_exam"> المعدل </div>
                            <div style="background-color: var(--whiteFFF); color: var(--black); font-weight: 400; border: 1px solid var(--mainblue);"
                                class="box grade_of_exam">
                                <?php echo ($row_avg['average'] != 0) ? $row_avg['average'] : 0 ?>/20
                            </div>
                        </div>

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