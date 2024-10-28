<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../head.php';
include("../../init.php");
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

// getting the halakah_id of the selected halakah
if (isset($_GET['halakah_id'])) {
    $halakah_id = $_GET['halakah_id'];
}

// getting school id
if ($_SESSION['role'] == 'administrator') {
    $stmt = mysqli_prepare($conn, "SELECT school_id from administrator where admin_email=?");
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $school_id = $row['school_id'];
} else {
    $school_id = $_SESSION['school_id'];
}

// the graph of learning and revision
$graph1and2Stmt = mysqli_prepare($conn, "SELECT H.halakah_name, ROUND(AVG(P.quran_memorized), 2) as averageMemo, ROUND(AVG(P.quran_revised), 2) as averageRevised
                                    from halakah H left join student_progress P
                                    on H.halakah_id=P.halakah_id
                                    where H.school_id=? group by H.halakah_id;");
mysqli_stmt_bind_param($graph1and2Stmt, "i", $school_id);
mysqli_stmt_execute($graph1and2Stmt);
$all_learning_revision_average = mysqli_stmt_get_result($graph1and2Stmt);
while ($all_learning_revision_row = mysqli_fetch_assoc($all_learning_revision_average)) {
    $halakah[] = "الحلقة  " . $all_learning_revision_row['halakah_name'];
    $all_learning_average[] = $all_learning_revision_row['averageMemo'];
    $all_revision_average[] = $all_learning_revision_row['averageRevised'];
    $bgColor[] = 'rgba(2, 120, 168, 0.8)';
    $borderColor[] = 'rgb(54, 162, 235)';
}

// halakat
$sql = mysqli_prepare($conn, "SELECT halakah_id, halakah_name FROM halakah where school_id=?");
mysqli_stmt_bind_param($sql, "s", $school_id);
mysqli_stmt_execute($sql);
$result = mysqli_stmt_get_result($sql);

// the graph of learning and revision of a specific episode
$graph3and4Stmt = mysqli_prepare($conn, "SELECT S.session_number, ROUND(avg(P.quran_memorized), 2) AS learning_average, ROUND(avg(P.quran_revised), 2) AS revision_average
                                        FROM session S JOIN student_progress P
                                        ON S.session_id = P.session_id
                                        WHERE P.halakah_id=?
                                        GROUP BY P.session_id;
                                        ");
mysqli_stmt_bind_param($graph3and4Stmt, "i", $halakah_id);
mysqli_stmt_execute($graph3and4Stmt);
$learning_revision_average = mysqli_stmt_get_result($graph3and4Stmt);
while ($learning_revision_row = mysqli_fetch_assoc($learning_revision_average)) {
    $sessions[] = "الحصة  " . $learning_revision_row['session_number'];
    $learning_average[] = $learning_revision_row['learning_average'];
    $revision_average[] = $learning_revision_row['revision_average'];
    $bgColor[] = 'rgba(2, 120, 168, 0.8)';
    $borderColor[] = 'rgb(54, 162, 235)';
}

?>


<title>Learning Insights</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/Teacher/hala9aMain.css">
<link rel="stylesheet" href="../../assets/CSS/School/school.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userMain.css">
<link rel="stylesheet" href="../../assets/CSS/landingPage.css">
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/Admin/adminEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/SchoolClasses.css">
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

    @media (max-width:800px) {
        .newExam {
            margin-top: 3%;
        }
    }

    @media (min-width:800px) {
        .newExam {
            margin-top: 0;
        }
    }
</style>
</head>

<body id="newExam" dir="rtl">

    <div class="main">
        <!--Nav bar-->
        <?php include '../../includings/schoolNav.php' ?>

        <?php include 'schoolSidebar.php' ?>

        <div class="newExam" style="width: 75%; display:inline-block;">
            <!--side bar toggler-->
            <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <div class="session">
                
                <div class="session-1 stat-panel">
                    <p class="session-1-text" style="text-align:center; font-weight:500;">معدلات حفظ ومراجعة حلقة معينة
                    </p>
                </div>
                <form method="post" class="selection-form">
                    <select class="selection-box">
                        <option value="#activity">تحفيظ القرآن الكريم</option>
                    </select>
                    <select class="selection-box" name="halakah" id="select_halakah" onchange="location = this.value;">
                        <option value="رقم الحلقة" selected disabled> اضغط لاختيار رقم الحلقة </option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="?halakah_id=' . $row['halakah_id'] . '">' . "الحلقة " . $row['halakah_name'] . '</option>';
                        }
                        ?>
                    </select>
                </form>
                <div style="width: 100%" class="learning_revision_graphs">
                    <div style="background-color: var(--whiteFFF); width:100%;" class="halakah_learning">
                        <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                            id="halakah_learning"></canvas>
                    </div>
                    <div style="background-color: var(--whiteFFF); width:100%;" class="halakah_revision">
                        <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                            id="halakah_revision"></canvas>
                    </div>
                </div>

                <div class="session-1 stat-panel">
                    <p class="session-1-text" style="text-align:center; font-weight:500;">معدل حفظ الحلقات</p>
                </div>
                <div style="display:flex; width:100%; justify-content: space-between; gap:2%;" class="selection-form">
                    <select class="selection-box">
                        <option value="#activity">تحفيظ القرآن الكريم</option>
                    </select>
                </div>
                <div style="background-color: var(--whiteFFF); width:100%;" class="all_halakah_learning">
                    <canvas style="height:60vh ;margin: 0 auto; padding: 20px" id="all_halakah_learning"></canvas>
                </div>


                <div class="session-1 stat-panel">
                    <p class="session-1-text" style="text-align:center; font-weight:500;">معدل مراجعة الحلقات</p>
                </div>
                <div style="display:flex; width:100%; justify-content: space-between; gap:2%;" class="selection-form">
                    <select class="selection-box">
                        <option value="#activity">تحفيظ القرآن الكريم</option>
                    </select>
                </div>
                <div style="background-color: var(--whiteFFF); width:100%;" class="all_halakah_revision">
                    <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                        id="all_halakah_revision"></canvas>
                </div>

            </div>
        </div>
    </div>
    <div id="footer">
        <!--footer-->
        <?php include '../../includings/schoolFooter.php' ?>
    </div>

    <script src="../../js/sidebars.js"></script>

    <script>
        function getSelectedValue() {
            var selectedValue = document.getElementById("mySelect").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refreshed-content").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "process.php?selectedValue=" + selectedValue, true);
            xhttp.send();
        }

        // the graphs of learning and revision
        const sessions_labels = <?php echo json_encode($sessions) ?>;
        const halaka_labels = <?php echo json_encode($halakah) ?>;

        // the learning graph of all halakahs
        const data1 = {
            labels: halaka_labels,
            datasets: [{
                label: 'معدلات حفظ الحلقات',
                data: <?php echo json_encode($all_learning_average) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1
            }]
        };

        const config1 = {
            type: 'bar',
            data: data1,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'الحلقة',
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
                            text: 'معدل الصفحات',
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

        var all_halakah_learning = new Chart(
            document.getElementById('all_halakah_learning'),
            config1
        );

        // the revision graph of all halakahs
        const data2 = {
            labels: halaka_labels,
            datasets: [{
                label: 'معدلات مراجعة الحلقات',
                data: <?php echo json_encode($all_revision_average) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1
            }]
        };

        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'الحلقة',
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

        var all_halakah_revision = new Chart(
            document.getElementById('all_halakah_revision'),
            config2
        )

        // the learning graph of specific halakahs
        const data3 = {
            labels: sessions_labels,
            datasets: [{
                label: 'معدلات حفظ الحلقة',
                data: <?php echo json_encode($learning_average) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1,
                pointRadius: 5
            }]
        };

        const config3 = {
            type: 'line',
            data: data3,
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

        var halakah_learning = new Chart(
            document.getElementById('halakah_learning'),
            config3
        )

        // the revision graph of specific halakah
        const data4 = {
            labels: sessions_labels,
            datasets: [{
                label: 'معدلات مراجعة الحلقة',
                data: <?php echo json_encode($revision_average) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1,
                pointRadius: 5
            }]
        };

        const config4 = {
            type: 'line',
            data: data4,
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

        var halakah_revision = new Chart(
            document.getElementById('halakah_revision'),
            config4
        )
    </script>
</body>