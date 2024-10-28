<?php

include '../../head.php';
include("../../init.php");
// unauthorized access
include '../../includings/teacherRedirection.php';
// non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
// getting the halakah_id
$halakah_id = $_GET['halakah_id'];
$halakah_name = $_GET['halakah_name'];

// after clicking search
if (isset($_POST['submit'])) {
    $tmp = $_POST['search'];
    $search = "%" . $tmp . "%";
    $stmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, COALESCE(count(P.session_id), 0) as countAbs 
                                    FROM student S 
                                    LEFT JOIN student_progress P ON S.student_id = P.student_id AND P.halakah_id=? AND P.student_state = 'غائب'
                                    WHERE S.student_id IN (SELECT student_id FROM student_halakah WHERE halakah_id=?)
                                    AND (S.student_fname like ? OR S.student_lname like ?)
                                    GROUP BY S.student_id;");
    mysqli_stmt_bind_param($stmt, "ssss", $halakah_id, $halakah_id, $search, $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $stmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, COALESCE(count(P.session_id), 0) as countAbs 
                                    FROM student S 
                                    LEFT JOIN student_progress P ON S.student_id = P.student_id AND P.halakah_id=? AND P.student_state = 'غائب'
                                    WHERE S.student_id IN (SELECT student_id FROM student_halakah WHERE halakah_id=?)
                                    GROUP BY S.student_id;");
    mysqli_stmt_bind_param($stmt, "ss", $halakah_id, $halakah_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}

// the graph 
$graphStmt = mysqli_prepare($conn, "SELECT S.session_number, count(P.student_id) AS attendCount
                                FROM session S JOIN student_progress P
                                ON S.session_id = P.session_id
                                WHERE P.student_state='حاضر' and P.halakah_id=?
                                GROUP BY P.session_id;");
mysqli_stmt_bind_param($graphStmt, "s", $halakah_id);
mysqli_stmt_execute($graphStmt);
$student_attendance = mysqli_stmt_get_result($graphStmt);
while ($stud_attendance_row = mysqli_fetch_assoc($student_attendance)) {
    $session[] = "الحصة " . $stud_attendance_row['session_number'];
    $attendance[] = $stud_attendance_row['attendCount'];
    $bgColor[] = 'rgba(2, 120, 168, 0.8)';
    $borderColor[] = 'rgb(54, 162, 235)';
}
?>


<title>Episode</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<style>
    canvas {
        width: 60%;
    }

    /*graphs*/
    @media (max-width: 1400px) {
        canvas {
            width: 90%;
        }
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
                    <p class="session-1-text" style="justify-content: flex-start">عدد الحضور في الحصص الأخيرة</p>
                </div>
                <div style="background-color: var(--whiteFFF); width:100%;" class="absenceGraph">
                    <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                        id="student_absence_graph"></canvas>
                </div>
            </div>
            <div class="studentsList">

                <div class="session-1">
                    <p class="session-1-text">عدد الغيابات لكل طالب</p>
                </div>

                <form method="post" class="studentSearchbar-input-form">
                    <input class="studentSearchbar-input" type="text" name="search" placeholder="ابحث عن الطالب">
                    <input style="display:none" type="submit" name="submit" value="submit" hidden>
                </form>

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
                                <th>عدد الغيابات</th>
                                <th>عدد الغيابات المبررة</th>
                            </tr>
                        </thead>
                        <tbody>

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
                                        <?php echo $row['countAbs'] ?>
                                    </td>
                                    <td>
                                        <?php echo 0 ?>
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

    <!-- Student absence graph -->
    <script>
        const labels = <?php echo json_encode($session) ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: 'عدد الحضور',
                data: <?php echo json_encode($attendance) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'الحصص',
                            font: {
                                size: 20,
                                weight: 'bold',
                                family: 'Cairo'
                            }
                        },
                        ticks: {
                            color: 'black',
                            fontSize: 20
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'الحضور',
                            font: {
                                size: 20,
                                weight: 'bold',
                                family: 'Cairo'
                            }
                        },
                        ticks: {
                            color: 'black',
                            fontSize: 20
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                elements: {
                    bar: {
                        borderColor: 'red',
                        borderWidth: 1
                    }
                }
            },
        };

        var student_absence_graph = new Chart(
            document.getElementById('student_absence_graph'),
            config
        );
    </script>
</body>