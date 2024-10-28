<?php
include_once('../../init.php');
// for non logged in users
include '../../includings/landingRedirection.php';
// unauthorized access from users with no school
include '../../includings/noSchool_unauthorized.php';

include '../../includings/functions.php';


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    switch ($_GET['roleToDelete']) {
        case 'student':
            $stmt1 = mysqli_prepare($conn, "UPDATE student SET school_id = NULL WHERE student_id = ?;");
            mysqli_stmt_bind_param($stmt1, "i", $_GET['student_id']);
            mysqli_stmt_execute($stmt1);
            $stmt2 = mysqli_prepare($conn, "DELETE FROM student_progress WHERE student_id = ?");
            mysqli_stmt_bind_param($stmt2, "i", $_GET['student_id']);
            mysqli_stmt_execute($stmt2);
            $stmt3 = mysqli_prepare($conn, "DELETE FROM student_halakah WHERE student_id = ?");
            mysqli_stmt_bind_param($stmt3, "i", $_GET['student_id']);
            mysqli_stmt_execute($stmt3);
            if (mysqli_stmt_affected_rows($stmt1) > 0) {
                setcookie('studentDeleted', true, time() + 5);
            } else {
                setcookie('errorDeletingStudent', true, time() + 5);
            }
            header("location: students.php");
            break;
        case 'teacher':
            if ($_GET['eps_num'] > 0) {
                setcookie('activeTeacher', true, time() + 10);
                setcookie('teacherDeleted', false, time() + 10);
            } elseif ($_GET['eps_num'] == 0) {
                $stmt1 = mysqli_prepare($conn, "UPDATE teacher SET school_id = NULL WHERE teacher_id = ?");
                mysqli_stmt_bind_param($stmt1, "i", $_GET['teacher_id']);
                mysqli_stmt_execute($stmt1);
                $stmt2 = mysqli_prepare($conn, "UPDATE school SET school_nbteachers = school_nbteachers - 1 WHERE school_id = ?");
                mysqli_stmt_bind_param($stmt2, "i", $_SESSION['school_id']);
                mysqli_stmt_execute($stmt2);
                if (mysqli_stmt_affected_rows($stmt1) > 0) {
                    setcookie('teacherDeleted', true, time() + 5);
                } else {
                    setcookie('errorDeletingTeacher', true, time() + 5);
                }
            }
            header("location: teachers.php");
            break;
        case 'admin':
            $selectStmt = mysqli_prepare($conn, "SELECT school_nbadmin FROM school WHERE school_id = ?");
            mysqli_stmt_bind_param($selectStmt, "i", $_SESSION['school_id']);
            // Execute the SELECT statement
            mysqli_stmt_execute($selectStmt);
            // Bind the result to a variable
            mysqli_stmt_bind_result($selectStmt, $number_of_admins);
            // Fetch the result
            mysqli_stmt_fetch($selectStmt);
            mysqli_stmt_close($selectStmt);
            if ($number_of_admins !== 1) {
                $stmt1 = mysqli_prepare($conn, "UPDATE administrator SET school_id = NULL WHERE admin_id = ?");
                mysqli_stmt_bind_param($stmt1, "i", $_GET['admin_id']);
                mysqli_stmt_execute($stmt1);
                $stmt2 = mysqli_prepare($conn, "UPDATE school SET school_nbadmin = school_nbadmin - 1 WHERE school_id = ?");
                mysqli_stmt_bind_param($stmt2, "i", $_SESSION['school_id']);
                mysqli_stmt_execute($stmt2);
                if (mysqli_stmt_affected_rows($stmt1) > 0) {
                    if (get_admin_id($conn) == $_GET['admin_id']) { #in case the admin deletes himself from the school
                        setcookie('adminDeleted', true, time() + 5);
                        $_SESSION['school_id'] = NULL;
                        header("location: ../Admin/index.php");
                        break;
                    } else {
                        setcookie('adminDeleted', true, time() + 5);
                    }
                } else {
                    setcookie('errorDeletingAdmin', true, time() + 5);
                }
            }else{
                setcookie('lastAdmin', true, time() + 5);
            }
            header("location: admins.php");
            break;
    }

    exit;
}
