<?php
session_start();
include '../../head.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';
// function of timetable
include '../../init.php';
include '../../includings/functions.php'
    ?>

<title>School classes</title>
<link rel="icon" href="../../assets/images/logo/Durar simplified - blue logo.png" type="image/x-icon">
<link rel="stylesheet" href="../../assets/CSS/general.css">
<link rel="stylesheet" href="../../assets/CSS/nav.css">
<link rel="stylesheet" href="../../assets/CSS/User/userProfile.css">
<link rel="stylesheet" href="../../assets/CSS/footer.css">
<link rel="stylesheet" href="../../assets/CSS/School/WeeklyProgram.css">
</head>

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
            <!-- timetable -->

            <div class="titleBar">
                <p>الجدولة الأسبوعية للحلقات</p>
                <a style="margin-left: 20px;" href="WeeklyProgramEditByHalakah.php">
                    <img src="../../assets/images/icons/edit.png" alt="edit">
                </a>
            </div>
            <?php EditschoolTimeTable($conn, "byHalakah") ?>
            <style>

            </style>
            <div id="errorContainer">
            </div>
            <!-- teachers time table-->
            <div class="titleBar">
                <p>الجدولة الأسبوعية للأساتذة</p>
                <div style="display:flex; flex-direction:row; gap: 15px">
                    <a href="">
                        <img src="../../assets/images/icons/angle-up.png" alt="hide">
                    </a>
                    <!-- <a style="margin-left: 20px;" href="WeeklyProgramEditByTeacher.php">
                        <img src="../../assets/images/icons/edit.png" alt="edit">
                    </a> -->
                </div>
            </div>

            <section class="teachersTimetable" id="teachersTimetable">
                <div class="firstRow">

                    <div class="day">
                        <p style=" text-align: right; padding-right:20px"> اليوم </p>
                    </div>

                    <div class="day">
                        <p style=" text-align: right; padding-right:20px"> الأستاذ </p>
                    </div>

                    <div class="day">
                        <p style=" text-align: right; padding-right:20px"> التوقيت </p>
                    </div>
                </div>

                <?php schoolTimeTable($conn, "byTeacher") ?>
            </section>
        </section>
    </div>
    <div id="footer">
        <?php include '../userFooter.html' ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/sidebars.js"></script>
    <script>
        function removeTiming(timetableId) {
            $.ajax({
                url: '../../includings/removeFromTimeTable.php',
                type: 'POST',
                data: { timetableId: timetableId },
                success: function (response) {
                    // Handle the response from the PHP function if needed
                    console.log(response);

                    // reload the current page
                    window.location.reload();
                },
                error: function () {
                    // Handle any errors during the AJAX call
                }
            });
        }
        function insert_new_timing(button, week_day) {
            // Create a new div element
            var form = document.getElementById("inserting_form");
            if (form) {
                form.parentNode.removeChild(form);
            }
            var td = button.closest('td');
            var newTd = document.createElement('td');
            newTd.classList.add('addTimingForm');
            newTd.style.border = '1px solid var(--mainblue)';
            newTd.id = "inserting_form";
            // Set the HTML content for the new div
            newTd.innerHTML = `
            <form method="post" action="" id="insert_timing_form">
                <div>
                    <label for="halakah_name" class="class">الحلقة :</label>
                    <input type="text" name="halakah_name" id="halakah_name" required><br>
                </div>
                <hr>
                <div>
                    <label for="start_time">من:</label>
                    <input type="text" name="start_time" id="start_time" required><br>
                </div>
                <div>
                    <label for="end_time">الى:</label>
                    <input type="text" name="end_time" id="end_time" required><br>
                </div>
                <div>
                    <input type="hidden" name="week_day" id="week_day">
                </div>
                <div>
                    <input type="hidden" name="admin_id" id="admin_id">
                </div>

                <input calss="" type="submit" value="اضافة">
            </form>
            `;
            td.parentNode.insertBefore(newTd, td);
            console.log(week_day);
            document.getElementById("week_day").value = week_day;
            document.getElementById("admin_id").value = <?php echo get_admin_id($conn); ?>;
            send_form_to_backend();
        }
        function send_form_to_backend() {
            document.getElementById('insert_timing_form').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent form submission

                var form = event.target;
                var formData = new FormData(form);

                // Send form data using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "../../includings/insertIntoTimeTable.php", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Success response, clear error container if needed
                            var errorContainer = document.getElementById('errorContainer');
                            errorContainer.textContent = ''; // Clear the error message
                            location.reload();
                        } else if (xhr.status === 400) {
                            // Error response, update the error container
                            var response = xhr.responseText;
                            var errorContainer = document.getElementById('errorContainer');
                            errorContainer.textContent = response; // Update the error message
                            errorContainer.style.display = "flex";
                        } else {
                            // Handle other status codes or errors if needed
                        }
                    }
                };
                xhr.send(formData);
            });
        }
    </script>

</body>