<?php

include '../../head.php';
include '../../init.php';
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
// getting the halakah_id
$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $duration_h = $_POST['hour_duration'];
    $duration_m = $_POST['minute_duration'];

    $errors = array();

    if (
        !is_numeric($day) or !is_numeric($month) or !is_numeric($year)
        or !is_numeric($hour) or !is_numeric($minute)
        or !is_numeric($duration_h) or !is_numeric($duration_m)
        or $day <= 0 or $day > 31
        or $month <= 0 or $month > 12
        or $hour < 0 or $hour >= 24
        or $minute < 0 or $minute >= 60
        or $duration_h < 0 or $duration_m < 0 or $duration_m >= 60
    ) {
        array_push($errors, "لقد أدخلت معلومات خاطئة");
    }

    // formatting the data:
    $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
    $time = $hour . ":" . $minute;
    $duration = ($duration_h * 60) + $duration_m;

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div style='margin: 100px auto -60px; display: flex; justify-content: center; font-size: 24px;' class='alert alert-danger'>$error</div>";
        }
    } else {
        // adding the exam
        $stmt = mysqli_prepare($conn, "INSERT into exams(exam_name, halakah_id, exam_date, exam_period, exam_description, exam_time)
                                        values(?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "sissss", $title, $halakah_id, $date, $duration, $desc, $time);
        mysqli_stmt_execute($stmt);

        // get the exam id of the added exam
        $examID = mysqli_prepare($conn, "SELECT exam_id from exams where exam_id=(select max(exam_id) from exams)");
        mysqli_stmt_execute($examID);
        $idResult = mysqli_stmt_get_result($examID);
        $rowID = mysqli_fetch_assoc($idResult);

        // adding the students of the halakah to the exam
        // first, we query all student of the halakah
        $halakahStudents = mysqli_prepare($conn, "SELECT H.student_id from student_halakah H where halakah_id=?");
        mysqli_stmt_bind_param($halakahStudents, "i", $halakah_id);
        mysqli_stmt_execute($halakahStudents);
        $studRes = mysqli_stmt_get_result($halakahStudents);
        while ($studRow = mysqli_fetch_assoc($studRes)) {
            $addStuds = mysqli_prepare($conn, "INSERT into grades(exam_id, student_id, remark, mark) values(?,?,'ناجح', 10)");
            mysqli_stmt_bind_param($addStuds, "ii", $rowID['exam_id'], $studRow['student_id']);
            mysqli_stmt_execute($addStuds);
        }
        header("Location: examList.php?halakah_id={$halakah_id}&halakah_name={$halakah_name}");
    }
}

?>


<title>Next multiple choice exam</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<style>
    
</style>
</head>

<body dir="rtl">
    <!--Nav bar-->
    <div class="main">
        <?php include '../Teacher/teacherNav.html' ?>

        <?php include 'hala9aSidebar.php' ?>

        <!--side bar toggler-->
        <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">

        <div class="newExam" style="width: 75%; display:inline-block">
            <div class="hala9a-num">
                <p class="text-1">
                    <?php echo "الحلقة: " . $halakah_name ?>
                </p>
                <p class="text-2">تحفيظ القران الكريم</p>
            </div>
            <form action="" method="post">
                <div class="session">
                    <input class="newExamText" type="text" name="title" placeholder="عنوان الامتحان" required></input>
                    <textarea class="newExamText" name="description" style="height:150px;margin-top:0;margin-bottom:0px"
                        rows="4" placeholder="هنا أضف وصف أو تعليمات للامتحان..."></textarea>
                </div>

                <div id="DateExam" class="DateExam">
                    <div class="Date Mean" style="width:97%;padding: 10px 30px 10px 10px">موعد الامتحان</div>
                    <div class="MultipleChoices">
                        <div class="exam_container">
                            <div class="newExamDate">
                                <div class="respons_exam"
                                    style="border: 1px solid var(--darkblue); margin:10px; margin-right:0;">موعد
                                    اطلاق الامتحان
                                </div>
                                <div class="exam_date_time">
                                    <div class="date_exam central_time" style="display: flex; flex-direction:row">
                                        <p style="display:inline;margin:auto 0;padding:auto">يوم</p>
                                        <input type="text" class="MeanNumber" name="day"
                                            style="width:50px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                            required>
                                        <p style="display:inline;margin:auto 0;padding:auto">/</p>
                                        <input type="text" class="MeanNumber" name="month"
                                            style="width:50px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                            required>
                                        <p style="display:inline;margin:auto 0;padding:auto">/</p>
                                        <input type="text" class="MeanNumber" name="year"
                                            style="width:70px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                            required>
                                    </div>
                                    <div class="hour_exam central_time" style="display: flex; flex-direction:row">
                                        <p style="display:inline;margin:auto 0;padding:auto">على</p>
                                        <input type="text" class="MeanNumber" name="hour"
                                            style="width:50px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                            required>
                                        <p style="display:inline;margin:auto 0;padding:auto">:</p>
                                        <input type="text" class="MeanNumber" name="minute"
                                            style="width:50px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="newExamDate">
                                <div class="respons_exam"
                                    style="border: 1px solid var(--darkblue);margin:10px;margin-right:0">مدة
                                    الامتحان</div>
                                <div class="duration_exam" style="display: flex; flex-direction:row">
                                    <input type="text" class="MeanNumber" name="hour_duration"
                                        style="width:50px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                        required>
                                    <p style="display:inline;margin:auto 0;padding:auto">ساعة</p>
                                    <input type="text" class="MeanNumber" name="minute_duration"
                                        style="width:50px;border: 1px solid var(--darkblue);margin:10px;padding:10px; text-align:center"
                                        required>
                                    <p style="display:inline;margin:auto 0;padding:auto">دقيقة</p>
                                </div>
                            </div>
                        </div>
                    </div><br><br>
                    <div style="display:flex; justify-content:flex-end" class="session-3">
                        <button class="session-3-text" name="submit" style="font-family: 'Cairo';"
                            href="examList.php">اضافة</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <div id="footer">
        <?php include 'teacherFooter.html' ?>
    </div>

    <script src="../../js/sidebars.js"></script>

    <script>
        function Onsite() {
            // make the p color all blue
            // change onsite class display from none to something else
            // change multi class display to none
            document.getElementsById("onsite").style = "background-color: var(--mainblue)";
            document.getElementsById("multi").style = "background-color: var(--whiteFFF)";
            document.getElementsById("multiExam").style = "display: none";
        }

        function Multiple() {
            // make the p color all blue
            // change multi class display from none to something else
            // change onsite class display to none
            document.getElementsById("multi").style = "background-color: var(--mainblue)";
            document.getElementsById("onsite").style = "background-color: var(--whiteFFF)";
            document.getElementsById("multiExam").style = "display: block";
        }
    </script>
</body>