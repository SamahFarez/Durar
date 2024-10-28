<?php
session_start();

include '../head.php';
include '../init.php';
include 'functions.php';

if (get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role'])) {
    $school_id = get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Resetting all students of the school
    $update_student_query = "UPDATE student SET school_id = NULL WHERE school_id = $school_id";
    $result = mysqli_query($conn, $update_student_query);

    // Resetting all taechers of the school
    $update_teacher_query = "UPDATE teacher SET school_id = NULL WHERE school_id = $school_id";
    $result = mysqli_query($conn, $update_teacher_query);

    // Resetting all admin of the school
    $update_admin_query = "UPDATE administrator SET school_id = NULL WHERE school_id = $school_id";
    $result = mysqli_query($conn, $update_admin_query);

    // deleting all Halakah of school of the school
    $delete_ep_query = "DELETE FROM halakah WHERE school_id = $school_id";
    $result = mysqli_query($conn, $update_ep_query);

    // Delete the school from the database
    $deleteQuery = "DELETE FROM school WHERE school_id = $school_id";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {

    } else {
        echo "حدث خلل خلال حذف مدرستكم";
    }
}
?>