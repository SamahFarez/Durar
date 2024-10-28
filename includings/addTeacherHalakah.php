<?php
// Perform necessary database connection and error handling here
include '../head.php';
include '../init.php';
include 'functions.php';

session_start();

$teacherID = $_GET["teacherID"];
$halakahID = $_SESSION['halakahID']; // Assuming you have the halakah ID stored in a session variable

// Update the halakah record with the teacher_id
$updateHalakahSQL = 'UPDATE halakah SET teacher_id = ? WHERE halakah_id = ?';
$updateStmt = $conn->prepare($updateHalakahSQL);

if ($updateStmt) {
    $updateStmt->bind_param('ii', $teacherID, $halakahID);
    if ($updateStmt->execute()) {
        header('Location: ../pages/School/Episodes.php?classname=' . urlencode($classname));
        exit();
    } else {
        echo 'Error adding the teacher to the halakah: ' . $updateStmt->error;
    }
    $updateStmt->close();
} else {
    echo 'Error preparing the statement: ' . $conn->error;
}

$conn->close();
?>