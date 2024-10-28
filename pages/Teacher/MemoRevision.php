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

// the graph of learning and revision
$learningRevisionStmt = mysqli_prepare($conn, "SELECT S.session_number, avg(P.quran_memorized) AS learning_average, avg(P.quran_revised) AS revision_average
                                            FROM session S JOIN student_progress P
                                            ON S.session_id = P.session_id
                                            WHERE P.halakah_id=?
                                            GROUP BY P.session_id;");
mysqli_stmt_bind_param($learningRevisionStmt, "i", $halakah_id);
mysqli_stmt_execute($learningRevisionStmt);
$learning_revision_average = mysqli_stmt_get_result($learningRevisionStmt);
while ($learning_revision_row = mysqli_fetch_assoc($learning_revision_average)) {
    $sessions[] = "الحصة " . $learning_revision_row['session_number'];
    $learning_average[] = $learning_revision_row['learning_average'];
    $revision_average[] = $learning_revision_row['revision_average'];
    $bgColor[] = 'rgba(2, 120, 168, 0.8)';
    $borderColor[] = 'rgb(54, 162, 235)';
}

// best learning
$bestLearnStmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, P.quran_memorized
                                        FROM student S JOIN student_progress P
                                        ON S.student_id=P.student_id
                                        WHERE P.halakah_id=? AND P.quran_memorized = (SELECT max(quran_memorized) FROM student_progress where halakah_id=?)
                                        limit 1");
mysqli_stmt_bind_param($bestLearnStmt, "ii", $halakah_id, $halakah_id);
mysqli_stmt_execute($bestLearnStmt);
$best_learn = mysqli_stmt_get_result($bestLearnStmt);
$best_learn_row = mysqli_fetch_assoc($best_learn);

// best revision
$bestRevisionStmt = mysqli_prepare($conn, "SELECT S.student_fname, S.student_lname, P.quran_revised
                                        FROM student S JOIN student_progress P
                                        ON S.student_id=P.student_id
                                        WHERE P.halakah_id=? AND P.quran_revised = (SELECT max(quran_revised) FROM student_progress where halakah_id=?)
                                        limit 1");
mysqli_stmt_bind_param($bestRevisionStmt, "ii", $halakah_id, $halakah_id);
mysqli_stmt_execute($bestRevisionStmt);
$best_revision = mysqli_stmt_get_result($bestRevisionStmt);
$best_revision_row = mysqli_fetch_assoc($best_revision);
?>


<title>Memo and revision </title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<style>
    .learning_revision_graphs {
        display: flex;
        flex-direction: row;
        gap: 10px
    }

    canvas {
        width: 60%;
    }

    /*graphs*/
    @media (max-width: 1400px) {
        .learning_revision_graphs {
            flex-direction: column;
        }

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

        <div class="newExam" style="width: 75%; display:inline-block">
            <div class="hala9a-num">
                <p class="text-1">
                    <?php echo "الحلقة: " . $halakah_name ?>
                </p>
                <p class="text-2">تحفيظ القران الكريم</p>
            </div>
            <div class="session">

                <div class="session-1">
                    <p style="text-align:center" class="session-1-text">أفضل انجاز في اخر حصة</p>
                </div>
            </div>

            <div id="DateExam" class="DateExam">
                <div class="MultipleChoices">
                    <div style="display:flex; flex-direction:column; gap: 10px">
                        <div class="best-learner">
                            <div class="category"> أفضل حفظ </div>
                            <div class="data">
                                <?php echo $best_learn_row['student_fname'] . " " . $best_learn_row['student_lname'] ?>
                            </div>
                            <div class="data">
                                <?php echo $best_learn_row['quran_memorized'] . " صفحة" ?>
                            </div>
                        </div>
                        <div class="best-learner">
                            <div class="category">
                                أفضل مراجعة</div>
                            <div class="data">
                                <?php echo $best_revision_row['student_fname'] . " " . $best_revision_row['student_lname'] ?>
                            </div>
                            <div class="data">
                                <?php echo $best_revision_row['quran_revised'] . " صفحة" ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top:10px" class="session-1">
                <p style="text-align:center" class="session-1-text">معدل الانجاز في الحصص الأخيرة</p>
            </div>

            <div class="learning_revision_graphs">
                <div style="background-color: var(--whiteFFF); width:100%;" class="session_learning_graph">
                    <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                        id="session_learning_graph"></canvas>
                </div>
                <div style="background-color: var(--whiteFFF); width:100%;" class="session_revision_graph">
                    <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                        id="session_revision_graph"></canvas>
                </div>
            </div>

        </div>

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

        // the graphs of learning and revision
        const labels = <?php echo json_encode($sessions) ?>;

        // the learning graph
        const data1 = {
            labels: labels,
            datasets: [{
                label: 'معدلات الحفظ',
                data: <?php echo json_encode($learning_average) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1,
                pointRadius: 5
            }]
        };

        const config1 = {
            type: 'line',
            data: data1,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'الحصة',
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
                            text: 'معدل الحفظ',
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

        var session_learning_graph = new Chart(
            document.getElementById('session_learning_graph'),
            config1
        );

        // the revision graph
        const data2 = {
            labels: labels,
            datasets: [{
                label: 'معدلات المراجعة',
                data: <?php echo json_encode($revision_average) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1,
                pointRadius: 5
            }]
        };

        const config2 = {
            type: 'line',
            data: data2,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'الحصة',
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
                            text: 'معدل المراجعة',
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

        var session_revision_graph = new Chart(
            document.getElementById('session_revision_graph'),
            config2
        );
    </script>
</body>