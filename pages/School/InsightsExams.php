<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../head.php';
include '../../init.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

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

// halakat
$sql = mysqli_prepare($conn, "SELECT halakah_id, halakah_name FROM halakah where school_id=?");
mysqli_stmt_bind_param($sql, "s", $school_id);
mysqli_stmt_execute($sql);
$result = mysqli_stmt_get_result($sql);

// getting the halakai id
if (isset($_GET['halakah_id'])) {
    $halakah_id = $_GET['halakah_id'];
}

// the graph of exams' marks average of specific halakahs
$graph2 = mysqli_prepare($conn, "SELECT E.exam_name, ROUND(avg(G.mark), 2) as average2, H.halakah_id
                                from grades G join exams E
                                on E.exam_id = G.exam_id
                                join halakah H on H.halakah_id=E.halakah_id
                                where E.halakah_id=? and E.exam_date < NOW()
                                group by E.exam_id;");
mysqli_stmt_bind_param($graph2, "s", $halakah_id);
mysqli_stmt_execute($graph2);
$halakah_average2 = mysqli_stmt_get_result($graph2);
while ($halakah_average_row = mysqli_fetch_assoc($halakah_average2)) {
    $exam_names[] = $halakah_average_row['exam_name'];
    $exam_averages[] = $halakah_average_row['average2'];
    $bgColor[] = 'rgba(2, 120, 168, 0.8)';
    $borderColor[] = 'rgb(54, 162, 235)';
}

?>
<title>Exams Insights</title>
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
    canvas {
        width: 60%;
    }

    /*graphs*/
    @media (max-width: 1400px) {
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
                    <p class="session-1-text" style="text-align:center; font-weight:500;">تطور الحلقات</p>
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
                <div style="background-color: var(--whiteFFF); width:100%;" class="halakah_average">
                    <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px"
                        id="halakah_average"></canvas>
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
        const exams_labels = <?php echo json_encode($exam_names) ?>;

        // the revision graph of all halakahs
        const data2 = {
            labels: exams_labels,
            datasets: [{
                label: 'معدلات تطور الحلقات',
                data: <?php echo json_encode($exam_averages) ?>,
                backgroundColor: <?php echo json_encode($bgColor) ?>,
                borderColor: <?php echo json_encode($borderColor) ?>,
                borderWidth: 1
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

        var exam_average2 = new Chart(
            document.getElementById('halakah_average'),
            config2
        )
    </script>

</body>