<?php

include_once('../../init.php');
include '../../head.php';
include '../../includings/functions.php';

// for non logged in users
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
    <!--Nav bar-->
    <?php include '../../includings/schoolNav.php' ?>

    <div class="main">
        <?php
        // Retrieve the halakahID from the URL parameter
        if (isset($_GET['halakahID'])) {
            $halakahID = $_GET['halakahID'];
            $_SESSION['halakahID'] = $halakahID;
        } ?>

        <!-- SIDE BAR -->
        <?php include 'schoolSidebar.php' ?>

        <div class="main_elements">
            <!--side bar toggler-->
         <img src="../../assets/images/icons/slide-left.png" class="sidebar-slider" alt="sid_bra_toggle">
            <img style="width: 20%;margin:50px 40% auto;" src="../../assets/images/School/Card Decoration.png" alt="">
            <img style="width: 10%;margin:auto 45%" class="auth_icon" src="../../assets/images/logo/Durar - Dark blue logo.png" alt="">
            <div class="AddAdminContentAll">

                <div style="width: 100%;margin:auto 50%;padding:auto 50%;" class="AddAdminContent" id="Hala9aSettings">
                    <p class="sidebar_title" href="EditHalakah.php">إعدادات الحلقة</p>
                    <div class="CardButtons specialCardButtons">
                        <button class="ChoiceButton hala9aSettingsChoose" id="moveToHala9aSettings1">
                            <p>
                                تعيين الأستاذ
                            </p>
                        </button>
                        <button class="ChoiceButton hala9aSettingsChoose" id="moveToHala9aSettings3" onclick="editBio()">
                            <p>
                                وصف الحلقة
                            </p>
                        </button>
                        <button class="ChoiceButton hala9aSettingsChoose" id="moveToHala9aSettings2" onclick="deleteHalakah()">
                            <p>
                                حذف الحلقة
                            </p>
                        </button>

                    </div>
                    <div class="CardButtons">
                        <button class="backButton" id="closeHala9aSettings" onclick="window.location.href = 'Episodes.php'">
                            <p>
                                الرجوع
                            </p>
                        </button>
                    </div>
                </div>

                <div class="AddAdminContent" id="Hala9aSettings1_1">
                    <p>أدخل اسم مستخدم الأستاذ الجديد</p>
                    <br>
                    <div class="searchContainer">
                        <div style="width:90%; margin: 5px 5%;">
                            <?php
                            // Fetch teachers from the database (assuming you have a "teachers" table)
                            $email = $_SESSION["email"];
                            $role = $_SESSION['role'];
                            $schoolID = get_school_id_from_user($conn, $email, $role);

                            $fetchTeachersSQL = 'SELECT * FROM teacher WHERE school_id = ?';
                            $teachersStmt = $conn->prepare($fetchTeachersSQL);
                            $teachersStmt->bind_param('i', $schoolID);
                            $teachersStmt->execute();
                            $teachersResult = $teachersStmt->get_result();

                            if ($teachersResult) {
                                // Loop through the teachers and create a row for each teacher
                                while ($teacher = $teachersResult->fetch_assoc()) {
                                    $teacherFname = $teacher['teacher_fname'];
                                    $teacherLname = $teacher['teacher_lname'];
                                    $teacherId = $teacher['teacher_id'];

                                    echo '<div class="teacherRow" style="width:100%">';
                                    echo '<p class="addTeacherRow">' . $teacherFname . ' ' . $teacherLname . '</p>';

                                    // Print the button for each teacher
                                    echo '<a class="confirmButton saveButton" href="../../includings/addTeacherHalakah.php?teacherID=' . $teacherId . '" >';
                                    echo '<p>تعيين</p>';
                                    echo '</a>';
                                    echo '</div>';
                                }
                                $teachersResult->free();
                            }
                            ?>
                        </div>
                    </div>


                    <div class="AddAdminContent" id="Hala9aSettings1Buttons">
                        <div style="width:88%;margin: 5px 5%;" class="CardButtons">

                            <button class="backButton" id="closeHala9aSettings" onclick="window.location.href = 'Episodes.php'">
                                <p>
                                    الرجوع
                                </p>
                            </button>

                        </div>
                    </div>
                </div>

                <div class="AddAdminContent" id="Hala9aSettings2">
                    <p>هل أنت متأكد من حذف الحلقة</p>
                    <p style="font-size: 20px; font-weight: 500;">الحلقة <?php echo $halakahID; ?></p>
                    <p style="color: var(--grey); width: 70%; text-align:center">
                        حذف الحلقات يمسحهم من قاعدة بيانات المدرسة وكل الطلبة والمعلمين
                        الملتحقين بالحلقة سيتم حذفهم أوتوماتيكيا
                    </p>
                    <div class="CardButtons">
                        <form action="../../includings/add_remove_halakah.php" method="POST">
                            <!-- Add a submit button to trigger the form submission -->
                            <input type="hidden" name="halakah_id" value="<?php echo $halakahID; ?>">
                            <input class="ButtonDelete ChoiceButton" style="width:100%" type="submit" name="removeRowButton" value="تأكيد الحذف">
                        </form>
                        <button class="backButton ChoiceButton" id="closeHala9aSettings" onclick="window.location.href = 'Episodes.php'">
                            <p>
                                الرجوع
                            </p>
                        </button>
                    </div>
                </div>


                <div class="AddAdminContent" id="Hala9aSettings3">
                    <p>الرجاء إدخال أو تغيير وصف حلقتك أدناه

                    </p>
                    <form action="../../includings/edit_halakah_bio.php" method="POST" style="width: 80%;margin:auto">
                        <textarea name="halakah_bio" class="halakah_bio" maxlength="120" dir="rtl" placeholder="أدخل وصف الحلقة هنا"><?php
                                                                                                                    // Fetch teachers from the database (assuming you have a "teachers" table)
                                                                                                                    $fetchHalakahSQL = 'SELECT halakah_bio FROM halakah WHERE halakah_id = ?';
                                                                                                                    $HalakahStmt = $conn->prepare($fetchHalakahSQL);
                                                                                                                    $HalakahStmt->bind_param('i', $halakahID);
                                                                                                                    $HalakahStmt->execute();
                                                                                                                    $HalakahResult = $HalakahStmt->get_result();

                                                                                                                    // Check if the query returned any rows
                                                                                                                    if ($HalakahResult && $HalakahResult->num_rows > 0) {
                                                                                                                        // Fetch the first row of the result (assuming halakah_id is unique)
                                                                                                                        $halakahData = $HalakahResult->fetch_assoc();
                                                                                                                        $halakahBio = $halakahData['halakah_bio'];

                                                                                                                        // Output the halakah_bio
                                                                                                                        echo $halakahBio;
                                                                                                                    } else {
                                                                                                                        // Handle the case when no matching halakah_id is found
                                                                                                                        echo "Halakah not found.";
                                                                                                                    }

                                                                                                                    // Don't forget to free the result and close the statement
                                                                                                                    if ($HalakahResult) {
                                                                                                                        $HalakahResult->free();
                                                                                                                    }
                                                                                                                    $HalakahStmt->close();

                                                                                                                    // ... (rest of your PHP code)
                                                                                                                    ?>
                    </textarea>
                        <div class="CardButtons" style="margin:auto">
                            <!-- Add a submit button to trigger the form submission -->
                            <input type="hidden" name="halakah_id" value="<?php echo $halakahID; ?>">
                            <input class="ButtonDelete ChoiceButton" type="submit" name="removeRowButton" value="تأكيد ">
                    </form>
                    <button type="reset" class="backButton ChoiceButton" id="closeHala9aSettings" onclick="window.location.href = 'Episodes.php'">
                        <p>
                            الرجوع
                        </p>
                    </button>
                </div>
            </div>
        </div>

    </div>

    </div>
    <style>
        /* Halakah bio since idk where to put it ? */
        .halakah_bio {
            width: 100%;
            margin: 30px auto;
            height: 150px;
            font-size: 18px;
            padding: 20px
        }
    </style>

    <script src="../../js/Hala9aSettingsCard.js"></script>
    <script src="../../js/sidebars.js"></script>

</body>