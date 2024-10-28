<?php

include '../../head.php';
include_once('../../init.php');
include '../../includings/functions.php';

// for non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';



?>

<title>School classes</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/Student/studEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/Admin/adminEpisode.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/SchoolClasses.css">
<link rel="stylesheet" href="../../assets/CSS/School/schoolCards.css">
<link rel="stylesheet" href="../../assets/CSS/School/school.css">
</head>
<?php

$email = $_SESSION["email"];
$role = $_SESSION["role"];
$school_id = get_school_id_from_user($conn, $email, $role);

$_SESSION['classname'] = empty($_GET['classname']) ? $_SESSION['classname'] : $_GET['classname'];
$class = $_SESSION['classname'];


$halakahArray = array();

// Fetch data from the "halakah" table and populate the array
$sql = "SELECT * FROM halakah WHERE school_id = $school_id";
$teacherSQL = "SELECT halakah.id AS halakah_id, halakah.name AS halakah_name, teacher.name AS teacher_name
FROM halakah JOIN teacher ON halakah.teacher_id = teacher.id WHERE halakah.school_id = ?";


$result = $conn->query($sql);

?>


<body dir="rtl">
    <!--Nav bar-->
    <?php include '../../includings/schoolNav.php' ?>

    <div class="main">
        <!-- SIDE BAR -->
        <?php include 'schoolSidebar.php' ?>

        <!--MAIN ELEMENTS-->


        <section class="main_elements">
            <!--side bar toggler-->
            <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <div class="attention">
                <div class="attention-title">
                    <p> تنبيه </p>
                </div>
                <div class="attention-content">
                    <p>
                        اضغط على إسم الحلقة لتتمكن من اضافة أو حذف تلاميذ هذه المدرسة لها <br>
                        اضغط على إعدادات الحلقة من أجل تعيين أستاذ ووصف لها أو حذفها
                    </p>
                </div>
            </div>
            <?php
            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Assign the halakah ID to a session variable
                        $halakahID = $row['halakah_id'];

                        // Fetch the teacher's first and last name from the "teacher" table
                        $teacherSQL = "SELECT teacher_fname, teacher_lname FROM teacher WHERE teacher_id = (SELECT teacher_id FROM halakah WHERE halakah_id = " . $halakahID . ")";
                        $teacherResult = $conn->query($teacherSQL);

                        if ($teacherResult && $teacherResult->num_rows > 0) {
                            $teacherRow = $teacherResult->fetch_assoc();
                            $teacherFirstName = $teacherRow['teacher_fname'];
                            $teacherLastName = $teacherRow['teacher_lname'];
                            $teacherFullName = $teacherFirstName . ' ' . $teacherLastName;
                        } else {
                            $teacherFullName = "غير محدد";
                        }

                        $class_name = empty($row["class_name"]) ? "غير محدد" : $row["class_name"];
                        $halakah_nbstudents = empty($row["halakah_nbstudents"]) ? "0" : $row["halakah_nbstudents"];

                        // Output the repeated HTML code
                        echo '<div>
                        <input type="hidden" name="halakahId" value="' . $halakahID . '">
                        <input type="hidden" name="classname" value="' . $class . '">
                        <div class="Classframe">
                                        <div class="upperTape">
                                            <a href="addStudent.php?halakahID=' . $halakahID . '"><h1 class="Title">الحلقة ' . $row['halakah_name'] . '</h1></a>
                                            <a href="editHalakah.php?halakahID=' . $halakahID . '"><input type="button" value="إعدادات الحلقة" ></a>
                                            </div>
                                        <div class="text">
                                            <p>القسم: ' . $class_name . '</p>
                                            <p>الأستاذ: ' . $teacherFullName . '</p>
                                            <p>' . $row['halakah_bio'] . '</p>
                                            <p class="numStudents">' . $halakah_nbstudents . ' طالب</p>
                                        </div>
                                    </div>
                                </div>';
                    }
                }
            } else {
                echo "Error executing the SQL query: " . $conn->error;
            }


            ?>

            <form class="AddHalakah" action="../../includings/add_remove_halakah.php" method="POST">
                <!-- Add a submit button to trigger the form submission -->
                <input class="AddHalakah" type="submit" name="addRowButton" value="إضافة حلقة">
            </form>
            <script src="../../js/Hala9aSettingsCard.js"></script>


        </section>
    </div>



    <div id="footer">
        <?php include '../userFooter.html' ?>
    </div>

    <script src="../../js/sidebars.js"></script>

</body>