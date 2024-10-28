<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include '../../head.php';
include("../../init.php");
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



// after clicking search
if (isset($_POST['submit'])) {
  $tmp = $_POST['search'];
  $search = "%" . $tmp . "%";
  $teacherAbsSTmt = mysqli_prepare($conn, "SELECT T.teacher_fname, T.teacher_lname, COALESCE(count(A.absence_date), 0) as countAbs 
                                          FROM teacher T 
                                          LEFT JOIN teacher_attendance A ON T.teacher_id = A.teacher_id AND A.absence_date IS NOT NULL
                                          WHERE T.school_id=? and (T.teacher_fname LIKE ? OR T.teacher_lname LIKE ?)
                                          GROUP BY T.teacher_id;");
  mysqli_stmt_bind_param($teacherAbsSTmt, "sss", $school_id, $search, $search);
  mysqli_stmt_execute($teacherAbsSTmt);
  $teacherAbs_result = mysqli_stmt_get_result($teacherAbsSTmt);
} else {
  $teacherAbsSTmt = mysqli_prepare($conn, "SELECT T.teacher_fname, T.teacher_lname, COALESCE(count(A.absence_date), 0) as countAbs 
                                            FROM teacher T 
                                            LEFT JOIN teacher_attendance A ON T.teacher_id = A.teacher_id AND A.absence_date IS NOT NULL
                                            WHERE T.school_id=?
                                            GROUP BY T.teacher_id;");
  mysqli_stmt_bind_param($teacherAbsSTmt, "s", $school_id);
  mysqli_stmt_execute($teacherAbsSTmt);
  $teacherAbs_result = mysqli_stmt_get_result($teacherAbsSTmt);
}

// halakat
$sql = mysqli_prepare($conn, "SELECT halakah_id, halakah_name FROM halakah where school_id=?");
mysqli_stmt_bind_param($sql, "s", $school_id);
mysqli_stmt_execute($sql);
$result = mysqli_stmt_get_result($sql);

// getting the halakah_id of the selected halakah
if (isset($_GET['halakah_id'])) {
  $halakah_id = $_GET['halakah_id'];
}

// the graph 
$graphStmt = mysqli_prepare($conn, "SELECT S.session_number, count(P.student_id) AS attendCount
                                FROM session S JOIN student_progress P
                                ON S.session_id = P.session_id
                                WHERE P.student_state='حاضر' and P.halakah_id=?
                                GROUP BY P.session_id;");
mysqli_stmt_bind_param($graphStmt, "i", $halakah_id);
mysqli_stmt_execute($graphStmt);
$student_attendance = mysqli_stmt_get_result($graphStmt);
while ($stud_attendance_row = mysqli_fetch_assoc($student_attendance)) {
  $session[] = "الحصة " . $stud_attendance_row['session_number'];
  $attendance[] = $stud_attendance_row['attendCount'];
  $bgColor[] = 'rgba(2, 120, 168, 0.8)';
  $borderColor[] = 'rgb(54, 162, 235)';
}

?>


<title>Attendance</title>
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
  input {
    border: 1px solid var(--mainblue);
    border-radius: 34px;
    background-color: var(--whiteFFF);
    font-size: 20px;
    font-family: "Cairo";
    height: fit-content;
    width: fit-content;
    padding: 10px 20px;
  }

  @media (max-width:700px) {
    input {
      font-size: 18px;
    }
  }

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
</head>

<body id="newExam" dir="rtl">
  <!--Nav bar-->
  <div class="main">
    <!--Nav bar-->
    <?php include '../../includings/schoolNav.php' ?>

    <?php include 'schoolSidebar.php' ?>

    <div class="newExam" style="display:inline-block; width: 75%;">
      <!--side bar toggler-->
      <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
      <div class="session">
        <div class="session-1 stat-panel">
          <p class="session-1-text" style="text-align:center; font-weight:500;">حضور وغياب الطلبة</p>
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
        <div style="background-color: var(--whiteFFF); width:100%;" class="absenceGraph" id="refreshed-content">
          <canvas style="width: 90%; height:60vh ;margin: 0 auto; padding: 20px" id="student_absence_graph"></canvas>
        </div>
        <div class="session-1 stat-panel">
          <p class="session-1-text" style="text-align:center; font-weight:500;">حضور وغياب الأساتذة</p>
        </div>

        <form style="display: flex;flex-direction: row;align-items: center;gap: 30px;color: black;width: 100%;padding: 0 10px 0 10px;border: 1px solid var(--black);
              border-radius: 20px;" method="post" class="search_student">
          <img src="../../assets/images/icons/search.png" alt="">
          <input style="color: black; width: 100%; outline: none; border: none; background: none; cursor:auto"
            type="text" name="search" placeholder="ابحث عن أستاذ" required>
          <input type="submit" name="submit" value="submit" style="display: none;">
        </form>

        <?php
        if (isset($_POST['submit'])) {
          ?>
          <div style="font-size: 22px; ">
            <p>
              <?php echo "نتائج البحث عن '$tmp'"; ?>
            </p>
          </div>
        <?php } ?>

        <div style="display:flex; width:100%; justify-content: space-between; gap:2%;" class="selection-form">
          <select class="selection-box" style="background-position: center left 1.75%;">
            <option value="#activity">تحفيظ القرآن الكريم</option>
          </select>
        </div>

        <div style="overflow-x:scroll; width:100%">
          <table class="absentTeachersTable">
            <thead>
              <tr>
                <th class="header"> الاسم </th>
                <th class="header"> اللقب </th>
                <th class="header"> عدد الغيابات </th>
              </tr>
            </thead>
            <tbody>

              <?php
              while ($row = mysqli_fetch_assoc($teacherAbs_result)) {
                ?>
                <tr>
                  <td>
                    <?php echo $row['teacher_fname'] ?>
                  </td>
                  <td>
                    <?php echo $row['teacher_lname'] ?>
                  </td>
                  <td>
                    <?php echo $row['countAbs'] ?>
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

  <div id="footer">
    <!--footer-->
    <?php include '../../includings/schoolFooter.php' ?>
  </div>

  <script src="../../js/sidebars.js"></script>

  <script>
    function getSelectedValue() {
      var selectedValue = document.getElementById("select_halakah").value;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("refreshed-content").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "process.php?selectedValue=" + selectedValue, true);
      xhttp.send();
    }

    // the graph
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