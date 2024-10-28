<?php

include '../../head.php';
include("../../init.php");
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

include '../../includings/functions.php';

// getting the halakah_id
$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];
$halakah_bio = $_GET['halakah_bio'];

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
    $num_rows = mysqli_num_rows($result);
} else {
    $stmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, COALESCE(sum(P.quran_memorized), 0) as sumMemo, COALESCE(sum(P.quran_revised), 0) as sumRevised
                                    FROM student S
                                    LEFT JOIN student_progress P ON S.student_id = P.student_id AND P.halakah_id = ?
                                    WHERE S.student_id IN (SELECT student_id FROM student_halakah WHERE halakah_id = ?)
                                    GROUP BY S.student_id");
    mysqli_stmt_bind_param($stmt, "ss", $halakah_id, $halakah_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $num_rows = mysqli_num_rows($result);
}

// program days
$halakaView = mysqli_prepare($conn, "SELECT S.session_id, S.session_date, H.halakah_id
                                    from session S join halakah H 
                                    on H.halakah_id=S.halakah_id
                                    where S.halakah_id=?
                                    group by S.session_id;");
mysqli_stmt_bind_param($halakaView, "i", $halakah_id);
mysqli_stmt_execute($halakaView);
$resultView = mysqli_stmt_get_result($halakaView);

// array that helps in the weekly program
$day_names = array(
    'Sunday' => 'الأحد',
    'Monday' => 'الاثنين',
    'Tuesday' => 'الثلاثاء',
    'Wednesday' => 'الأربعاء',
    'Thursday' => 'الخميس',
    'Friday' => 'الجمعة',
    'Saturday' => 'السبت'
);


?>


<title>Episode</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<style>
    .studentSearchbar-input-form {
        display: flex;
        border: 1px solid black;
        border-radius: 20px;
        width: 100%;
    }

    input.studentSearchbar-input {
        border: none;
        width: 100%;
        padding: 10px 37px 10px 50px;
        border-radius: 20px;
        height: 55px;
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

            <div class="session">
                <div class="session-1">
                    <p class="session-1-text" style="justify-content: flex-start">عن الحلقة</p>
                </div>
                <div style="background-color: var(--whiteFFF); border-radius: 5px; width: 100%;" class="session-2">
                    <p class="session-2-text">
                        <?php
                        if ($halakah_bio) {
                            echo $halakah_bio;
                        } else {
                            echo "لا يوجد تعريف للحلقة";
                        }

                        ?>
                    </p>
                </div>
            </div>
            <div class="studentsList">
                <!-- timetable -->
                <?php //halakahTimeTable($conn) 
                ?>
                <div class="session-1">
                    <p class="session-1-text">قائمة الطلبة</p>
                    <p class="session-1-text" style="font-weight: 400;">
                        <?php showNumberOfStudents($conn, $halakah_id) . " طالب" ?>
                    </p>
                </div>


                <form method="post" class="studentSearchbar-input-form">
                    <input class="studentSearchbar-input" type="text" name="search" placeholder="ابحث عن الطالب">
                    <input style="display:none" type="submit" name="submit" value="submit" hidden>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    ?>
                    <div style="font-size: 20px;">
                        <p>
                            <?php echo "نتائج البحث عن '$tmp'"; ?>
                        </p>
                    </div>
                <?php } ?>

                <div style="overflow-x: scroll;">
                    <table class="studentsTable">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>اللقب</th>
                                <th>مقدار الحفظ</th>
                                <th>مقدار المراجعة</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- LIST OF STUDENTS -->
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row['student_fname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['student_lname'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['sumMemo'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['sumRevised'] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="footer">
        <?php include 'teacherFooter.html' ?>
    </div>

    <script src="../../js/sidebars.js"></script>

</body>