<?php
// Perform necessary database connection and error handling here
include '../head.php';
include '../init.php';
include 'functions.php';

session_start();

$studentID = $_GET["studentID"];
$halakahID = $_SESSION['halakahID']; // Assuming you have the halakah ID stored in a session variable
$email = $_SESSION["email"];
$role = $_SESSION['role'];
$schoolID = get_school_id_from_user($conn, $email, $role);

// Check if the student belongs to the current school
$checkStudentSQL = 'SELECT * FROM student WHERE student_id = ? AND school_id = ?';
$checkStmt = $conn->prepare($checkStudentSQL);
$checkStmt->bind_param('ii', $studentID, $schoolID);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // The student belongs to the current school, proceed with adding to the halakah

    // Update the student_halakah table with the student_id and halakah_id
    $insertStudentHalakahSQL = 'INSERT INTO student_halakah (student_id, halakah_id) VALUES (?, ?)';
    $insertStmt = $conn->prepare($insertStudentHalakahSQL);

    if ($insertStmt) {
        $insertStmt->bind_param('ii', $studentID, $halakahID);
        if ($insertStmt->execute()) {
            // Calculate the number of students admitted to the halakah
            $countStudentsSQL = 'SELECT COUNT(*) AS student_count FROM student_halakah WHERE halakah_id = ?';
            $countStmt = $conn->prepare($countStudentsSQL);
            $countStmt->bind_param('i', $halakahID);
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            
            if ($countResult && $countResult->num_rows > 0) {
                $row = $countResult->fetch_assoc();
                $studentCount = $row['student_count'];

                // Update the halakah_nbstudents value
                $updateHalakahSQL = 'UPDATE halakah SET halakah_nbstudents = ? WHERE halakah_id = ?';
                $updateStmt = $conn->prepare($updateHalakahSQL);

                if ($updateStmt) {
                    $updateStmt->bind_param('ii', $studentCount, $halakahID);
                    if ($updateStmt->execute()) {
                        header('Location: ../pages/School/addStudent.php');
                        exit();
                    } else {
                        echo 'Error updating halakah_nbstudents: ' . $updateStmt->error;
                    }
                    $updateStmt->close();
                } else {
                    echo 'Error preparing the statement: ' . $conn->error;
                }
            }

            $countResult->free();
            $countStmt->close();
        } else {
            echo 'Error adding the student to the halakah: ' . $insertStmt->error;
        }
        $insertStmt->close();
    } else {
        echo 'Error preparing the statement: ' . $conn->error;
    }
} else {
    echo 'The selected student does not belong to the current school.';
}

$checkResult->free();
$checkStmt->close();
$conn->close();
?>