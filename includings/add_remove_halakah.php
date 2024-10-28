<?php
// Perform necessary database connection and error handling here
include '../head.php';
include '../init.php';
include 'functions.php';

session_start();

$email = $_SESSION["email"];
$role = $_SESSION['role'];
$schoolId = get_school_id_from_user($conn, $email, $role);

// Fetch the count of existing halakat for the current school
$countHalakatSQL = 'SELECT COUNT(*) FROM halakah WHERE school_id = ?';
$countStmt = $conn->prepare($countHalakatSQL);
$countStmt->bind_param('i', $schoolId);
$countStmt->execute();
$countResult = $countStmt->get_result();
$countHalakat = $countResult->fetch_array()[0];

// Increment the count by 1 to determine the new halakah_name
$newHalakahName = $countHalakat + 1;

$countStmt->close();

// Check if the form was submitted
if (isset($_POST['addRowButton'])) {
    $classname = $_SESSION["classname"];
    // Insert the class name into the halakah table
    $insertSQL = 'INSERT INTO halakah (class_name, halakah_name, school_id) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($insertSQL);

    if ($stmt) {
        $stmt->bind_param("sii", $classname, $newHalakahName, $schoolId);

        if ($stmt->execute()) {
            // Row added successfully
            header('Location: ../pages/School/Episodes.php?classname=' . urlencode($classname));
        } else {
            // Error occurred while adding the row
            echo "Error adding a new row: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Error preparing the statement
        echo "Error preparing the statement: " . $conn->error;
    }
} elseif (isset($_POST['removeRowButton'])) {
    $rowId = $_POST['halakah_id'];

    // Get the halakah_name of the halakah to be deleted
    $getHalakahNameSQL = 'SELECT halakah_name FROM halakah WHERE halakah_id = ?';
    $getHalakahNameStmt = $conn->prepare($getHalakahNameSQL);
    $getHalakahNameStmt->bind_param('i', $rowId);
    $getHalakahNameStmt->execute();
    $halakahNameResult = $getHalakahNameStmt->get_result();
    $halakahNameRow = $halakahNameResult->fetch_assoc();
    $halakahName = $halakahNameRow['halakah_name'];

    // Delete associated rows in student_halakah table
    $deleteStudentHalakahSQL = 'DELETE FROM student_halakah WHERE halakah_id = ?';
    $deleteStudentHalakahStmt = $conn->prepare($deleteStudentHalakahSQL);
    $deleteStudentHalakahStmt->bind_param('i', $rowId);

    // Disable foreign key checks
    $disableForeignKeySQL = 'SET FOREIGN_KEY_CHECKS = 0';
    $disableStmt = $conn->prepare($disableForeignKeySQL);
    $disableStmt->execute();

    // Now, delete the row from halakah table
    $deleteHalakahSQL = 'DELETE FROM halakah WHERE halakah_id = ?';
    $deleteHalakahStmt = $conn->prepare($deleteHalakahSQL);
    $deleteHalakahStmt->bind_param('i', $rowId);

    if ($deleteHalakahStmt->execute()) {
        // Update the halakah names after the deleted halakah
        $updateHalakahNamesSQL = 'UPDATE halakah SET halakah_name = halakah_name - 1 WHERE school_id = ? AND halakah_name > ?';
        $updateHalakahNamesStmt = $conn->prepare($updateHalakahNamesSQL);
        $updateHalakahNamesStmt->bind_param('is', $schoolId, $halakahName);
        $updateHalakahNamesStmt->execute();
        $updateHalakahNamesStmt->close();

        $deleteStudentHalakahStmt->execute();

        // Delete associated rows in exams table
        $deleteExamsSQL = 'DELETE FROM exams WHERE halakah_id = ?';
        $deleteExamsStmt = $conn->prepare($deleteExamsSQL);
        $deleteExamsStmt->bind_param('i', $rowId);
        $deleteExamsStmt->execute();

        header('Location: ../pages/School/Episodes.php?classname=' . urlencode($classname));
    } else {
        echo 'Error removing the row: ' . $deleteHalakahStmt->error;
    }

    // Re-enable foreign key checks
    $enableForeignKeySQL = 'SET FOREIGN_KEY_CHECKS = 1';
    $enableStmt = $conn->prepare($enableForeignKeySQL);
    $enableStmt->execute();

    $getHalakahNameStmt->close();
    $deleteHalakahStmt->close();
    $deleteStudentHalakahStmt->close();
    $deleteExamsStmt->close();
}

// Close the database connection
$conn->close();
?>