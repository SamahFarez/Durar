<?php
include_once('../../init.php');
include '../../head.php';
include '../../includings/functions.php';

// for non-logged-in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

?>

<title>Edit Halakah</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/Admin/adminEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolMain.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolCards.css">
<link rel="stylesheet" href="../../assets/CSS/School/school.css">

</head>

<body dir="rtl">
    <!-- Nav bar -->
    <?php include '../../includings/schoolNav.php' ?>

    <div class="main">
        <?php
        // Retrieve the halakahID from the URL parameter
        if (isset($_GET['halakahID'])) {
            $halakahID = $_GET['halakahID'];
            $_SESSION['halakahID'] = $halakahID;
        }
        ?>

        <!-- SIDE BAR -->
        <?php include 'schoolSidebar.php' ?>

        <div class="main_elements">
            <!--side bar toggler-->
            <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <img style="width: 20%;margin:50px 40% auto;" src="../../assets/images/School/Card Decoration.png" alt="">
            <img style="width: 10%;margin:auto 45%" class="auth_icon"
                src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
            <div class="AddAdminContentAll">

                <div style="width:100%;margin: 5px 5%;" class="AddAdminContent" id="Hala9aSettings1_1">
                    <p>أدخل اسم المستخدم للطالب الجديد</p>
                    <br>
                    <div style="width:90%;margin: 5px 5%;" class="searchContainer">
                        <div>
                            <?php
                            // Fetch students from the database (assuming you have a "student" table)
                            $email = $_SESSION["email"];
                            $role = $_SESSION['role'];
                            $schoolID = get_school_id_from_user($conn, $email, $role);
                            $currentHalakahID = $_SESSION['halakahID'];

                            $fetchStudentsSQL = 'SELECT * FROM student WHERE school_id = ? AND student_id NOT IN (SELECT student_id FROM student_halakah WHERE halakah_id = ?)';
                            $studentsStmt = $conn->prepare($fetchStudentsSQL);
                            if (!$studentsStmt) {
                                echo 'Error preparing the statement: ' . $conn->error;
                                exit();
                            }
                            if (!$studentsStmt->bind_param('ii', $schoolID, $currentHalakahID)) {
                                echo 'Error binding parameters: ' . $studentsStmt->error;
                                exit();
                            }
                            if (!$studentsStmt->execute()) {
                                echo 'Error executing the statement: ' . $studentsStmt->error;
                                exit();
                            }
                            $studentsResult = $studentsStmt->get_result();

                            if ($studentsResult && $studentsResult->num_rows > 0) {
                                // Loop through the students and create a row for each student
                                while ($student = $studentsResult->fetch_assoc()) {
                                    $studentFname = $student['student_fname'];
                                    $studentLname = $student['student_lname'];
                                    $studentId = $student['student_id'];

                                    echo '<div class="studentRow" style="width:100%;">';
                                    echo '<p class="addTeacherRow" style="width:70%;">' . $studentFname . ' ' . $studentLname . '</p>';

                                    // Print the button for each student
                                    echo '<a class="confirmButton saveButton" style="width:20%;margin: 0 5px;" href="../../includings/addStudentHalakah.php?studentID=' . $studentId . '" >';
                                    echo '<p style="display:inline-block;">اضافة</p>';
                                    echo '</a>';
                                    echo '</div>';
                                }
                                $studentsResult->free();
                            } else {
                                // Display a message when no students are available
                                echo '<p style="width:100%;text-align:center;">لا يوجد طلاب متاحين</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Display the list of students admitted to the current halakah -->
                    <h3>الطلاب المسجلون في الحلقة</h3>
                    <div style="width:100%;">
                        <?php
                        $fetchAdmittedStudentsSQL = 'SELECT s.student_id, CONCAT(s.student_fname, " ", s.student_lname) AS student_name FROM student s JOIN student_halakah sh ON s.student_id = sh.student_id WHERE sh.halakah_id = ?';
                        $fetchAdmittedStudentsStmt = $conn->prepare($fetchAdmittedStudentsSQL);
                        if (!$fetchAdmittedStudentsStmt) {
                            echo 'Error preparing the statement: ' . $conn->error;
                            exit();
                        }
                        if (!$fetchAdmittedStudentsStmt->bind_param('i', $currentHalakahID)) {
                            echo 'Error binding parameters: ' . $fetchAdmittedStudentsStmt->error;
                            exit();
                        }
                        if (!$fetchAdmittedStudentsStmt->execute()) {
                            echo 'Error executing the statement: ' . $fetchAdmittedStudentsStmt->error;
                            exit();
                        }
                        $admittedStudentsResult = $fetchAdmittedStudentsStmt->get_result();

                        if ($admittedStudentsResult && $admittedStudentsResult->num_rows > 0) {
                            while ($admittedStudentRow = $admittedStudentsResult->fetch_assoc()) {
                                $RstudentName = $admittedStudentRow['student_name'];
                                $RstudentId = $admittedStudentRow['student_id'];

                                echo '<div class="studentRow" style="width:100%;margin: 0 10%;">';
                                echo '<p class="addTeacherRow" style="width:60%;">' . $RstudentName . '</p>';

                                // Print the button for each student
                                echo '<a class="confirmButton saveButton" style="width:20%;margin: 0 5px;" href="../../includings/removeStudentHalakah.php?studentID=' . $RstudentId . '" >';
                                echo '<p style="display:inline-block;">حذف</p>';
                                echo '</a>';
                                echo '</div>';
                            }
                            $admittedStudentsResult->free();
                        } else {
                            // Display a message when no admitted students are available
                            echo '<p style="width:100%;text-align:center;">لا يوجد طلاب مسجلون في الحلقة</p>';
                        }
                        ?>
                    </div>

                    <div class="AddAdminContent" id="Hala9aSettings1Buttons">
                        <div style="width:88%;margin: 5px 6%;" class="CardButtons">

                            <button class="backButton" id="closeHala9aSettings"
                                onclick="window.location.href = 'Episodes.php'">
                                <p>
                                    الرجوع
                                </p>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../../js/Hala9aSettingsCard.js"></script>
    <script src="../../js/sidebars.js"></script>

</body>