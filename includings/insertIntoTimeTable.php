<?php

include 'functions.php';
include '../init.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // getting the school ID

    // Retrieve the form data
    $halakahName = intval($_POST['halakah_name']);
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $weekDay = $_POST['week_day'];
    $admin_id = $_POST['admin_id'];
    // echo $_SESSION['email']== null;
    $sql_school_id = "SELECT admin_email FROM administrator WHERE admin_id = '$admin_id'";
    $result_school_id = mysqli_query($conn, $sql_school_id);

    if ($result_school_id && mysqli_num_rows($result_school_id) > 0) {
        $row = mysqli_fetch_assoc($result_school_id);
        $admin_email = $row['admin_email'];
    } else {
        $admin_email = null;
    }
    $school_id = get_school_id_from_user($conn, $admin_email, "administrator");

    // getting the halakah ID
    $sql_halakah_id = "SELECT halakah_id FROM halakah WHERE halakah_name = '$halakahName' AND school_id = '$school_id'";
    $result_halakah_id = mysqli_query($conn, $sql_halakah_id);

    if (!($result_halakah_id && mysqli_num_rows($result_halakah_id) > 0)){
        http_response_code(400);
        echo "لا توجد حلقة بهذا الرقم";
        exit;
    }

    // checking if the enetered timing is valid
    $startTimestamp = strtotime($startTime);
    $endTimestamp = strtotime($endTime);

    if ($endTimestamp < $startTimestamp) {
        // Display error message or perform any necessary action
        http_response_code(400); // Set the HTTP status code for a bad request
        echo "تحققوا من صحة التوقيت الذي قمتم بإدخاله";
        exit; // Terminate script execution
    } else {
        http_response_code(200);
        $row = mysqli_fetch_assoc($result_halakah_id);
        $halakah_id = $row['halakah_id'];
        //inserting the new timing to the timetable
        $sql_inserting = "INSERT INTO timetable (halakah_id, timetalbe_week_day, timetalbe_session_start_time, timetalbe_session_end_time) VALUES ('$halakah_id', '$weekDay', '$startTime', '$endTime')";
        mysqli_query($conn, $sql_inserting);
        
    }
}
?>