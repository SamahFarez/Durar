<?php

include_once('../../init.php');
include '../../includings/landingRedirection.php';
include '../../includings/noSchool_unauthorized.php';
include '../../includings/functions.php';

try {
    $school_id = get_school_id_from_user($conn, $_SESSION['email'], $_SESSION['role']);

    if (!$school_id) {
        throw new Exception("School ID not found.");
    }

    // students are no longer in the school
    $removeStudentsInSchool = mysqli_prepare($conn, "UPDATE student SET school_id = NULL WHERE school_id = ?;");
    mysqli_stmt_bind_param($removeStudentsInSchool, "i", $school_id);
    mysqli_stmt_execute($removeStudentsInSchool);

    // admins are no longer in the school
    $removeAdminsInSchool = mysqli_prepare($conn, "UPDATE administrator SET school_id = NULL WHERE school_id = ?;");
    mysqli_stmt_bind_param($removeAdminsInSchool, "i", $school_id);
    mysqli_stmt_execute($removeAdminsInSchool);

    // teachers are no longer in the school
    $removeTeachersInSchool = mysqli_prepare($conn, "UPDATE teacher SET school_id = NULL WHERE school_id = ?;");
    mysqli_stmt_bind_param($removeTeachersInSchool, "i", $school_id);
    mysqli_stmt_execute($removeTeachersInSchool);

    // deleting all Halakah of the school
    removeAllSchoolHalakah ($conn, $school_id);

    // Delete the school from the database
    $deleteSchool = mysqli_prepare($conn, "DELETE from school WHERE school_id = ?;");
    mysqli_stmt_bind_param($deleteSchool, "i", $school_id);
    mysqli_stmt_execute($deleteSchool);

    // close the database connection
    $conn->close();

    if ($deleteSchool) {
        $_SESSION['school_id'] = NULL;
        header("location: ../Admin/index.php");
    } else {
        echo "حدث خلل خلال حذف مدرستكم";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}