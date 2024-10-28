<?php

function showNewSessionForm($conn)
{
    $halakah_id = $_GET['halakah_id'];

    $sql = "SELECT s.student_id, s.student_fname, s.student_lname 
        FROM student_halakah sh JOIN student s ON sh.student_id = s.student_id
        WHERE sh.halakah_id = '$halakah_id'";

    $result = mysqli_query($conn, $sql);

    $students_list = array();
    while ($row = mysqli_fetch_array($result)) {
        $student_id = $row['student_id'];
        $student_fname = $row['student_fname'];
        $student_lname = $row['student_lname'];
        $students_list[] = array('student_id' => $student_id, 'student_fname' => $student_fname, 'student_lname' => $student_lname);
    }

    // get a number for the new session
    $sql = "SELECT max(session_number) AS recent FROM session WHERE halakah_id = '$halakah_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if ($row['recent'] === null) {
        $recent = 1;
    } else {
        $recent = $row['recent'] + 1;
    }
    $currentDate = date('Y-m-d');
?>

    <form class="studentsList" method="post" action="../../includings/insertNewSession.php" id="add_new_session_form">
        <div class="session">
            <div class="session-1">
                <p class="session-1-text">الحصة <?php echo $recent; ?></p>
                <p class="session-1-text"><?php echo $currentDate; ?></p>
            </div>
            <div style="background-color: var(--whiteFFF); width: 100%;" class="seesion-2">
                <input class="session-2-text" placeholder="أدخل وصفا للحصة" type="text" name="session_report" id="session_report" required></input>
            </div>
        </div>
        <div class="session-1">
            <p class="session-1-text">قائمة الطلبة</p>
        </div>
        <div class="table_container">
            <table style="overflow-x:scroll;" class="studentsTable">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>اللقب</th>
                        <th style="font-size: 16px;"> عدد صفحات <br> الحفظ </th>
                        <th style="font-size: 16px;"> عدد صفحات <br> المراجعة </th>
                        <th>التقييم</th>
                        <th>الحضور</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="halakah_id" id="halakah_id" value="<?php echo $halakah_id ?>" />
                    <?php
                    $counter = 0;
                    foreach ($students_list as $student) {
                        $counter++;
                        echo '
                            <tr>
                                <td style="display: none;">
                                    <input type="hidden" name="student_id' . $counter . '" id="student_id' . $counter . '" value="' . $student['student_id'] . '" />
                                </td>
                                <td style="width: 10vw">
                                    <p >
                                        ' . $student['student_fname'] . '
                                    </p>
                                </td>
                                <td style="width: 10vw">
                                    <p>
                                        ' . $student['student_lname'] . '
                                    </p>
                                </td>
                                <td>
                                    <input required type="text" id="quran_memorized' . $counter . '" name="quran_memorized' . $counter . '"></input>
                                </td>
                                <td>
                                    <input required type="text" id="quran_revised' . $counter . '" name="quran_revised' . $counter . '"></input>
                                </td>
                                <td>
                                    <input required type="text" id="student_evaluation' . $counter . '" name="student_evaluation' . $counter . '" placeholder="/20"></input>
                                </td>
                                <td style="background: #AEF7B5;" class="state_button">
                                    <input readonly type="text" id="student_state' . $counter . '" name="student_state' . $counter . '" value="حاضر" onclick=\'changeState("student_state' . $counter . '")\'></input>
                                </td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div><br>
        <div style="display: flex; justify-content:flex-end" class="session-3">
            <button type="submit" style="border: none" class="session-3-text">حفظ</button>
        </div>
    </form>




<?php
}

function insertNewSession($conn)
{
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get POST information
        $halakah_id = $_POST['halakah_id'];
        $session_report = $_POST['session_report'];
        // get the number of students in this halakah
        $sql = "SELECT count(*) AS num_of_students FROM student_halakah WHERE halakah_id = '$halakah_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if ($row['num_of_students'] === null) {
            $num_of_students = 0;
        } else {
            $num_of_students = $row['num_of_students'];
        }

        $session_progress = array();
        for ($i = 1; $i <= $num_of_students; $i++) {
            $student_progress = array(
                'student_id' => $_POST['student_id' . $i],
                'quran_memorized' => $_POST['quran_memorized' . $i],
                'quran_revised' => $_POST['quran_revised' . $i],
                'student_evaluation' => $_POST['student_evaluation' . $i],
                'student_state' => $_POST['student_state' . $i]
            );
            $session_progress[] = $student_progress;
        }

        // get a number for the new session
        $sql = "SELECT max(session_number) AS recent FROM session WHERE halakah_id = '$halakah_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if ($row['recent'] === null) {
            $recent = 1;
        } else {
            $recent = $row['recent'] + 1;
        }
        $currentDate = date('Y-m-d');

        // Creating a new session in the database
        $sql = "INSERT INTO session (halakah_id, session_date, session_number, session_report) VALUES ('$halakah_id', '$currentDate', '$recent', '$session_report')";
        $result = mysqli_query($conn, $sql);
        $session_id = mysqli_insert_id($conn);

        // Getting the id of the school
        session_start();
        $teacher_email = $_SESSION['email'];
        $school_id = get_school_id_from_user($conn, $teacher_email, "teacher");
        // Inserting the progress of each student into the halakah
        foreach ($session_progress as $student_progress) {

            // adding the new progress to student_progress
            $sql = "INSERT INTO student_progress (session_id, halakah_id, school_id, student_id, student_state, quran_memorized, quran_revised, student_evaluation)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $session_id, $halakah_id, $school_id, $student_progress['student_id'], $student_progress['student_state'], $student_progress['quran_memorized'], $student_progress['quran_revised'], $student_progress['student_evaluation']);
            $stmt->execute();
        }
        // constructing the url
        $sql = "SELECT * FROM halakah WHERE halakah_id = '$halakah_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $halakah_name = $row['halakah_name'];
        $halakah_bio = $row['halakah_bio'];

        header("Location: ../pages/Teacher/episodeReportsAll.php?halakah_id=" . $halakah_id . "&halakah_name=" . $halakah_name . "&halakah_bio=" . $halakah_bio);
    }
}

function showSessions($conn, $halakah_id)
{
    $sql = "SELECT session_id, session_date, session_number FROM session WHERE halakah_id = '$halakah_id'";
    $result = mysqli_query($conn, $sql);
    $sessions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $session_id = $row['session_id'];
        $session_date = $row['session_date'];
        $session_number = $row['session_number'];
        $sessions[] = array(
            'session_id' => $session_id,
            'session_date' => $session_date,
            'session_number' => $session_number
        );
    }
    $counter = 0;
    foreach ($sessions as $session) {
        if ($counter % 3 === 0) {
            echo '<div class="hala9at">';
        }
        echo '
            <div class="hala9at-hala9a" onclick="goToSession(' . $session['session_id'] . ')">
                <p style="font-weight: 700; color: #0278A8" href="episodeReports.php">
                    الحصة ' . $session['session_number'] . '
                </p>
                <p>
                    ' . $session['session_date'] . '
                </p>
            </div>
        ';
        if ($counter % 3 === 2) {
            echo '</div>';
        }
        $counter++;
    }
?>

<?php
}

function showSession($conn, $session_id)
{
    $sql = "SELECT s.student_fname, s.student_lname, sp.student_state, sp.quran_memorized, sp.quran_revised, sp.student_evaluation
            FROM student_progress sp JOIN student s ON sp.student_id=s.student_id
            WHERE session_id = '$session_id'";
    $result = mysqli_query($conn, $sql);

    $students = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $student_fname = $row['student_fname'];
        $student_lname = $row['student_lname'];
        $student_state = $row['student_state'];
        $quran_memorized = $row['quran_memorized'];
        $quran_revised = $row['quran_revised'];
        $student_evaluation = $row['student_evaluation'];
        $students[] = array(
            'student_fname' => $student_fname,
            'student_lname' => $student_lname,
            'student_state' => $student_state,
            'quran_memorized' => $quran_memorized,
            'quran_revised' => $quran_revised,
            'student_evaluation' => $student_evaluation
        );
    }
?>

    <table class="studentsTable">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>اللقب</th>
                <th style="font-size: 16px;">
                    عدد الصفحات
                    <br>
                    الحفظ
                </th>
                <th style="font-size: 16px;">
                    عدد الصفحات
                    <br>
                    المراجعة
                </th>
                <th>التقييم</th>
                <th>الحضور</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($students as $student) {
                echo '
                    <tr>
                        <td> ' . $student['student_fname'] . ' </td>
                        <td> ' . $student['student_lname'] . '</td>
                        <td> ' . $student['quran_memorized'] . '</td>
                        <td> ' . $student['quran_revised'] . '</td>
                        <td> ' . $student['student_evaluation'] . '/20</td>
                        <td> ' . $student['student_state'] . '</td>
                    </tr>
                    ';
            }
            ?>
        </tbody>
    </table>
    </div>
<?php
}

function showNumberOfSessions($conn, $halakah_id)
{
    $sql = "SELECT count(*) AS numberOfSessions FROM session WHERE halakah_id='$halakah_id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $numberOfSessions = $row['numberOfSessions'];
    } else {
        $numberOfSessions = 0;
    }
    echo $numberOfSessions;
}

?>