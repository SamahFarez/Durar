<?php

//session_start();
include '../../head.php';
include '../../init.php';
include '../../includings/functions.php';
include '../../includings/studentRedirection.php';
include '../../includings/noSchool_unauthorized.php';
include '../../includings/landingRedirection.php';


// Get the school name and student_id
$schoolStmt = mysqli_prepare($conn, "SELECT st.student_id, S.school_name, st.school_id, S.school_email
                              From school S join student st
                              on S.school_id=st.school_id
                              where st.student_email=?");
mysqli_stmt_bind_param($schoolStmt, "s", $_SESSION['email']);
mysqli_stmt_execute($schoolStmt);
$schoolResult = mysqli_stmt_get_result($schoolStmt);
$schoolRow = mysqli_fetch_assoc($schoolResult);

$_SESSION['school_name'] = $schoolRow['school_name'];
$_SESSION['student_id'] = $schoolRow['student_id'];
$student_id = $schoolRow['student_id'];


// Get Halakah information
$epsStmt = mysqli_prepare($conn, "SELECT H.halakah_id, H.halakah_name, H.halakah_bio, H.class_name, H.halakah_nbstudents, S.student_id
                                FROM halakah H
                                JOIN student_halakah S ON S.halakah_id = H.halakah_id
                                WHERE S.student_id = ?
                                GROUP BY H.halakah_id, H.halakah_name, H.halakah_bio, H.class_name, H.halakah_nbstudents, S.student_id");
mysqli_stmt_bind_param($epsStmt, "i", $student_id);
mysqli_stmt_execute($epsStmt);
$epsResult = mysqli_stmt_get_result($epsStmt);


// timetable updates :


?>
<title>Student</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/User/userMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
</head>

<body dir="rtl">
    <!--Nav bar-->
    <?php include 'studentNav.html' ?>
    
    <!-- welcome -->
    <section class="welcome" id="welcome">
        <div class="welcome_elements">
            <div style="background-image: url('../../assets/images/Admin/art-lanterns-middle-eastern-background 1.png');
            background-repeat: no-repeat; background-size: cover; width: 100%; height: 330px; border-radius: 5px;
            display: flex; flex-direction: column; justify-content: center; color: var(--whiteFFF); text-shadow: 2px 2px 2px black;" class="schoolPanel">
                <p style="font-weight: 700;
               font-size: 24px;
               line-height: 45px;
               margin-bottom: -20px;
               margin: 0 auto;
               "> مرحبا بكم في مدرسة
                </p>
                <p style="font-family: 'Reem Kufi';
               font-size: 40px;
               line-height: 60px;
               margin: 0 auto;
               "> <?php echo $schoolRow['school_name'] ?>
                </p>
            </div>
            <a href="../School/index.php?school_id=<?php echo $schoolRow['school_id'] ?>">
                <div class="main-button">
                    الصفحة الرئيسية للمدرسة
                </div>
            </a>
        </div>
    </section>

    <!-- episodes -->
    <section class="eps" id="episodes">
        <div class="title">
            <p> حلقاتي </p>
        </div>
        <div class="eps_elements">
            <?php
            while ($epsRow = mysqli_fetch_assoc($epsResult)) {

            ?>
                <a href="episode.php?halakah_id=<?php echo urlencode($epsRow['halakah_id']) ?>&halakah_name=<?php echo urlencode($epsRow['halakah_name']) ?>&halakah_bio=<?php echo $epsRow['halakah_bio'] ?>">
                    <div class=" grid_element">
                        <div class="ep_first">
                            <div class="ep_title"> الحلقة <?php echo $epsRow['halakah_name'] ?> </div>
                            <div style=" padding-top: 10px;" class="ep_genre">
                                تحفيظ القرآن الكريم
                            </div>
                        </div>
                        <p class="ep_desc">
                            <?php
                            if ($epsRow['halakah_bio'] == "") {
                                echo "لا يوجد تعريف للحلقة";
                            } else {
                                echo $epsRow['halakah_bio'];
                            }
                            ?>
                        </p>
                        <p class="ep_cap">
                            <?php echo $epsRow['halakah_nbstudents'] . " طالب" ?>
                        </p>
                    </div>
                </a>
            <?php } ?>

        </div>
    </section>
    <!-- timetable -->
    <?php studentTimeTable($conn) ?>
    <!-- footer -->
    <div id="footer">
        <?php include 'studentFooter.html' ?>
    </div>
</body>
