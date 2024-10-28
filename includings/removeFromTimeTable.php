

<?php

include '../init.php';

// Check if the timetableId is provided and not empty
if (isset($_POST['timetableId']) && !empty($_POST['timetableId'])) {
    // Retrieve the timetableId from the POST data
    $timetableId = $_POST['timetableId'];
   
    // Construct the SQL delete statement
    $sql = "DELETE FROM timetable WHERE timetable_id = $timetableId";

    // Execute the delete query
    if ($conn->query($sql) === TRUE) {
        echo "Row deleted successfully.";
    } else {
        echo "Error deleting row: " . $conn->error;
    }
} else {
    echo "timetableId is missing or empty.";
}

// Close the connection
$conn->close();
?>

