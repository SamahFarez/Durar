<?php
// Perform necessary database connection and error handling here
include '../head.php';
include '../init.php';
include 'functions.php';

session_start();

$studentID = $_GET["studentID"];
$halakahID = $_SESSION['halakahID']; // Assuming you have the halakah ID stored in a session variable

// Check if the student belongs to the halakah
$checkStudentSQL = 'SELECT * FROM student_halakah WHERE student_id = ? AND halakah_id = ?';
$checkStmt = $conn->prepare($checkStudentSQL);
$checkStmt->bind_param('ii', $studentID, $halakahID);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // The student belongs to the halakah, proceed with removing from the halakah

    // Delete the student from the student_halakah table
    $removeStudentHalakahSQL = 'DELETE FROM student_halakah WHERE student_id = ? AND halakah_id = ?';
    $removeStmt = $conn->prepare($removeStudentHalakahSQL);

    if ($removeStmt) {
        $removeStmt->bind_param('ii', $studentID, $halakahID);
        if ($removeStmt->execute()) {
            // Calculate the number of students remaining in the halakah
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
            echo 'Error removing the student from the halakah: ' . $removeStmt->error;
        }
        $removeStmt->close();
    } else {
        echo 'Error preparing the statement: ' . $conn->error;
    }
} else {
    echo 'The selected student does not belong to the halakah.';
}

$checkResult->free();
$checkStmt->close();
$conn->close();
?>