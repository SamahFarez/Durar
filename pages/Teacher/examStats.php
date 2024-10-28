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
    $stmt = mysqli_prepare($conn, "SELECT e.exam_name, e.exam_date,
                            COUNT(CASE WHEN se.mark >= 10 THEN 1 END) AS successful_count,
                            COUNT(CASE WHEN se.mark < 10 THEN 1 END) AS failing_count 
                            FROM exams e JOIN grades se
                            ON e.exam_id = se.exam_id 
                            WHERE e.exam_name LIKE ? and e.halakah_id=? and e.exam_date < NOW()
                            GROUP BY e.exam_id");
    mysqli_stmt_bind_param($stmt, "si", $search, $halakah_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $stmt = mysqli_prepare($conn, "SELECT e.exam_name, e.exam_date,
                                COUNT(CASE WHEN se.mark >= 10 THEN 1 END) AS successful_count,
                                COUNT(CASE WHEN se.mark < 10 THEN 1 END) AS failing_count
                                FROM exams e JOIN grades se
                                ON e.exam_id = se.exam_id
                                where e.halakah_id=? and e.exam_date < NOW()
                                GROUP BY e.exam_id;");
    mysqli_stmt_bind_param($stmt, "i", $halakah_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}


// the graph 
$graphStmt = mysqli_prepare($conn, "SELECT E.exam_name, ROUND(AVG(S.mark), 2) AS average
                                    FROM exams E JOIN grades S
                                    ON E.exam_id=S.exam_id
                                    where E.halakah_id=? and E.exam_date < NOW()
                                    GROUP BY E.exam_id;");
mysqli_stmt_bind_param($graphStmt, "i", $halakah_id);
mysqli_stmt_execute($graphStmt);
$exam_average = mysqli_stmt_get_result($graphStmt);
while ($exam_average_row = mysqli_fetch_assoc($exam_average)) {
    $exams[] = $exam_average_row['exam_name'];
    $average[] = $exam_average_row['average'];
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
                <p class="text-1"><?php echo "الحلقة: " . $halakah_name ?></p>
                <p class="text-2">تحفيظ القران الكريم</p>
            </div>
            <div class="session">
                <div class="session-1">
                    <p class="session-1-text" style="justify-content: flex-start">المعدلات العامة في الامتحانات</p>
                </div>
                <div style="background-color: var(--whiteFFF); width:100%;" class="examsAverageGraph">
                    <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px" id="exams_average_graph"></canvas>
                </div>
            </div>
            <div class="studentsList">

                <div class="session-1">
                    <p class="session-1-text">النجاح والرسوب</p>
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
                                <th>الامتحان</th>
                                <th>التاريخ</th>
                                <th>عدد الناجحين</th>
                                <th>عدد الراسبين</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- LIST OF EXAMS -->
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td> <?php echo $row['exam_name'] ?> </td>
                                    <td> <?php echo $row['exam_date'] ?> </td>
                                    <td> <?php echo $row['successful_count'] ?> </td>
                                    <td> <?php echo $row['failing_count'] ?> </td>
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
        const labels = <?php echo json_encode($exams) ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: 'معدلات الامتحانات',
                data: <?php echo json_encode($average) ?>,
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
                            text: 'الامتحان',
                            font: {
                                size: 20,
                                weight: 'bold',
                                family: 'Cairo'
                            }
                        },
                        ticks: {
                            color: 'black',
                            fontSize: 20,
                        },
                        beginAtZero: false
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'المعدل',
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
            document.getElementById('exams_average_graph'),
            config
        );
    </script>
</body>